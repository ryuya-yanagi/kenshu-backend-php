<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Controllers\DTO\Article\UpdateArticleDto;
use App\Entity\Article;

interface iArticleInteractor
{
  public function ListArticle(): array;
  public function FindById(int $id): ?Article;
  public function Save(CreateArticleDto $createArticleDto): int;
  public function Update(UpdateArticleDto $updateArticleDto);
  public function Delete(int $id): bool;
}
