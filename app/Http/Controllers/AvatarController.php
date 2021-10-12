<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\u;

class AvatarController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        request()->validate([
            'filetoupload' => 'required|image:jpeg,png,jpg,gif,svg|max:6048'
        ]);

        if (request()->has('filetoupload')) {
            $avatar = new ImageController;
            $path = $avatar->store('filetoupload','avatars');

            // store the new image in aws
            $user = Auth::user();
            $user->avatar = $path;
            $user->save();

            // delete the old avatar from aws
            if($old_url = $user->avatar){
                $avatar->destroy($old_url);
            }

            return response()->json([
                'path' => $path,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'path' => null,
            ]);
        }
    }
}
