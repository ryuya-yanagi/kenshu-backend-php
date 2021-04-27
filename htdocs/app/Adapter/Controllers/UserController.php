<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Adapter\Controllers\Interfaces\iUserController;
use App\Adapter\Presentators\Interfaces\iUserPresentator;
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
    $id = intval((explode('/', $uri)[1]));
    if (gettype($id) != "integer") {
      return;
    }
    $user = $this->userInteractor->FindById($id);
    return $this->userPresentation->show($user);
  }

  public function post($obj)
  {
    $name = $obj['name'];
    $password = $obj['password'];

    if (!CreateUserDto::isExists($name, $password)) {
      return;
    }

    $cud = new CreateUserDto($name, $password);
    return $this->userInteractor->Save($cud);
  }

  public function patch($obj)
  {
    $name = $obj['name'];
    $password = $obj['password'];

    if (!UpdateUserDto::isExists($name, $password)) {
      return;
    }

    $cud = new UpdateUserDto($name, $password);
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
