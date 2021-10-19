<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PasswordResetLinkController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use App\Events\Comment;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsArticleController;
use App\Models\NewsArticle;
use \App\Http\Controllers\CommentsController;
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

Route::get('/products',function () {
   return response('hello');
});




//Route::post('/avatar',function (Request $request){
//
//    if ($request->hasFile('image')) {
//
//        $path = $request->file('image')->store('images');
//        return $path;
//
//    }
////    $attributes = $request->validate([
////        'avatar' => 'required|image:jpeg,png,jpg,gif,svg|max:6048'
////    ]);
//
//        //    $attributes;
//// return $request->all();
////    if ($request->file('avatar')->isValid()) {
////        return 'isvalid';
////    } else {
////        'is not valid';
////    }
//
//});

Route::post('/check_auth',[UserController::class,'checkAuth']);
Route::post('/forgot-password',[PasswordResetLinkController::class,'store'])->name('password.email');;
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
//Route::post('/send_comment',[CommentController::class,'comment']);
// fetch all the news articles


Route::post('/news_articles/{news_article}/comment', function (Request $request, NewsArticle $news_article) {
    $comment = new \Laravelista\Comments\Comment;
    $comment->commenter()->associate(null);
    $comment->commentable()->associate($news_article);
    $comment->comment = $request->comment;
    $comment->approved = true;
    $comment->save();

    return $comment;
});



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

//Route::post('/avatar',function (){
//    return 'wtf';
//});
Route::post('/comments/{commentable_type}/{commentable_id}', [ CommentsController::class, 'index' ]);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/news_articles',[NewsArticleController::class,'index']);
    Route::post('/avatar',AvatarController::class);
    Route::post('/comments', [ CommentsController::class, 'store' ]);

// fetch all the comments associated with this article
    Route::get('/news_articles/{news_article}/comments', function (NewsArticle $news_article) {
        return $news_article->comments;
    });
    Route::post('/logout',[UserController::class,'logout']);
    Route::get('/products',function () {
        return response('hello');
    });
//    Route::post('comments', 'CommentsCenter\CommentController@store');
//    Route::delete('comments/{comment}', 'CommentsCenter\CommentController@destroy');
//    Route::put('comments/{comment}', 'CommentsCenter\CommentController@update');
//    Route::post('comments/{comment}', 'CommentsCenter\CommentController@reply');
});

