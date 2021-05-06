<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Tag\CreateTagDto;
use App\Adapter\Controllers\DTO\Tag\UpdateTagDto;
use App\Entity\Tag;

interface iTagInteractor
{
  public function ListTag(): array;
  public function FindById(int $id): ?Tag;
  public function Save(CreateTagDto $createTagDto): int;
  public function Update(UpdateTagDto $updateTagDto): bool;
}
