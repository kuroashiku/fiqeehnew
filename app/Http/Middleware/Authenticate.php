<?php

namespace App\Http\Middleware;

use Closure;
use App\LogActiveUser;
use App\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|string|null
     */


    public function handle($request, Closure $next){
        $logActiveUser = LogActiveUser::where('date', date('Y-m-d'))->first();
        if (!$logActiveUser) {
            LogActiveUser::create([
                'date' => date('Y-m-d'),
                'active_user' => User::where('user_type', 'student')->whereDate('expired_package_at', '>=', date('Y-m-d'))->count(),
                'inactive_user' => User::where('user_type', 'student')->whereDate('expired_package_at', '<=', date('Y-m-d'))->count()
            ]);
        }

        return $next($request);
    }
    protected function redirectTo($request){
        if ($request->expectsJson()){
            die(json_encode(['success' => 0, 'message' => 'unauthenticated']));
        }else{
            return route('login');
        }
    }
}
