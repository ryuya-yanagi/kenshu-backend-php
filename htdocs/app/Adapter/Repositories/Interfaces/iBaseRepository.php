<?php

namespace App\Adapter\Repositories\Interfaces;

interface iBaseRepository
{
  public function BeginTransaction();
  public function Commit();
  public function RollBack();
  public function CloseConnect();
}
