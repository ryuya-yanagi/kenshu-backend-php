<?php

namespace App\Usecase;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Adapter\Repositories\Interfaces\iUserRepository;
use App\Entity\User;
use App\Entity\Errors\ValidationException;
use App\Usecase\Interfaces\iUserInteractor;
use Exception;

class UserInteractor implements iUserInteractor
{
  protected iUserRepository $userRepository;

  function __construct(iUserRepository $ur)
  {
    $this->userRepository = $ur;
  }

  public function ListUser(): array
  {
    return $this->userRepository->SelectAll();
  }

  public function FindById(int $id): ?User
  {
    $array = $this->userRepository->SelectById($id);

    if (!$array) {
      return null;
    }

    $user = new User((object) $array[0]);
    $articleList = array();

    foreach ($array as $index => $record) {
      $article = [];
      foreach ($record as $key => $value) {
        if ($key !== "id" && $key !== "name") {
          $article[$key] = $value;
        }
      }
      array_push($articleList, $article);
    }

    $user->articleList = $articleList;
    return $user;
  }

  public function FindByName(string $name): ?User
  {
    $obj = $this->userRepository->SelectByName($name);

    if (!$obj) {
      return null;
    }

    return new User($obj);
  }

  public function Save(CreateUserDto $createUserDto): int
  {
    $valError = User::validation($createUserDto->name, $createUserDto->password);

    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $findUser = $this->FindByName($createUserDto->name);
    if ($findUser) {
      throw new Exception("既に登録されているユーザー名です");
    }

    $createUser = new User($createUserDto);
    $createUser->setPassword(User::hash_pass($createUserDto->password));

    return $this->userRepository->Insert($createUser);
  }

  public function Update(UpdateUserDto $updateUserDto): bool
  {
    $valError = User::validation($updateUserDto->name, $updateUserDto->password);

    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $updateUser = new User($updateUserDto);
    $updateUser->setPassword($updateUserDto->password);

    return $this->userRepository->Update($updateUser);
  }

  public function Delete(int $id): bool
  {
    return $this->userRepository->Delete($id);
  }
}
