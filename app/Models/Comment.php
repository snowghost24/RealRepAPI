<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Laravelista\Comments\Events\CommentCreated;
use Laravelista\Comments\Events\CommentDeleted;
use Laravelista\Comments\Events\CommentUpdated;
use Spatie\Honeypot\ProtectAgainstSpam;

class Comment extends Model
{
    use SoftDeletes,HasFactory;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'commenter'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commentable_type', 'comment', 'approved', 'guest_name', 'guest_email' ,'commentable_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'approved' => 'boolean'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CommentCreated::class,
        'updated' => CommentUpdated::class,
        'deleted' => CommentDeleted::class,
    ];

    public function __construct()
    {
//        $this->middleware('web');
//
//        if (Config::get('comments.guest_commenting') == true) {
//            $this->middleware('auth')->except('store');
//            $this->middleware(ProtectAgainstSpam::class)->only('store');
//        } else {
//            $this->middleware('auth');
//        }
    }

    /**
     * The user who posted the comment.
     */
    public function commenter()
    {
        return $this->morphTo();
    }

    /**
     * The model that was commented upon.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

//    /**
//     * Returns all comments that this comment is the parent of.
//     */
//    public function children()
//    {
//        return $this->hasMany(Config::get('comments.model'), 'child_id');
//    }
//
//    /**
//     * Returns the comment to which this comment belongs to.
//     */
//    public function parent()
//    {
//        return $this->belongsTo(Config::get('comments.model'), 'child_id');
//    }
}
