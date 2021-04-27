<?php

namespace App\Adapter\Controllers\DTO\User;

use App\Adapter\Controllers\DTO\BaseDto;

class CreateUserDto extends BaseDto
{
  public string $name;
  public string $password;

  function __construct(string $name, string $password)
  {
    $this->name = $name;
    $this->password = $password;
  }
}
