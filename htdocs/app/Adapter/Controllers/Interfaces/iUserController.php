<?php

namespace App\Adapter\Controllers\Interfaces;

interface iUserController
{
  public function index();
  public function show(string $uri);
  public function post($obj);
  public function patch($obj);
  public function delete(string $uri);
}
