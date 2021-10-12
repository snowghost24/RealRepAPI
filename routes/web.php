<?php

use App\Http\Controllers\GravatarController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/image/upload',[ ImageController::class,'upload' ]);
//Route::post('/image/upload',function (){
//  $imageStore = new ImageController;
//  dd($imageStore->destroy('hello'));
//});

//Route::post('/image/upload',[ ImageController::class,'index' ]);

Route::get('/email', function (){
    return new \App\Mail\WelcomeMail();
});

//Route::get('/forgot-password', [PasswordResetLinkController::class, 'create']);
require __DIR__.'/auth.php';
