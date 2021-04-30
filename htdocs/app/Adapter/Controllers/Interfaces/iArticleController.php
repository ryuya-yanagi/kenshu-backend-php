<?php

namespace App\Adapter\Controllers\Interfaces;

use App\Entity\Article;

interface iArticleController
{
  public function index(): array;
  public function show(string $uri): Article;
  public function post($user_id, $obj, $photos);
}
