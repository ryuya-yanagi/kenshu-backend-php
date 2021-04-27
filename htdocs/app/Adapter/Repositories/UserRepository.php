<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iUserRepository;
use App\Entity\User;
use PDO;

class UserRepository implements iUserRepository
{
  protected PDO $connection;

  function __construct(PDO $pdo)
  {
    $this->connection = $pdo;
  }

  public function SelectAll()
  {
    $stmt = $this->connection->prepare("select id, name from users");
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function SelectById(int $id)
  {
    $stmt = $this->connection->prepare("select id, name, created_at from users where id = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();

    return (object) $stmt->fetch();
  }

  public function SelectByName(string $name)
  {
    $stmt = $this->connection->prepare("select id, name from users where name = ?");
    $stmt->bindValue(1, $name);
    $stmt->execute();

    return (object) $stmt->fetch();
  }

  public function Insert(User $user)
  {
    $stmt = $this->connection->prepare("insert into users (name, password_hash) values (?, ?)");
    return $stmt->execute(array($user->getName(), $user->getPasswordHash()));
  }

  public function Update(User $user)
  {
    $stmt = $this->connection->prepare("update users set name = ? where id = ?");
    $stmt->bindValue(1, $user->getName());
    $stmt->bindValue(2, $user->getId());
    return $stmt->execute();
  }

  public function Delete(int $id)
  {
    $stmt = $this->connection->prepare("delete from users where id = ?");
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
