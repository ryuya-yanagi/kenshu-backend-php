<?php

namespace App\Adapter\Controllers\Interfaces;

use App\Entity\User;

interface iUserController
{
  public function index(): array;
  public function show(string $id): User;
  public function post($obj);
  public function patch($obj): bool;
  public function delete(string $uri): bool;
}
