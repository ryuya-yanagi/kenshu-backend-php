<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\Interfaces\iUserController;
use App\Entity\User;
use App\Usecase\Interfaces\iUserInteractor;
use Exception;

class UserController implements iUserController
{
  protected iUserInteractor $userInteractor;

  function __construct(iUserInteractor $ui)
  {
    $this->userInteractor = $ui;
  }

  public function index(): array
  {
    $userList = $this->userInteractor->findAll();
    return $userList;
  }

  public function show(string $id): User
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定したIDは無効です");
    }
    $user = $this->userInteractor->findById($id);

    if (!$user) {
      throw new NotFoundException();
    }
    return $user;
  }

  public function post(object $obj)
  {
    $createUserDto = new CreateUserDto($obj);

    $createUserId = $this->userInteractor->save($createUserDto);
    header("Location: /users/$createUserId");
  }

  public function patch(object $obj): bool
  {
    $updateUserDto = new UpdateUserDto($obj);
    return $this->userInteractor->update($updateUserDto);
  }

  public function delete(string $uri): bool
  {
    $id = intval((explode('/', $uri)[1]));
    if (gettype($id) != "integer") {
      return false;
    }

    return $this->userInteractor->delete($id);
  }
}
