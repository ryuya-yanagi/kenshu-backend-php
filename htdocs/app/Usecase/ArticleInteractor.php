<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Controllers\DTO\Article\UpdateArticleDto;
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

  public function Save(CreateArticleDto $createArticleDto): int
  {
    $createArticle = new Article($createArticleDto);

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

      $insertResult = $this->photoRepository->InsertValues($createArticleId, $photoUrlList);
      if (!$insertResult) {
        throw new Exception("画像の登録に失敗しました");
      }

      $createArticle->id = $createArticleId;
      $createArticle->thumbnail_id = $insertResult;
      $updateResult = $this->articleRepository->Update($createArticle);
      if (!$updateResult) {
        throw new Exception("サムネイルの設定に失敗しました");
      }

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

  public function Update(UpdateArticleDto $updateArticleDto)
  {
    $article = new Article($updateArticleDto);

    $valError = $article->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $result = $this->articleRepository->Update($article);
    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }
    return $result;
  }

  public function Delete(int $id): bool
  {
    return $this->articleRepository->Delete($id);
  }
}
