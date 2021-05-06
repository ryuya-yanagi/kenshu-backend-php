<?php

namespace App\Entity;

class Photo
{
  public int $id;
  public string $url;
  public int $article_id;

  function __construct(object $obj = null)
  {
    if ($obj) {
      if (isset($obj->id)) $this->id = $obj->id;
      if (isset($obj->url)) $this->url = $obj->url;
      if (isset($obj->article_id)) $this->article_id =  intval($obj->article_id);
    }
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
