<?php

namespace App\Adapter\Controllers\DTO\Article;

class CreateArticleDto
{
  public int $userId;
  public string $title;
  public string $body;
  public array $photos;
  public array $tags;

  public function __construct(int $userId, string $title, string $body, array $photos, array $tags)
  {
    $this->userId = $userId;
    $this->title = $title;
    $this->body = $body;
    $this->photos = $photos;
    $this->tags = $tags;
  }
}
