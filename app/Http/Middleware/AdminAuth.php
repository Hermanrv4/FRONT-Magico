<?php

namespace App\Http\Middleware;

use App\Http\Common\Services\RouteService;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(Session::has(config('env.app_auth_admin_session_id'))){
            return $next($request);
        }else{
            return redirect(RouteService::GetAdminURL('login'));
        }
    }
}
