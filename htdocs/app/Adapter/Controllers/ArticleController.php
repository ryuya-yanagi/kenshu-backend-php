<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
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

  public function show(string $uri): Article
  {
    $id = intval((explode('/', $uri)[2]));
    if ($id == 0) {
      throw new Exception("指定したIDは無効です");
    }
    $article = $this->articleInteractor->FindById($id);

    if (!$article) {
      throw new NotFoundException();
    }
    return $article;
  }

  public function post($user_id, $input, $files)
  {
    $user_id = intval($user_id);
    if ($user_id == 0) {
      return http_response_code(400);
    }

    $createArticleDto = new CreateArticleDto($user_id, (object) $input, $files);

    try {
      $createArticleId = $this->articleInteractor->Save($createArticleDto);
      header("Location: /articles/$createArticleId");
    } catch (ValidationException $e) {
      throw $e;
    } catch (Exception $e) {
      throw $e;
    }
  }
}
