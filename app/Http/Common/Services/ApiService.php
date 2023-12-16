<?php
namespace App\Http\Common\Services;
use App\Http\Common\Helpers\StringHelper;
use App\Http\Common\Responses\ApiResponse;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ApiService{
    public static function Request($app_group,$ws_group,$ws_name,$parameters=null){
        try {
            $token = null;
            if (session()->has(config('env.app_auth_'.$app_group.'_session_id'))) {
                $token = session()->get(config('env.app_auth_'.$app_group.'_session_id'));
                $token = $token["token"];
            }
            $method = strtolower(config($app_group . '.ws.service.' . $ws_group . '.' . $ws_name . '.method'));

            $url = config('env.app_service_url')
                . "/" . LaravelLocalization::getCurrentLocale()
                . "/" . config('env.app_commerce_id')
                . "/" . $app_group
                . "/" . config($app_group . '.ws.service.' . $ws_group . '.group')
                . "/" . config($app_group . '.ws.service.' . $ws_group . '.' . $ws_name . '.url');

            if ($token == null) {
                $headers = ['Content-Type' => 'application/json'];
                } else {
                $headers = ['Content-Type' => 'application/json', 'Authorization' => 'Bearer '.$token];
            }
            /************************************************************************************************************/
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($process, CURLOPT_VERBOSE, true);
            curl_setopt($process, CURLOPT_HEADER, false);
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($process, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
            if(strtoupper($method) == "POST"){
                if($parameters!=null) curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($process, CURLOPT_POST, 1);
            }
            $response = curl_exec($process);
            curl_close($process);
            /************************************************************************************************************/
            try{
                return ApiResponse::ParseResponse($response);
            }catch(\Exception $e){
                //dd($response);
            }
        }catch (\Exception $ex){
            return dd($ex);
        }
    }
    public static function GetApiAjaxCall($app_group,$ws_group,$ws_name){
        $token = null;
        if (session()->has(config('env.app_auth_' . $app_group . '_session_id'))) {
            $token = session()->get(config('env.app_auth_' . $app_group . '_session_id'));
            $token = $token["token"];
        }
        $method = strtoupper(config($app_group . '.ws.service.' . $ws_group . '.' . $ws_name . '.method'));

        $url = "url: '" .
            config('env.app_service_url')
            . "/" . LaravelLocalization::getCurrentLocale()
            . "/" . config('env.app_commerce_id')
            . "/" . $app_group
            . "/" . config($app_group . '.ws.service.' . $ws_group . '.group')
            . "/" . config($app_group . '.ws.service.' . $ws_group . '.' . $ws_name . '.url')
            . "'";
        $headers = "headers: {}";
        if ($token != null) $headers = "headers: {'Authorization': 'Bearer " . $token . "'}";
        $method = "type: '" . $method . "'";
        $dataType = "dataType: 'JSON'";

        return $url . "\n," . $headers . "\n," . $method . "\n," . $dataType;
    }
    public static function GetInternalAjaxCall($app_group,$route,$parameters=array()){
        if($app_group==config('env.app_group_site')){
            $url = "url: '".RouteService::GetSiteURL($route,$parameters)."'";
            $method = "type: '".RouteService::GetSiteURLMethod($route)."'";
        }else if($app_group==config('env.app_group_admin')){
            $url = "url: '".RouteService::GetAdminURL($route,$parameters)."'";
            $method = "type: '".RouteService::GetAdminURLMethod($route)."'";
        }
        $headers = "headers: { 'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content') }";
        $dataType = "dataType: 'JSON'";
        return $url."\n,".$headers."\n,".$method."\n,".$dataType;
    }
    public function SendSuccessResponse($message=null,$response=null){
        return (new ApiResponse())->SendResponse(true,$message,$response);
    }
    public function SendErrorResponse($message=null,$response=null,$locale=null){
        return (new ApiResponse())->SendResponse(false,$message,$response);
    }
}
