<?php

namespace App\Adapter\Uploaders;

use App\Adapter\Uploaders\Interfaces\iPhotoUploader;
use Exception;

class PhotoUploader implements iPhotoUploader
{
  public function upload(int $article_id, $tmp_name, $file_name): ?string
  {
    $dir_path = dirname(__DIR__, 3) . "/public/uploads/$article_id";
    if (!file_exists($dir_path)) {
      if (mkdir($dir_path, 0777)) {
        chmod($dir_path, 0777);
      } else {
        throw new Exception("画像を保存するためのディレクトリの作成に失敗しました");
      }
    }

    $result = move_uploaded_file($tmp_name, $dir_path . "/" . $file_name);
    if (!$result) {
      return null;
    }

    return "/uploads/$article_id/" . $file_name;
  }
}
