<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

    /**
         * @group Register management
         *
         * APIs for managing Register
     */

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:200', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company_id' => ['required'],
            'company_website' => ['required', 'url', 'max:255'],
            // 'com_code' => ['required', 'string', 'max:200'],
            'user_role' => ['required', 'string'],
            // 'company_admin' => ['required', 'string'],
            // 'accstatus' => ['required'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    /**
    * Registration User 
    * 
    * register a user
    *
    * @bodyParam  firstname string required The id of the location. Example: test
    * @bodyParam  lastname string required The id of the location. Example: demo
    * @bodyParam  username string required The id of the location. Example: user_name
    * @bodyParam  email string required The id of the location. Example: test@test.com
    * @bodyParam  company_id string required The id of the location. Example: 159
    * @bodyParam  company_website string required The id of the location. Example: www.demo.com
    * @bodyParam  com_code string required The id of the location. Example: 357
    * @bodyParam  user_role string required The id of the location. Example: intan
    * @bodyParam  company_admin string required The id of the location. Example: No
    * @bodyParam  password string required The id of the location. Example: 123
    *
    * @response {
    *  "firstname": "test",
    *  "lastname": "demo",
    *  "username": "user_name",
    *  "email": "test@test.com",
    *  "company_id": "159",
    *  "company_website": "www.dwmo.com",
    *  "com_code": "357",
    *  "user_role": "intan",
    *  "company_admin": "No",
    *  "password": "123",
    * }
	*/
    protected function create(array $data)
    {   

        $user_role = $data['user_role'];
        $com_code = md5( uniqid( rand() ) );
        $company_admin = 'N';
        if( $user_role === 'Privacy Official' OR $user_role === 'Security Official' ) {
            $company_admin = 'Y';
        }

        $user = User::create([
            'name' => trim( $data['firstname'] . ' ' . $data['lastname'] ),
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'company_id' => $data['company_id'],
            'company_website' => $data['company_website'],
            'com_code' => $com_code,
            'user_role' => $user_role,
            'company_admin' => $company_admin,
            'password' => Hash::make($data['password']),
        ]);

        $company = Company::where('id', $data['company_id'])->first();
        $company->website = $data['company_website'];
        $company->emp_title = $data['employee_title'];
        $company->address_one = $data['company_address_1'];
        $company->address_two = $data['company_address_2'];
        $company->city = $data['city'];
        $company->state = $data['state'];
        $company->zip = $data['zip'];
        $company->phone = $data['company_tel'];
        $company->save();

        $user->mobile = $data['mobile'];

        $user->save();

        $role = Role::where('name', $user_role)->first();
        $user->assignRole($role);

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $companies = Company::orderBy('company_name', 'ASC')->get();

        $roles = Role::where('name', 'not like', 'Admin')->orderBy('role_order', 'asc')->pluck('name','name')->all();

        return view('auth.register', compact('companies', 'roles'));
    }
}
