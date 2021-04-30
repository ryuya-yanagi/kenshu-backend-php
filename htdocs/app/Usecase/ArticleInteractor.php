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

    // トランザクション開始
    $this->articleRepository->BeginTransaction();
    try {
      $createArticleId = $this->articleRepository->Insert($createArticle);

      if (empty($createArticle->photos["name"][0])) {
        return $createArticleId;
      }

      $photoUrlList = [];
      $photos = $createArticle->photos;
      for ($i = 0; $i < count($photos["name"]); $i++) {
        $this->photoUploader->setPhotoInfo($createArticleId, $photos["tmp_name"][$i], $photos["name"][$i]);
        $result = $this->photoUploader->upload();
        if (!$result) {
          throw new Exception("画像のアップロードに失敗しました");
        }
        array_push($photoUrlList, $result);
      }

      $result = $this->photoRepository->InsertValues($createArticleId, $photoUrlList);
      if (!$result) {
        throw new Exception("画像の登録に失敗しました");
      }

      $createArticle->id = $createArticleId;
      $createArticle->thumbnail_id = $result;
      $this->articleRepository->Update($createArticle);

      // コミット
      $this->articleRepository->Commit();

      return $createArticleId;
    } catch (Exception $e) {
      // ロールバック
      $this->articleRepository->RollBack();
      $this->photoUploader->rollback();
      throw $e;
    }
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
