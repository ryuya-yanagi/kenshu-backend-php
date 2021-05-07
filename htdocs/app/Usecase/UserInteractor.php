<?php

namespace App\Usecase;

use App\Adapter\Repositories\Interfaces\iUserRepository;
use App\Entity\User;
use App\Usecase\Interfaces\iUserInteractor;

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

    $user->setArticles($articles);
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
}
