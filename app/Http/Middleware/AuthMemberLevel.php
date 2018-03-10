<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AuthMemberLevel
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
		if(Auth::check())
		{
			if(Auth::user()->level == 'Admin' || Auth::user()->level == 'Member')
			{
				return $next($request);
			}
        }
		return redirect()->route('login')->with([
			'alert_type' => 'alert-danger',
			'alert_title' => 'Warning!',
			'alert_messages' => 'You don\'t have authority to access the page. (Code: U01)',
		]);
    }
}
