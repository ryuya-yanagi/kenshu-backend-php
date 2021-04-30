<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Entity\Article;

interface iArticleInteractor
{
  public function ListArticle(): array;
  public function FindById(int $id): ?Article;
  public function Save(CreateArticleDto $cad): int;
  public function Update(): bool;
  public function Delete(): bool;
}
