<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Photo\CreatePhotoDto;
use App\Adapter\Repositories\Interfaces\iPhotoRepository;
use App\Entity\Errors\ValidationException;
use App\Entity\Photo;
use App\Usecase\Interfaces\iPhotoInteractor;

class PhotoInteractor implements iPhotoInteractor
{
  protected iPhotoRepository $photoRepository;

  function __construct(iPhotoRepository $pr)
  {
    $this->photoRepository = $pr;
  }

  public function ListPhoto(): array
  {
    return $this->photoRepository->SelectAll();
  }

  public function FindById(int $id): ?Photo
  {
    $obj = $this->photoRepository->SelectById($id);

    if (!$obj) {
      return null;
    }

    return new Photo($obj);
  }

  public function Save(CreatePhotoDto $cad): int
  {
    $createPhoto = new Photo($cad);
    $valError = $createPhoto->validation();

    if (count($valError)) {
      throw new ValidationException($valError);
    }

    return $this->photoRepository->Insert($createPhoto);
  }
}
