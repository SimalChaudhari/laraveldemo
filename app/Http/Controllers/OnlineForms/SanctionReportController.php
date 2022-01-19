<?php

namespace App\Http\Controllers\OnlineForms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Redirect;
use Response;
use Illuminate\Support\Facades\Validator;
use PdfSnappy;

use App\Models\SanctionForm;

class SanctionReportController extends Controller
{

    public function migrate_forms() {
        $forms = DB::table('sanctions_form_bk')->get();
        foreach( $forms as $form ) {
            $form = collect($form)->toArray();
            SanctionForm::create( $form );
        }
    }

    public function ajax_getResults(Request $request) {

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

            $query = SanctionForm::select('uuid', 'org AS name');

            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            } else {
                $query = $query->where('user_id', $logged_in_user_id);
            }

            if(!empty($searchchar)) {
                $query->where(function($q) use($searchchar) {
                    return $q->orWhere('name', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 1: $query->orderBy('name', $orderdir); break;
                default: $query->orderBy('name', $orderdir);
            }

            $total_forms = $query->count();
            $query->skip($start)->take($length);

            $data = $query->get();
            $data = $data->map(function($form, $key) use($isSuperAdmin) {

                $form->no = intval( $key ) + 1;

                $actions = [];

                $actions[] = '<a href="' . route('sanction.edit', $form->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';

                $actions[] = '<a href="' . route('viewSanctionsForm', $form->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';

                $actions[] = '<a href="' . route('downloadSanctionsForm', $form->uuid) . '" target="blank" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>';

                if( $isSuperAdmin ) {
                    $actions[] = '<a href="' . route('deleteSanctionsFormRecord', $form->uuid) . '" class="btn btn-xs btn-custom-danger delete-record"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $form->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $form;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_forms,
                'recordsFiltered' => $total_forms
            ]);
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the forms. ' . $e->getMessage()); // 
        }
    }
    
	public function create() {
		return view('online-forms.sanction-report.create');
	}

	public function save(Request $request) {
		try {

            $data = $request->except( ['_token', 'submit'] );

            $rules = $this->getRules();

            $error_messages = [
                // rule => message
                'required' => 'This field is required.'
            ];

            $validator = Validator::make($data, $rules, $error_messages);

            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $data['user_id']    = Auth::user()->id;
            $data['rep_date']   = date('Y-m-d', strtotime( $request->rep_date ) );
            $data['vio_date']   = date('Y-m-d', strtotime( $request->vio_date ) );
            
            SanctionForm::create( $data );

            return Redirect::route('UI_allOnlineForms')->with('success', 'Form has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while saving the sanctions_form.' . $e->getMessage()); // $e->getMessage()
        }
	}

	public function view($uuid) {

        $form = SanctionForm::whereUuid($uuid)->firstOrfail();

        return view('online-forms.sanction-report.view', compact( 'form' ) );
	}

    public function edit($uuid) {

        $form = SanctionForm::whereUuid($uuid)->firstOrfail();
        
        return view('online-forms.sanction-report.edit', compact( 'form' ) );
    }

    private function getRules() {
        return [
            'rep_date' => ['required'],
            'vio_date' => ['required'],
            'org' => ['required'],
            'job' => ['required'],
            'method' => ['required'],
            'descr' => ['required'],
            'grp1' => ['required'],
            'grp2' => ['required'],
            'grp3' => ['required'],
            'sanct' => ['required'],
            'add_info' => ['required'],
            'type_of' => ['required'],
            'field1' => ['required'],
            'field2' => ['required'],
            'breach' => ['required'],
            'deter' => ['required'],
            'involve' => ['required'],
            'offence' => ['required'],
            'train' => ['required'],
            'comments' => ['required'],
            'report' => ['required'],
        ];
    }

    public function update(Request $request, $uuid) {

        try {

            $data = $request->except( ['_token', 'update'] );

            $rules = $this->getRules();

            $error_messages = [
                // rule => message
                'required' => 'This field is required.'
            ];

            $validator = Validator::make($data, $rules, $error_messages);

            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $data['user_id']    = Auth::user()->id;
            $data['rep_date']   = date('Y-m-d', strtotime( $request->rep_date ) );
            $data['vio_date']   = date('Y-m-d', strtotime( $request->vio_date ) );

            SanctionForm::whereUuid($uuid)->update( $data );

            return Redirect::route('UI_allOnlineForms')->with('success', 'Record has been updated successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the sanctions_form.' . $e->getMessage()); // $e->getMessage()
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SanctionForm
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $form = SanctionForm::whereUuid($uuid)->firstOrfail();
            $form->delete();

            return back()->with('success', 'Record has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the record. ' . $e->getMessage()); // $e->getMessage()
        }
    }

    public function download($uuid) {

        try {

            $form = SanctionForm::whereUuid($uuid)->firstOrfail();

            $pdf = PdfSnappy::loadView("online-forms.download-form", [ 'form' => $form, 'form_folder_name' => 'sanction-report' ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $form->org ) . '_Sanction_Report_Form.pdf';

            \Storage::put('/public/download-practice-form/' . $fileName, $pdfContent);/*exit;*/

            $file_path = storage_path("app/" . 'public/download-practice-form/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! something went wrong while downloading the form: ' . $e->getMessage()); // $e->getMessage()
        }
    }
}