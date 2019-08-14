<?php 
namespace App\Library;
class ulearnHelpers {

  public static function HumanFileSize($size,$unit="") {
    if( (!$unit && $size >= 1<<30) || $unit == "GB")
      return number_format($size/(1<<30),2)." GB";
    if( (!$unit && $size >= 1<<20) || $unit == "MB")
      return number_format($size/(1<<20),2)." MB";
    if( (!$unit && $size >= 1<<10) || $unit == "KB")
      return number_format($size/(1<<10),2)." KB";
      return number_format($size)." bytes";
  }
  
}

?>