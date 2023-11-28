<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('login', 'register');
    }

    public function login(Request $request){
        $credentials = $request->only([
            'email',
            'password'
        ]);

        if(!$token = auth('api')->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized'], 404);
        }

        return $this->respondWithToken($token);
   }

   public function register(UserRegisterRequest $request){

        $user = User::create(array_merge(
            $request->validated(),
            ['password' => bcrypt($request->password)]
            )
        );

        return response()->json([
            'message' => 'User successfully registered ',
            'user' => $user
        ], 201);
   }

   public function logout(){

        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
   }

   public function refresh(){
        return $this->respondWithToken(auth('api')->refresh());
   }

   public function respondWithToken($token){

       return response()->json([
           'access_token' => $token,
           'type' => 'Bearer',
           'expired_at' => Config::get('jwt.ttl') * 60
       ]);
   }
}
