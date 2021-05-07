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

  public function selectUserByName(string $name): ?object
  {
    $stmt = $this->connection->prepare("select id, name, password_hash from users where name = ?");
    $stmt->bindValue(1, $name);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (object) $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
