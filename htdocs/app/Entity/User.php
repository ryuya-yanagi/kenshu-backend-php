<?php

namespace App\Entity;

class User
{
  public ?int $id;
  public string $name;
  protected string $password_hash;
  public ?array $articleList;

  /**
   * ユーザのパスワードを取得
   * 
   * @return string
   */
  public function getPasswordHash()
  {
    return $this->password_hash;
  }

  /**
   * ユーザのパスワードをセット
   * 
   * @param string $password
   * 
   * @return string
   */
  public function setPassword(string $password)
  {
    $this->password_hash = $password;
  }

  /**
   * ユーザの名前とパスワードが有効か検証
   * 
   * @param string $name
   * @param string $password
   * 
   * @return array
   */
  public static function validation(string $name, string $password): array
  {
    $valError = array();

    if (empty($name)) {
      $valError["name"] = "名前が空になっています";
    } elseif (strlen($name) > 15) {
      $valError["name"] = "名前の文字数は15文字以下しか受け付けません";
    }

    if (strlen($password) < 6) {
      $valError["password"] = "パスワードは6文字以上必要です";
    }

    return $valError;
  }

  /**
   * パスワードをハッシュ化し、返す
   * 
   * @param string $password
   * @return string
   */
  public static function hash_pass(string $password): string
  {
    return password_hash($password, PASSWORD_DEFAULT);
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
