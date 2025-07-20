<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class CheckToken
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
        $user = Auth::user();

        if ($user) {
            if ($user->user_type == 'student') {
                $token = User::where('id', $user->id)->first()->session_id;
                if ($request->session()->get('token') == $token) {
                    return $next($request);
                } else {
                    Auth::logout();
                    return redirect(route('login'));
                }
            } else {
                return $next($request);
            }
        }

        return $next($request);
    }
}
