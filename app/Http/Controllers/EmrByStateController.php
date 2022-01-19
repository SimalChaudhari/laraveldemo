<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Response;
use Redirect;
use Gate;

use App\Models\EmrByState;
use App\Models\PolicyRevision;

class EmrByStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('EMR Records'), redirect(url('/dashboard')));

        $company_admin      = Auth::user()->company_admin;
        $logged_in_username = Auth::user()->username;

        $isSuperAdmin = false;
        if( getCurrentUserRole() === \Config::get('constants.admin')) {
            $isSuperAdmin = true;
        }

        return view( 'policy-procedure.emr-by-states.index', compact('isSuperAdmin') );
    }

    public function ajaxGetPolicies(Request $request) {
        try {

            $postData = $request->all();
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $emr = EmrByState::select(['uuid', 'policy_name']);

            $company_admin      = Auth::user()->company_admin;
            $logged_in_username = Auth::user()->username;

            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            }

            if(!empty($searchchar)) {
                $emr->where(function($query) use($searchchar) {
                    return $query->orWhere('policy_name', 'like', '%'.$searchchar.'%')/*->orWhere('content', 'like', '%'.$searchchar.'%')*/;
                });
            }

            switch ($ordercol) {
                case 0: $emr->orderBy('id', $orderdir); break;
                case 1: $emr->orderBy('policy_name', $orderdir); break;
                default: $emr->orderBy('id', $orderdir);
            }

            $total_policies = $emr->count();
            $emr->skip($start)->take($length);

            $can_edit = Auth::user()->can('Edit EMR Records') ? true : false;
            $can_delete = Auth::user()->can('Delete EMR Records') ? true : false;

            $data = $emr->get();
            $data = $data->map(function($record, $key) use($isSuperAdmin, $can_edit, $can_delete) {

                $record->no = intval( $key ) + 1;

                $actions = [];

                if( $can_edit ) {
                    $actions[] = '<a href="' . route('emr-records.edit', $record->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                $actions[] = '<a href="' . route('emr-records.view', $record->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';

                if( $can_delete ) {
                    $actions[] = '<a href="' . route('emr-records.destroy', $record->uuid) . '" class="btn btn-xs btn-custom-danger delete-emr"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $record->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $record;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_policies,
                'recordsFiltered' => $total_policies
            ]);

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the emr records. ' . $e->getMessage()); // 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('Create EMR Records'), redirect(url('/dashboard')));

        $company_admin      = Auth::user()->company_admin;
        $logged_in_username = Auth::user()->username;

        $isSuperAdmin = false;
        if( getCurrentUserRole() === \Config::get('constants.admin')) {
            $isSuperAdmin = true;
        }

        return view( 'policy-procedure.emr-by-states.create', compact('isSuperAdmin') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

            EmrByState::create( $data );

            return Redirect::route('emr-records.index')->with('success', 'Record has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while saving the emr record. ' . $e->getMessage()); // 
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
        $emr = EmrByState::whereUuid($uuid)->firstOrfail();

        $revisions = PolicyRevision::where('emr_by_state_id', $emr->id)->get();

        return view('policy-procedure.emr-by-states.view', compact('emr', 'revisions') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        abort_if(Gate::denies('Edit EMR Records'), redirect(url('/dashboard')));

        $emr = EmrByState::whereUuid($uuid)->firstOrfail();

        return view('policy-procedure.emr-by-states.edit', compact('emr') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        try {

            $emr = EmrByState::whereUuid($uuid)->firstOrfail();

            $rules = [
                'policy_name' => ['required', 'string', 'max:255'],
                'content' => ['required'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $emr->policy_name = $request->policy_name;
            $emr->content = $request->content;
            $emr->save();

            return Redirect::route('emr-records.index')->with('success', 'Record has been updated successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the emr record. ' . $e->getMessage()); // 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        abort_if(Gate::denies('Delete EMR Records'), redirect(url('/dashboard')));

        try {
            $emr = EmrByState::whereUuid($uuid)->firstOrfail();
            $emr->delete();

            return back()->with('success', 'Record has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the emr record. ' . $e->getMessage()); // $e->getMessage()
        }
    }
}
