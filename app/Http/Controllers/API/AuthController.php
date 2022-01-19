<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
/**
 * @group Authentication
 *
 * APIs for managing login
 */
class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

      /**
         * Login
         *
         * @bodyParam username string required The username of the user. Example: admin
	     * @bodyParam password string required The password of user.
         * @response {
         *  "access_token": "eyJ0eXA...",
         *  "token_type": "Bearer",
         *  "email": "testuser@tests.com",
         *  "password": "secret"
         * }
    */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();
        if( $user !== null && $user->accstatus == 'N' ){
            return response(['message' => 'Your account has been terminated']);
        }

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);

    }

     /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
    * Logout
    * @authenticated
    */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }


    /**
    * Refresh a token.
    * @authenticated
    */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
    *  Get the authenticated User.
    * @authenticated
    */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}
