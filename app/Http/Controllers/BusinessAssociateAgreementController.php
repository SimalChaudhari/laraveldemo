<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Response;
use Redirect;
use Gate;

use PdfSnappy;

use App\Models\BusinessAssociateAgreement;
use App\Models\User;

class BusinessAssociateAgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('Business Associate Agreement'), redirect(url('/dashboard')));

        return view( 'business-associate-agreement.index');
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

            $query = BusinessAssociateAgreement::select('uuid', 'covered_entity', 'business_associate', 'agreement_dated_on', 'effective_date');

            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            } else {
                $query = $query->where('user_id', $logged_in_user_id);
            }

            if(!empty($searchchar)) {
                $query->where(function($q) use($searchchar) {
                    return $q->orWhere('covered_entity', 'like', '%'.$searchchar.'%')->orWhere('business_associate', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 1: $query->orderBy('covered_entity', $orderdir); break;
                case 2: $query->orderBy('business_associate', $orderdir); break;
                case 3: $query->orderBy('agreement_dated_on', $orderdir); break;
                case 4: $query->orderBy('effective_date', $orderdir); break;
                default: $query->orderBy('covered_entity', $orderdir);
            }

            $total_forms = $query->count();
            $query->skip($start)->take($length);

            $can_edit = Auth::user()->can('Edit Business Associate Agreement') ? true : false;
            $can_delete = Auth::user()->can('Delete Business Associate Agreement') ? true : false;

            $data = $query->get();
            $data = $data->map(function($form, $key) use($isSuperAdmin, $can_edit, $can_delete) {

                $form->no = intval( $key ) + 1;

                $actions = [];

                if( $can_edit ) {
                    $actions[] = '<a href="' . route('business-associate-agreement.edit', $form->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                $actions[] = '<a href="' . route('business-associate-agreement.view', $form->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';
                $actions[] = '<a href="' . route('business-associate-agreement.download', $form->uuid) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>';

                if( $isSuperAdmin && $can_delete ) {
                    $actions[] = '<a href="' . route('business-associate-agreement.destroy', $form->uuid) . '" class="btn btn-xs btn-custom-danger delete-agreements"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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
        abort_if(Gate::denies('Create Business Associate Agreement'), redirect(url('/dashboard')));

        return view( 'business-associate-agreement.create');
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
            
            $data['agreement_dated_on'] = date('Y-m-d', strtotime( $request->agreement_dated_on ) );
            $data['effective_date'] = date('Y-m-d', strtotime( $request->effective_date ) );
            $data['covered_entity_date'] = date('Y-m-d', strtotime( $request->covered_entity_date ) );
            $data['business_associate_date'] = date('Y-m-d', strtotime( $request->business_associate_date ) );

            BusinessAssociateAgreement::create( $data );

            return Redirect::route('business-associate-agreement.index')->with('success', 'Form has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while saving the business associate agreement form.' . $e->getMessage()); // $e->getMessage()
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $form = BusinessAssociateAgreement::whereUuid($uuid)->firstOrfail();

        return view('business-associate-agreement.show', compact( 'form' ) );
    }

    public function download($uuid) {
        try {

            $form = BusinessAssociateAgreement::whereUuid($uuid)->first();

            $user = User::where('id', $form->user_id)->first();

            $pdf = PdfSnappy::loadView("business-associate-agreement.download", [ 'form' => $form ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $user->firstname . '_' . $user->lastname ) . '_business_associate_agreement.pdf';

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 

        }
        catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while downloading a business associate agreement.' . $e->getMessage()); // $e->getMessage()
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        abort_if(Gate::denies('Edit Business Associate Agreement'), redirect(url('/dashboard')));

        $form = BusinessAssociateAgreement::whereUuid($uuid)->firstOrfail();

        return view('business-associate-agreement.edit', compact( 'form' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        try {

            $data = $request->except(['_token', 'update']);

            $data['user_id'] = Auth::user()->id;
            
            $data['agreement_dated_on'] = date('Y-m-d', strtotime( $request->agreement_dated_on ) );
            $data['effective_date'] = date('Y-m-d', strtotime( $request->effective_date ) );
            $data['covered_entity_date'] = date('Y-m-d', strtotime( $request->covered_entity_date ) );
            $data['business_associate_date'] = date('Y-m-d', strtotime( $request->business_associate_date ) );

            BusinessAssociateAgreement::whereUuid($uuid)->update( $data );

            return Redirect::route('business-associate-agreement.index')->with('success', 'Record has been updated successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the form.' . $e->getMessage()); // $e->getMessage()
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        abort_if(Gate::denies('Delete Business Associate Agreement'), redirect(url('/dashboard')));

        try {
            $form = BusinessAssociateAgreement::whereUuid($uuid)->firstOrfail();
            $form->delete();

            return back()->with('success', 'Record has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the record. ' . $e->getMessage()); // $e->getMessage()
        }
    }
}
