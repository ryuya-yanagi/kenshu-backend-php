<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Controllers\DTO\Article\UpdateArticleDto;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\Interfaces\iArticleController;
use App\Entity\Article;
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
    return $this->articleInteractor->findAll();
  }

  public function show(string $id): Article
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定したIDは無効です");
    }
    $article = $this->articleInteractor->findById($id_int);

    if (!$article) {
      throw new NotFoundException();
    }
    return $article;
  }

  public function post(string $user_id, $obj, array $photos)
  {
    $user_id = intval($user_id);
    if ($user_id == 0) {
      return http_response_code(400);
    }

    $createArticleDto = new CreateArticleDto($user_id, $obj, $photos);

    $createArticleId = $this->articleInteractor->save($createArticleDto);
    header("Location: /articles/$createArticleId");
  }

  public function update(object $obj)
  {
    $updateArticleDto = new UpdateArticleDto($obj);

    $this->articleInteractor->update($updateArticleDto);
    header("Location: /articles/{$updateArticleDto->id}");
  }

  public function delete(string $id)
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定されたIDは無効です");
    }

    $article = $this->articleInteractor->findById($id_int);
    if (!$article) {
      throw new NotFoundException();
    }

    $this->articleInteractor->delete($id_int);
    header("Location: /mypage");
  }
}
