<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function upload(){
        return view('image.upload');
    }

    public function store( $requestName = 'image', $folder = 'avatars' ){
        $path = request()->file($requestName)->storePublicly($folder,'s3');
        return static::show($path);
    }

    // fetch the avatar value to see if it exists in the database
    public function show($path){
        return Storage::disk('s3')->url($path);
    }

    public function destroy($path){
        return Storage::disk('s3')->delete($path);
    }

}
