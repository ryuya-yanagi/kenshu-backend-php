<?php

namespace App\Entity;

class Auth extends BaseEntity
{
  private int $id;
  private string $name;
  private string $password;
  private string $password_hash;

  function __construct(object $obj)
  {
    foreach ($obj as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        switch ($key) {
          case "id":
            $this->setId($value);
            break;
          case "name":
            $this->setName($value);
            break;
          case "password":
            $this->setPassword($value);
            break;
        }
      }
    }
  }

  public function &__get($name)
  {
    return $this->$name;
  }

  public function setId($id)
  {
    if (!is_numeric($id)) {
      $this->illegalAssignment("id", $id);
    }

    if (!is_int($id)) {
      $id = (int) $id;
    }
    $this->id = $id;
  }

  public function setName(string $name)
  {
    if (2 <= strlen($name) && strlen($name) <= 15) {
      $this->illegalAssignment("name", $name);
    }
    $this->name = $name;
  }

  public function setPassword(string $password)
  {
    if (strlen($password) < 6) {
      $this->illegalAssignment("password", $password);
    }
    $this->password = $password;
  }

  /**
   * $this->passwordをハッシュ化し、$this->password_hashに代入
   * 
   */
  public function hash_pass()
  {
    $this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
  }

  /**
   * パスワードが一致するか検証
   * 
   * @param string $password
   * @return bool
   */
  public function verify_pass(string $password): bool
  {
    return password_verify($password, $this->password_hash);
  }
}
