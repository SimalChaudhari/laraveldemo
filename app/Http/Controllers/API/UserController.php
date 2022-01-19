<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Company;

/**
 * @group User Management
 *
 * APIs for managing company users
 */
class UserController extends Controller
{
    /**
         * list
         * 
         * @bodyParam start_date string The start date.
         * @bodyParam end_date string The end date.
         * @bodyParam company_id int The company_id of the user.
         * @bodyParam start int The start of users length.
         * @bodyParam length int The end length of users length.
         * @bodyParam search string The search value.
         * 
         * @authenticated
         * @response {
         *  "email": "testuser@tests.com",
         *  "password": "secret"
         * }
    */
    public function list(Request $request) {
        try {

            $postData = $request->all();
            $start_date = isset($postData['start_date']) ? $postData['start_date'] : null;
            $end_date = isset($postData['end_date']) ? $postData['end_date'] : null;
            $company_id = isset($postData['company_id']) ? $postData['company_id'] : null;
            
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $searchchar = isset($postData['search'])   ? $postData['search']      : '';

            $company_admin      = Auth::user() && Auth::user()->company_admin ? Auth::user()->company_admin : '';
            $logged_in_username = Auth::user() && Auth::user()->username ? Auth::user()->username : '';

            $users = User::select(['users.id', 'users.uuid', 'users.firstname', 'users.lastname', 'users.username', 'users.email', 'companies.company_name', 'users.accstatus'])
                        ->leftJoin('companies', 'companies.id', 'users.company_id');

            if ($company_id) {
                $users->where('companies.id', $company_id);
            }

            if ($start_date && $start_date != 'undefined' && $end_date && $end_date != 'undefined') {
                $users->whereBetween('users.created_at', [$start_date, $end_date]);
            }

            if (!empty($searchchar)) {
                $users->where(function($query) use($searchchar) {
                    return $query->orWhere('firstname', 'like', '%'.$searchchar.'%')->orWhere('lastname', 'like', '%'.$searchchar.'%')->orWhere('companies.company_name', 'like', '%'.$searchchar.'%')->orWhere('email', 'like', '%'.$searchchar.'%');
                });
            }

            $total_users = $users->count();
            $users->skip($start)->take($length);

            $data = $users->get();
            $data = $data->map(function($user) {
                $user->user_role = $user->roles->pluck('name','name')->first();
                $user->is_active = strtolower( $user->accstatus ) === 'y' ? 'Yes' : 'No';

                return $user;
            });

            return response()->json([
                'data' => $data,
                'recordsTotal' => $total_users,
                'recordsFiltered' => $total_users
            ], 201);
        }
        catch(\Exception $e) {
            return response()->json([
                'message' => 'Sorry! There was an error while listing users. ' . $e->getMessage()
            ], 400);
        }
    }

    /**
         * create
         *
         * @bodyParam firstname string required The firstname of the user. Example: test
         * @bodyParam lastname string required The lastname of the user. Example: test
         * @bodyParam username string required The username of the user. Example: username
         * @bodyParam email string required The email of the user. Example: test@gmail.com
	     * @bodyParam password string required The password of user.
	     * @bodyParam confirm_password string required The confirm password of user.
         * @bodyParam user_role string required The role of the user. Example: admin, user
         * @bodyParam mobile string required The mobile of the user. Example: mobile
         * @bodyParam company_id int required The company_id of the user.
         * 
         * @authenticated
         * @response {
         *  "email": "testuser@tests.com",
         *  "password": "secret"
         * }
    */
    public function create(Request $request) {
        try {
            $rules = [
                'firstname' => ['required', 'string', 'max:100'],
                'lastname' => ['required', 'string', 'max:100'],
                'username' => ['required', 'string ', 'max:200', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'company_id' => ['required'],
                'user_role' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'same:confirm_password'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            unset($data['confirm_password']);

            $user_role = $data['user_role'];
            $com_code = md5( uniqid( rand() ) );
            $company_admin = 'N';
            if( $user_role === 'Privacy Official' OR $user_role === 'Security Official' ) {
                $company_admin = 'Y';
            }

            $data['password'] = Hash::make( $request->password );
            $data['company_admin'] = $company_admin;
            $data['com_code'] = $com_code;
            $data['email_verified_at'] = date('Y-m-d H:i:s');

            // create the user
            $user = User::create( $data );
            $user->employee_title = '';
            $user->company_website = '';
            $user->term_acceptance = 1;
            $user->completed_profile = 1;
            $user->mobile = $request->mobile;
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->accstatus='Y';
            $user->save();

            $role = Role::where('name', $user_role)->first();
            $user->assignRole($role);
            $full_name = $request->firstname . ' ' . $request->lastname;

            return response()->json([
                'message' => 'User: ' . $full_name . ' has been created successfully.',
                'user' => $user
            ], 201);
        }
        catch(\Exception $e) {
            return response()->json([
                'message' => 'Sorry! There was an error while creating a user. ' . $e->getMessage()
            ], 400);
        }
    }

    /**
         * get
         *
         * @authenticated
         * @response {
         *  "email": "testuser@tests.com",
         *  "password": "secret"
         * }
    */
    public function getById($id)
    {
        try {
            $user = User::where('id', $id)->first();
            $user->user_role = $user->roles->pluck('name','name')->first();
            return response()->json([
                'data' => $user
            ], 201);
        }
        catch(\Exception $e) {
            return response()->json([
                'message' => 'Sorry! There was an error. ' . $e->getMessage()
            ], 400);
        }
    }

        /**
        * Update 
        * 
        * Display Upadte User 
        * 
        * update a user
        *
        * @queryParam  firstname string required The id of the firstname. Example: test
        * @queryParam  lastname string required The id of the lastname. Example: demo
        * @queryParam  username string required The id of the username. Example: user_name
        * @queryParam  email string required The id of the email. Example: test@test.com
        * @queryParam  mobile int required The id of the mobile. Example: 1234567890
        * @queryParam  password string The id of the password. Example: 123
        *
        * @response {
           *  "firstname": "test",
           *  "lastname": "demo",
           *  "username": "user_name",
           *  "email": "test@test.com",
           *  "mobile": "1234567890",
        * }
        */

        public function update(Request $request, $id)
        {
            try {
    
                $user = User::where('id', $id)->first();
                $user_id = $user->id;
                
                $rules = [
                    'firstname' => ['required', 'string', 'max:100'],
                    'lastname' => ['required', 'string', 'max:100'],
                    'username' => ['required', 'string', 'max:200', Rule::unique('users')->ignore($user_id)],
                    'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user_id)],
                    'company_id' => ['required'],
                    'password' => ['nullable', 'string', 'min:8']
                ];
    
                if( $request->has('user_role') ) {
                    $rules['user_role'] = ['required', 'string'];
                }
    
                $data = $request->except(['_token', 'btnSubmit']);
    
                $validator = Validator::make($data, $rules);
    
                if ( $validator->fails() ) {
                    return response()->json($validator->errors()->toJson(), 400);
                }
    
                $user->firstname = $request->firstname;
                $user->lastname = $request->lastname;
                $user->username = $request->username;
                $user->email = $request->email;
                $user->company_website = '';
                $user->company_id = intval( $request->company_id );
    
                if( !empty( trim( $request->password ) ) ) {
                    $user->password = Hash::make( trim( $request->password ) );
                }
    
                $user->employee_title = '';
                $user->mobile = $request->mobile;
    
                $user->save();
    
                if( $request->has('user_role') ) {
    
                    $role = Role::where('name', $request->user_role)->first();
    
                    // uncomment when we add role while update user
                    DB::table('model_has_roles')->where('model_id',$user_id)->delete();
                    $user->assignRole($role);
                }
    
                $full_name = $request->firstname . ' ' . $request->lastname;
                return response()->json([
                    'message' => 'User: ' . $full_name . ' has been updated successfully.',
                    'user' => $user
                ], 201);
            }
            catch(\Exception $e) {
                return response()->json([
                    'message' => 'Sorry! There was an error. ' . $e->getMessage()
                ], 400);
            }
        }

    /**
    * Delete 
    * 
    * Display Delete User 
    * 
    * destroy a user
    *
    * @response {
        *  "user_Id": "1",
        *  "username": "user_name",
    * }
    */
    public function destroy($id)
    {
        try {
            $user = User::where('id', $id)->first();
            $user->delete();
            return response()->json([
                'message' => 'User has been deleted successfully.',
            ], 201);
        }
        catch(\Exception $e) {
            return response()->json([
                'message' => 'Sorry! There was an error. ' . $e->getMessage()
            ], 400);
        }
    }

}
