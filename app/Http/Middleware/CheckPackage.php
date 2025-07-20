<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPackage
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

        if ($user && $user->user_type == 'student') {
            if (!empty($user->expired_package_at) && $user->expired_package_at >= date('Y-m-d')) {
                return $next($request);
            } else {
                $request->session()->put('user', $user->id);
                return redirect(route('payment_detail'));
            }
        } elseif ($user && $user->user_type == 'afiliasi') {
            return redirect(route('afiliasi'));
        }

        return $next($request);
    }
}
