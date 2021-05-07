<?php

namespace App\Entity;

use RuntimeException;

class Article
{
  private int $id;
  private string $title;
  private string $body;
  private int $thumbnail_id;
  private string $thumbnail_url;
  private string $username;
  private int $user_id;
  private array $photos = [];
  private array $tags = [];

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

  public function setId(int $id)
  {
    if (!is_int($id)) {
      $this->illegalAssignment("id", $id);
    }
    $this->id = $id;
  }

  public function setTitle(string $title)
  {
    if (empty($title) || strlen($title) > 30) {
      $this->illegalAssignment("title", $title);
    }
    $this->title = $title;
  }

  public function setBody(string $body)
  {
    if (empty($body) || strlen($body) > 200) {
      $this->illegalAssignment("body", $body);
    }
    $this->body = $body;
  }

  public function setThumbnailId(int $thumbnail_id)
  {
    if (!is_int($thumbnail_id)) {
      $this->illegalAssignment("thumbnail_id", $thumbnail_id);
    }
    $this->thumbnail_id = $thumbnail_id;
  }

  public function setThumbnailUrl(string $thumbnail_url)
  {
    $this->thumbnail_url = $thumbnail_url;
  }

  public function setUsername(string $username)
  {
    $this->username = $username;
  }

  public function setUserId(int $user_id)
  {
    if (!is_int($user_id)) {
      $this->illegalAssignment("user_id", $user_id);
    }
    $this->user_id = $user_id;
  }

  public function setPhotos(array $photos)
  {
    if (!is_array($photos)) {
      $this->illegalAssignment("photos", $photos);
    }
    $this->photos = $photos;
  }

  public function setTags(array $tags)
  {
    if (!is_array($tags)) {
      $this->illegalAssignment("tags", $tags);
    }
    $this->tags = $tags;
  }

  private function illegalAssignment(string $propety, $value)
  {
    throw new RuntimeException("Illegal assignment for article.$propety: $value");
  }
}
