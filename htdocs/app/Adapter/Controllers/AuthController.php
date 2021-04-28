<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Adapter\Controllers\Interfaces\iAuthController;
use App\Adapter\Presentators\Interfaces\iAuthPresentator;
use App\Usecase\Interfaces\iAuthInteractor;
use Exception;

class AuthController implements iAuthController
{
  protected iAuthInteractor $authInteractor;

  function __construct(iAuthInteractor $ai)
  {
    $this->authInteractor = $ai;
  }

  public function login($obj)
  {
    $name = $obj["name"];
    $password = $obj["password"];

    $lud = new LoginUserDto($name, $password);

    $result = $this->authInteractor->Validate($lud);
    if (!$result) {
      throw new Exception("ログインに失敗しました");
    }
    return $result;
  }
}
