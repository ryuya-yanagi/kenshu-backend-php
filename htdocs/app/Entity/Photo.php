<?php

namespace App\Entity;

class Photo
{
  private int $id;
  private string $url;
  private int $article_id;

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

    if (empty($this->url)) {
      $valError["url"] = "URLが空になっています";
    }

    if (empty($this->article_id)) {
      $valError["article_id"] = "関連する記事のIDが空になっています";
    } elseif ($this->article_id == 0) {
      $valError["article_id"] = "関連する記事のIDが無効です";
    }

    return $valError;
  }
}
