<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @group Login management
 *
 * APIs for managing login
 */
class LoginController extends Controller
{

   /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard'; //RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

      /**
         * Login
         *
         * @bodyParam username string required The string of the user. Example: admin
	     * @bodyParam password required string The password of user.
         * @response {
         *  "access_token": "eyJ0eXA...",
         *  "token_type": "Bearer",
         *  "email": "testuser@tests.com",
         *  "password": "secret"
         * }
    */
    protected function validateLogin(Request $request)
    {
        // Get the user details from database and check if user is exist and active.
        $user = \App\Models\User::where('username',$request->username)->first();
        if( $user !== null && $user->accstatus == 'N' ){
            throw ValidationException::withMessages([$this->username() => __('Your account has been terminated.')]);
        }

        // Then, validate input.
        return $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
