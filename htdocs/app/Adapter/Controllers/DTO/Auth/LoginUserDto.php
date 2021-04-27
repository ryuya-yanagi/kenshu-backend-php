<?php

namespace App\Adapter\Controllers\DTO\Auth;

class LoginUserDto
{
  public string $name;
  public string $password;

  function __construct(string $name, string $password)
  {
    $this->name = $name;
    $this->password = $password;
  }
}
