<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Tag;

interface iTagRepository extends iBaseRepository
{
  public function selectAll(): ?array;
  public function selectById(int $id): ?object;
  public function insert(Tag $tag): ?int;
  public function update(Tag $tag): bool;
}
