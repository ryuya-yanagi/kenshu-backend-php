<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iAuthRepository;
use PDO;

class AuthRepository implements iAuthRepository
{
  protected PDO $connection;

  function __construct(PDO $pdo)
  {
    $this->connection = $pdo;
  }

  public function SelectUserByName(string $name)
  {
    $stmt = $this->connection->prepare("select id, name, password_hash from users where name = ?");
    $stmt->bindValue(1, $name);
    $stmt->execute();

    return (object) $stmt->fetch();
  }
}
