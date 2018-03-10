<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AuthAdminLevel
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
			if(Auth::user()->level == 'Admin')
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
