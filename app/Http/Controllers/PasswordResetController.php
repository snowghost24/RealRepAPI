<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function resetPassword(Request $request)
    {

        $request->validate(['email' => 'required']);

       $status = Password::sendResetLink(
            $request->only('email')
        );

//       return 'hello';

        return response()->json([
                'success' => $status == Password::RESET_LINK_SENT,
                'status' => $status,
                'pwd' => Password::RESET_LINK_SENT,
            ]);


        // for web
//        return $status === Password::RESET_LINK_SENT
//            ? back()->with(['status' => __($status)])
//            : back()->withErrors(['email' => __($status)]);
    }


}
