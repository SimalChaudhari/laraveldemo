<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;
use DB;
use Response;

use PdfSnappy;

use App\Models\TrainingAcknowledge;
use App\Models\User;

class TrainingAcknowledgeController extends Controller
{
    public function index() {
        return view( 'training-acknowledgment.index' );
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

            $acknowledgements = TrainingAcknowledge::select(['training_acknowledment.id', 'training_acknowledment.uuid', 'training_acknowledment.compliance_officer', 'training_acknowledment.compliance_date', 'training_acknowledment.acknowledgement_date', 'training_acknowledment.acknowledgement_by'])
                            ->leftJoin('users', 'users.id', 'training_acknowledment.user_id');

            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            } else {
                $acknowledgements->where('training_acknowledment.user_id', Auth::user()->id);
            }
            if(!empty($searchchar)) {
                $acknowledgements->where(function($query) use($searchchar) {
                    return $query->orWhere('training_acknowledment.acknowledgement_by', 'like', '%'.$searchchar.'%')->orWhere('training_acknowledment.compliance_officer', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 0: $acknowledgements->orderBy('training_acknowledment.id', $orderdir); break;
                case 1: $acknowledgements->orderBy('training_acknowledment.compliance_officer', $orderdir); break;
                case 2: $acknowledgements->orderBy('training_acknowledment.compliance_date', $orderdir); break;
                case 3: $acknowledgements->orderBy('training_acknowledment.acknowledgement_by', $orderdir); break;
                case 4: $acknowledgements->orderBy('training_acknowledment.acknowledgement_date', $orderdir); break;
                default: $acknowledgements->orderBy('training_acknowledment.id', $orderdir);
            }

            $total = $acknowledgements->count();
            $acknowledgements->skip($start)->take($length);

            $data = $acknowledgements->get();
            $data = $data->map(function($acknowledgement, $key) {

                $acknowledgement->no = intval( $key ) + 1;

                $actions = [];

                $actions[] = '<a href="' . route('training.ack.download', $acknowledgement->id) . '" class="btn btn-xs btn-custom-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>';

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
                // 'acknowledgement_text'  => ['required', 'string', 'max:255'],
                'acknowledgement_by'    => ['required', 'string', 'max:255'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withErrors($validator);
            }

            $acknowledge = new TrainingAcknowledge();
            $acknowledge->user_id = Auth::user()->id;
            $acknowledge->compliance_officer = $request->compliance_officer;
            $acknowledge->compliance_date = date('Y-m-d', strtotime( $request->compliance_date ) );
            $acknowledge->acknowledgement_date = date('Y-m-d', strtotime( $request->acknowledgement_date ) );
            // $acknowledge->acknowledgement_text = $request->acknowledgement_text;
            $acknowledge->acknowledgement_by = $request->acknowledgement_by;
            $acknowledge->created_at = Carbon::now();

            $acknowledge->save();

            return back()->with('success', 'A Training acknowledgement has been created successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while creating a training acknowledgement.' . $e->getMessage()); // $e->getMessage()
        }
    }

    public function download($ack_id) {
        try {

            $ack = TrainingAcknowledge::where('id', $ack_id)->first();

            $user = User::where('id', $ack->user_id)->first();

            $pdf = PdfSnappy::loadView("training-acknowledgment.download", [ 'ack' => $ack ] );
            $pdfContent = $pdf->inline();

            $fileName   = sanitize_str( $user->firstname . '_' . $user->lastname ) . '_acknowledgement.pdf';

            \Storage::put('/public/download-quiz-data/' . $fileName, $pdfContent);

            $file_path = storage_path("app/" . 'public/download-quiz-data/' . $fileName);

            return response()->download($file_path)->deleteFileAfterSend(true); 

        }
        catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while downloading a training acknowledgement.' . $e->getMessage()); // $e->getMessage()
        }
    }

}
