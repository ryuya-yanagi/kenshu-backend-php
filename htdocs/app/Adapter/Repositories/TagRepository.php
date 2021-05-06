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

  public function SelectAll(): ?array
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM tags");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function SelectById(int $id): ?object
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM tags WHERE id = ?");
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $result = $stmt->execute();

    if (!$result) {
      return null;
    }

    return (object) $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function Insert(Tag $tag): ?int
  {
    $stmt = $this->connection->prepare("INSERT INTO tags SET name = :name");
    $stmt->bindParam(":name", $tag->name, PDO::PARAM_STR);
    $result = $stmt->execute();

    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }

    return (int) $this->connection->lastInsertId();
  }

  public function Update(Tag $tag): bool
  {
    $stmt = $this->connection->prepare("UPDATE tags SET name = :name WHERE id = :id");
    $stmt->bindParam(":name", $tag->name, PDO::PARAM_STR);
    $stmt->bindParam(":id", $tag->id, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
