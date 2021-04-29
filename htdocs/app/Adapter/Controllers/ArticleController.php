<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\Interfaces\iArticleController;
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

  public function show(string $uri): object
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
}
