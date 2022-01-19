<?php

function get_submenu_HTML( $submenus ) {

	$html = '';

	$user = \Auth::user();

	foreach( $submenus as $route_key => $menu ) {

		if( $user->can( $menu['permission'] ) ) {

			$menu_url = isset( $menu['args'] ) ? route( $route_key, $menu['args'] ) : route( $route_key );

			$is_menu_active = ( url()->current() == $menu_url ) ? 'active' : '';

			$target = isset( $menu['target'] ) ? 'target="' . $menu['target'] . '"' : '';
			

			$html .= "<li class='{$is_menu_active}'>";
				$html .= "<a href='$menu_url' $target>";
					$html .= '<span class="fa fa-caret-right"></span> ' . $menu['title'];
				$html .= '</a>';
			$html .= '</li>';

		}

	}

	return $html;
}

function has_user_given_answer( $result_id, $question_id ) {

	$answers = [];

	// dd( $result_id . ' ' . $question_id );

	$question_ans = \App\Models\QuizAnswer::select('answer')->where('result_id', $result_id)->where('question_id', $question_id)->first();
	if( $question_ans !== null ) {
		$answers = (array) $question_ans->answer;
	}

	return $answers;
}

function sanitize_str( $string ) {
	$string = str_replace( ' ', '_', $string );
	$string = str_replace( ',', '', $string );
	$string = str_replace( '.', '', $string );

	return $string;
}

function getCurrentUserCompanyName() {

	$company_name = '';

	$company = \Auth::user()->company;
	if( $company !== null ) {
		$company_name = $company->company_name;
	}

	return $company_name;
}

function is_currentUserSuperAdmin() {
	$company_admin      = \Auth::user()->company_admin;
	$logged_in_username = \Auth::user()->username;

	$company_name = '';
	$company = \Auth::user()->company;
	if( $company !== null ) {
		$company_name = $company->company_name;
	}


}

function getCurrentUserRole() {
	return strtolower( \Auth::user()->roles->pluck('name','name')->first() );	
}

function getCompanies() {
	$companies = \App\Models\Company::select(['id', 'company_name']);

    if( getCurrentUserRole() == \Config::get('constants.admin') ) {

    } else {
        $companies = $companies->where('user_id', \Auth::user()->id);
    }

    $companies = $companies->orderBy('company_name', 'ASC')->get();

    return $companies;
}