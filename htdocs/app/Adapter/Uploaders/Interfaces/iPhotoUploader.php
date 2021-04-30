<?php

namespace App\Adapter\Uploaders\Interfaces;

interface iPhotoUploader
{
  public function upload(int $article_id, string $tmp_name, string $file_name): ?string;
}
