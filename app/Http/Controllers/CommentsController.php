<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\NewsArticle;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;




class CommentsController extends Controller
{
    /**
     * grab all comments for a particular model.
     *
     * @param  Request  $request
     * @param  string  $commentable_type
     * @param  string  $commentable_id
     *
     */
    public function index($commentable_type, $commentable_id)
    {

        $model = null;
        switch ($commentable_type) {
            case 'NewsArticle':
                $model = app('\App\Models\NewsArticle');
                break;
            default:
                $model = null;
        }

        return $model::find($commentable_id)->comment()->orderBy('created_at', 'desc')->with('commenter')->paginate(10);
    }

    /**
     * grab a comment and its children.
     */
    public function show(Request $request)
    {
        $attributes = $request->validate([
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|string|min:1',
        ]);

        $model = static::getModel($attributes['commentable_type']);

        $element = $model::firstOrFail($attributes['commentable_id']);

        return $element->comment();

    }






    /**
     * Creates a new comment for given model.
     */
    public function store(Request $request)
    {


        // If guest commenting is turned off, authorize this action.
//        if (Config::get('comments.guest_commenting') == false) {
//            Gate::authorize('create-comment', Comment::class);
//        }

        // Define guest rules if user is not logged in.
        if (!Auth::check()) {
            $guest_rules = [
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|string|email|max:255',
            ];
        }

        // Merge guest rules, if any, with normal validation rules.
        $attributes = Validator::make($request->all(), array_merge($guest_rules ?? [], [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|string|min:1',
            'message' => 'required|string'
        ]))->validate();

//        $model = $request->commentable_type::findOrFail($request->commentable_id);
//        return $model;
//        $attributes = $request->validate([
//            'commentable_type' => 'required|string',
//            'commentable_id' => 'required|string|min:1',
//            'message' => 'required|string',
//            'email' => 'string',
//            'name' => 'string'
//        ]);

        $model = null;
        switch ($attributes['commentable_type']) {
            case 'NewsArticle':
                $model = app('App\Models\NewsArticle');
                break;
            default:
                $model = null;
        }

        $comment = new \App\Models\Comment;

        $comment->commentable()->associate($model::findOrFail($attributes['commentable_id']));
        $comment->comment = $attributes['message'];

        if (!Auth::check()) {

            $comment->guest_name = $request->guest_name;
            $comment->guest_email = $request->guest_email;
        } else {
            $comment->commenter()->associate(Auth::user());
        }

        $comment->save();


//        return response()->json([
//            'model' =>  $model->all(),
//            'attributes' => $attributes
//        ]);



//        return response([
//            'model'=>$attributes
//        ]);

//        $commentClass = Config::get('comments.model');
//        $comment = new $commentClass;
//        $comment = new Comment();




//        $comment->approved = !Config::get('comments.approval_required');
//        $comment->save();
//
//        return Redirect::to(URL::previous() . '#comment-' . $comment->getKey());
    }





    /**
     * Creates a reply "comment" to a comment.
     */
    public function reply(Request $request, Comment $comment)
    {
//        Gate::authorize('reply-to-comment', $comment);

        Validator::make($request->all(), [
            'message' => 'required|string'
        ])->validate();

//        $commentClass = Config::get('comments.model');
//        $commentClass = Config::get('comments.model');
        $reply = new \Laravelista\Comments\Comment;
//        $reply = new $commentClass;
        $reply->commenter()->associate(Auth::user());
        $reply->commentable()->associate($comment->commentable);
        $reply->parent()->associate($comment);
        $reply->comment = $request->message;
        $reply->approved = !Config::get('comments.approval_required');
        $reply->save();

        return response('all good');
    }

    public function getModel($modelName)
    {
        switch ($modelName) {
            case 'NewsArticle':
                return app('App\Models\NewsArticle');
            default:
               return null;
        }
    }
};
