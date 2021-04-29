<?php

namespace App\Adapter\Controllers\DTO\User;

class UpdateUserDto extends BaseUserDto
{
  public string $id;

  function __construct(object $obj)
  {
    parent::__construct($obj);
    $this->id = $obj->id;
  }
}
