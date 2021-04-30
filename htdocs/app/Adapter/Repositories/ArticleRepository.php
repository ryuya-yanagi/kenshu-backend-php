<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Entity\Article;
use Exception;
use PDO;

class ArticleRepository implements iArticleRepository
{
  protected PDO $connection;

  function __construct(PDO $pdo)
  {
    $this->connection = $pdo;
  }

  public function SelectAll(): array
  {
    $stmt = $this->connection->prepare(
      "SELECT articles.id as id, title, body, users.id as user_id, users.name as username 
      FROM articles INNER JOIN users ON articles.user_id = users.id"
    );
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function SelectById(int $id): ?object
  {
    $stmt = $this->connection->prepare(
      "SELECT articles.id as id, title, body, users.id as user_id, users.name as username
      FROM articles JOIN users ON articles.user_id = users.id
      AND articles.id = ?"
    );
    $stmt->bindValue(1, $id);
    $result = $stmt->execute();

    if (!$result) {
      return null;
    }

    return (object) $stmt->fetch();
  }

  public function Insert(Article $article): int
  {
    $stmt = $this->connection->prepare("INSERT INTO articles SET title = :title, body = :body, user_id = :user_id");
    $stmt->bindParam(":title", $article->title, PDO::PARAM_STR);
    $stmt->bindParam(":body", $article->body, PDO::PARAM_STR);
    $stmt->bindParam(":user_id", $article->user_id, PDO::PARAM_INT);

    $result = $stmt->execute();
    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }

    return (int) $this->connection->lastInsertId();
  }

  public function Update(Article $article): bool
  {
    return true;
  }

  public function Delete(int $id): bool
  {
    return true;
  }
}
