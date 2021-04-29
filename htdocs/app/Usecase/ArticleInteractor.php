<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Entity\Article;
use App\Entity\Errors\ValidationException;
use App\Usecase\Interfaces\iArticleInteractor;

class ArticleInteractor implements iArticleInteractor
{
  protected iArticleRepository $articleRepository;

  function __construct(iArticleRepository $ar)
  {
    $this->articleRepository = $ar;
  }

  public function ListArticle(): array
  {
    return $this->articleRepository->SelectAll();
  }

  public function FindById(int $id): ?Article
  {
    $obj = $this->articleRepository->SelectById($id);

    if (!$obj) {
      return null;
    }

    return new Article($obj);
  }

  public function Save(CreateArticleDto $cad): int
  {
    $createArticle = new Article($cad);

    $valError = $createArticle->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    return $this->articleRepository->Insert($createArticle);
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
