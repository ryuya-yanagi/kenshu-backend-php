<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iBaseRepository;
use PDO;

class BaseRepository implements iBaseRepository
{
  protected PDO $connection;

  function __construct(PDO $pdo)
  {
    $this->connection = $pdo;
  }

  public function BeginTransaction()
  {
    $this->connection->beginTransaction();
  }

  public function Commit()
  {
    $this->connection->commit();
  }

  public function RollBack()
  {
    $this->connection->rollBack();
  }

  public function CloseConnect()
  {
    $this->connection = null;
  }
}
