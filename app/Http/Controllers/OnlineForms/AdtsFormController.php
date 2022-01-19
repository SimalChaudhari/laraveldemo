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

use App\Models\AdtsForm;

class AdtsFormController extends Controller
{
    public function migrate_forms() {
        $forms = DB::table('accounting_of_disclosures_tracking_sheet_form_bk')->get();
        foreach( $forms as $form ) {
            $form = collect($form)->toArray();
            AdtsForm::create( $form );
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

            $query = AdtsForm::select('uuid', 'name AS name');

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

                $actions[] = '<a href="' . route('adts.edit', $form->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';

                $actions[] = '<a href="' . route('viewADTSForm', $form->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';

                $actions[] = '<a href="' . route('downloadADTSForm', $form->uuid) . '" target="blank" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>';

                if( $isSuperAdmin ) {
                    $actions[] = '<a href="' . route('deleteADTSForm', $form->uuid) . '" class="btn btn-xs btn-custom-danger delete-record"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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
		return view('online-forms.adts.create');
	}

	public function save(Request $request) {
		try {

            $rules = $this->getRules();

            $data = $request->except(['_token', 'submit']);

            $error_messages = [
                // rule => message
                'required' => 'This field is required.'
            ];

            $validator = Validator::make($data, $rules, $error_messages);
            
            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $data['user_id'] = Auth::user()->id;
            $data['dob'] = date('Y-m-d', strtotime( $request->dob ) );
            $data['first_entry'] = date('Y-m-d', strtotime( $request->first_entry ) );

            AdtsForm::create( $data );

            return Redirect::route('UI_allOnlineForms')->with('success', 'Form has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while saving the accounting_of_disclosures_tracking_sheet_form.' . $e->getMessage()); // $e->getMessage()
        }
	}

    private function getRules() {
        return [
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['required'],
            'ss' => ['required'],
            'first_entry' => ['required'],
            'data_info' => ['required'],
            'to_whome' => ['required'],
            'descri_info' => ['required'],
            'add_info' => ['required'],
            'reported_by' => ['required'],
            'sign' => ['required'],
        ];
    }

	public function view($uuid) {

        $form = AdtsForm::whereUuid($uuid)->firstOrfail();
        
		return view('online-forms.adts.view', compact( 'form' ) );
	}

    public function edit($uuid) {

        $form = AdtsForm::whereUuid($uuid)->firstOrfail();
        
        return view('online-forms.adts.edit', compact( 'form' ) );
    }

    public function update(Request $request, $uuid) {

        try {

            $rules = $this->getRules();

            $data = $request->except(['_token', 'update']);

            $error_messages = [
                // rule => message
                'required' => 'This field is required.'
            ];

            $validator = Validator::make($data, $rules, $error_messages);
            
            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $data['user_id'] = Auth::user()->id;
            $data['dob'] = date('Y-m-d', strtotime( $request->dob ) );
            $data['first_entry'] = date('Y-m-d', strtotime( $request->first_entry ) );

            AdtsForm::whereUuid($uuid)->update( $data );

            return Redirect::route('UI_allOnlineForms')->with('success', 'Record has been updated successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the accounting_of_disclosures_tracking_sheet_form.' . $e->getMessage()); // $e->getMessage()
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdtsForm  $AdtsForm
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $form = AdtsForm::whereUuid($uuid)->firstOrfail();
            $form->delete();

            return back()->with('success', 'Record has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the record. ' . $e->getMessage()); // $e->getMessage()
        }
    }

    public function download($uuid) {

        try {

            $form = AdtsForm::whereUuid($uuid)->firstOrfail();

            // dd($form);

            // return view("online-forms.adts.download", [ 'form' => $form ] );

            // return view("users.download.index", [ 'results' => $results, 'training_ack' => $training_ack, 'risk_ack' => $risk_ack ] );

            $pdf = PdfSnappy::loadView("online-forms.download-form", [ 'form' => $form, 'form_folder_name' => 'adts' ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $form->name ) . '_Accounting_Of_Disclosures_Tracking_Sheet_Form.pdf';

            /*
            // uncomment this if you want to see output directly in browser
            $type       = 'application/pdf';
            $fileName   = 'user.pdf';
            
            return Response::make($pdfContent, 200, [
                'Content-Type'        => $type,
                'Content-Disposition' => 'inline; filename="'.$fileName.'"'
            ]);
            */

            \Storage::put('/public/download-practice-form/' . $fileName, $pdfContent);/*exit;*/

            $file_path = storage_path("app/" . 'public/download-practice-form/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! something went wrong while downloading the form: ' . $e->getMessage()); // $e->getMessage()
        }
    }
}