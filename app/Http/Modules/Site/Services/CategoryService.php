<?php
namespace App\Http\Modules\Site\Services;

use App\Http\Common\Helpers\DateHelper;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CategoryService{
    public static function GetChildCategories($root_category_id){
        $result = array();

        if($root_category_id == null) {
            $lstCategories = ApiService::Request(config('env.app_group_site'), 'entity', 'category-root-parents', array())->response;
        }else{
            $lstCategories = ApiService::Request(config('env.app_group_site'), 'entity', 'category-childs-by-root-id', array('root_id'=>$root_category_id))->response;
        }
        for ($i = 0; $i < count($lstCategories); $i++) {
            $result[] = $lstCategories[$i]["id"];
            $result = array_merge($result, CategoryService::GetChildCategories($lstCategories[$i]["id"]));
        }
        return $result;
    }
}