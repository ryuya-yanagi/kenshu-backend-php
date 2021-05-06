<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Controllers\DTO\Article\UpdateArticleDto;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\Interfaces\iArticleController;
use App\Entity\Article;
use App\Entity\Errors\ValidationException;
use App\Usecase\Interfaces\iArticleInteractor;
use Exception;

class ArticleController implements iArticleController
{
  protected iArticleInteractor $articleInteractor;

  function __construct(iArticleInteractor $ai)
  {
    $this->articleInteractor = $ai;
  }

  public function index(): array
  {
    return $this->articleInteractor->ListArticle();
  }

  public function show(string $id): Article
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定したIDは無効です");
    }
    $article = $this->articleInteractor->FindById($id_int);

    if (!$article) {
      throw new NotFoundException();
    }
    return $article;
  }

  public function post($user_id, $input, $photos)
  {
    $user_id = intval($user_id);
    if ($user_id == 0) {
      return http_response_code(400);
    }

    $createArticleDto = new CreateArticleDto($user_id, (object) $input, $photos);

    try {
      $createArticleId = $this->articleInteractor->Save($createArticleDto);
      header("Location: /articles/$createArticleId");
    } catch (ValidationException $e) {
      throw $e;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function update(object $obj)
  {
    $updateArticleDto = new UpdateArticleDto($obj);

    try {
      $this->articleInteractor->Update($updateArticleDto);
      header("Location: /articles/{$updateArticleDto->id}");
    } catch (ValidationException $e) {
      throw $e;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function delete(string $id)
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定されたIDは無効です");
    }

    $article = $this->articleInteractor->FindById($id_int);
    if (!$article) {
      throw new NotFoundException();
    }

    try {
      $deleteResult = $this->articleInteractor->Delete($id_int);
      if (!$deleteResult) {
        throw new Exception("データの削除に失敗しました");
      }
      header("Location: /mypage");
    } catch (Exception $e) {
      throw $e;
    }
  }
}
