<?php

namespace App\Entity;

class Article
{
  public ?int $id;
  public int $userId;
  public string $title;
  public string $body;
  public ?int $thumbnailId;
}
