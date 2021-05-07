<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Adapter\Controllers\DTO\Auth\SignUpDto;
use App\Adapter\Repositories\Interfaces\iAuthRepository;
use App\Entity\Auth;
use App\Entity\Errors\ValidationException;
use App\Usecase\Interfaces\iAuthInteractor;
use Exception;

class AuthInteractor implements iAuthInteractor
{
  protected iAuthRepository $authRepository;

  function __construct(iAuthRepository $ar)
  {
    $this->authRepository = $ar;
  }

  public function validate(LoginUserDto $loginUserDto): ?Auth
  {
    $target = $this->authRepository->selectUserByName($loginUserDto->name);

    if (!$target) {
      return null;
    }

    $auth = new Auth($target);

    if (!$auth->verify_pass($loginUserDto->password)) {
      return null;
    }

    return $auth;
  }

  public function register(SignUpDto $signUpDto): int
  {
    $createAuth = new Auth($signUpDto);

    $valError = $createAuth->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    // passwordをハッシュ
    $createAuth->hash_pass();

    $result = $this->authRepository->insert($createAuth);
    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }
    return $result;
  }
}
