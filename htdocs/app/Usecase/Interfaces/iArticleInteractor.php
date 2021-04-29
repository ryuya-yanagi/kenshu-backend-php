<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;

interface iArticleInteractor
{
  public function ListArticle(): array;
  public function FindById(int $id): ?object;
  public function Save(CreateArticleDto $cad): int;
  public function Update(): bool;
  public function Delete(): bool;
}
