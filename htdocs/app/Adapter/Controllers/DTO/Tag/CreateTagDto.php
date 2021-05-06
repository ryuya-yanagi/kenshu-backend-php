<?php

namespace App\Adapter\Controllers\DTO\Tag;

class CreateTagDto
{
  public string $name;

  function __construct(object $obj)
  {
    $this->name = $obj->name;
  }
}
