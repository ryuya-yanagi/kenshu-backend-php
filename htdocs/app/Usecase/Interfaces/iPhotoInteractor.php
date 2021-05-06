<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Photo\CreatePhotoDto;
use App\Entity\Photo;

interface iPhotoInteractor
{
  public function ListPhoto(): array;
  public function FindById(int $id): ?Photo;
  public function Save(CreatePhotoDto $cad): int;
}
