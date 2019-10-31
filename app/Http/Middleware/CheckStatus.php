<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStatus
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
        $response =  $next($request);

        if(Auth::check() && Auth::user()->status_id == 0){

            Auth::logout();

            $request->session()->flash('alert-danger', 'Your Account is pending, It will be activated soon.');

            return redirect('/login')->with('erro_login', 'Pending Account');
        }

        if(Auth::check() && Auth::user()->status_id == 2){

            Auth::logout();

            $request->session()->flash('alert-danger', 'Your Account has been deactivated.');

            return redirect('/login')->with('erro_login', 'Deactivated Account');
        }
        return $response;

    }
}
