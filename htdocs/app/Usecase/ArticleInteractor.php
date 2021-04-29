<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Entity\Article;
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

  public function FindById(int $id): ?object
  {
    return $this->articleRepository->SelectById($id);
  }

  public function Save(CreateArticleDto $cad): int
  {
    $createArticle = new Article();

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
