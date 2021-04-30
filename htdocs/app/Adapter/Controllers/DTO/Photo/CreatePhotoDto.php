<?php

namespace App\Adapter\Controllers\DTO\Photo;

class CreatePhotoDto
{
  public string $url;
  public int $article_id;

  function __construct(int $article_id, object $obj)
  {
    $this->article_id = $article_id;
    $this->url = $obj->url;
  }
}
