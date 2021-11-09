<?php

namespace App\Http\Controllers\Api\Image;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ImageController extends Controller{

  public function existFIle($file)
  {
    return Storage::disk("public")->exists($this->format($file));
  }

  public function store(Request $request)
  {
    if (!is_array($request->file("images"))) {

      $image = $this->save($request->file("images"));
    } else {
      $image = array();
      for ($i = 0; $i < count($request->allFiles()["images"]); $i++) {
        $file = $request->allFiles()["images"][$i];
        $image[] = $this->save($file);
      }
    }
    $this->response["result"] = $image;
    return response()->json($this->response);
  }

  private function save(UploadedFile $image)
  {
    $url = $image->store("images", "public");
    $path = asset("storage/" . $url);
    return $path;
  }

  public function destroy(string $image)
  {
    $file = $this->format($image);
    Storage::disk("public")->delete($file);
  }

  private function format(string $format)
  {
    return str_replace("http://localhost/storage/", "", $format);
  }
}
