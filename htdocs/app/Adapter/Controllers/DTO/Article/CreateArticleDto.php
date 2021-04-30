<?php

namespace App\Adapter\Controllers\DTO\Article;

class CreateArticleDto
{
  public int $user_id;
  public string $title;
  public string $body;
  public array $photos;
  public array $tags;

  public function __construct(int $user_id, object $obj)
  {
    $this->user_id = $user_id;
    $this->title = $obj->title;
    $this->body = $obj->body;
  }
}
