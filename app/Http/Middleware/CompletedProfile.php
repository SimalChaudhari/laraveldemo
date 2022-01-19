<?php

namespace App\Http\Middleware;

use Closure;

class CompletedProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $user = \Auth::user();
        if( $user === null ) {
            return redirect('/login');
        }

        $has_term_accepted = (bool) $user->term_acceptance;
        $has_profile_completed = (bool) $user->completed_profile;

        if( $has_term_accepted === false || $has_profile_completed === false ) {
            return redirect('/complete-signup');
        }

        return $response;
    }
}
