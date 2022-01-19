<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Redirect;
use Illuminate\Support\Facades\Hash;
use Response;
use Session;
use DB;
use Gate;
use Spatie\Permission\Models\Role;
use PdfSnappy;

use App\Models\User;
use App\Models\Company;
use App\Models\Result;
use App\Models\TrainingAcknowledge;
use App\Models\RiskAssignmentAcknowledge;
use App\Models\EmployeeTrainingAcknowledgement;
use GuzzleHttp\Client;

/**
 * @group User management
 *
 * APIs for managing users
 */

class UserController extends Controller
{
    

    /**
        * Display Migrate User
        * 
        * Get List Of  User
        *  
         * migrate_users a user
         *
         * @queryParam int Size per page. Defaults to 20.
         * @queryParam page int Page to view.
         * 
         * @queryParam string  required    The firstname of the  user.      
         * @queryParam string  required    The lastname of the  user.    
         * @queryParam string  required    The username of the  user.      
         * @queryParam string  required    The email of the  user.     
         * @queryParam string  required    The mobile of the  user.      
         * @queryParam string  required    The password of the  user.     
         *
         * @response {
            *  "firstname": "test",
            *  "lastname": "demo",
            *  "username": "user_name",
            *  "email": "test@test.com",
            *  "mobile": "1234567890",
        * }
	*/

    public function migrate_users() {
        $users = DB::table('users_bk')->get();
        foreach( $users as $user ) {
            $user = collect($user)->toArray();
            $user['email_verified_at'] = date('Y-m-d H:i:s');
            User::create( $user );
        }
    }

        /**
        * Display User
        * 
        * Get List Of  User
        *  
        *
        * @bodyParam  firstname string required The id of the firstname. Example: test
        * @bodyParam  lastname string required The id of the lastname. Example: demo
        * @bodyParam  username string required The id of the username. Example: user_name
        * @bodyParam  email string required The id of the email. Example: test@test.com
        * @bodyParam  mobile string required The id of the mobile. Example: 1234567890
        *
        * @response {
        *  "firstname": "test",
        *  "lastname": "demo",
        *  "username": "user_name",
        *  "email": "test@test.com",
        *  "mobile": "1234567890",
        * }
	*/
    public function index(Request $request)
    {
        abort_if(Gate::denies('user-list'), redirect(url('/dashboard')));
        $require_subscription_message = '';
        $companies = Company::all()->where('is_terminated', '0');
        /*if( getCurrentUserRole() !== \Config::get('constants.admin') ) {
            $registered_users = User::select('id')->where('company_id', Auth::user()->company_id)->count();

            $company = Company::where('id', Auth::user()->company_id)->first();

            $available_licenses = $company->purchased_licenses - $company->registered_users;

            if( $available_licenses < 1 ) {
                $require_subscription_message = 'To add new user, you require to purchase a additional subscription for professional.';
            }
        }*/

        return view( 'users.index', compact('require_subscription_message', 'companies') );
    }

    public function ajaxGetUsers(Request $request) {

        try {

            $postData = $request->all();
            $start_date = isset($postData['start_date']) ? $postData['start_date'] : null;
            $end_date = isset($postData['end_date']) ? $postData['end_date'] : null;
            $company_id = isset($postData['company_id']) ? $postData['company_id'] : null;
            
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $company_admin      = Auth::user()->company_admin;
            $logged_in_username = Auth::user()->username;
            $company_name       = getCurrentUserCompanyName();

            $users = User::select(['users.id', 'users.uuid', 'users.firstname', 'users.lastname', 'users.username', 'users.email', 'companies.company_name', 'users.accstatus'])
                        ->leftJoin('companies', 'companies.id', 'users.company_id');

            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            } else {
                $users->where('companies.company_name', $company_name)/*->where('username', '!=', $logged_in_username)*/;
            }

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

            
            switch ($ordercol) {
                case 0: $users->orderBy('users.firstname', $orderdir); break;
                case 1: $users->orderBy('users.lastname', $orderdir); break;
                case 2: $users->orderBy('users.email', $orderdir); break;
                case 3: $users->orderBy('users.username', $orderdir); break;
                case 4: $users->orderBy('companies.company_name', $orderdir); break;
                default: $users->orderBy('users.firstname', $orderdir);
            }

            $total_users = $users->count();
            $users->skip($start)->take($length);

            $can_edit = Auth::user()->can('user-edit') ? true : false;
            $can_delete = Auth::user()->can('user-delete') ? true : false;

            $data = $users->get();
            $data = $data->map(function($user) use($isSuperAdmin, $can_edit, $can_delete) {

                $user->user_role = $user->roles->pluck('name','name')->first();
                $user->is_active = strtolower( $user->accstatus ) === 'y' ? 'Yes' : 'No';

                $actions = [];
                
                $actions[] = '<a href="' . route('users.downloadTrainingQuiz', $user->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Training Quiz</a>';

                $actions[] = '<a href="' . route('users.downloadAcknowledgements', $user->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Acknowledgement</a>';

                $actions[] = '<a href="' . route('users.downloadRiskAssessment', $user->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Risk Assessment Questionnaire</a>';

                if( $can_edit ) {
                    $actions[] = '<a href="' . route('users.edit', $user->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';

                    // $actions[] = '<a href="' . route('users.downloadTrainingQuiz', $user->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Training Quiz</a>';

                    // $actions[] = '<a href="' . route('users.downloadAcknowledgements', $user->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Acknowledgement</a>';

                    // $actions[] = '<a href="' . route('users.downloadRiskAssessment', $user->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Risk Assessment Questionnaire</a>';
                    
                    if( strtolower( $user->accstatus ) === 'y' ) {
                        $user->is_active = '<a href="' . route('disableUser', $user->uuid) . '" class="btn btn-xs btn-custom-danger disable-user"><i class="fa fa-ban" aria-hidden="true"></i> Disable</a>';
                    } else {
                        $user->is_active = '<a href="' . route('enableUser', $user->uuid) . '" class="btn btn-xs btn-custom-success enable-user"><i class="fa fa-flag" aria-hidden="true"></i> Enable</a>';
                    }
                    

                }

                if( $can_delete ) {
                    $actions[] = '<a href="' . route('users.destroy', $user->uuid) . '" class="btn btn-xs btn-custom-danger delete-user"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }
                
                if ($user->user_role != 'Super Admin') {
                    $actions[] = '<a href="' . route('users.switchUser', $user->id) . '" class="btn btn-xs btn-custom-primary switch-user"><span class="usericon" aria-hidden="true"></span> Switch User</a>';
                }

                $user->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                
                return $user;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_users,
                'recordsFiltered' => $total_users
            ]);
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the user list. ' . $e->getMessage());
        }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('user-create'), redirect(url('/dashboard')));

        $companies = getCompanies();

        $roles = Role::orderBy('role_order', 'asc')->pluck('name','name')->all();

        /*if( strtolower( Auth::user()->roles->pluck('name','name')->first() ) == \Config::get('constants.admin') ) {
            $roles = Role::orderBy('role_order', 'asc')->pluck('name','name')->all();
        } else {*/
            $roles = Role::where('name', 'not like', 'Super Admin')->orderBy('role_order', 'asc')->pluck('name','name')->all();
        /*}*/

        return view('users.create', compact( 'companies', 'roles' ));
    }

    /**
    * Create User 
    * 
    * create a user
    *
    * @bodyParam  firstname string required The id of the firstname. Example: test
    * @bodyParam  lastname string required The id of the lastname. Example: demo
    * @bodyParam  username string required The id of the username. Example: user_name
    * @bodyParam  email string required The id of the email. Example: test@test.com
    * @bodyParam  mobile string required The id of the mobile. Example: 1234567890
    * @bodyParam  password string required The id of the password. Example: 123
    *
    * @response {
    *  "firstname": "test",
    *  "lastname": "demo",
    *  "username": "user_name",
    *  "email": "test@test.com",
    *  "mobile": "1234567890",
    *  "password": "1234567890",
    * }
	*/
    public function store(Request $request)
    {
        try {
            $rules = [
                'firstname' => ['required', 'string', 'max:100'],
                'lastname' => ['required', 'string', 'max:100'],
                'username' => ['required', 'string', 'max:200', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'company_id' => ['required'],
                // 'company_website' => ['required', 'url', 'max:255'],
                // 'com_code' => ['required', 'string', 'max:200'],
                'user_role' => ['required', 'string'],
                // 'company_admin' => ['required', 'string'],
                // 'accstatus' => ['required'],
                'password' => ['required', 'string', 'min:8', 'same:confirmed'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            unset($data['confirmed']);

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

            $user->employee_title = ''; //$request->employee_title;
            $user->company_website = '';

            /*$user->company_address_1 = $request->company_address_1;
            $user->company_address_2 = $request->company_address_2;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->zip = $request->zip;
            $user->company_tel = $request->company_tel;*/

            $user->term_acceptance = 1;
            $user->completed_profile = 1;

            $user->mobile = $request->mobile;
            $user->email_verified_at=date('Y-m-d H:i:s');
            $user->accstatus='Y';
            $user->save();

            $role = Role::where('name', $user_role)->first();

            $user->assignRole($role);

            $full_name = $request->firstname . ' ' . $request->lastname;
            // dd($user);
            return Redirect::route('users.index')->with('success', 'User: ' . $full_name . ' has been created successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while creating a user. ' . $e->getMessage());
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


    public function edit($uuid)
    {
        abort_if(Gate::denies('user-edit'), redirect(url('/dashboard')));

        $user = User::whereUuid($uuid)->firstOrfail();

        $companies = getCompanies();

        $roles = Role::pluck('name','name')->all();

        $isSuperAdmin = false;
        if( Auth::user()->company_admin === 'Y' && Auth::user()->administrator === 'Superadmin' || Auth::user()->administrator === 'superadmin' || Auth::user()->administrator === 'Administration' || Auth::user()->administrator === 'administration') {
            $isSuperAdmin = true;
        }

        $userRole = $user->roles->pluck('name','name')->first();

        if( getCurrentUserRole() !== \Config::get('constants.admin')) {
            $roles = Role::where('name', 'not like', 'Super Admin')->orderBy('role_order', 'asc')->pluck('name','name')->all();
        } else {
            $roles = Role::orderBy('role_order', 'asc')->pluck('name','name')->all();
        }
        return view( 'users.edit', compact( 'user', 'companies', 'roles', 'userRole', 'isSuperAdmin' ) );
    }

        /**
        * Update User 
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
        * @queryParam  password string required The id of the password. Example: 123
        *
        * @response {
           *  "firstname": "test",
           *  "lastname": "demo",
           *  "username": "user_name",
           *  "email": "test@test.com",
           *  "mobile": "1234567890",
        * }
        */

    public function update(Request $request, $uuid)
    {
        try {

            $user = User::whereUuid($uuid)->firstOrfail();
            $user_id = $user->id;
            
            $rules = [
                'firstname' => ['required', 'string', 'max:100'],
                'lastname' => ['required', 'string', 'max:100'],
                'username' => ['required', 'string', 'max:200', Rule::unique('users')->ignore($user_id)],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user_id)],
                'company_id' => ['required'],
                'password' => ['nullable', 'string', 'min:8'],
                // 'company_website' => ['required', 'url', 'max:255'],
            ];

            if( $request->has('user_role') ) {
                $rules['user_role'] = ['required', 'string'];
            }

            $data = $request->except(['_token', 'btnSubmit']);

            $validator = Validator::make($data, $rules);

            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
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

            $user->employee_title = ''; //$request->employee_title;

            /*$user->company_address_1 = $request->company_address_1;
            $user->company_address_2 = $request->company_address_2;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->zip = $request->zip;
            $user->company_tel = $request->company_tel;*/
            $user->mobile = $request->mobile;

            $user->save();

            if( $request->has('user_role') ) {

                $role = Role::where('name', $request->user_role)->first();

                // uncomment when we add role while update user
                DB::table('model_has_roles')->where('model_id',$user_id)->delete();
                $user->assignRole($role);
            }

            $full_name = $request->firstname . ' ' . $request->lastname;

            return Redirect::route('users.index')->with('success', 'User: ' . $full_name . ' has been updated successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the user. ' . $e->getMessage());
        }
    }

/**
        * Delete User 
        * 
        * Display Delete User 
        * 
        * destroy a user
        *
        * @queryParam  user_Id int required The id of the location. Example: 1
        * @queryParam  username string required The id of the location. Example: user_name
        *
        * @response {
            *  "user_Id": "1",
            *  "username": "user_name",
        * }
        */
    public function destroy($user_uuid)
    {
        abort_if(Gate::denies('user-delete'), redirect(url('/dashboard')));

        try {
            $user = User::whereUuid($user_uuid)->firstOrfail();
            $user->delete();

            return Redirect::route('users.index')->with('success', 'User has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the user.'); // $e->getMessage()
        }
    }

    public function disableUser($user_uuid) {

        try {
            $user = User::whereUuid($user_uuid)->firstOrfail();
            $user->accstatus = 'n';
            $user->save();

            return Redirect::route('users.index')->with('success', 'User Disabled Successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while disabling the user.'); // $e->getMessage()
        }
    }

    public function enableUser($user_uuid) {

        try {
            $user = User::whereUuid($user_uuid)->firstOrfail();
            $user->accstatus = 'y';
            $user->save();

            return Redirect::route('users.index')->with('success', 'User enabled Successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while enabling the user.'); // $e->getMessage()
        }
    }

    public function changePassword($user_uuid) {
        $user = User::whereUuid($user_uuid)->firstOrfail();

        return view( 'users.password', compact( 'user' ) );
    }

    public function updatePassword(Request $request, $user_uuid) {
        try {

            $rules = [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $user = User::whereUuid($user_uuid)->firstOrfail();
            $user->password = Hash::make( $request->password );
            $user->save();

            return Redirect::route('users.index')->with('success', 'Password has been updated secessfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the user password.'); // $e->getMessage()
        }
    }

    public function completeSignup(Request $request) {

        $user = Auth::user();

        $userRole = $user->roles->pluck('name','name')->first();

        $roles = Role::where('name', 'not like', 'Admin')->orderBy('role_order', 'asc')->pluck('name','name')->all();

        $companies = getCompanies();
        return view( 'users.complete-signup', compact( 'userRole', 'roles', 'companies' ) );
    }

    public function acceptTermsConditions(Request $request) {
        $user = Auth::user();

        // $user = User::find( $user );
        $user->term_acceptance = 1;
        $user->save();


    }

    public function submitProfile(Request $request) {
        try {
            $user = Auth::user();
            $user->name = trim( $request->firstname . ' ' . $request->lastname );
            $user->firstname = trim( $request->firstname );
            $user->lastname = trim( $request->lastname );
            $user->completed_profile = 1;
            
            $purchased_licenses = 0;
            $monthly_fees = 0;
            if ($user->wp_user_id) {
                $client = new Client();
                $res = $client->request('POST', 'https://hipaamart.com/wp-json/users/get_users_com', [
                    'form_params' => [
                        "user_id" => $user->wp_user_id
                    ]
                ]);

                if($res->getStatusCode() == 200) {
                    $response = json_decode((string) $res->getBody(), true);
                    if( $response['req'] && $response['req']['data'] && $response['req']['data']['billing_amount'] ) {
                        $purchased_licenses = $response['req']['data']['subscription_users_limit'] != NULL ? $response['req']['data']['subscription_users_limit'] : 0;
                        $monthly_fees = $response['req']['data']['billing_amount'] != NULL ? $response['req']['data']['billing_amount'] : 0;
                    }
                }
            }

            $company = Company::select('*')->where('company_name', 'LIKE', $request->company_name)->first();
            if( $company === null ) {
                $company = new Company();
                $company->company_name = $request->company_name;
                $company->website = $request->company_website;
                $company->emp_title = $request->employee_title;
                $company->address_one = $request->company_address_1;
                $company->address_two = $request->company_address_2;
                $company->city = $request->city;
                $company->state = $request->state;
                $company->zip = $request->zip;
                $company->phone = $request->company_tel;
                $company->user_id = $user->id;
                $company->purchased_licenses = $purchased_licenses;
                $company->monthly_fees = $monthly_fees;
                $company->save();
            } else {
                $company->website = $request->company_website;
                $company->emp_title = $request->employee_title;
                $company->address_one = $request->company_address_1;
                $company->address_two = $request->company_address_2;
                $company->city = $request->city;
                $company->state = $request->state;
                $company->zip = $request->zip;
                $company->phone = $request->mobile;
                $company->purchased_licenses = $purchased_licenses;
                $company->monthly_fees = $monthly_fees;
                $company->save();
            }

            $user->company_id = $company->id;
            $user->employee_title = $request->employee_title;
            $user->company_website = $request->company_website;
            $user->company_address_1 = $request->company_address_1;
            $user->company_address_2 = $request->company_address_2;
            $user->city = $request->city;
            $user->state = $request->state;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->zip = $request->zip;
            $user->company_tel = $request->company_tel;
            $user->mobile = $request->mobile;
            $user->save();

            return redirect('dashboard');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the user password.'); // $e->getMessage()
        }
    }

    public function terminateAccount(Request $request) {
        $user = Auth::user();

        $user->accstatus = 'N';
        $user->save();

        \Auth::logout();
        return redirect('/login');
    }

    public function downloadQuizData($user_uuid) {

        try {

            $user = User::whereUuid($user_uuid)->firstOrfail();
            $user_id = $user->id;

            $results = Result::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            
            $training_ack = TrainingAcknowledge::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            $risk_ack = RiskAssignmentAcknowledge::where('user_id', $user_id)->orderBy('id', 'desc')->get();

            // return view("users.download.index", [ 'results' => $results, 'training_ack' => $training_ack, 'risk_ack' => $risk_ack ] );

            $pdf = PdfSnappy::loadView("users.download.index", [ 'results' => $results, 'training_ack' => $training_ack, 'risk_ack' => $risk_ack ] );
            $pdfContent = $pdf->inline();

            $fileName   = $user->firstname . '_' . $user->lastname . '_quiz_data.pdf';

            /*
            // uncomment this if you want to see output directly in browser
            $type       = 'application/pdf';
            $fileName   = 'user.pdf';
            
            return Response::make($pdfContent, 200, [
                'Content-Type'        => $type,
                'Content-Disposition' => 'inline; filename="'.$fileName.'"'
            ]);
            */

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 


        } catch( \Exception $e ) {
            dd( $e->getMessage() );
        }

    }

    public function downloadTrainingQuiz($user_uuid) {

        try {

            $user = User::whereUuid($user_uuid)->firstOrfail();
            $user_id = $user->id;

            $results = Result::where('user_id', $user_id)
                ->where('quiz_id', DB::raw("(SELECT id FROM quizes WHERE name LIKE 'Training Quiz' LIMIT 1)"))
                ->orderBy('id', 'desc')
                ->get();
            
            $pdf = PdfSnappy::loadView("users.download.training", [ 'results' => $results ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $user->firstname . '_' . $user->lastname ) . '_training_quiz_data.pdf';

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 


        } catch( \Exception $e ) {
            dd( $e->getMessage() );
        }

    }

    public function downloadRiskAssessment($user_uuid) {

        try {

            $user = User::whereUuid($user_uuid)->firstOrfail();
            $user_id = $user->id;

            $results = Result::where('user_id', $user_id)
                ->where('quiz_id', DB::raw("(SELECT id FROM quizes WHERE name LIKE 'Risk Assessment Questionnaire' LIMIT 1)"))
                ->orderBy('id', 'desc')
                ->get();
            
            $pdf = PdfSnappy::loadView("users.download.risk_assessment", [ 'results' => $results ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $user->firstname . '_' . $user->lastname ) . '_risk_assessment_quiz_data.pdf';

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 


        } catch( \Exception $e ) {
            dd( $e->getMessage() );
        }

    }

    public function downloadAcknowledgements($user_uuid) {

        try {

            $user = User::whereUuid($user_uuid)->firstOrfail();
            $user_id = $user->id;

            $training_ack = TrainingAcknowledge::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            $risk_ack = RiskAssignmentAcknowledge::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            $emp_training_ack = EmployeeTrainingAcknowledgement::where('user_id', $user_id)->orderBy('id', 'desc')->get();

            // return view("users.download.acknowledgements", [ 'training_ack' => $training_ack, 'risk_ack' => $risk_ack, 'emp_training_ack' => $emp_training_ack ] );
            
            $pdf = PdfSnappy::loadView("users.download.acknowledgements", [ 'training_ack' => $training_ack, 'risk_ack' => $risk_ack, 'emp_training_ack' => $emp_training_ack ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $user->firstname . '_' . $user->lastname ) . '_acknowledgements.pdf';

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 


        } catch( \Exception $e ) {
            dd( $e->getMessage() );
        }

    }

        // switch User
        public function switchUser($id) {
            try {
                $user = User::where('id', $id)->first();
                
                if (!$user) {
                    return response::json([
                        'success' => false,
                        'message' => 'User Id not match with, Please contact with Admin!',
                    ]);
                }
                
                Session::put('orig_user', Auth::id());
                Session::put('user_is_switched', true);
                Auth::login($user);

                if ($user->completed_profile) {
                    return response::json([
                        'success' => true,
                        'message' => 'User has been switched successfully!',
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
