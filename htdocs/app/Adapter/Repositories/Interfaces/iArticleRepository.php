<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Article;

interface iArticleRepository extends iBaseRepository
{
  public function selectAll(): array;
  public function selectById(int $id): ?array;
  public function insert(Article $article): ?int;
  public function update(Article $article): bool;
  public function delete(int $id): bool;
}
