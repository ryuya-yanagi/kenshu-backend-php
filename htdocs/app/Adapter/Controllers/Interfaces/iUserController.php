<?php

namespace App\Adapter\Controllers\Interfaces;

interface iUserController
{
  public function index(): array;
  public function show(string $uri): object;
  public function post($obj);
  public function patch($obj);
  public function delete(string $uri);
}
