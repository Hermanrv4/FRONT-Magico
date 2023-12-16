<?php
namespace App\Http\Modules\Site\Services;

use App\Http\Common\Helpers\DateHelper;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class SiteService{
    public static function GetCurrencyCode(){
        if(!Session::has(config(config('env.app_group_site').'.value.session.current_currency_id'))){
            Session::put(config(config('env.app_group_site').'.value.session.current_currency_id'),ParameterService::GetParameter('default_currency_code'));
        }
        return Session::get(config(config('env.app_group_site').'.value.session.current_currency_id'));
    }
}
