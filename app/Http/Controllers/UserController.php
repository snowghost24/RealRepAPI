<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name'     => 'required|string',
            'username' =>  'required|string|unique:users,username',
            'email'    => 'required|string|unique:users,email',
            'password' =>'required|string|confirmed'
        ]);

        // check to see if the user has a gravatar and save the image link
        $gravatar =  new GravatarController;

        if ( $url = $gravatar->getGravatar($fields['email'])){
            $fields['avatar'] = $url;
        }


        $user = User::create([
            'name'     => $fields['name'],
            'username'     => $fields['username'],
            'email'    => $fields['email'],
            'avatar' => $fields['avatar'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('real_rep')->plainTextToken;
        $response = [
            'success' => true,
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

       $response = [
            'user' => $user,
            'token' => $user->createToken($request->device_name)->plainTextToken
        ];


        return response($response, 201);
    }

    public function logout(Request $request)
    {
//        $request->user()->tokens->delete();
        $request->user()->currentAccessToken()->delete();

        return ['message' => 'deleted' ];
    }


    /**
     * Social Login
     */
    public function checkAuth(Request $request)
    {
        $provider = "google";
        // get the provider's user. (In the provider server)
        $attribute = $request->validate(['token'=>'required']);
        try {
            $providerUser = Socialite::driver($provider)->userFromToken($attribute['token']);
        } catch (Throwable $e){
            return response()->json([
                'success' => 'false',
                 'error' => $e->getCode()
                ]
            );
        }

        // check if access token exists etc..
        // search for a user in our server with the specified provider id and provider name
        $user = User::where('provider_name', $provider)->where('user_provider_id', $providerUser->id)->first();
        // if there is no record with these data, create a new user
        if($user == null){
            $user = User::create([
                'email' => $providerUser->email,
                'name' => $providerUser->name,
                'avatar' => $providerUser->name,
                'provider_name' => $provider,
                'user_provider_id' => $providerUser->id,
            ]);
        }
        // create a token for the user, so they can login
        $token = $user->createToken(env('APP_NAME'))->plainTextToken;
        // return the token for usage
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
