<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\DTO\Tag\CreateTagDto;
use App\Adapter\Controllers\DTO\Tag\UpdateTagDto;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\Interfaces\iTagController;
use App\Entity\Tag;
use App\Usecase\Interfaces\iTagInteractor;
use Exception;

class TagController implements iTagController
{
  protected iTagInteractor $tagInteractor;

  function __construct(iTagInteractor $ti)
  {
    $this->tagInteractor = $ti;
  }

  public function index(): array
  {
    return $this->tagInteractor->findAll();
  }

  public function show(string $id): Tag
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定したIDは無効です");
    }
    $tag = $this->tagInteractor->findById($id_int);

    if (!$tag) {
      throw new NotFoundException();
    }
    return $tag;
  }

  public function post(object $obj)
  {
    $createTagDto = new CreateTagDto($obj);

    $createTagId = $this->tagInteractor->save($createTagDto);
    header("Location: /tags/$createTagId");
  }

  public function update(object $obj)
  {
    $updateTagDto = new UpdateTagDto($obj);

    $result = $this->tagInteractor->update($updateTagDto);
    if (!$result) {
      throw new Exception("データの更新に失敗しました");
    }
    header("Location: /tags/$updateTagDto->id");
  }
}
