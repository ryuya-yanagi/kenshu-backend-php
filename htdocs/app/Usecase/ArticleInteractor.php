<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Controllers\DTO\Article\UpdateArticleDto;
use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Adapter\Repositories\Interfaces\iArticleTagRepository;
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
  protected ?iArticleTagRepository $articleTagRepository;

  function __construct(iArticleRepository $ar, iPhotoRepository $pr = null, iPhotoUploader $pu = null, iArticleTagRepository $atr = null)
  {
    $this->articleRepository = $ar;
    $this->photoRepository = $pr;
    $this->photoUploader = $pu;
    $this->articleTagRepository = $atr;
  }

  public function findAll(): array
  {
    return $this->articleRepository->selectAll();
  }

  public function findById(int $id): ?Article
  {
    $array = $this->articleRepository->selectById($id);

    if (!$array) {
      return null;
    }

    $article = new Article((object) $array[0]);
    $photos = array();
    $prevPhoto = null;
    $tags = array();
    $prevTag = null;

    foreach ($array as $record) {
      foreach ($record as $key => $value) {
        switch ($key) {
          case ($key === "photo" && !empty($value) && $prevPhoto !== $value):
            array_push($photos, $value);
            $prevPhoto = $value;
            break;
          case ($key === "tag_name" && !empty($value) && $prevTag !== $value):
            array_push($tags, $value);
            $prevTag = $value;
            break;
        }
      }
    }

    $article->photos = $photos;
    $article->tags = $tags;
    return $article;
  }

  public function save(CreateArticleDto $createArticleDto): int
  {
    $createArticle = new Article($createArticleDto);

    $valError = $createArticle->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    // トランザクション開始
    $this->articleRepository->beginTransaction();
    try {
      $createArticleId = $this->articleRepository->insert($createArticle);

      // 記事に画像が付与されている時
      if (!empty($createArticle->photos["name"][0])) {
        // 画像をアップロード
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

        // アップロードされた画像をDBに登録
        $insertResult = $this->photoRepository->insertValues($createArticleId, $photoUrlList);
        if (!$insertResult) {
          throw new Exception("画像の登録に失敗しました");
        }

        // DBに登録された画像のIDを記事のサムネイルに登録
        $createArticle->id = $createArticleId;
        $createArticle->thumbnail_id = $insertResult;
        $updateResult = $this->articleRepository->update($createArticle);
        if (!$updateResult) {
          throw new Exception("サムネイルの設定に失敗しました");
        }
      }

      // 記事にタグが付与されている時
      if (!empty($createArticle->tags)) {
        // articles_tagsテーブルに保存
        $this->articleTagRepository->insertValues($createArticleId, $createArticle->tags);
      }

      // コミット
      $this->articleRepository->commit();

      return $createArticleId;
    } catch (Exception $e) {
      // ロールバック
      $this->articleRepository->rollBack();
      $this->photoUploader->rollBack();
      throw $e;
    }
  }

  public function update(UpdateArticleDto $updateArticleDto)
  {
    $article = new Article($updateArticleDto);

    $valError = $article->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $result = $this->articleRepository->update($article);
    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }
    return $result;
  }

  public function delete(int $id): bool
  {
    return $this->articleRepository->delete($id);
  }
}
