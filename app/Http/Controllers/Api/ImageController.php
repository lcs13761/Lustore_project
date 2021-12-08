<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ImageController extends Controller{

  public function existFile($file): bool
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

  private function save( $image): string
  {
      $url = $image->store("images", "public");
      return asset("storage/" . $url);
  }

  public function destroy(string $image)
  {
    $file = $this->format($image);
    Storage::disk("public")->delete($file);
  }

  private function format(string $format): array|string
  {
    return str_replace("http://192.168.1.105/storage/", "", $format);
  }
}
