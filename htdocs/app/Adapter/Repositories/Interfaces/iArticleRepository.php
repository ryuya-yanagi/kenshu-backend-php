<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Article;

interface iArticleRepository
{
  public function SelectAll(): array;
  public function SelectById(int $id): ?array;
  public function Insert(Article $article): int;
  public function Update(Article $article): bool;
  public function Delete(int $id): bool;
}
