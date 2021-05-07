<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iUserRepository;
use PDO;

class UserRepository extends BaseRepository implements iUserRepository
{
  protected PDO $connection;

  function __construct(PDO $pdo)
  {
    $this->connection = $pdo;
  }

  public function selectAll(): array
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM users");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectById(int $id): ?array
  {
    $stmt = $this->connection->prepare(
      "SELECT users.id as id, name, articles.id as article_id, title, url as thumbnail_url
      FROM users 
      LEFT JOIN articles ON users.id = articles.user_id
      LEFT JOIN photos ON articles.thumbnail_id = photos.id
      WHERE users.id = ?"
    );
    $stmt->bindValue(1, $id);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function SelectByName(string $name): ?object
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM users WHERE name = ?");
    $stmt->bindValue(1, $name);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if ($result || !!$count) {
      return null;
    }

    return (object) $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
