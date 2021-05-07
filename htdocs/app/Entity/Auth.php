<?php

namespace App\Entity;

class Auth
{
  private ?int $id;
  private string $name;
  private string $password;
  private string $password_hash;

  function __construct(object $obj)
  {
    foreach ($obj as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  public function &__get($name)
  {
    return $this->$name;
  }

  /**
   * ユーザの名前とパスワードが有効か検証
   * 
   * @param string $name
   * @param string $password
   * 
   * @return array
   */
  public function validation(): array
  {
    $valError = array();

    if (strlen($this->name) < 2) {
      $valError["name"] = "名前は2文字以上15文字以内にしてください";
    } elseif (strlen($this->name) > 15) {
      $valError["name"] = "名前は2文字以上15文字以内にしてください";
    }

    if (strlen($this->password) < 6) {
      $valError["password"] = "パスワードは6文字以上必要です";
    }

    return $valError;
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
