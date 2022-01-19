<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use Response;
use Redirect;
use Session;
use Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Mail\CompanyRestoreNotification;
use App\Mail\CompanyTerminateNotification;
use App\Models\Company;
use App\Models\User;
use GuzzleHttp\Client;
use Spatie\Permission\Models\Role;

/**
 * @group Company management
 *
 * API for manage the company, like create, update, delete, view etc... 
 */
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('company-list'), redirect(url('/dashboard')));
        
        return view( 'company.index' );
    }

    /**
    * List 
    *
    * @authenticated
    * @response [{
        *  "company_id": "1",
        *  "company_name": "Demo",
        *  "website": "www.test.com",
        *  "emp_title": "Demo",
        *  "address_one": "test-demo",
        *  "address_two": "demo-test",          
        *  "city": "demo-city",
        *  "state": "demo-state",
        *  "zip": "151543",
        *  "phone": "1234567890",
        *  "user_id": "1",
    * }]
    */
    public function ajax_getRecords(Request $request) {
        try {
            $postData = $request->all();
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $company_admin      = Auth::user()->company_admin;
            $logged_in_username = Auth::user()->username;
            $logged_in_user_id = Auth::user()->id;

            $query = Company::select([ 'roles.name', 'users.id as u_id', 'users.username', 'companies.id', 'companies.company_name', 'companies.emp_title', 'companies.purchased_licenses', 'companies.user_id', 'companies.created_at', 'companies.is_terminated', 'companies.monthly_fees'])
            ->leftJoin('users', 'users.id', 'companies.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id');

            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            } else {
                $query = $query->where('companies.user_id', $logged_in_user_id);
            }

            if(!empty($searchchar)) {
                $query->where(function($q) use($searchchar) {
                    return $q->orWhere('companies.company_name', 'like', '%'.$searchchar.'%');
                });
            }

            $query->whereNotIn("roles.name", ["Super Admin"]);

            switch ($ordercol) {
                case 1: $query->orderBy('companies.company_name', $orderdir); break;
                case 2: $query->orderBy('users.username', $orderdir); break;
                // case 2: $query->orderBy('emp_title', $orderdir); break;
                case 7: $query->orderBy('companies.created_at', $orderdir); break;
                default: $query->orderBy('companies.created_at', $orderdir);
            }

            $total_companies = $query->count();
            $query->skip($start)->take($length);

            $can_edit = Auth::user()->can('Edit Company') ? true : false;
            $can_delete = Auth::user()->can('Delete Company') ? true : false;

            $data = $query->get();
            $data = $data->map(function($company, $key) use($isSuperAdmin, $can_edit, $can_delete) {

                $company->no = intval( $key ) + 1;

                $company->registered_users = User::select('id')->where('company_id', $company->id)->count();

                $company->available_licenses = $company->purchased_licenses - $company->registered_users;
                
                // If terminatted then 0 values 
                $company->monthly_fees = $company->is_terminated ? 0 :  $company->monthly_fees;

                $company->created_on = Carbon::parse( $company->created_at )->format( \config('app.VIEW_DATE_FORMAT') );

                $actions = [];

                if( $can_edit ) {
                    $actions[] = '<a href="' . route('company.edit', $company->id) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                if( !$company->is_terminated) {
                    $actions[] = '<a href="' . route('company.terminate', $company->id) . '" class="btn btn-xs btn-custom-danger terminate-company" data-before_delete_callback="' . route('company.hasAnyUser', $company->id) . '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Terminate</a>';
                }
              
                if( $company->is_terminated) {
                    $actions[] = '<a href="' . route('company.restore', $company->id) . '" class="btn btn-xs btn-custom-primary restore-company" data-before_delete_callback="' . route('company.hasAnyUser', $company->id) . '"><span class="glyphicon" aria-hidden="true"></span> Restore</a>';
                }

                if ($isSuperAdmin) {
                    $actions[] = '<a href="' . route('company.switchUser', $company->id) . '" class="btn btn-xs btn-custom-primary switch-user"><span class="usericon" aria-hidden="true"></span> Switch User</a>';
                }

                $company->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $company;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_companies,
                'recordsFiltered' => $total_companies
            ]);
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the data. ' . $e->getMessage()); // 
        }
    }

  /**
        * Create Compney 
        * 
        * Display Create compney 
        * 
        * create a compney
        *
        * @bodyParam  company_name string required The id of the company_name. Example: Demo
        * @bodyParam  website string required The id of the website. Example: www.test.com
        * @bodyParam  emp_title string required The id of the emp_title. Example: Demo
        * @bodyParam  address_one string required The id of the address_one. Example: test-demo
        * @bodyParam  address_two string required The id of the address_two. Example: demo-test
        * @bodyParam  city string required The id of the city. Example: demo-city
        * @bodyParam  state string required The id of the state. Example: demo-state
        * @bodyParam  zip int required The id of the zip. Example: 151543
        * @bodyParam  phone int required The id of the phone. Example: 1234567890
        * @bodyParam  user_id int required The id of the user_id. Example: 1
        
        * @response {
           *  "company_name": "Demo",
           *  "website": "www.test.com",
           *  "emp_title": "Demo",
           *  "address_one": "test-demo",
           *  "address_two": "demo-test",          
           *  "city": "demo-city",
           *  "state": "demo-state",
           *  "zip": "151543",
           *  "phone": "1234567890",
           *  "user_id": "1",
        * }
        */
    public function create()
    {
        abort_if(Gate::denies('Add New Company'), redirect(url('/dashboard')));

        return view( 'company.create' );
    }

    public function add_new_company(Request $request) {

        $rules = [
            'company_name' => ['required', 'string', 'max:255', 'unique:companies,company_name']
        ];

        $data = [
            'company_name' => $request->company_name
        ];

        $validator = Validator::make($data, $rules);

        if ( $validator->fails() ) {
            return response::json([
                'error' => true,
                'message' => $validator->errors()->first()
            ]);
        }

        Company::create( [
            'company_name' => $request->company_name
        ] );

        $companies = Company::orderBy('company_name', 'ASC')->get()->toArray();

        return response::json([
            'success' => true,
            'companies' => $companies
        ]);
    }

    /**
         * store a company
         *
         * @bodyParam string  required    The firstname of the  user.      Example: test
         * @bodyParam string  required    The lastname of the  user.      Example: demo
         * @bodyParam string  required    The username of the  user.      Example: user_name 
         * @bodyParam string  required    The email of the  user.      Example: test@test.com 
         * @authenticated
         *
         *
         * @response {
            *  "firstname": "test",
            *  "lastname": "demo",
            *  "username": "user_name",
            *  "email": "test@test.com",
        * }
	 */
    public function store(Request $request)
    {
        try {
            $rules = [
                'company_name' => ['required', 'string', 'max:255', 'unique:companies,company_name']
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $company = new Company();
            $company->company_name = $request->company_name;
            $company->website = $request->website;
            $company->emp_title = $request->emp_title;
            $company->address_one = $request->address_one;
            $company->address_two = $request->address_two;
            $company->city = $request->city;
            $company->state = $request->state;
            $company->zip = $request->zip;
            $company->phone = $request->phone;
            $company->user_id = \Auth::user()->id;
            $company->created_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $company->save();

            return Redirect::route('company.index')->with('success', 'Company: ' . $request->company_name . ' has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the user.'); // $e->getMessage()
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('Edit Company'), redirect(url('/dashboard')));

        $company = Company::findOrFail( $id );
        // $user = User::select('*')->where('id', $company->user_id)->first();
        // $company->website =  $user->company_website;
        // $company->emp_title =  $user->employee_title;
        // $company->address_one =  $user->company_address_1;
        // $company->address_two = $user->company_address_2;
        // $company->city =  $user->city;
        // $company->state =  $user->state;
        // $company->zip =  $user->zip;
        // $company->phone =  $user->mobile;
        
        return view( 'company.edit', compact( 'company' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

/**
        * Update Compney 
        * 
        * Display Update compney 
        * 
        * update a compney
        *
        * @queryParam  company_id int required The id of the company_id. Example: 1
        * @queryParam  company_name string required The id of the company_name. Example: Demo
        * @queryParam  website string required The id of the website. Example: www.test.com
        * @queryParam  emp_title string required The id of the emp_title. Example: Demo
        * @queryParam  address_one string required The id of the address_one. Example: test-demo
        * @queryParam  address_two string required The id of the address_two. Example: demo-test
        * @queryParam  city string required The id of the city. Example: demo-city
        * @queryParam  state string required The id of the state. Example: demo-state
        * @queryParam  zip int required The id of the zip. Example: 151543
        * @queryParam  phone int required The id of the phone. Example: 1234567890
        * @queryParam  user_id int required The id of the user_id. Example: 1
        
        * @response {
           *  "company_id": "1",
           *  "company_name": "Demo",
           *  "website": "www.test.com",
           *  "emp_title": "Demo",
           *  "address_one": "test-demo",
           *  "address_two": "demo-test",          
           *  "city": "demo-city",
           *  "state": "demo-state",
           *  "zip": "151543",
           *  "phone": "1234567890",
           *  "user_id": "1",
        * }
        */
    public function update(Request $request, $id)
    {
        try {
            $company_id = $id;

            $rules = [
                'company_name' => ['required', 'string', 'max:255', Rule::unique('companies')->ignore($company_id)]
            ];

            $data = $request->except(['_token', 'update']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $company = Company::find($company_id);
            $company->company_name = $request->company_name;
            $company->company_name = $request->company_name;
            $company->website = $request->website;
            $company->emp_title = $request->emp_title;
            $company->address_one = $request->address_one;
            $company->address_two = $request->address_two;
            $company->city = $request->city;
            $company->state = $request->state;
            $company->zip = $request->zip;
            $company->phone = $request->phone;
            $company->updated_at = Carbon::now();
            $company->save();

            return Redirect::route('company.index')->with('success', 'Company: ' . $request->company_name . ' has been updated successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the company.'); // $e->getMessage()
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
        * Delete Compney 
        * 
        * Display Delete compney 
        * 
        * delete a compney
        *
        * @queryParam  company_id int required The id of the company_id. Example: 1
        * @queryParam  company_name string required The id of the company_name. Example: Demo
        * @queryParam  user_id int required The id of the user_id. Example: 1
        
        * @response {
           *  "company_id": "1",
           *  "company_name": "Demo",
           *  "user_id": "1",
        * }
        */
    public function destroy($id)
    {
        abort_if(Gate::denies('Delete Company'), redirect(url('/dashboard')));

        try {
            $company = Company::findOrFail( $id );
            $company->delete();

            return Redirect::route('company.index')->with('success', 'Company has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the company.'); // $e->getMessage()
        }
    }

    /**
     * terminate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function terminate($id)
    {
        try {
            $company = Company::find($id);
            $company->is_terminated = 1;
            $company->updated_at = Carbon::now();
            $company->save();

            $user = User::where('id', $company->user_id)->first();
			if ($user) {
				$user->accstatus = 'n';
                $user->save();

                if ($user->wp_user_id) {
                    $client = new Client();
                    $res = $client->request('POST', 'https://hipaamart.com/wp-json/users/terminate', [
                        'form_params' => [
                            "user_id" => $user->wp_user_id
                        ]
                    ]);
        
                    if($res->getStatusCode() == 200) {
                        if ($user->email) {
                            \Mail::to($user->email)->send(new CompanyTerminateNotification($user));
                        }
                        return response::json([
                            'success' => true,
                            'message' => 'Company has been terminated successfully!',
                        ]);
                    }
                }

			}

            return response::json([
                'success' => true,
                'message' => 'Company has been terminated successfully!',
            ]);
        }
        catch(\Exception $e) {
            return response::json([
                'success' => false,
                'message' => 'Sorry! There was an error, Please try again!',
            ]);
        }
    }

    /**
     * Restore
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            $company = Company::find($id);
            $company->is_terminated = 0;
            $company->updated_at = Carbon::now();
            $company->save();

            $total_users = User::select('id')->where('company_id', $company->id)->count();
            
            $user = User::select('*')->where('id', $company->user_id)->first();
            $user->accstatus = 'Y';
            $user->save();
            if ($user->email) {
                \Mail::to($user->email)->send(new CompanyRestoreNotification($user));
            }

            
            
            if ($user->wp_user_id) {
                $client = new Client();
                $res = $client->request('POST', 'https://hipaamart.com/wp-json/users/terminate', [
                    'form_params' => [
                        "user_id" => $user->wp_user_id,
                        "action" => 'restore',
                        "users" => $total_users,
                    ]
                ]);
    
                if($res->getStatusCode() == 200) {
                    return response::json([
                        'success' => true,
                        'message' => 'Company has been restored successfully and sent email!',
                    ]);
                }
            }

            return response::json([
                'success' => true,
                'message' => 'Company has been restored successfully and sent email!',
            ]);
        }
        catch(\Exception $e) {
            return response::json([
                'success' => false,
                'message' => 'Sorry! There was an error, Please try again!',
            ]);
        }
    }

    public function hasAnyUser($id) {

        try {
            $company = Company::findOrFail( $id );

            $user = User::select('id')->where('company_id', $company->id)->first();

            $can_delete = false;
            if( $user === null ) {
                $can_delete = true;
            }

            return response::json([
                'can_delete' => $can_delete
            ]);
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the company.'); // $e->getMessage()
        }
    }

    // Create new password for first time login user
    public function createPassword($company_token) {
        $user = User::where('company_token', $company_token)->first();
        if ($user) {
            return view('users.new_password', compact( 'user' ));
        } else {
            return Redirect::route('login')->with('error', 'Sorry! Invalid parameter in request.');
        }
    }

    // Save password for the new company
    public function savePassword(Request $request, $id) {
        try {

            $rules = [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
            
            $data = $request->except(['_token', 'submit']);
            $validator = Validator::make($data, $rules);
            
            
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            $user = User::where('id', $id)->firstOrfail();
            $user->password = Hash::make( $request->password );
            $user->is_first_attept = 0;
            $user->company_token = '';
            $user->save();
            return Redirect::route('login')->with('success', 'Password has been created secessfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while creating the password.'); // $e->getMessage()
        }
    }

    // Save password for the new company
    public function increasePurchaseLimit(Request $request) {
        try {
            $id = $request->id;
            $company = Company::findOrFail($id);
            $number_of_users = $company->purchased_licenses + 1;
            $user = User::where('id', $company->user_id)->first();

            if (!$user->wp_user_id) {
                return response::json([
                    'success' => false,
                    'message' => 'User Id not match, Please contact with Admin!',
                ]);
            }

            $client = new Client();
            $res = $client->request('POST', 'https://hipaamart.com/wp-json/users/upgrade_downgrade_users', [
                'form_params' => [
                    "user_id" => $user->wp_user_id,
                    "number_of_users" => $number_of_users,
                    "company_name" => $company->company_name
                ]
            ]);
    
            if($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody(), true);
                if( $response['req'] && $response['req']['data'] && $response['req']['data']['billing_amount'] ) {
                    $company->purchased_licenses = $response['req']['data']['subscription_users_limit'] != NULL ? $response['req']['data']['subscription_users_limit'] : 0;
                    $company->monthly_fees = $response['req']['data']['billing_amount'] != NULL ? $response['req']['data']['billing_amount'] : 0;
                }
                
                $company->save();
                return response::json([
                    'success' => true,
                    'message' => 'Data has been updated successfully!',
                ]);
            }else {
                return response::json([
                    'success' => false,
                    'message' => 'Sorry! There was an error, Please try again!',
                ]);
            } 
        }
        catch(\Exception $e) {
            return response::json([
                'success' => false,
                'message' => 'Sorry! There was an error, Please try again!',
            ]);
        }
    }
   
    // Save password for the new company
    public function decreasePurchaseLimit(Request $request) {
        try {
            $id = $request->id;
            $company = Company::findOrFail($id);
            $user = User::where('id', $company->user_id)->first();
            if ($company->purchased_licenses == 0) {
                return response::json([
                    'success' => false,
                    'message' => 'Already 0 purchased licenses!',
                ]);
            }

            if (!$user->wp_user_id) {
                return response::json([
                    'success' => false,
                    'message' => 'User Id not match with, Please contact with Admin!',
                ]);
            }
            
            $number_of_users = $company->purchased_licenses - 1;
           
            $client = new Client();
            $res = $client->request('POST', 'https://hipaamart.com/wp-json/users/upgrade_downgrade_users', [
                'form_params' => [
                    "user_id" => $user->wp_user_id,
                    "number_of_users" => $number_of_users,
                    "company_name" => $company->company_name
                ]
            ]);
    
            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody(), true);
                if ( $response['req'] && $response['req']['data'] && $response['req']['data']['billing_amount'] ) {
                    $company->purchased_licenses = $response['req']['data']['subscription_users_limit'] != NULL ? $response['req']['data']['subscription_users_limit'] : 0;
                    $company->monthly_fees = $response['req']['data']['billing_amount'] != NULL ? $response['req']['data']['billing_amount'] : 0;
                }
                $company->save();
                return response::json([
                    'success' => true,
                    'message' => 'Data has been updated successfully!',
                ]);
            } else {
                return response::json([
                    'success' => false,
                    'message' => 'Sorry! There was an error, Please try again!',
                ]);
            }
        }
        catch(\Exception $e) {
            return response::json([
                'success' => false,
                'message' => 'Sorry! There was an error, Please try again!',
            ]);
        }
    }
  
    // switch User
    public function switchUser(Request $request, $id) {
        try {

            $company = Company::findOrFail($id);
            if (!$company->user_id) {
                return response::json([
                    'success' => false,
                    'message' => 'User Id not match with, Please contact with Admin!',
                ]);
            }

            $user = User::where('id', $company->user_id)->first();
            if (!$user) {
                return response::json([
                    'success' => false,
                    'message' => 'User Id not match with, Please contact with Admin!',
                ]);
            }

            Session::put('orig_user', Auth::id());
            Session::put('user_is_switched', true);
            Auth::login($user);

            return response::json([
                'success' => true,
                'message' => 'User has been switched successfully!',
            ]);
        }
        catch(\Exception $e) {
            return response::json([
                'success' => false,
                'message' => 'Sorry! There was an error, Please try again!',
            ]);
        }
    }

    // switch back admin
    public function switchBackUser(Request $request) {
        try {
            $id = Session::pull('orig_user');
            $user = User::where('id', $id)->first();
            Auth::login($user);
            Session::put('user_is_switched', false);

            if (!$user) {
                return response::json([
                    'success' => false,
                    'message' => 'User Id not match with, Please contact with Admin!',
                ]);
            }

            return response::json([
                'success' => true,
                'message' => 'User has been switched successfully!',
            ]);
        }
        catch(\Exception $e) {
            return response::json([
                'success' => false,
                'message' => 'Sorry! There was an error, Please try again!',
            ]);
        }
    }
}
