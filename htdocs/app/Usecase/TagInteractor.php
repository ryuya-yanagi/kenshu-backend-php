<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Tag\CreateTagDto;
use App\Adapter\Controllers\DTO\Tag\UpdateTagDto;
use App\Adapter\Repositories\Interfaces\iTagRepository;
use App\Entity\Errors\ValidationException;
use App\Entity\Tag;
use App\Usecase\Interfaces\iTagInteractor;

class TagInteractor implements iTagInteractor
{
  protected iTagRepository $tagRepository;

  function __construct(iTagRepository $tr)
  {
    $this->tagRepository = $tr;
  }

  public function ListTag(): array
  {
    return $this->tagRepository->SelectAll();
  }

  public function FindById(int $id): ?Tag
  {
    $array = $this->tagRepository->SelectById($id);

    if (!$array) {
      return null;
    }

    return new Tag((object) $array);
  }

  public function Save(CreateTagDto $createTagDto): int
  {
    $createTag = new Tag($createTagDto);

    $valError = $createTag->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    return $this->tagRepository->Insert($createTag);
  }

  public function Update(UpdateTagDto $updateTagDto): bool
  {
    $updateTag = new Tag($updateTagDto);
    return $this->tagRepository->Update($updateTag);
  }
}
