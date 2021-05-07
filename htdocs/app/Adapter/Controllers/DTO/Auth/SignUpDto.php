<?php

namespace App\Adapter\Controllers\DTO\Auth;

class SignUpDto
{
  public string $name;
  public string $password;

  function __construct(object $obj)
  {
    $this->name = $obj->name;
    $this->password = $obj->password;
  }
}
