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

  public function validation()
  {
    $valError = array();

    if (empty($this->name)) {
      $valError["name"] = "入力必須項目です";
    } elseif (strlen($this->name) > 15) {
      $valError["name"] = "15文字以内にしてください";
    }

    return $valError;
  }
}
