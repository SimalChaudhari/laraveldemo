<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Mail;
use App\Mail\ApiUserRegisterationNotification;
use Response;
use App\Models\User;
use App\Models\Company;
use DB;

/**
 * @group User Management (API for Wordpress portal)
 *
 * APIs for managing users
 */
class ApiController extends Controller
{
	/**
	 * Create User from Wordpress Hippamart.
	 *
	 * This endpoint allows you to Create User from wordpress hippamart platform
	 * 
	* @bodyParam email string required The string of the user. Example: test@gmail.com
	* @bodyParam user_pass required string The password of user.
	* @bodyParam firstname required string The firstname of user.
	* @bodyParam lastname required string The lastname of user.
	* @bodyParam username required string The username of user.
	* @bodyParam wp_user_id required string The wp_user_id of user from wordpress database.
	* @bodyParam company_name required string The company name of user.
	* @bodyParam purchased_licenses required string The purchased licenses of user.
	* @bodyParam monthly_fees required string The monthly fees of user.
	*/
	public function _api_create_hipaa_mart_portal_user(Request $request) {

        try {

        	$user = User::where('email', 'LIKE', $request->email)->orWhere('username', 'LIKE', $request->username)->first();
			if ($user === null) {
				$random_password = Str::random(8);
				$actual_password = $request->user_pass ? $request->user_pass : $random_password;
	            $data = [
	                'firstname' => $request->firstname ? $request->firstname : '',
	                'lastname' => $request->lastname ? $request->lastname : '',
	                'username' => $request->username ? $request->username : '',
	                'email' => $request->email ? $request->email : '',
	                'wp_user_id' => $request->wp_user_id ? $request->wp_user_id : '',
	                'company_name'=>$request->company_name ? $request->company_name : '',
	                'password' => Hash::make( $actual_password ),
	                'com_code' => md5( uniqid( rand() ) ),
	                'company_token' => md5(uniqid(rand())),
	                'accstatus' => 'Y',
	                'administrator' => 'Administration',
	            ];

	            $user = User::create( $data );
	            $user = User::find( $user->id );
	            $user->email_verified_at = date('Y-m-d H:i:s');
	            $user->save();
				$user->assignRole($data['administrator']);

				$company = new Company();
				$company->company_name = $request->company_name ? $request->company_name : '';
				$company->purchased_licenses = $request->purchased_licenses ? $request->purchased_licenses : 0;
				$company->monthly_fees = $request->monthly_fees ? $request->monthly_fees : 0;
				$company->user_id = $user->id;
				$company->created_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
				$company->save();
				
	            //update usre table after creating com
                DB::table('users')->where('wp_user_id',$request->wp_user_id)->update(["company_id"=>$company->id]);
                //dd($user,$company,$request);
	            $data['actual_password'] = $actual_password;

	            \Mail::to($request->email)->send(new ApiUserRegisterationNotification($data));
			   
				return response::json([
					'success' => true,
					'message' => 'User has been created successfully and sent the email!',
				]);
			} else {
				return response::json([
					'success' => false,
					'message' => 'User already exist with the email or username.',
				]);
			}

        }
        catch(\Exception $e) {
			return response::json([
				'success' => false,
				'message' => 'Oops! something went wrong. ' . $e->getMessage(),
			]);
        }

    }

	/**
	 * Delete User.
	 *
	 * This endpoint allows you to Create User from wordpress hippamart platform
	 * 
	* @bodyParam email string required The string of the user. Example: test@gmail.com
	*/
    public function _api_delete_wp_portal_user(Request $request) {
    	try {

			$user = User::where('email', 'LIKE', $request->email)->where('username', 'LIKE', $request->username)->first();
			if ($user === null) {
				dd('Invalid user found.');
			}

			$user->accstatus = 'n';
			$user->delete();

    	}
    	catch(\Exception $e) {
            dd('Oops! something went wrong. ' . $e->getMessage());
        }
    }
}