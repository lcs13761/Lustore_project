<?php

namespace App\Http\Controllers\Api\Image;

use Illuminate\Support\Facades\Storage;

class ImageController {

  public function delete($image)
  {
      $file = str_replace(env('APP_URL') . "/storage", "", $image);
      if(!Storage::disk("public_upload")->exists($file)){
        return true;
      }
      $verification = Storage::disk("public_upload")->delete($file);
      if($verification){
        return true;
      }
      return false;

  }

}