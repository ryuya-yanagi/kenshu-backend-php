# kenshu-backend-php

## 新卒研修バックエンド　記事投稿サービス

---

要件

- ユーザー登録、ログイン機能を備えている
- ログインしたユーザーは自分の記事の作成、編集、削除ができる
- 記事は”タイトル”、”本文”、”画像”、”タグ”から構成される
  - 画像は複数枚アップロードすることができる
  - アップロードした画像のうち 1 枚をサムネイル画像として指定する
  - タグは複数指定することができる
- ログインしていないユーザーは投稿された記事を閲覧できる

## 使用技術

---

Docker 20.10.5

MySQL 5.7

# ディレクトリ構成

```
kenshu-backend-php /
      ┝ docs /
      │   └ entity_relationship_diagram.drawio  <-- データベースのER図
      │
      ┝ infra /
      │   ┝ mysql /   <-- mysqlの設定ファイル群
      │   └ php /     <-- php, apacheの設定ファイル群
      │
      ┝ app /  <-- アプリケーションディレクトリ
      ┝ .gitignore
      ┝ docker-compose.yml
      ┝ makefile
      └ README.md
```
