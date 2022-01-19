<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Redirect;
use Carbon\Carbon;
use Gate;
use DB;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\TodoList;
use App\Models\EmployeeTrainingAcknowledgement;

class QuizController extends Controller
{
    public function overview($quiz_uuid) {

        $quiz = Quiz::whereUuid($quiz_uuid)->first();

        // here we need to check are there any last incompleted session found.
        $result = Result::select(['id', 'uuid', 'completed', 'quiz_id'])
                        //->where( 'sess_id', session()->getId() )
                        ->where( 'user_id', Auth::user()->id )
                        ->where( 'quiz_id', $quiz->id )
                        ->where( 'completed', 'N' )
                        ->first();

        // get last stopped question
        $last_question_id = 0;
        $start_page_query_string = '';
        if( $result !== null ) {

            // get number of per per question for quiz
            $per_page_questions = $quiz->per_page_questions;

            // total questions for quiz
            $total_questions = QuizQuestion::where('quiz_id', $result->quiz_id)->count();

            $last_quiz_answer = QuizAnswer::select('question_id')->where('result_id', $result->id)->orderBy('id', 'desc')->first();
            if( $last_quiz_answer !== null ) {
                $last_question_id = $last_quiz_answer->question_id;
                // get question order of this question
                $qq = QuizQuestion::select('question_order')->where('id', $last_question_id)->first();
                $next_question_order = $qq->question_order + 1;

                $total_pages = $total_questions / $per_page_questions;
                for( $i = 1; $i <= $total_pages; $i++) {
                    if( ( $i * $per_page_questions ) > $next_question_order ) {
                        $start_page_query_string = "?page=$i";
                        break;
                    }
                }
            }


            

        }


        return view('quiz.overview', compact('quiz', 'start_page_query_string'));
    }

    private function updateResult($quiz_id, $is_quiz_completed = 'N', $result_id = false ) {

        if( $is_quiz_completed === 'N' OR !$result_id ) {

            $result = Result::select(['id', 'uuid', 'completed'])
                        //->where( 'sess_id', session()->getId() )
                        ->where( 'user_id', Auth::user()->id )
                        ->where( 'quiz_id', $quiz_id )
                        ->where( 'completed', 'N' )
                        ->first();

            if( $result === null ) {

                $result = new Result();
                $result->user_id = Auth::user()->id;
                $result->quiz_id = $quiz_id;
                $result->sess_id = session()->getId();
                $result->completed = 'N';
                $result->datetime = Carbon::now();
                $result->company_name = getCurrentUserCompanyName();
                $result->firstname = Auth::user()->firstname;
                $result->save();

            }

        }

        if( $result_id && $is_quiz_completed === 'Y' ) {

            $result = Result::where('id', $result_id)->first();
            $result->completed = 'Y';
            $result->save();

        }

        return $result->uuid;
    }

    private function validateAnswerRequest(Request $request) {

        $rules = [
            'answer' => ['required'],
        ];

        $error_messages = [
            // rule => message
            'required' => 'Please select one of the following options to continue'
        ];

        $data = $request->except(['_token', 'next', 'page', 'qid']);

        $validator = Validator::make($data, $rules, $error_messages);

        return $validator;
    }

    private function saveAnswer(Request $request, $result_id, $quiz_id) {

        if( $request->isMethod('post') ) {

            $ary_answers = $request->answer;

            foreach( $request->que_id as $que_uuid ) {

                $question = QuizQuestion::whereUuid( $que_uuid )->first();

                if( !is_null( $question->todolist ) OR !empty( $question->todolist ) ) {
                    TodoList::create([
                        'todo_list' => $question->todolist,
                        'user_id' => Auth::user()->id,
                    ]);
                }

                $session_id = session()->getId();
                $user_id = Auth::user()->id;

                $answer = QuizAnswer::where('result_id', $result_id)->where('question_id', $question->id)->first();
                if( $answer === null ) {
                    $answer = new QuizAnswer();
                }

                $answer->result_id = $result_id;
                $answer->question_id = $question->id;
                $answer->answer = json_encode( (array) $ary_answers[ $que_uuid ] );
                $answer->user_id=$user_id;
                $answer->save();
            }

        }

    }

    public function beginQuiz(Request $request) {

        $quiz = Quiz::whereUuid($request->quiz_uuid)->firstOrfail();

        $quiz_id = intval( $quiz->id );
        
        $cur_page = isset( $request->page ) ? intval( $request->page ) : 0;

        // when any user attemp quiz and if its a starting of the quiz, then create result entry so when user ends the quiz, we can update
        $result_uuid = $this->updateResult($quiz_id, 'N');

        $result = Result::select('id', 'uuid')->whereUuid($result_uuid)->first();
        $result_id = $result->id;

        if( $request->isMethod('post') ) {

            $validator = $this->validateAnswerRequest( $request );
            if ( $validator->fails() ) {
                return back()->withError($validator->errors()->first());
            }

            $this->saveAnswer( $request, $result_id, $quiz_id );
        }

        $questions = QuizQuestion::where('quiz_id', $quiz_id);

        $questions = $questions->orderByRaw('ifnull(question_order, created_at)+0 asc')->paginate( $quiz->per_page_questions );

        if( $quiz->name === 'Risk Assessment Questionnaire' ) {
            return view('quiz.risk-assessment-quiz-start', compact('questions', 'quiz', 'result_id', 'result_uuid') );            
        }

        return view('quiz.start', compact('questions', 'quiz', 'result_id', 'result_uuid') );
    }

    public function getQuizResult(Request $request) {

        $result = Result::whereUuid($request->result_uuid)->firstOrfail();

        $quiz_id = intval( $result->quiz_id );
        $result_id = intval( $result->id );

        if( $request->isMethod('post') ) {

            $validator = $this->validateAnswerRequest( $request );

            if ( $validator->fails() ) {
                return back()->withError($validator->errors()->first());
            }

            $this->saveAnswer( $request, $result_id, $quiz_id );

        }

        $this->updateResult( $quiz_id, 'Y', $result_id );

        // $todos = QuizQuestion::where('quiz_id', $quiz_id)->whereNotNull('todolist')->get();

        $acknowledgement_url = '';
        if( $quiz_id == 6 && Auth::user()->can('Training Acknowledgement') ) {
            $acknowledgement_url = route('training.ack.index');
        }
        if( $quiz_id == 7 && Auth::user()->can('Risk Assessment Acknowledgment') ) {
            $acknowledgement_url = route('risk.ack.index');
        }

        // session()->regenerate();
        $result_uuid = $this->updateResult($quiz_id, 'N');

        return view('quiz.result', compact(/*'todos',*/ 'result', 'acknowledgement_url','result_uuid','result_id'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('Quiz Crud Module'), redirect(url('/dashboard')));

        return view('quiz.index');
    }

    public function ajaxGetQuizes(Request $request) {
        try {

            $postData = $request->all();
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $quizes = Quiz::select(['uuid', 'name', 'description', 'per_page_questions', 'show_definition', 'show_impact', 'updated_at']);

            if(!empty($searchchar)) {
                $quizes->where(function($query) use($searchchar) {
                    return $query->orWhere('name', 'like', '%'.$searchchar.'%')->orWhere('description', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 0: $quizes->orderBy('name', $orderdir); break;
                case 1: $quizes->orderBy('updated_at', $orderdir); break;
                default: $quizes->orderBy('updated_at', $orderdir);
            }

            $total_quizes = $quizes->count();
            $quizes->skip($start)->take($length);

            $can_edit = Auth::user()->can('Edit Quiz') ? true : false;
            $can_delete = Auth::user()->can('Delete Quiz') ? true : false;

            $data = $quizes->get();
            $data = $data->map(function($quiz) use($can_edit, $can_delete) {

                $quiz->show_definition = $quiz->show_definition ? 'Yes' : 'No';
                $quiz->show_impact = $quiz->show_impact ? 'Yes' : 'No';
                $quiz->last_modified = Carbon::parse( $quiz->updated_at )->format( \config('app.VIEW_DATE_FORMAT') );

                $actions = [];

                if( $can_edit ) {
                    $actions[] = '<a href="' . route('quiz.edit', $quiz->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                $actions[] = '<a href="' . route('quiz.preview', $quiz->uuid) . '" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Preview</a>';

                if( $can_delete ) {
                    $actions[] = '<a href="' . route('quiz.destroy', $quiz->uuid) . '" class="btn btn-xs btn-custom-danger delete-quiz"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $quiz->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';

                return $quiz;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_quizes,
                'recordsFiltered' => $total_quizes
            ]);

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the quiz. ' . $e->getMessage()); // 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('Create Quiz'), redirect(url('/dashboard')));

        return view('quiz.create');
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
            $rules = [
                'name' => ['required', 'string', 'max:255', 'unique:quizes,name'],
                'description' => ['required'],
                'per_page_questions' => ['nullable', 'integer'],
                'show_definition' => ['required', 'integer'],
                'show_impact' => ['required', 'integer']
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);

            // dd($validator->fails());
            
            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $data['per_page_questions'] = empty( $request->per_page_questions ) ? 1 : $request->per_page_questions;

            Quiz::create( $data );

            return Redirect::route('quiz.index')->with('success', 'A Quiz: '. $request->name . ' has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while storing the quiz. ' . $e->getMessage()); // 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        abort_if(Gate::denies('Edit Quiz'), redirect(url('/dashboard')));

        $quiz = Quiz::whereUuid($uuid)->firstOrfail();

        return view('quiz.edit', compact('quiz') );
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
            $quiz = Quiz::whereUuid($uuid)->firstOrfail();

            $rules = [
                'name' => ['required', 'string', 'max:255', Rule::unique('quizes')->ignore($quiz->id)],
                'description' => ['required'],
                'per_page_questions' => ['nullable', 'integer'],
                'show_definition' => ['required', 'integer'],
                'show_impact' => ['required', 'integer']
            ];

            $data = $request->except(['_token', 'update']);

            $validator = Validator::make($data, $rules);

            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $quiz->name = $request->name;
            $quiz->description = $request->description;
            $quiz->per_page_questions = empty( $request->per_page_questions ) ? 1 : $request->per_page_questions;
            $quiz->show_definition = $request->show_definition;
            $quiz->show_impact = $request->show_impact;

            $quiz->save();

            return Redirect::route('quiz.index')->with('success', 'A Quiz: ' . $request->name . ' has been updated successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the quiz. ' . $e->getMessage());
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
        abort_if(Gate::denies('Delete Quiz'), redirect(url('/dashboard')));

        try {
            $quiz = Quiz::whereUuid($uuid)->firstOrfail();
            $quiz->delete();

            return back()->with('success', 'A Quiz has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting a quiz. ' . $e->getMessage());
        }
    }

    public function preview($uuid)
    {
        try {

            $quiz = Quiz::whereUuid($uuid)->firstOrfail();
            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                $isSuperAdmin = true;
            }
            return view('quiz.preview', compact('quiz', 'isSuperAdmin'));

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while previewing a quiz. ' . $e->getMessage());
        }
    }


    /**
     * Upadte the quiz question if they want to edit wrong one
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function resultupdate(Request $request){
        
       
        
        $quiz_id = intval( $request->quiz_id );
        $result_id = intval( $request->result_id);

        //loop out all answers and save this quiz id entr
        
        foreach($request->question_ans as $key=>$val){
             // echo '<br>Key is '.$key;
             // echo '<br>Value is '.$val[0];
             
                $update=DB::table('quiz_answers')->where('result_id', $result_id)->where('question_id', intval($key))->update(['answer'=>json_encode( (array) $val )]);
                
        }

       
        $this->updateResult( $quiz_id, 'Y', $result_id );

        $todos = QuizQuestion::where('quiz_id', $quiz_id)->whereNotNull('todolist')->get();

        $acknowledgement_url = '';
        if( $quiz_id == 6 && Auth::user()->can('Training Acknowledgement') ) {
            $acknowledgement_url = route('training.ack.index');
        }
        if( $quiz_id == 7 && Auth::user()->can('Risk Assessment Acknowledgment') ) {
            $acknowledgement_url = route('risk.ack.index');
        }
        
        $result = Result::whereUuid($request->result_uuid)->firstOrfail();
        return redirect()->back()->with('success', 'quiz updated successfully');
     }

     public function submitAcknowledgement(Request $request, $result_uuid) {

        $result = Result::whereUuid($result_uuid)->firstOrfail();

        $data = [
            'result_id' => $result->id,
            'user_id' => Auth::user()->id,
            'printed_name' => $request->printed_name,
            'signature' => $request->signature
        ];

        EmployeeTrainingAcknowledgement::create( $data );

        return response::json([
            'success' => true
        ]);

     } 
}
