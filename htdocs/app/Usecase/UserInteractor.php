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

  public function findAll(): array
  {
    return $this->userRepository->selectAll();
  }

  public function findById(int $id): ?User
  {
    $array = $this->userRepository->selectById($id);

    if (!$array) {
      return null;
    }

    $user = new User((object) $array[0]);
    $articles = array();

    foreach ($array as $record) {
      $article = [];
      foreach ($record as $key => $value) {
        if ($key !== "id" && $key !== "name") {
          $article[$key] = $value;
        }
      }
      array_push($articles, $article);
    }

    $user->articles = $articles;
    return $user;
  }

  public function findByName(string $name): ?User
  {
    $obj = $this->userRepository->selectByName($name);

    if (!$obj) {
      return null;
    }

    return new User($obj);
  }

  public function save(CreateUserDto $createUserDto): int
  {
    $valError = User::validation($createUserDto->name, $createUserDto->password);

    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $findUser = $this->findByName($createUserDto->name);
    if ($findUser) {
      throw new Exception("既に登録されているユーザー名です");
    }

    $createUser = new User($createUserDto);
    $pass_hash = User::hash_pass($createUserDto->password);
    $createUser->setPassword($pass_hash);

    return $this->userRepository->insert($createUser);
  }

  public function update(UpdateUserDto $updateUserDto): bool
  {
    $valError = User::validation($updateUserDto->name, $updateUserDto->password);

    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $updateUser = new User($updateUserDto);
    $updateUser->setPassword($updateUserDto->password);

    return $this->userRepository->update($updateUser);
  }

  public function delete(int $id): bool
  {
    return $this->userRepository->delete($id);
  }
}
