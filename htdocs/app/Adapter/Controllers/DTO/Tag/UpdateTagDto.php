<?php

namespace App\Adapter\Controllers\DTO\Tag;

class UpdateTagDto
{
  public int $id;
  public string $name;

  function __construct(object $obj)
  {
    $this->id = $obj->id;
    $this->name = $obj->name;
  }
}
