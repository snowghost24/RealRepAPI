<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use App\Events\Comment;
use App\Http\Controllers\UserController;
//use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsArticleController;
use App\Models\NewsArticle;
use \App\Http\Controllers\CommentsController as CommentsCenter;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::get('/test_log',function (){
// $response  =  Socialite::driver('google')->userFromToken('ya29.a0ARrdaM89_Fodi2mArEwoSmUC2eHO0euNzhAeHjZniPMBKshMpElWBb2T-IWWoSHrO7nQLcSFckwaMTEeXSi_a2cHIIhLuzUlLrRWvaXxLSYEmqnac1ccAHEnbYnSdgVSqdRTwUBy5Bp3qeApqQrb7Bfr_xl1');
//    dd($response);
//});

Route::get('/products',function () {
   return response('hello');
});

//Route::get('/test_log',function (){
//    try {
//        $so  =  Socialite::driver('google')->userFromToken('ya29.a0ARrdaM_DfbXrjtnXfzC3rdGhYV0Oxz_PceHaRQh81FQrNbqUD9rLJ4enRETd6o0OYor1wgVKIoHMfAYG33Ashls1nyAG5_SIu0dH-GD0hQBV-eoZ-E04ZeFKQcOhGczxrbQvvYoTY9VqUZ1jD74-5FpAjtys');
//        dd($so);
//    }catch (Exception $e){
//        dd($e);
//    }
//
//});
Route::post('/check_auth',[UserController::class,'checkAuth']);
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
//Route::post('/send_comment',[CommentController::class,'comment']);
// fetch all the news articles
Route::get('/news_articles',[NewsArticleController::class,'index']);

// fetch all the comments associated with this article
Route::get('/news_articles/{news_article}/comments', function (NewsArticle $news_article) {
    return $news_article->comments;
});

Route::post('/news_articles/{news_article}/comment', function (Request $request, NewsArticle $news_article) {
    $comment = new \Laravelista\Comments\Comment;
    $comment->commenter()->associate(null);
    $comment->commentable()->associate($news_article);
    $comment->comment = $request->comment;
    $comment->approved = true;
    $comment->save();

    return $comment;
});



Route::post('/comments', 'CommentsCenter\CommentController@store');
Route::delete('/comments/{comment}', 'CommentsCenter\CommentController@destroy');
Route::put('/comments/{comment}', 'CommentsCenter\CommentController@update');
Route::post('/comments/{comment}', 'CommentsCenter\CommentController@reply');

//$reply = new $commentClass;
//$reply->commenter()->associate(Auth::user());
//$reply->commentable()->associate($comment->commentable);
//$reply->parent()->associate($comment);
//$reply->comment = $request->message;
//$reply->approved = !Config::get('comments.approval_required');
//$reply->save();

//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout',[UserController::class,'logout']);
    Route::get('/products',function () {
        return response('hello');
    });
//    Route::post('comments', 'CommentsCenter\CommentController@store');
//    Route::delete('comments/{comment}', 'CommentsCenter\CommentController@destroy');
//    Route::put('comments/{comment}', 'CommentsCenter\CommentController@update');
//    Route::post('comments/{comment}', 'CommentsCenter\CommentController@reply');
});
