<?php

namespace App\Http\Controllers;

use App\Events\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'comment' => 'required',
        ]);

        event(new Comment($request->username, $request->comment));

        $response = [
            "how_is_it" => $request->comment,
        ];

        return response($response, 201);

    }
}
