<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Models\Logo;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\User;

use App\Models\AdtsForm;
use App\Models\AuthorizeDisclosure;
use App\Models\BusinessAssociation;
use App\Models\EmailForAccessToHealth;
use App\Models\EmailForHealthAmmendment;
use App\Models\EmployeeTermination;
use App\Models\MediaDestructionForm;
use App\Models\RequestToDownloadEphiForm;
use App\Models\SanctionForm;

use App\Models\DocumentLibrary;
use App\Models\QuizQuestion;

/**
 * @group Dashbord management
 *
 * APIs for managing Dashbord
 */

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        /*$questions = DB::table('questions')->get();
        foreach( $questions as $question ) {

            $data = [
                'user_id' => 1,
                'quiz_id' => 6,
                'title' => $question->question_name,
                'options' => json_encode(array_filter([
                    $question->optionA,
                    $question->optionB,
                    !empty( $question->optionC ) ? $question->optionC : '',
                    !empty( $question->optionD ) ? $question->optionD : ''
                ])),
                'right_answers' => json_encode([])
            ];

            QuizQuestion::create( $data );
        }

        $questions = DB::table('mst_question')->get();
        foreach( $questions as $question ) {

            $data = [
                'user_id' => 1,
                'quiz_id' => 7,
                'title' => $question->que_desc,
                'definition' => $question->Definition,
                'impact' => $question->Impact,
                'options' => json_encode(array_filter([
                    'Yes',
                    'No',
                    'Review'
                ])),
                'right_answers' => json_encode([]),
                'todolist' => $question->todolist
            ];

            QuizQuestion::create( $data );
        }

        


        dd('test');*/
        $training_quiz = Quiz::select('id')->where('name', 'Training Quiz')->first();

        $training_quiz_query = Result::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(datetime, "%b, %y") AS month') ])
                                    ->where('quiz_id', $training_quiz->id)
                                    ->groupBy('quiz_id', 'month')
                                    ->pluck('total', 'month');

        
        $training_data = $this->getCollectionToArray( $training_quiz_query );

        $risk_assessment_quiz = \App\Models\Quiz::select('id')->where('name', 'Risk Assessment Questionnaire')->first();

        $risk_assessment_quiz_query = Result::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(datetime, "%b, %y") AS month') ])
                                    ->where('quiz_id', $risk_assessment_quiz->id)
                                    ->groupBy('quiz_id', 'month')
                                    ->pluck('total', 'month');

        $risk_assessment_data = $this->getCollectionToArray( $risk_assessment_quiz_query );

        $quiz_data = [];
        for( $i = 1; $i <= intval( date('m') ); $i++ ) {
            // convert number to month name
            $month_year = date("M, y", mktime( 0, 0, 0, $i, 10 ) );
            $quiz_data[] = [
                'month' => $month_year,
                'training' => isset( $training_data[ $month_year ] ) ? $training_data[ $month_year ] : 0,
                'riskAssessment' => isset( $risk_assessment_data[ $month_year ] ) ? $risk_assessment_data[ $month_year ] : 0,
            ];
        }

        $quiz_data = json_encode( $quiz_data );

        $adts = AdtsForm::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(first_entry, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $adts = $this->getCollectionToArray( $adts );

        // dd($adts);

        $authorize_use_disclosure = AuthorizeDisclosure::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(insert_date, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $authorize_use_disclosure = $this->getCollectionToArray( $authorize_use_disclosure );

        $bba_vendor = BusinessAssociation::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(cur_date, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $bba_vendor = $this->getCollectionToArray( $bba_vendor );

        $email_access_to_health = EmailForAccessToHealth::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(date, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $email_access_to_health = $this->getCollectionToArray( $email_access_to_health );

        $email_health_ammendment = EmailForHealthAmmendment::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(cur_date, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $email_health_ammendment = $this->getCollectionToArray( $email_health_ammendment );

        $emp_termination = EmployeeTermination::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(formcomplte_date, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $emp_termination = $this->getCollectionToArray( $emp_termination );

        $media_destruction = MediaDestructionForm::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(sign_date, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $media_destruction = $this->getCollectionToArray( $media_destruction );

        $request_to_download = RequestToDownloadEphiForm::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(cur_date, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $request_to_download = $this->getCollectionToArray( $request_to_download );

        $sanction_reports = SanctionForm::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(vio_date, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $sanction_reports = $this->getCollectionToArray( $sanction_reports );

        $online_forms_data = [];
        for( $year = (date('Y') - 7); $year <= date('Y'); $year++ ) {
            // convert number to month name
            
            $online_forms_data[] = [
                'year' => "$year",
                'adts' => isset( $adts[ $year ] ) ? $adts[ $year ] : null,
                'authorize_use_disclosure' => isset( $authorize_use_disclosure[ $year ] ) ? $authorize_use_disclosure[ $year ] : null,
                'bba_vendor' => isset( $bba_vendor[ $year ] ) ? $bba_vendor[ $year ] : null,
                'email_access_to_health' => isset( $email_access_to_health[ $year ] ) ? $email_access_to_health[ $year ] : null,
                'email_health_ammendment' => isset( $email_health_ammendment[ $year ] ) ? $email_health_ammendment[ $year ] : null,
                'emp_termination' => isset( $emp_termination[ $year ] ) ? $emp_termination[ $year ] : null,
                'media_destruction' => isset( $media_destruction[ $year ] ) ? $media_destruction[ $year ] : null,
                'request_to_download' => isset( $request_to_download[ $year ] ) ? $request_to_download[ $year ] : null,
                'sanction_reports' => isset( $sanction_reports[ $year ] ) ? $sanction_reports[ $year ] : null
            ];
        }

        $online_forms_data = json_encode( $online_forms_data );

        

        // dd($online_forms_data);

        $agreements = DocumentLibrary::select([ DB::raw('COUNT(*) AS total'), DB::raw('DATE_FORMAT(created_at, "%Y") AS year') ])->groupBy('year')->pluck('total', 'year');
        $agreements = $this->getCollectionToArray( $agreements );

        $agreements_data = [];
        for( $year = (date('Y') - 7); $year <= date('Y'); $year++ ) {
            // convert number to month name
            
            $agreements_data[] = [
                'year' => "$year",
                'total' => isset( $agreements[ $year ] ) ? $agreements[ $year ] : 0,
            ];
        }

        $agreements_data = json_encode( $agreements_data );

        $resultController = new ResultController();
        // list($total_risk_assessment_completed, $total_employees_trained, $total_business_associate_agreements) = $resultController->getStats();

        $todo_list = collect();
        $has_user_taken_risk_assessment_test = $resultController->getUserResultCount();
        if( $has_user_taken_risk_assessment_test > 0 ) {

            // get todo list
            $todoController = new TodoController();
            $todo_list = $todoController->getUserTodo();

        }

        // $users_count = User::count();

        // dd($users_count);

        return view('dashboard.index', compact( /*'total_risk_assessment_completed', 'total_employees_trained', 'total_business_associate_agreements',*/ 'has_user_taken_risk_assessment_test', 'todo_list', 'quiz_data', /*'users_count',*/ 'online_forms_data', 'agreements_data' ));
    }

    private function getCollectionToArray( $collection ) {
        $ary_data = [];
        if( $collection->count() > 0) {
            $ary_data = $collection->toArray();
        }

        return $ary_data;
    }

    public function safeHarbor(Request $request) {
        return view( 'hipaa.safe_harbor' );
    }

    public function hipaaRules(Request $request) {
        return view( 'hipaa.hipaaRules' );
    }

    public function cybersecurity(Request $request) {
        return view('hipaa.cybersecurity');
    }
    
}
