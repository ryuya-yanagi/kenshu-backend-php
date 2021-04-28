<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Adapter\Controllers\Interfaces\iAuthController;
use App\Adapter\Presentators\Interfaces\iAuthPresentator;
use App\Usecase\Interfaces\iAuthInteractor;

class AuthController implements iAuthController
{
  protected iAuthInteractor $authInteractor;
  protected iAuthPresentator $authPresentator;

  function __construct(iAuthInteractor $ai, iAuthPresentator $ap)
  {
    $this->authInteractor = $ai;
    $this->authPresentator = $ap;
  }

  public function login($obj)
  {
    $name = $obj["name"];
    $password = $obj["password"];

    $lud = new LoginUserDto($name, $password);

    $result = $this->authInteractor->Validate($lud);
    if (!$result) {
      return $this->authPresentator->outMessage("ログインに失敗しました");
    }
    return $result;
  }
}