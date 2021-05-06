<?php

namespace App\Entity;

class Tag
{
  public int $id;
  public string $name;

  function __construct(object $obj = null)
  {
    if ($obj) {
      if (isset($obj->id)) $this->id = $obj->id;
      if (isset($obj->name)) $this->name = $obj->name;
    }
  }
}
