<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Tag;

interface iTagRepository extends iBaseRepository
{
  public function SelectAll(): ?array;
  public function SelectById(int $id): ?object;
  public function Insert(Tag $tag): ?int;
  public function Update(Tag $tag): bool;
}
