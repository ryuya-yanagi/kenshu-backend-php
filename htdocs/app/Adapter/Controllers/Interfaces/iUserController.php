<?php

namespace App\Adapter\Controllers\Interfaces;

use App\Entity\User;

interface iUserController
{
  public function index(): array;
  public function show(string $id): User;
  public function post(object $obj);
  public function patch(object $obj): bool;
  public function delete(string $uri): bool;
}
