<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Adapter\Repositories\Interfaces\iPhotoRepository;
use App\Adapter\Uploaders\Interfaces\iPhotoUploader;
use App\Entity\Article;
use App\Entity\Errors\ValidationException;
use App\Usecase\Interfaces\iArticleInteractor;
use Exception;

class ArticleInteractor implements iArticleInteractor
{
  protected iArticleRepository $articleRepository;
  protected ?iPhotoRepository $photoRepository;
  protected ?iPhotoUploader $photoUploader;

  function __construct(iArticleRepository $ar, iPhotoRepository $pr = null, iPhotoUploader $pu = null)
  {
    $this->articleRepository = $ar;
    $this->photoRepository = $pr;
    $this->photoUploader = $pu;
  }

  public function ListArticle(): array
  {
    return $this->articleRepository->SelectAll();
  }

  public function FindById(int $id): ?Article
  {
    $array = $this->articleRepository->SelectById($id);

    if (!$array) {
      return null;
    }

    $article = new Article((object) $array[0]);
    $photos = array();

    foreach ($array as $record) {
      foreach ($record as $key => $value) {
        if ($key === "photo" && $value) {
          array_push($photos, $value);
        }
      }
    }

    $article->photos = $photos;
    return $article;
  }

  public function Save(CreateArticleDto $cad): int
  {
    $createArticle = new Article($cad);

    $valError = $createArticle->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $createArticleId = $this->articleRepository->Insert($createArticle);

    $photoUrlList = [];
    foreach ($createArticle->photos as $photo) {
      for ($i = 0; $i < count($photo["name"]); $i++) {
        $result = $this->photoUploader->upload($createArticleId, $photo["tmp_name"][$i], $photo["name"][$i]);
        if (!$result) {
          throw new Exception("画像のアップロードに失敗しました");
        }
        array_push($photoUrlList, $result);
      }
    }

    $result = $this->photoRepository->InsertValues($createArticleId, $photoUrlList);
    if (!$result) {
      throw new Exception("画像の登録に失敗しました");
    }

    return $createArticleId;
  }

  public function Update(): bool
  {
    return true;
  }

  public function Delete(): bool
  {
    return true;
  }
}
