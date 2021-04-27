<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Adapter\Repositories\Interfaces\iAuthRepository;
use App\Usecase\Interfaces\iAuthInteractor;

class AuthInteractor implements iAuthInteractor
{
  protected iAuthRepository $authRepository;

  function __construct(iAuthRepository $ar)
  {
    $this->authRepository = $ar;
  }

  public function Validate(LoginUserDto $validateUser)
  {
    $target = $this->authRepository->SelectUserByName($validateUser->name);

    if (!property_exists($target, "id") || !property_exists($target, "name") || !property_exists($target, "password_hash")) {
      return false;
    }

    if (!password_verify($validateUser->password, $target->password_hash)) {
      return false;
    }

    return $target;
  }
}
