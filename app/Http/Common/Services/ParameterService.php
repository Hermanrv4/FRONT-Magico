<?php


namespace App\Http\Common\Services;


use App\Http\Common\Helpers\DateHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ParameterService
{
    public static function UpdateParameters($force=false){
        $update_config = false;
        if(Cache::has(config('env.app_config_site_cache_id'))){
            if(!isset(Cache::get(config('env.app_config_site_cache_id'))["last_update"])){
                $update_config = true;
            }else {
                $last_update = Cache::get(config('env.app_config_site_cache_id'))["last_update"];
                $last_update = DateHelper::GetDateInFormat($last_update);
                $apiResponse = ApiService::Request(config('env.app_group_site'), 'configuration', 'need-update', array("date" => $last_update));
                $update_config = $apiResponse->response["need_update"];
            }
        }else{$update_config = true;}
        if($update_config||$force){
            $apiResponse = ApiService::Request(config('env.app_group_site'),'configuration','get');
            Cache::put(config('env.app_config_site_cache_id'),$apiResponse->response,config('env.app_cache_retention_time'));
        }
        Session::put(config('env.app_open_page_session_id'),true);
    }
    public static function GetParameter($code){
        if(!Cache::has(config('env.app_config_site_cache_id'))){
            ParameterService::UpdateParameters();
        }
        $params = Cache::get(config('env.app_config_site_cache_id'),true)["parameters"];

        for($i=0;$i<count($params);$i++){
            if($params[$i]["code"]==$code){
                if($params[$i]["value_localized"]==null) return $params[$i]["value"];
                return $params[$i]["value_localized"];
            }
        }
        return null;
    }
}
