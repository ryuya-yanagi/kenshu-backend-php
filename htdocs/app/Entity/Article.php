<?php

namespace App\Entity;

class Article extends BaseEntity
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
        switch ($key) {
          case "id":
            $this->setId($value);
            break;
          case "title":
            $this->setTitle($value);
            break;
          case "body":
            $this->setBody($value);
            break;
          case "thumbnail_id":
            $this->setThumbnailId($value);
            break;
          case "thumbnail_url":
            $this->setThumbnailUrl($value);
            break;
          case "username":
            $this->setUsername($value);
            break;
          case "user_id":
            $this->setUserId($value);
            break;
          case "photos":
            $this->setPhotos($value);
            break;
          case "tags":
            $this->setTags($value);
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

  public function setThumbnailId($thumbnail_id)
  {
    if (!is_numeric($thumbnail_id)) {
      $this->illegalAssignment("thumbnail_id", $thumbnail_id);
    }

    if (!is_int($thumbnail_id)) {
      $thumbnail_id = (int) $thumbnail_id;
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

  public function setUserId($user_id)
  {
    if (!is_numeric($user_id)) {
      $this->illegalAssignment("user_id", $user_id);
    }

    if (!is_int($user_id)) {
      $user_id = (int) $user_id;
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
}
