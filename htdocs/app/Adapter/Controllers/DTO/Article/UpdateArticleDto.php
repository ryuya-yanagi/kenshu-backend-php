<?php

namespace App\Adapter\Controllers\DTO\Article;

class UpdateArticleDto
{
  public int $id;
  public int $user_id;
  public string $title;
  public string $body;
  public int $thumbnail_id;

  public function __construct(object $obj)
  {
    $this->id = $obj->id;
    $this->user_id = $obj->user_id;
    $this->title = $obj->title;
    $this->body = $obj->body;
    $this->thumbnail_id = $obj->thumbnail_id;
  }
}
