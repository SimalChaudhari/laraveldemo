<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;
use DB;
use Response;

use PdfSnappy;

use App\Models\RiskAssignmentAcknowledge;
use App\Models\User;

class RiskAssignmentAcknowledgeController extends Controller
{
    public function index() {

        $acknowledgements = RiskAssignmentAcknowledge::all();

        return view( 'risk-assignment-acknowledge.index', compact( 'acknowledgements' ) );
    }

    public function ajaxGetAcknowledgements(Request $request) {

        try {

            $postData = $request->all();
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $company_admin      = Auth::user()->company_admin;
            $logged_in_username = Auth::user()->username;
            $company_name       = getCurrentUserCompanyName();

            $acknowledgements = RiskAssignmentAcknowledge::select(['id', 'uuid', 'compliance_officer', 'compliance_date', 'acknowledgement_date', 'acknowledgement_by']);

            if(!empty($searchchar)) {
                $acknowledgements->where(function($query) use($searchchar) {
                    return $query->orWhere('acknowledgement_by', 'like', '%'.$searchchar.'%')->orWhere('compliance_officer', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 0: $acknowledgements->orderBy('id', $orderdir); break;
                case 1: $acknowledgements->orderBy('compliance_officer', $orderdir); break;
                case 2: $acknowledgements->orderBy('compliance_date', $orderdir); break;
                case 3: $acknowledgements->orderBy('acknowledgement_by', $orderdir); break;
                case 4: $acknowledgements->orderBy('acknowledgement_date', $orderdir); break;
                default: $acknowledgements->orderBy('id', $orderdir);
            }

            $total = $acknowledgements->count();
            $acknowledgements->skip($start)->take($length);

            $data = $acknowledgements->get();
            $data = $data->map(function($acknowledgement, $key) {

                $acknowledgement->no = intval( $key ) + 1;

                $actions = [];

                $actions[] = '<a href="' . route('risk.ack.download', $acknowledgement->id) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>';

                /*if( $can_delete ) {
                    $actions[] = '<a href="' . route('users.destroy', $user->uuid) . '" class="btn btn-xs btn-custom-danger delete-user"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }*/

                $acknowledgement->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                
                return $acknowledgement;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ]);
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the user list. ' . $e->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $rules = [
                'compliance_officer'    => ['required', 'string', 'max:255'],
                'compliance_date'       => ['required'],
                'acknowledgement_date'  => ['required'],
                'acknowledgement_text'  => ['required', 'string', 'max:255'],
                'acknowledgement_by'    => ['required', 'string', 'max:255'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $acknowledge = new RiskAssignmentAcknowledge();
            $acknowledge->user_id = Auth::user()->id;
            $acknowledge->compliance_officer = $request->compliance_officer;
            $acknowledge->compliance_date = date('Y-m-d', strtotime( $request->compliance_date ) );
            $acknowledge->acknowledgement_date = date('Y-m-d', strtotime( $request->acknowledgement_date ) );
            $acknowledge->acknowledgement_text = $request->acknowledgement_text;
            $acknowledge->acknowledgement_by = $request->acknowledgement_by;
            $acknowledge->created_at = Carbon::now();

            $acknowledge->save();

            return back()->with('success', 'A Risk assessment acknowledgement has been created successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while creating a risk assessment acknowledgement.' . $e->getMessage()); // $e->getMessage()
        }
    }

    public function download($ack_id) {
        try {

            $ack = RiskAssignmentAcknowledge::where('id', $ack_id)->first();

            $user = User::where('id', $ack->user_id)->first();

            $pdf = PdfSnappy::loadView("risk-assignment-acknowledge.download", [ 'ack' => $ack ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $user->firstname . '_' . $user->lastname ) . '_acknowledgement.pdf';

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 

        }
        catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while downloading a risk assessment acknowledgement.' . $e->getMessage()); // $e->getMessage()
        }
    }

}
