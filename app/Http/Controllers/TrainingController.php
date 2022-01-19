<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Auth;

use App\Models\Question;
use App\Models\MSTQuestion;
use App\Models\Answer;
use App\Models\MSTAnswer;
use App\Models\Result;
use App\Models\TodoList;
use App\Models\MstTest;

class TrainingController extends Controller
{

    public function migrate_mst_tests() {
        $tests = DB::table('mst_test_bk')->get();
        foreach( $tests as $test ) {
            $test = collect($test)->toArray();
            MstTest::create( $test );
        }
    }

    public function welcome() {
        return view('training.welcome');
    }

    public function trainingVideoWatched(Request $request) {
        Auth::user()->has_video_watched = 1;
        Auth::user()->save();
    }

    public function AnnualRiskAssessmentWelcome() {
        return view('annual-risk-assessment.welcome');
    }

    public function hipaaTraining() {
        return view('training.hipaa');
    }

    public function quizOverviewPage($quiz_id) {

        $quizes = MstTest::select(['uuid', 's.sub_id', 'test_name AS title'])
                        ->join('mst_subject as s', 's.sub_id', '=', 'mst_test.sub_id')
                        ->where('s.quiz_id', $quiz_id)->get();

        return view('training.quiz.overview', compact('quizes'));
    }

    public function riskAssessmentQuizOverviewPage( $quiz_id ) {

        $quizes = MstTest::select(['uuid', 's.sub_id', 'test_name AS title'])
                        ->join('mst_subject as s', 's.sub_id', '=', 'mst_test.sub_id')
                        ->where('s.quiz_id', $quiz_id)->get();

        return view('training.quiz.risk-assessment.overview', compact('quizes'));   
    }

    private function validateAnswerRequest(Request $request) {

        $rules = [
            'quiz' => ['required'],
        ];

        $error_messages = [
            // rule => message
            'required' => 'Please select one of the following options to continue'
        ];

        $data = $request->except(['_token', 'next', 'page', 'qid']);

        $validator = Validator::make($data, $rules, $error_messages);

        return $validator;
    }

    public function startRiskAssessmentQuiz(Request $request) {

        $quiz = MstTest::whereUuid($request->test_id)->firstOrfail();

        $test_id = intval( $quiz->test_id );

        // when any user attemp quiz and if its a starting of the quiz, then create result entry so when user ends the quiz, we can update
        $cur_page = isset( $request->page ) ? intval( $request->page ) : 0;
        if( in_array( $test_id, [13, 14] ) && $cur_page < 1 ) {

            $this->updateResult($test_id, 'N');
        }

        if( $request->isMethod('post') ) {

            $validator = $this->validateAnswerRequest( $request );
            if ( $validator->fails() ) {
                return back()->withError($validator->errors()->first());
            }

            $this->saveRiskAssessmentQuizAnswer( $request, $test_id );

        }

        $questions = collect();
        $answer = '';

        if( $test_id === 13 ) {

            $administrator = Auth::user()->administrator;

            if( $administrator === 'IT Tech' ) {
                $questions = MSTQuestion::where('test_id', $test_id)->where('user_type', $administrator);
            } else if( $administrator === 'Security Official' ) {
                $questions = MSTQuestion::where('test_id', $test_id)->where('user_type', $administrator);
            } else if( $administrator === 'Superadmin' ) {
                $questions = MSTQuestion::where('test_id', $test_id);
            }

            $questions = $questions->paginate(1);

            $question = $questions->items()[0];

            $answer = MSTAnswer::select('your_ans')->where('test_id', $test_id)->where('user_id', Auth::user()->id)->where('sess_id', session()->getId())->where('que_des', $question->que_desc)->where('question_number', $question->question_number)->first();
            if( $answer !== null ) {
                $answer = strtolower( $answer->your_ans );
            }

        }

        return view('training.quiz.risk-assessment.question', compact('questions', 'quiz', 'answer') );
    }

    public function startQuiz(Request $request) {

        $quiz = MstTest::whereUuid($request->test_id)->firstOrfail();

        $test_id = intval( $quiz->test_id );

        // when any user attemp quiz and if its a starting of the quiz, then create result entry so when user ends the quiz, we can update
        $cur_page = isset( $request->page ) ? intval( $request->page ) : 0;
        if( in_array( $test_id, [13, 14] ) && $cur_page < 1 ) {

            $this->updateResult($test_id, 'N');
        }

        if( $request->isMethod('post') ) {

            $validator = $this->validateAnswerRequest( $request );
            if ( $validator->fails() ) {
                return back()->withError($validator->errors()->first());
            }

            $this->saveAnswer( $request, $test_id );

        }

        $questions = collect();

        if( $test_id === 14 ) {
            $questions = Question::where('test_id', $test_id)->orderBy('id', 'ASC')->paginate(1);
            $question = $questions->items()[0];

            $answer = Answer::select('your_ans')->where('test_id', $test_id)->where('user_id', Auth::user()->id)->where('sess_id', session()->getId())->where('question_name', $question->question_name)->first();
            if( $answer === null ) {
                $answer = '';
            } else {
                $answer = strtolower( $answer->your_ans );
            }

            return view('training.quiz.question', compact('questions', 'quiz', 'answer') );
        }
        
    }

    private function updateResult($test_id, $is_quiz_completed = 'N') {

        $result = null;

        if( $is_quiz_completed === 'Y') {
            $result = Result::where('sess_id', session()->getId())
                                ->where('user_id', Auth::user()->id)
                                ->where('test_id', $test_id)
                                ->where('completed', 'N')
                                ->orderBy('id', 'desc')->first();
        } else {

            // completed status is NO so check is entry exist with the given session-id
            $result = Result::where('sess_id', session()->getId())
                                ->where('user_id', Auth::user()->id)
                                ->where('test_id', $test_id)
                                ->where('completed', 'N')
                                ->orderBy('id', 'desc')->first();

            if( $result !== null ) {
                return $result;
            }

        }

        if( $result === null ) {
            $result = new Result();
        }

        $result->user_id = Auth::user()->id;
        $result->test_id = $test_id;
        $result->sess_id = session()->getId();
        $result->datetime = Carbon::now();
        $result->completed = $is_quiz_completed;
        $result->company_name = getCurrentUserCompanyName();
        $result->firstname = Auth::user()->firstname;
        $result->save();

        return $result;

    }

    private function saveRiskAssessmentQuizAnswer( Request $request, $test_id ) {
        if( $request->isMethod('post') ) {

            $question = MSTQuestion::where('que_id', $request->qid )->first();

            if( $request->quiz === 'no' ) {

                if( !is_null( $question->todolist ) OR !empty( $question->todolist ) ) {
                    TodoList::create([
                        'todo_list' => $question->todolist,
                        'user_id' => Auth::user()->id,
                    ]);                    
                }

            }

            $session_id = session()->getId();
            $user_id = Auth::user()->id;

            $answer = MSTAnswer::where('test_id', $test_id)->where('user_id', $user_id)->where('sess_id', $session_id)->where('que_des', $question->que_desc)->where('question_number', $question->question_number)->first();
            if( $answer === null ) {
                $answer = new MSTAnswer();
            }

            // dd($answer);

            $answer->test_id = $test_id;
            $answer->user_id = $user_id;
            $answer->sess_id = $session_id;
            $answer->que_des = $question->que_desc;
            $answer->question_number = $question->question_number;
            $answer->reason = '';
            $answer->your_ans = $request->quiz;
            $answer->todolist = $question->todolist;
            $answer->datetime = Carbon::now();
            $answer->rand = '';

            $answer->save();

        }
    }

    private function saveAnswer(Request $request, $test_id) {

        if( $request->isMethod('post') ) {

            $question = Question::findOrFail( $request->qid );

            $session_id = session()->getId();
            $user_id = Auth::user()->id;

            $answer = Answer::where('test_id', $test_id)->where('user_id', $user_id)->where('sess_id', $session_id)->where('question_name', $question->question_name)->first();
            if( $answer === null ) {
                $answer = new Answer();
            }

            $answer->test_id = $test_id;
            $answer->user_id = $user_id;
            $answer->sess_id = $session_id;
            $answer->question_name = $question->question_name;
            $answer->your_ans = $request->quiz;
            $answer->datetime = Carbon::now();

            $answer->save();
        }

    }

    public function getQuizResult(Request $request) {

        $quiz = MstTest::whereUuid($request->test_id)->firstOrfail();

        $test_id = intval( $quiz->test_id );
        $sess_id = $request->sess_id;

        if( $request->isMethod('post') ) {

            $validator = $this->validateAnswerRequest( $request );

            if ( $validator->fails() ) {
                return back()->withError($validator->errors()->first());
            }

            $this->saveAnswer( $request, $test_id );
        }

        $this->updateResult( $test_id, 'Y' );

        $todos = DB::table('mst_useranswer')
                    ->where('test_id', $test_id)
                    ->where('user_id', Auth::user()->id)
                    ->groupBy('todolist')
                    ->get();

        $answers = Answer::where('sess_id', $sess_id)->where('user_id', Auth::user()->id)->where('test_id', $test_id)->get();

        session()->regenerate();

        return view('training.quiz.result', compact('todos', 'answers'));

    }

    public function getRiskAssessmentQuizResult(Request $request) {

        $quiz = MstTest::whereUuid($request->test_id)->firstOrfail();

        $test_id = intval( $quiz->test_id );
        $sess_id = $request->sess_id;

        if( $request->isMethod('post') ) {

            $validator = $this->validateAnswerRequest( $request );

            if ( $validator->fails() ) {
                return back()->withError($validator->errors()->first());
            }

            $this->saveRiskAssessmentQuizAnswer( $request, $test_id );

        }

        $this->updateResult( $test_id, 'Y' );

        $todos = DB::table('mst_useranswer')
                    ->where('test_id', $test_id)
                    ->where('user_id', Auth::user()->id)
                    ->groupBy('todolist')
                    ->get();

        $answers = MSTAnswer::where('sess_id', $sess_id)->where('user_id', Auth::user()->id)->where('test_id', $test_id)->get();

        session()->regenerate();

        return view('training.quiz.risk-assessment.result', compact('todos', 'answers'));

    }
}
