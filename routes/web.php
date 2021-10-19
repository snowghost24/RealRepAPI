<?php

use App\Http\Controllers\GravatarController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/testroute', function () {
//    return view('login');
    return \App\Models\Comment::all();
});

//Route::get('/logins', function () {
////    return view('login');
////    return view('test_anything');
//
////    $comment = new Comment;
////    commentable()->associate($news_article);
////    return $comment-> commentable()->associate($model);
//    $commentable_type = 'NewsArticle';
//    $model = null;
//    switch ($commentable_type) {
//        case 'NewsArticle':
//            $model = app('\App\Models\NewsArticle');
//            break;
//        default:
//            $model = null;
//    }
////    $model = app('\App\Models\NewsArticle');
//    $comments = $model::find('1')->comment()->paginate(2);
//    return response($comments ,200) ;
//});

Route::get('/logins/{commentable_type}/{commentable_id}',[\App\Http\Controllers\CommentsController::class,'index']);

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
