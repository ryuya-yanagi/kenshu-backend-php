<?php

namespace App\Entity;

class Article
{
  public int $id;
  public string $title;
  public string $body;
  public int $thumbnail_id;
  public string $thumbnail_url;
  public string $username;
  public int $user_id;
  public array $photos;
  public array $tags;

  function __construct(object $obj = null)
  {
    if ($obj) {
      if (isset($obj->id)) $this->id = $obj->id;
      if (isset($obj->title)) $this->title = $obj->title;
      if (isset($obj->body)) $this->body = $obj->body;
      if (isset($obj->thumbnail_id)) $this->thumbnail_id = $obj->thumbnail_id;
      if (isset($obj->thumbnail_url)) $this->thumbnail_url = $obj->thumbnail_url;
      if (isset($obj->username)) $this->username = $obj->username;
      if (isset($obj->user_id)) $this->user_id = $obj->user_id;
      if (isset($obj->photos)) $this->photos = $obj->photos;
      if (isset($obj->tags)) $this->tags = $obj->tags;
    }
  }

  public function validation()
  {
    $valError = array();

    if (empty($this->title)) {
      $valError["title"] = "入力必須です";
    } elseif (strlen($this->title) > 30) {
      $valError["title"] = "30文字以内にしてください";
    }

    if (empty($this->body)) {
      $valError["body"] = "入力必須です";
    } elseif (strlen($this->body) > 200) {
      $valError["body"] = "200文字以内にしてください";
    }

    return $valError;
  }
}
