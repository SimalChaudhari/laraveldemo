<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;

use App\Models\PolicyRevisionState;

class PolicyRevisionStateController extends Controller
{
	public function store(Request $request) {
		try {
			$rules = [
                'upload_id'		=> ['required', 'integer'],
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

            $data['user_id'] 		= Auth::user()->id;
            $data['comp_date'] 		= date('Y-m-d', strtotime( $request->comp_date ) );
            $data['revision_date'] 	= date('Y-m-d', strtotime( $request->revision_date ) );
            $data['created_at'] 	= Carbon::now();

            PolicyRevisionState::create( $data );

            return back()->with('success', 'Revision has been created successfully.');
		}
		catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while creating a revision.' . $e->getMessage()); // $e->getMessage()
        }
	}
}