<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iAuthRepository;
use PDO;

class AuthRepository extends BaseRepository implements iAuthRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function SelectUserByName(string $name): ?object
  {
    $stmt = $this->connection->prepare("select id, name, password_hash from users where name = ?");
    $stmt->bindValue(1, $name);
    $stmt->execute();

    $result = (object) $stmt->fetch(PDO::FETCH_ASSOC);

    if (!property_exists($result, "id") || !property_exists($result, "name") || !property_exists($result, "password_hash")) {
      return null;
    }
    return $result;
  }
}
