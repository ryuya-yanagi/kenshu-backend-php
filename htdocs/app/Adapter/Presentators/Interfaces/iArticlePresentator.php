<?php

namespace App\Adapter\Presentators\Interfaces;

use App\Entity\Article;

interface iArticlePresentator extends iBasePresentator
{
  public static function viewArticleList(array $articleList);
  public static function viewArticle(Article $article);
}
