<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Response;
use Redirect;
use Gate;

use PdfSnappy;

use App\Models\PatientDisclosureAuthorization;
use App\Models\User;

class PatientDisclosureAuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('Patient Disclosure Authorization Form'), redirect(url('/dashboard')));

        return view( 'patient-disclosure-authorization.index');
    }

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

            $query = PatientDisclosureAuthorization::select('uuid', 'patient_name');

            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            } else {
                $query = $query->where('user_id', $logged_in_user_id);
            }

            if(!empty($searchchar)) {
                $query->where(function($q) use($searchchar) {
                    return $q->orWhere('patient_name', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 1: $query->orderBy('patient_name', $orderdir); break;
                default: $query->orderBy('patient_name', $orderdir);
            }

            $total_forms = $query->count();
            $query->skip($start)->take($length);

            $can_edit = Auth::user()->can('Edit Patient Disclosure Authorization Form') ? true : false;
            $can_delete = Auth::user()->can('Delete Patient Disclosure Authorization Form') ? true : false;

            $data = $query->get();
            $data = $data->map(function($form, $key) use($isSuperAdmin, $can_edit, $can_delete) {

                $form->no = intval( $key ) + 1;

                $actions = [];

                if( $can_edit ) {
                    $actions[] = '<a href="' . route('patient.disclosure.edit', $form->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                $actions[] = '<a href="' . route('patient.disclosure.view', $form->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';
                
                $actions[] = '<a href="' . route('patient.disclosure.download', $form->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>';

                if( $isSuperAdmin && $can_delete ) {
                    $actions[] = '<a href="' . route('patient.disclosure.destroy', $form->uuid) . '" class="btn btn-xs btn-custom-danger delete-patient-disclosure-entry"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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
            return back()->with('error', 'Sorry! There was an error while fetching the data. ' . $e->getMessage()); // 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('Create Patient Disclosure Authorization Form'), redirect(url('/dashboard')));

        return view( 'patient-disclosure-authorization.create');
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

            $data = $request->except(['_token', 'submit']);

            $data['user_id'] = Auth::user()->id;
            $data['section_one_data'] = json_encode( $request->section_one_data );
            $data['authorization_start'] = date('Y-m-d', strtotime( $request->authorization_start ) );
            $data['authorization_expiry'] = date('Y-m-d', strtotime( $request->authorization_expiry ) );

            PatientDisclosureAuthorization::create( $data );

            return Redirect::route('patient.disclosure.index')->with('success', 'Form has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while saving the patient disclosure authorization form.' . $e->getMessage()); // $e->getMessage()
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
        $form = PatientDisclosureAuthorization::whereUuid($uuid)->firstOrfail();

        return view('patient-disclosure-authorization.show', compact( 'form' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        abort_if(Gate::denies('Edit Patient Disclosure Authorization Form'), redirect(url('/dashboard')));

        $form = PatientDisclosureAuthorization::whereUuid($uuid)->firstOrfail();

        return view('patient-disclosure-authorization.edit', compact( 'form' ) );
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

            $data = $request->except(['_token', 'update']);

            $data['user_id'] = Auth::user()->id;
            $data['section_one_data'] = json_encode( $request->section_one_data );
            $data['authorization_start'] = date('Y-m-d', strtotime( $request->authorization_start ) );
            $data['authorization_expiry'] = date('Y-m-d', strtotime( $request->authorization_expiry ) );

            PatientDisclosureAuthorization::whereUuid($uuid)->update( $data );

            return Redirect::route('patient.disclosure.index')->with('success', 'Record has been updated successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the form.' . $e->getMessage()); // $e->getMessage()
        }
    }

    public function download($uuid) {
        try {

            $form = PatientDisclosureAuthorization::whereUuid($uuid)->first();

            $user = User::where('id', $form->user_id)->first();

            $pdf = PdfSnappy::loadView("patient-disclosure-authorization.download", [ 'form' => $form ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $user->firstname . '_' . $user->lastname ) . '_patient_disclosure_authorization_form.pdf';

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 

        }
        catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while downloading a business associate agreement.' . $e->getMessage()); // $e->getMessage()
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
        abort_if(Gate::denies('Delete Patient Disclosure Authorization Form'), redirect(url('/dashboard')));

        try {
            $form = PatientDisclosureAuthorization::whereUuid($uuid)->firstOrfail();
            $form->delete();

            return back()->with('success', 'Record has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the record. ' . $e->getMessage()); // $e->getMessage()
        }
    }
}
