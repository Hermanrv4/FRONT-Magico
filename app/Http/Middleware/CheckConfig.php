<?php

namespace App\Http\Middleware;

use App\Http\Common\Helpers\DateHelper;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CheckConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        ParameterService::UpdateParameters();
        return $next($request);
    }
}
