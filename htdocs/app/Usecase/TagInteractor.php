<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Tag\CreateTagDto;
use App\Adapter\Controllers\DTO\Tag\UpdateTagDto;
use App\Adapter\Repositories\Interfaces\iTagRepository;
use App\Entity\Tag;
use App\Usecase\Interfaces\iTagInteractor;
use Exception;

class TagInteractor implements iTagInteractor
{
  protected iTagRepository $tagRepository;

  function __construct(iTagRepository $tr)
  {
    $this->tagRepository = $tr;
  }

  public function findAll(): array
  {
    return $this->tagRepository->selectAll();
  }

  public function findById(int $id): ?Tag
  {
    $array = $this->tagRepository->selectById($id);

    if (!$array) {
      return null;
    }

    $tag = new Tag((object) $array[0]);

    // タグのid, nameを配列から削除し、記事情報だけの配列を作成
    $articles = array_map(function ($v) {
      if (empty($v["article_id"])) return;
      unset($v["id"]);
      unset($v["name"]);
      return $v;
    }, $array);

    $tag->setArticles($articles);

    return $tag;
  }

  public function save(CreateTagDto $createTagDto): int
  {
    $createTag = new Tag($createTagDto);

    $result = $this->tagRepository->insert($createTag);
    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }
    return $result;
  }

  public function update(UpdateTagDto $updateTagDto): bool
  {
    $updateTag = new Tag($updateTagDto);
    return $this->tagRepository->update($updateTag);
  }
}
