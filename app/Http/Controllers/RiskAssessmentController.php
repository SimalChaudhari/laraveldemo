<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Response;
use Carbon\Carbon;

use App\Models\Result;
use App\Models\MSTAnswer;
use App\Models\Answer;

class RiskAssessmentController extends Controller
{

    public function migrate_results() {
        $results = DB::table('results_bk')->get();
        foreach( $results as $result ) {
            $result = collect($result)->toArray();
            Result::create( $result );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quiz-answers.index');
    }

    public function ajaxGetTests(Request $request) {
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

            $results = Result::select('results.*', 'quizes.name')->join('quizes', 'quizes.id', '=', 'results.quiz_id');

            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $results = $results->where('completed', 'Y');
                $isSuperAdmin = true;
            } else if( getCurrentUserRole() !== \Config::get('constants.admin')) {
                $results = $results->where('company_name', $company_name)->where('completed', 'Y');
            } else if( $company_admin === 'N' && $logged_in_username !== \Config::get('constants.admin') ) {
                $results = $results->where('user_id', Auth::user()->id)->where('completed', 'Y');
            }

            if(!empty($searchchar)) {
                $results->where(function($query) use($searchchar) {
                    return $query->orWhere('company_name', 'like', '%'.$searchchar.'%')->orWhere('mst_test.test_name', 'like', '%'.$searchchar.'%')->orWhere('firstname', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 0: $results->orderBy('firstname', $orderdir); break;
                case 1: $results->orderBy('company_name', $orderdir); break;
                case 2: $results->orderBy('datetime', $orderdir); break;
                case 3: $results->orderBy('quizes.name', $orderdir); break;
                default: $results->orderBy('datetime', $orderdir);
            }

            $total_result = $results->count();
            $results->skip($start)->take($length);

            $data = $results->get();
            $data = $data->map(function($result) use($isSuperAdmin) {

                $result->date = Carbon::parse( $result->datetime )->format( \config('app.VIEW_DATE_FORMAT') );

                $actions = [];

                $actions[] = '<a href="' . route('UI_showQuizAnswers', $result->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Answers</a>';

                if( $isSuperAdmin ) {
                    $actions[] = '<a href="' . route('post_deleteResult', $result->uuid) . '" class="btn btn-xs btn-custom-danger delete-result"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $result->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $result;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_result,
                'recordsFiltered' => $total_result
            ]);

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the agreements. ' . $e->getMessage()); // 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $result = Result::select('results.*', 'quizes.name')->join('quizes', 'quizes.id', '=', 'results.quiz_id')->whereUuid($uuid)->firstOrfail();

        if( $result === null ) {
            dd('Invalid result found.');
        }

        // dd($result->answers);

        return view('quiz-answers.view', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $result = Result::whereUuid($uuid)->firstOrfail();
            $result->delete();

            return back()->with('success', 'Record has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the test. ' . $e->getMessage());
        }
    }
}
