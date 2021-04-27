<?php

namespace App\Adapter\Controllers\DTO\User;

class UpdateUserDto extends BaseUserDto
{
  public string $id;

  function __construct(string $id, string $name, string $password)
  {
    parent::__construct($name, $password);
    $this->id = $id;
  }
}
