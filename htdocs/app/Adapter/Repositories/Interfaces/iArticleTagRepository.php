<?php

namespace App\Adapter\Repositories\Interfaces;

interface iArticleTagRepository extends iBaseRepository
{
  public function Insert(int $article_id, int $tag_id): ?int;
  public function InsertValues(int $article_id, array $tagIdList): ?int;
}
