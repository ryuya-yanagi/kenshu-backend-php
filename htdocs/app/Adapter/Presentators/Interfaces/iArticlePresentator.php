<?php

namespace App\Adapter\Presentators\Interfaces;

interface iArticlePresentator extends iBasePresentator
{
  public static function viewArticleList(array $articleList);
  public static function viewArticle(object $article);
}
