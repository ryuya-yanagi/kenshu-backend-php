<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\Interfaces\iUserController;
use App\Entity\User;
use App\Usecase\Errors\ValidationException;
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
    $userList = $this->userInteractor->ListUser();
    return $userList;
  }

  public function show(string $uri): User
  {
    $id = intval((explode('/', $uri)[2]));
    if ($id == 0) {
      throw new Exception("指定したIDは無効です");
    }
    $user = $this->userInteractor->FindById($id);

    if (!$user) {
      throw new NotFoundException();
    }
    return $user;
  }

  public function post($input)
  {
    $cud = new CreateUserDto((object) $input);

    try {
      $createUserId = $this->userInteractor->Save($cud);
      header("Location: /users/$createUserId");
    } catch (ValidationException $e) {
      throw $e;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function patch($input): bool
  {
    $cud = new UpdateUserDto((object) $input);
    return $this->userInteractor->Update($cud);
  }

  public function delete(string $uri): bool
  {
    $id = intval((explode('/', $uri)[1]));
    if (gettype($id) != "integer") {
      return false;
    }

    return $this->userInteractor->Delete($id);
  }
}
