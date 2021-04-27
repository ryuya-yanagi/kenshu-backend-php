<?php

namespace App\Adapter\Repository;

use App\Adapter\Controllers\DTO\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Adapter\Repository\Interfaces\iUserRepository;
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
    $stmt = $this->connection->prepare("select id, name from users where id = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();

    return $stmt->fetch();
  }

  public function Insert(CreateUserDto $user)
  {
    $stmt = $this->connection->prepare("insert into users (name, password_hash) values ($user[name], $user[password_hash])");
    return $stmt->execute();
  }

  public function Update(UpdateUserDto $user)
  {
    $stmt = $this->connection->prepare("update users set name = $user[name] where id = ?");
    $stmt->bindValue(1, $user["id"]);
    return $stmt->execute();
  }

  public function Delete(int $id)
  {
    $stmt = $this->connection->prepare("delete from users where id = ?");
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
