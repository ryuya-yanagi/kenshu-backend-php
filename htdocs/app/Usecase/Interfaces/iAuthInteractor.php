<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;

interface iAuthInteractor
{
  public function Validate(LoginUserDto $validateUser): ?object;
}
