<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Response;
use Redirect;
use Gate;

use PdfSnappy;

use App\Models\Upload;
use App\Models\PolicyProcedure;
use App\Models\PolicyRevision;
use App\Models\PolicyRevisionState;

class PolicyProcedureController extends Controller
{
	public function index() {

		abort_if(Gate::denies('Policies and Procedures'), redirect(url('/dashboard')));

		$company_admin      = Auth::user()->company_admin;
        $logged_in_username = Auth::user()->username;

        $isSuperAdmin = false;
        if( getCurrentUserRole() === \Config::get('constants.admin')) {
            $isSuperAdmin = true;
        }

		return view( 'policy-procedure.index', compact('isSuperAdmin') );
	}

	public function ajaxGetPolicies(Request $request) {
		try {

			$postData = $request->all();
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $policies = PolicyProcedure::select(['uuid', 'policy_name']);

            $company_admin      = Auth::user()->company_admin;
            $logged_in_username = Auth::user()->username;

            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            }

            if(!empty($searchchar)) {
                $policies->where(function($query) use($searchchar) {
                    return $query->orWhere('policy_name', 'like', '%'.$searchchar.'%')/*->orWhere('content', 'like', '%'.$searchchar.'%')*/;
                });
            }

            switch ($ordercol) {
                case 0: $policies->orderBy('id', $orderdir); break;
                case 1: $policies->orderBy('policy_name', $orderdir); break;
                default: $policies->orderBy('id', $orderdir);
            }

            $total_policies = $policies->count();
            $policies->skip($start)->take($length);

            $can_edit = Auth::user()->can('Edit Policy and Procedures') ? true : false;
            $can_delete = Auth::user()->can('Delete Policy and Procedures') ? true : false;

            $data = $policies->get();
            $data = $data->map(function($policy, $key) use($isSuperAdmin, $can_edit, $can_delete) {

                $policy->no = intval( $key ) + 1;

                $actions = [];

                if( $can_edit ) {
                    $actions[] = '<a href="' . route('policy-procedure.edit', $policy->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                $actions[] = '<a href="' . route('policy-procedure.view', $policy->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';

                $actions[] = '<a href="' . route('policy-procedure.download', $policy->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span> Download</a>';

                if( $can_delete ) {
                    $actions[] = '<a href="' . route('policy-procedure.destroy', $policy->uuid) . '" class="btn btn-xs btn-custom-danger delete-policy"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $policy->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $policy;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_policies,
                'recordsFiltered' => $total_policies
            ]);

		}
		catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the policies. ' . $e->getMessage()); // 
        }
	}

	public function create() {

        abort_if(Gate::denies('Create Policy and Procedures'), redirect(url('/dashboard')));

		$company_admin      = Auth::user()->company_admin;
        $logged_in_username = Auth::user()->username;

        $isSuperAdmin = false;
        if( getCurrentUserRole() === \Config::get('constants.admin')) {
            $isSuperAdmin = true;
        }

		return view( 'policy-procedure.create', compact('isSuperAdmin') );
	}

	public function store(Request $request) {
		try {

			$rules = [
                'policy_name' => ['required', 'string', 'max:255'],
                'content' => ['required'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            PolicyProcedure::create( $data );

            return Redirect::route('UI_policyProcedures')->with('success', 'Policy has been created successfully.');

		}
		catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while saving the policy. ' . $e->getMessage()); // 
        }
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $policy = PolicyProcedure::whereUuid($uuid)->firstOrfail();

        $revisions = PolicyRevision::where('policy_procedure_id', $policy->id)->get();

        return view('policy-procedure.view', compact('policy', 'revisions') );
    }

    public function download($uuid) {
        try {

            $policy = PolicyProcedure::whereUuid($uuid)->firstOrfail();

            $revisions = PolicyRevision::where('policy_procedure_id', $policy->id)->get();

            $pdf = PdfSnappy::loadView("policy-procedure.download", [ 'policy' => $policy, 'revisions' => $revisions ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $policy->policy_name ) . '.pdf';

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 
        }
        catch(\Exception $e) {
            die( $e->getMessage() );
        }
    }

	public function edit($uuid) {
        abort_if(Gate::denies('Edit Policy and Procedures'), redirect(url('/dashboard')));

		$policy = PolicyProcedure::whereUuid($uuid)->firstOrfail();

        return view('policy-procedure.edit', compact('policy') );
	}

	public function update(Request $request, $uuid) {
		try {

			$policy = PolicyProcedure::whereUuid($uuid)->firstOrfail();

			$rules = [
                'policy_name' => ['required', 'string', 'max:255'],
                'content' => ['required'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $policy->policy_name = $request->policy_name;
            $policy->content = $request->content;
            $policy->save();

            return Redirect::route('UI_policyProcedures')->with('success', 'Policy has been updated successfully.');

		}
		catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the policy. ' . $e->getMessage()); // 
        }
	}

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($report_uuid)
    {
        abort_if(Gate::denies('Delete Policy and Procedures'), redirect(url('/dashboard')));

        try {
            $policy = PolicyProcedure::whereUuid($report_uuid)->firstOrfail();
            $policy->delete();

            return back()->with('success', 'Policy has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the policy. ' . $e->getMessage()); // $e->getMessage()
        }
    }

	/*public function emrByState() {
		$uploads = Upload::select('id', 'name', 'url')->where('category', 'policies_state')->get();

		return view( 'policy-procedure.emr', compact('uploads') );			
	}

	public function view($id) {

		$upload = Upload::select('id', 'name', 'url AS file_name')->where('id', $id)->first();

		// get policy revision
		$policy_revisions = PolicyRevision::where('upload_id', $upload->id)->get();

		return view( 'policy-procedure.view-policy-procedure-form', compact( 'upload', 'policy_revisions' ) );
	}

	public function viewEmr($id) {

		$upload = Upload::select('id', 'name', 'url AS file_name')->where('id', $id)->first();

		// get policy revision
		$policy_revisions = PolicyRevisionState::where('upload_id', $upload->id)->get();

		return view( 'policy-procedure.view-emr-form', compact( 'upload', 'policy_revisions' ) );
	}*/
}