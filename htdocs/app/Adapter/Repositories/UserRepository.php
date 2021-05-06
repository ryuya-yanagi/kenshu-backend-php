<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iUserRepository;
use App\Entity\User;
use Exception;
use PDO;

class UserRepository extends BaseRepository implements iUserRepository
{
  protected PDO $connection;

  function __construct(PDO $pdo)
  {
    $this->connection = $pdo;
  }

  public function SelectAll(): array
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM users");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function SelectById(int $id): ?array
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

    if (!$result) {
      return null;
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function SelectByName(string $name): ?object
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM users WHERE name = ?");
    $stmt->bindValue(1, $name);
    $result = $stmt->execute();

    if ($result) {
      return null;
    }

    return (object) $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function Insert(User $user): int
  {
    $stmt = $this->connection->prepare("INSERT INTO users SET name = :name, password_hash = :password_hash");
    $stmt->bindParam(':name', $user->name, PDO::PARAM_STR);
    $pass_hash = $user->getPasswordHash();
    $stmt->bindParam(':password_hash', $pass_hash);
    $result = $stmt->execute();

    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }

    return (int) $this->connection->lastInsertId();
  }

  public function Update(User $user): bool
  {
    $stmt = $this->connection->prepare("UPDATE users SET name = :name WHERE id = :id");
    $stmt->bindParam(":name", $user->name);
    $stmt->bindParam(":id", $user->id);
    $result =  $stmt->execute();

    if (!$result) {
      throw new Exception("データの更新に失敗しました");
    }

    return $result;
  }

  public function Delete(int $id): bool
  {
    $stmt = $this->connection->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
