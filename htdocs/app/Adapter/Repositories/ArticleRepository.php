<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Entity\Article;
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
      "SELECT articles.id as id, title, body, users.id as userId, users.name as username 
      FROM articles INNER JOIN users ON articles.user_id = users.id"
    );
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function SelectById(int $id): ?object
  {
    $stmt = $this->connection->prepare(
      "SELECT articles.id as id, title, body, users.id as userId, users.name as username
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
    return 0;
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
