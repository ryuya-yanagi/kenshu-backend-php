<?php

namespace App\Entity;

class User
{
  protected ?int $id;
  protected string $name;
  protected string $password_hash;

  /**
   * ユーザの名前と平文のパスワードを与える
   * 
   * @param string $name
   * @param string $password
   */
  function __construct(string $name, string $password)
  {
    $this->name = $name;
    $this->password_hash = $this->hash_pass($password);
  }

  /**
   * ユーザのIDを取得
   * 
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * ユーザの名前を取得
   * 
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

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
}
