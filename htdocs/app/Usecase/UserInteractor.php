<?php

namespace App\Usecase;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Adapter\Repository\Interfaces\iUserRepository;
use App\Usecase\Interfaces\iUserInteractor;

class UserInteractor implements iUserInteractor
{
  protected iUserRepository $userRepository;

  function __construct(iUserRepository $ur)
  {
    $this->userRepository = $ur;
  }

  public function ListUser()
  {
    return $this->userRepository->SelectAll();
  }

  public function FindById(int $id)
  {
    return $this->userRepository->SelectById($id);
  }

  public function Save(CreateUserDto $user)
  {
    return $this->userRepository->Insert($user);
  }

  public function Update(UpdateUserDto $user)
  {
    return $this->userRepository->Update($user);
  }

  public function Delete(int $id)
  {
    return $this->userRepository->Delete($id);
  }
}
