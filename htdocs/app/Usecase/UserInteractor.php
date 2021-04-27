<?php

namespace App\Usecase;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Adapter\Repositories\Interfaces\iUserRepository;
use App\Entity\User;
use App\Usecase\Errors\UsecaseException;
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

  public function FindByName(string $name)
  {
    return $this->userRepository->SelectByName($name);
  }

  public function Save(CreateUserDto $createUserDto)
  {
    $valError = User::validation($createUserDto->name, $createUserDto->password);

    if (count($valError) != 0) {
      throw new UsecaseException($valError);
    }

    $createUser = new User(null, $createUserDto->name, User::hash_pass($createUserDto->password));

    return $this->userRepository->Insert($createUser);
  }

  public function Update(UpdateUserDto $updateUserDto)
  {
    $valError = User::validation($updateUserDto->name, $updateUserDto->password);

    if (count($valError)) {
      throw new UsecaseException($valError);
    }

    $updateUser = new User($updateUserDto->id, $updateUserDto->name, $updateUserDto->password);

    return $this->userRepository->Update($updateUser);
  }

  public function Delete(int $id)
  {
    return $this->userRepository->Delete($id);
  }
}
