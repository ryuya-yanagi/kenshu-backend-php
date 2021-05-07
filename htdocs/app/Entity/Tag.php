<?php

namespace App\Entity;

class Tag
{
  private int $id;
  private string $name;

  function __construct(object $obj)
  {
    foreach ($obj as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  public function &__get($name)
  {
    return $this->$name;
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
