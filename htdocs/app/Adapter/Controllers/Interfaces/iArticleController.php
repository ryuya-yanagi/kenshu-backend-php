<?php

namespace App\Adapter\Controllers\Interfaces;

interface iArticleController
{
  public function index(): array;
  public function show(string $uri): object;
}
