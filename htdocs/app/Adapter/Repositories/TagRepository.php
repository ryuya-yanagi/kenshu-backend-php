<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iTagRepository;
use App\Entity\Tag;
use Exception;
use PDO;

class TagRepository extends BaseRepository implements iTagRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function selectAll(): ?array
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM tags");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectById(int $id): ?object
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM tags WHERE id = ?");
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (object) $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insert(Tag $tag): ?int
  {
    $stmt = $this->connection->prepare("INSERT INTO tags SET name = :name");
    $stmt->bindParam(":name", $tag->name, PDO::PARAM_STR);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (int) $this->connection->lastInsertId();
  }

  public function update(Tag $tag): bool
  {
    $stmt = $this->connection->prepare("UPDATE tags SET name = :name WHERE id = :id");
    $stmt->bindParam(":name", $tag->name, PDO::PARAM_STR);
    $stmt->bindParam(":id", $tag->id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    return $result && !!$count;
  }
}
