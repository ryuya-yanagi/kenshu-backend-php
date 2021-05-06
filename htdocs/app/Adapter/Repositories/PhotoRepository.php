<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iPhotoRepository;
use App\Entity\Photo;
use Exception;
use PDO;

class PhotoRepository extends BaseRepository implements iPhotoRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function SelectAll(): ?array
  {
    $stmt = $this->connection->prepare("SELECT id, url, article_id FROM articles");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function SelectById(int $id): ?object
  {
    $stmt = $this->connection->prepare("SELECT id, url, article_id FROM articles WHERE id = ?");
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $result = $stmt->execute();

    if (!$result) {
      return null;
    }

    return (object) $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function Insert(Photo $photo): ?int
  {
    $stmt = $this->connection->prepare("INSERT INTO photos SET url = :url, article_id = :article_id");
    $stmt->bindParam(":url", $photo->url, PDO::PARAM_STR);
    $stmt->bindParam(":article_id", $photo->article_id, PDO::PARAM_INT);
    $result = $stmt->execute();

    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }

    return (int) $this->connection->lastInsertId();
  }

  public function InsertValues(int $article_id, array $photoUrlList): ?int
  {
    $sql = "INSERT INTO photos (url, article_id) VALUES ";
    $insertQuery = [];
    $insertValues = [];

    foreach ($photoUrlList as $url) {
      array_push($insertQuery, "(?, ?)");
      array_push($insertValues, $url);
      array_push($insertValues, $article_id);
    }

    $sql .= implode(', ', $insertQuery);
    $stmt = $this->connection->prepare($sql);
    $stmt->execute($insertValues);

    return (int) $this->connection->lastInsertId() - count($photoUrlList) + 1;
  }
}
