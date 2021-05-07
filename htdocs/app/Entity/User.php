<?php

namespace App\Entity;

use RuntimeException;

class User
{
  private ?int $id;
  private string $name;
  private ?array $articles = [];

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

  public function setId(string $id)
  {
    if (!is_int($id)) {
      throw new RuntimeException("Invalid value for user.id: $id");
    }
    $this->id = $id;
  }

  public function setName(string $name)
  {
    if (!strlen($name)) {
      throw new RuntimeException("Invalid value for user.name: $name");
    }
    $this->name = $name;
  }

  public function setArticles(array $articles)
  {
    if (!is_array($articles)) {
      throw new RuntimeException("Invalid value for user.articles: $articles");
    }
    $this->articles = $articles;
  }
}
