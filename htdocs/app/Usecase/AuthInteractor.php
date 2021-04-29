<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Adapter\Repositories\Interfaces\iAuthRepository;
use App\Entity\User;
use App\Usecase\Interfaces\iAuthInteractor;

class AuthInteractor implements iAuthInteractor
{
  protected iAuthRepository $authRepository;

  function __construct(iAuthRepository $ar)
  {
    $this->authRepository = $ar;
  }

  public function Validate(LoginUserDto $validateUser): ?User
  {
    $target = $this->authRepository->SelectUserByName($validateUser->name);

    if (!$target) {
      return null;
    }

    $user = new User();
    $user->id = $target->id;
    $user->name = $target->name;
    $user->setPassword($target->password_hash);

    if (!$user->verify_pass($validateUser->password)) {
      return null;
    }

    return $user;
  }
}
