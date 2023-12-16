<?php
namespace App\Http\Common\Services;

use App\Http\Common\Helpers\StringHelper;
use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteService{
    public static function GetSiteURL($route,$parameters=array()){
        return RouteService::GetURL(config('env.app_group_site'), $route, $parameters);
    }
    public static function GetAdminURL($route,$parameters=array()){

        return RouteService::GetURL(config('env.app_group_admin'), $route, $parameters);
    }
    public static function GetURL($group,$route,$parameters=array()){
        return route($group.'.'.$route,$parameters);
    }
    public static function GetSiteURLMethod($route){
        $group = config('env.app_group_site');
        return strtoupper(config($group.".route.".$route.".method"));
    }
    public static function GetAdminURLMethod($route){
        $group = config('env.app_group_admin');
        return strtoupper(config($group.".route.".$route.".method"));
    }
    public static function GetRoute($group,$route){
        if($route == null) return config($group.".route");
        $base_route = $route;
        $route = $group.".route.".$route.".";

        $action = array();
        $action["uses"] = config($route.'action');
        $action["as"] = $group.'.'.$base_route;

        $action["middleware"] = array();
        $action["middleware"][] = 'web';
        if(config($route.'localized')){
            $action["middleware"][] = 'localize';
            $action["middleware"][] = 'localeSessionRedirect';
            $action["middleware"][] = 'localizationRedirect';
            $action["middleware"][] = 'localeViewPath';
        }
        if(config($route.'secure')) $action["middleware"][] = $group.'.auth';

        $prefix = "";
        if($group == config('env.app_group_admin')) $prefix = config('env.app_group_admin').'';

        $method = strtolower(config($route.'method'));
        if(config($route.'localized')) {
            $url = LaravelLocalization::transRoute($group.'/route.'.config($route.'url'));
            return Route::$method(LaravelLocalization::setLocale().'/'.$prefix.$url, $action);
        }else{
            $url = config($route.'unlocalized_url');
            return Route::$method($prefix.$url, $action);
        }
    }
    public static function GetAdminRoute($route = null){
        try {
            return RouteService::GetRoute(config('env.app_group_admin'), $route);
        }catch(Exception $ex){return array();}
    }
    public static function GetSiteRoute($route = null){
        try {
            return RouteService::GetRoute(config('env.app_group_site'), $route);
        }catch(Exception $ex){return array();}
    }
}
