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

  public function Validate(LoginUserDto $validateUser): ?object
  {
    $target = $this->authRepository->SelectUserByName($validateUser->name);

    if (!$target) {
      return null;
    }

    if (!password_verify($validateUser->password, $target->password_hash)) {
      return null;
    }

    return $target;
  }
}
