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

  public function SelectUserByName(string $name): ?object
  {
    $stmt = $this->connection->prepare("select id, name, password_hash from users where name = ?");
    $stmt->bindValue(1, $name);
    $stmt->execute();

    $result = (object) $stmt->fetch();

    if (!property_exists($result, "id") || !property_exists($result, "name") || !property_exists($result, "password_hash")) {
      return null;
    }
    return $result;
  }
}
