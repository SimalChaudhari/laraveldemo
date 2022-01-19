<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\Result;
use App\Models\Quiz;
use App\Models\DocumentLibrary;

class ResultController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     	$this->middleware('auth');
    }
    
    public function getStats() {

    	$company_admin 		= Auth::user()->company_admin;
    	$logged_in_username = Auth::user()->username;
    	$company_name		= getCurrentUserCompanyName();

        $risk_assessment_quiz = Quiz::select('id')->where('name', 'Risk Assessment Questionnaire')->first();
        $risk_assessment_quiz_id = 0;
        if( $risk_assessment_quiz !== null ) {
                $risk_assessment_quiz_id = $risk_assessment_quiz->id;
        }
        

        $risk_assessment_query = Result::select()->distinct('user_id')
                                        ->where('completed', 'Y')->where('quiz_id', $risk_assessment_quiz_id);

        $employees_trained_quiz = Quiz::select('id')->where('name', 'Training Quiz')->first();
        $employees_trained_quiz_id = 0;
        if( $employees_trained_quiz !== null ) {
                $employees_trained_quiz_id = $employees_trained_quiz->id;
        }

        $employees_trained_query = Result::select()->distinct('user_id')
                                        ->where('completed', 'Y')->where('quiz_id', $employees_trained_quiz_id);

    	if( getCurrentUserRole() === \Config::get('constants.admin')) {

    		$total_business_associate_agreements = DocumentLibrary::count();

    	} else {

            $risk_assessment_query = $risk_assessment_query->where('company_name', $company_name);

            $employees_trained_query = $employees_trained_query->where('company_name', $company_name);

    		$total_business_associate_agreements = DocumentLibrary::where('company_name', $company_name)->count();

    	}

        $total_risk_assessment_completed = $risk_assessment_query->count();
        $total_employees_trained = $employees_trained_query->count();

    	return [ $total_risk_assessment_completed, $total_employees_trained, $total_business_associate_agreements ];

    }

    public function getUserResultCount( $user_id = false ) {

    	if( !$user_id ) {
          $user_id = Auth::user()->id;
    	}

    	return Result::where('user_id', $user_id)->where('completed', 'Y')->count();
    }
}
