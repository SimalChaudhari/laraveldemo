<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;
use DB;
use Response;
use Gate;

use App\Models\PolicyRevision;
use App\Models\PolicyProcedure;
use App\Models\EmrByState;

class PolicyRevisionController extends Controller
{

    public function migrate_revisions() {
        $revisions = DB::table('policy_revisions_bk')->get();
        foreach( $revisions as $revision ) {
            $revision = collect($revision)->toArray();
            PolicyRevision::create( $revision );
        }
    }

    public function index() {

        abort_if(Gate::denies('List Policy Revisions'), redirect(url('/dashboard')));

        return view( 'policy-revision.index' );
    }

    public function ajaxGetPolicyRevisions(Request $request) {

        try {

            $postData = $request->all();
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $revisions = PolicyRevision::select('uuid', 'policie_name AS policy_name', 'comp_ofc', 'comp_date', 'revision_date', 'revision', 'revision_by', 'policy_procedure_id', 'emr_by_state_id');

            if(!empty($searchchar)) {
                // @see https://pineco.de/search-eloquent-relationships/
                /*$revisions->whereHas('policy', function($query) {
                    $query->where('policy_name', 'like', '%'.$searchchar.'%');
                });*/
                $revisions->where(function($query) use($searchchar) {
                    return $query->orWhere('revision', 'like', '%'.$searchchar.'%')->orWhere('revision_by', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 0: $revisions->orderBy('policy_name', $orderdir); break;
                case 1: $revisions->orderBy('revision_by', $orderdir); break;
                case 2: $revisions->orderBy('revision_date', $orderdir); break;
                default: $revisions->orderBy('revision_date', $orderdir);
            }

            $total_revisions = $revisions->count();
            $revisions->skip($start)->take($length);

            $data = $revisions->get();
            $data = $data->map(function($revision, $key) {

                $policy_name = '';
                if( !is_null( $revision->policy_procedure_id ) OR intval( $revision->policy_procedure_id ) > 0 ) {
                    $policy_name = $revision->policy->policy_name . ' <span class="badge btn-custom-success">Policy</span>';
                }

                if( !is_null( $revision->emr_by_state_id ) OR intval( $revision->emr_by_state_id ) > 0 ) {
                    $policy_name = $revision->emr->policy_name . ' <span class="badge btn-custom-primary">EMR</span>';
                }

                $revision->policy_name = $policy_name;

                $revision->revision_date = Carbon::parse( $revision->revision_date )->format( \config('app.VIEW_DATE_FORMAT') );

                $actions = [];
                
                $actions[] = '<a href="' . route('policy-revision.view', $revision->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';

                $actions[] = '<a href="' . route('policy-revision.destroy', $revision->uuid) . '" class="btn btn-xs btn-custom-danger delete-revision"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';

                $revision->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $revision;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_revisions,
                'recordsFiltered' => $total_revisions
            ]);

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the revisions. ' . $e->getMessage()); // 
        }
    }

	public function store(Request $request) {

        abort_if(Gate::denies('Create Policy Revisions'), redirect(url('/dashboard')));

		try {
			$rules = [
                'parent_id'		=> ['required'],
                'comp_ofc' 		=> ['required', 'string', 'max:255'],
                'comp_date' 	=> ['required'],
                'revision_date' => ['required'],
                'revision' 		=> ['required', 'string', 'max:255'],
                'revision_by' 	=> ['required', 'string', 'max:255'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $revision = new PolicyRevision();
            $revision->user_id = Auth::user()->id;
            $revision->policie_name = '';
            $revision->comp_ofc = $request->comp_ofc;
            $revision->comp_date = date('Y-m-d', strtotime( $request->comp_date ) );
            $revision->revision_date = date('Y-m-d', strtotime( $request->revision_date ) );
            $revision->revision = $request->revision;
            $revision->revision_by = $request->revision_by;
            $revision->created_at = Carbon::now();

            $type = $request->type;
            if( $type === 'policy_procedure' ) {

                $policy = PolicyProcedure::select('id')->whereUuid(request('parent_id', 0))->firstOrfail();
                $revision->policy_procedure_id = $policy->id;

            } elseif( $type === 'emr_by_state' ) {

                $emr_by_state = EmrByState::select('id')->whereUuid(request('parent_id', 0))->firstOrfail();
                $revision->emr_by_state_id = $emr_by_state->id;

            }

            $revision->save();

            return back()->with('success', 'Revision has been created successfully.');
		}
		catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while creating a revision.' . $e->getMessage()); // $e->getMessage()
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
        $revision = PolicyRevision::whereUuid($uuid)->firstOrfail();

        return view('policy-revision.view', compact('revision') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($revision_uuid)
    {
        abort_if(Gate::denies('Delete Policy Revisions'), redirect(url('/dashboard')));

        try {
            $revision = PolicyRevision::whereUuid($revision_uuid)->firstOrfail();
            $revision->delete();

            return back()->with('success', 'Policy revision has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the revision. ' . $e->getMessage()); // $e->getMessage()
        }
    }
}