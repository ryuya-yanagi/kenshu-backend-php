<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Adapter\Controllers\Interfaces\iUserController;
use App\Adapter\Presentators\Interfaces\iUserPresentator;
use App\Usecase\Errors\UsecaseException;
use App\Usecase\Interfaces\iUserInteractor;

class UserController implements iUserController
{
  protected iUserInteractor $userInteractor;
  protected iUserPresentator $userPresentator;

  function __construct(iUserInteractor $ui, iUserPresentator $up)
  {
    $this->userInteractor = $ui;
    $this->userPresentator = $up;
  }

  public function index()
  {
    $userList = $this->userInteractor->ListUser();
    return $this->userPresentator->index($userList);
  }

  public function show(string $uri)
  {
    $id = intval((explode('/', $uri)[2]));
    if ($id == 0) {
      return $this->userPresentator->outMessage("指定したIDは無効です");
    }
    $user = $this->userInteractor->FindById($id);

    if (!property_exists($user, "id") || !property_exists($user, "name")) {
      return $this->userPresentator->viewNotFound();
    }
    return $this->userPresentator->show($user);
  }

  public function post($obj)
  {
    $name = $obj['name'];
    $password = $obj['password'];

    $cud = new CreateUserDto($name, $password);

    try {
      $this->userInteractor->Save($cud);
      header("Location: /users/");
    } catch (UsecaseException $e) {
      return $this->userPresentator->outUsecaseError($e);
    }
  }

  public function patch($obj)
  {
    $id = $obj['id'];
    $name = $obj['name'];
    $password = $obj['password'];

    $cud = new UpdateUserDto($id, $name, $password);
    return $this->userInteractor->Update($cud);
  }

  public function delete(string $uri)
  {
    $id = intval((explode('/', $uri)[1]));
    if (gettype($id) != "integer") {
      return;
    }

    return $this->userInteractor->Delete($id);
  }
}
