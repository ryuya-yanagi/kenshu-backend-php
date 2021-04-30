<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Photo;

interface iPhotoRepository extends iBaseRepository
{
  public function SelectAll(): ?array;
  public function SelectById(int $id): ?object;
  public function Insert(Photo $photo): ?int;
  public function InsertValues(int $article_id, array $photoUrlList): ?int;
}
