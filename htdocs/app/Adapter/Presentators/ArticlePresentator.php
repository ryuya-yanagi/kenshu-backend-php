<?php

namespace App\Adapter\Presentators;

use App\Adapter\Presentators\Interfaces\iArticlePresentator;
use App\Entity\Article;

class ArticlePresentator extends BasePresentator implements iArticlePresentator
{
  public static function viewArticleList(array $articleList)
  {
    echo "<ul class='article-list'>\n";
    foreach ($articleList as $article) {
      echo
      "<li class='article-list__item'>
        <article class='article'>
      ";

      if (isset($article["thumbnail_url"])) {
        echo "<img src='{$article['thumbnail_url']}' alt='thumbnail' height='100px' />";
      }

      echo "<h3><a href='/articles/" . $article['id'] . "' >" . $article['title'] . "</a></h3>";

      echo "<p>投稿者：<a href='/users/" . $article['user_id'] . "' >" . $article['username'] . "</a></p>";

      echo
      "</article>
      </li>";
    }
    echo "</ul>\n";
  }

  public static function viewArticle(Article $article)
  {
    echo "<h2 style='margin-top: 20px'>{$article->title}</h2>";
    if (isset($article->photos)) {
      foreach ($article->photos as $photo) {
        echo "<img src='{$photo}' alt='photo' height='200px' />";
      }
    }
    echo "<p>{$article->body}</p>";
    echo "<p style='margin-top: 30px'>投稿者：<a href='/users/" . $article->user_id . "' >" . $article->username . "</a></p>";
  }
}
