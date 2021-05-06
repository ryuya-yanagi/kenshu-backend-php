<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Entity\Article;
use Exception;
use PDO;

class ArticleRepository extends BaseRepository implements iArticleRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function SelectAll(): array
  {
    $stmt = $this->connection->prepare(
      "SELECT articles.id as id, title, users.id as user_id, users.name as username, photos.url as thumbnail_url
      FROM articles 
      INNER JOIN users 
      LEFT JOIN photos ON articles.thumbnail_id = photos.id
      WHERE articles.user_id = users.id
      ORDER BY articles.updated_at DESC"
    );
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function SelectById(int $id): ?array
  {
    $stmt = $this->connection->prepare(
      "SELECT articles.id as id, title, body, thumbnail_id, users.id as user_id, users.name as username, photos.url as photo
      FROM articles 
      LEFT JOIN users ON articles.user_id = users.id
      LEFT JOIN photos ON articles.id = photos.article_id
      WHERE articles.id = ?"
    );
    $stmt->bindValue(1, $id);
    $result = $stmt->execute();

    if (!$result) {
      return null;
    }

    return $stmt->fetchAll();
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
    $stmt = $this->connection->prepare("UPDATE articles SET title = :title, body = :body, thumbnail_id = :thumbnail_id WHERE id = :id");
    $stmt->bindParam(":title", $article->title, PDO::PARAM_STR);
    $stmt->bindParam(":body", $article->body, PDO::PARAM_STR);
    $stmt->bindParam(":thumbnail_id", $article->thumbnail_id, PDO::PARAM_INT);
    $stmt->bindParam(":id", $article->id, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function Delete(int $id): bool
  {
    $stmt = $this->connection->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
