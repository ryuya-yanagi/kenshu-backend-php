<?php

namespace App\Entity;

class Tag extends BaseEntity
{
  private int $id;
  private string $name;

  function __construct(object $obj)
  {
    foreach ($obj as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        switch ($key) {
          case "id":
            $this->setId($value);
            break;
          case "name":
            $this->setName($value);
            break;
        }
      }
    }
  }

  public function &__get($name)
  {
    return $this->$name;
  }

  public function setId($id)
  {
    if (!is_numeric($id)) {
      $this->illegalAssignment("id", $id);
    }

    if (!is_int($id)) {
      $id = (int) $id;
    }
    $this->id = $id;
  }

  public function setName(string $name)
  {
    if (empty($name) || 15 < strlen($name)) {
      $this->illegalAssignment("name", $name);
    }
    $this->name = $name;
  }
}
