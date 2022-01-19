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

use App\Models\Quiz;
use App\Models\QuizQuestion;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('List Questions'), redirect(url('/dashboard')));

        $quizes = Quiz::select('id', 'name')->get();

        return view('quiz.questions.index', compact('quizes'));
    }

    public function ajaxGetQuestions(Request $request) {
        try {

            $postData = $request->all();
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $questions = QuizQuestion::select(['quiz_questions.uuid', 'quiz_questions.quiz_id', 'quiz_questions.title', 'quiz_questions.updated_at', 'quizes.name AS quiz_name', 'question_order'])
                            ->join('quizes', 'quizes.id', '=', 'quiz_questions.quiz_id');

            if(!empty($searchchar)) {
                $questions->where(function($query) use($searchchar) {
                    return $query->orWhere('title', 'like', '%'.$searchchar.'%');
                });
            }

            if( $request->quiz_id != 0 ) {
                $questions->where('quiz_id', $request->quiz_id);
            }

            switch ($ordercol) {
                case 0: $questions->orderBy('quiz_questions.question_order', $orderdir); break;
                case 1: $questions->orderBy('quiz_questions.name', $orderdir); break;
                case 2: $questions->orderBy('quizes.name', $orderdir); break;
                case 3: $questions->orderBy('quiz_questions.updated_at', $orderdir); break;
                default: $questions->orderBy('quiz_questions.updated_at', $orderdir);
            }

            $total_questions = $questions->count();
            $questions->skip($start)->take($length);

            $can_edit = Auth::user()->can('Edit Questions') ? true : false;
            $can_delete = Auth::user()->can('Delete Questions') ? true : false;

            $data = $questions->get();
            $data = $data->map(function($question) use($can_edit, $can_delete) {

                $question->last_modified = Carbon::parse( $question->updated_at )->format( \config('app.VIEW_DATE_FORMAT') );

                $actions = [];

                if( $can_edit ) {
                    $actions[] = '<a href="' . route('question.edit', $question->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                if( $can_delete ) {
                    $actions[] = '<a href="' . route('question.destroy', $question->uuid) . '" class="btn btn-xs btn-custom-danger delete-question"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $question->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $question;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_questions,
                'recordsFiltered' => $total_questions
            ]);

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the questions. ' . $e->getMessage()); // 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('Create Questions'), redirect(url('/dashboard')));

        $quizes = Quiz::orderBy('name', 'ASC')->get();

        return view('quiz.questions.create', compact('quizes'));
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
                'quiz_id' => ['required', 'string'],
                'title' => ['required'],
                'options' => ['required'],
                'right_answers' => ['required'],
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);

            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $data['user_id'] = Auth::user()->id;

            $quiz = Quiz::select('id')->whereUuid($request->quiz_id)->firstOrfail();
            $data['quiz_id'] = $quiz->id;

            $options = $request->options;

            $data['options'] = json_encode( $options );
            
            $ary_right_answers = [];
            $right_answers = explode(',', $request->right_answers);
            foreach( $options as $key => $option ) {
                if( isset( $right_answers[$key] ) && $right_answers[$key] == 'true' ) {
                    $ary_right_answers[] = $option;
                }
            }

            $data['right_answers'] = json_encode( $ary_right_answers );

            $data['todolist'] = is_null( $request->todolist ) ? '' : $request->todolist;

            QuizQuestion::create( $data );

            return Redirect::route('question.index')->with('success', 'A question has been updated successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while storing the question. ' . $e->getMessage());
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
        abort_if(Gate::denies('Edit Questions'), redirect(url('/dashboard')));

        $question = QuizQuestion::whereUuid($uuid)->firstOrfail();

        $quizes = Quiz::orderBy('name', 'ASC')->get();

        return view('quiz.questions.edit', compact('question', 'quizes'));
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
            $question = QuizQuestion::whereUuid($uuid)->firstOrfail();

            $rules = [
                'quiz_id' => ['required', 'string'],
                'title' => ['required'],
                'options' => ['required'],
                'right_answers' => ['required'],
            ];

            $data = $request->except(['_token', 'update']);

            $validator = Validator::make($data, $rules);

            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $question->user_id = Auth::user()->id;
            $question->title = $request->title;

            $question->definition = $request->definition;
            $question->impact = $request->impact;

            $quiz = Quiz::select('id')->whereUuid($request->quiz_id)->firstOrfail();
            $question->quiz_id = $quiz->id;

            $options = $request->options;

            $question->options = json_encode( $options );
            
            $ary_right_answers = [];
            $right_answers = explode(',', $request->right_answers);
            foreach( $options as $key => $option ) {
                if( ( isset( $right_answers[$key] ) && $right_answers[$key] == 'true' ) OR (is_array( $right_answers ) && !empty( $right_answers ) && in_array( $option, $right_answers ) ) ) {
                    $ary_right_answers[] = $option;
                }
            }
            $question->right_answers = json_encode( $ary_right_answers );

            $question->todolist = $request->todolist;

            $question->save();

            return Redirect::route('question.index')->with('success', 'A question has been updated successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the question. ' . $e->getMessage());
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
        abort_if(Gate::denies('Delete Questions'), redirect(url('/dashboard')));

        try {
            $question = QuizQuestion::whereUuid($uuid)->firstOrfail();
            $question->delete();

            return back()->with('success', 'A question has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the question. ' . $e->getMessage());
        }
    }

    public function setOrder(Request $request) {

        $quiz = Quiz::whereUuid( $request->quiz_uuid )->first();
        if( $quiz === null ) {
            dd('Invalid quiz.');
        }

        $questions = (array) $request->hi_questions;
        try {
            if( !empty( $questions ) ) {

                $i = 1;

                foreach( $questions as $question ) {

                    $q = QuizQuestion::whereUuid($question)->first();
                    $q->question_order = $i++;
                    $q->save();

                }

            }

            return back()->with('success', "A question order has been updated successfully for the quiz $quiz->name.");
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the question. ' . $e->getMessage());
        }

    }
}
