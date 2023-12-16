<?php
namespace App\Http\Modules\Site\Services;

use App\Http\Common\Helpers\DateHelper;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ProductService{
    public static function GetDefaultSitePhoto(){
        return asset("resources/assets/site/ecommerce/img/default/product.jpg");
    }
    public static function GetFrontBackPhotos($data,$imgDefault=null){
        $datita = $data;
        try{
        if($imgDefault==null) $imgDefault = ProductService::GetDefaultSitePhoto();
        $lstPhotos = array("front"=>$imgDefault,"back"=>$imgDefault);

        $data = $data["product_photos"];
        $arrPhotos = json_decode($data,true);
        if(count($arrPhotos)>=2){
            $lstPhotos["front"] = HtmlService::ParseImage($arrPhotos[0],"products");
            $lstPhotos["back"] =HtmlService::ParseImage($arrPhotos[0],"products");
        }elseif(count($arrPhotos)==1){
            $lstPhotos["front"] = HtmlService::ParseImage($arrPhotos[0],"products");
            $lstPhotos["back"] = HtmlService::ParseImage($arrPhotos[0],"products");
        }
        }catch(\Exception $ex){
            return array("front"=>"default.png","back"=>"default.png");
        }
        return $lstPhotos;
    }
    public static function GetPrices($data){
        $lstPrices = array(
            "principal" => $data["online_price"],
            "other" => $data["regular_price"]
        );
        return $lstPrices;
    }
    public static function GetPreviews($lstSpecifications,&$objSpColor,&$objSpNeedUserInfo){
        $objSpColor = null;
        $lstPreviews = array();
        for($i=0;$i<count($lstSpecifications);$i++){
            if($lstSpecifications[$i]["is_color"] == 1){
                $objSpColor = $lstSpecifications[$i];
            }
            if($lstSpecifications[$i]["needs_user_info"] == 1){
                $objSpNeedUserInfo = $lstSpecifications[$i];
            }
            if($lstSpecifications[$i]["is_preview"] == 1){
                $lstPreviews[] = $lstSpecifications[$i];
            }
        }
        return $lstPreviews;
    }
    public static function GetPreviewsAndNeedUserInfo($lstSpecifications,&$objSpColor,&$objSpNeedUserInfo){
        $objSpColor = null;
        $lstPreviews = array();
        for($i=0;$i<count($lstSpecifications);$i++){
            if($lstSpecifications[$i]["is_color"] == 1){
                $objSpColor = $lstSpecifications[$i];
            }
            if($lstSpecifications[$i]["needs_user_info"] == 1){
                $objSpNeedUserInfo = $lstSpecifications[$i];
            }
            if($lstSpecifications[$i]["is_preview"] == 1 || $lstSpecifications[$i]["needs_user_info"] == 1){
                $lstPreviews[] = $lstSpecifications[$i];
            }
        }
        return $lstPreviews;
    }
    public static function GetMySpecifications($data){
        $str_union = $data["str_union"];
        $str_limiter = $data["str_limiter"];
        $data = $data["specifications"];
        $lstMySpecifications = array();
        $lstSpec = explode($str_limiter,$data);
        for($i=0;$i<count($lstSpec);$i++){
            $lstSub = explode($str_union,$lstSpec[$i]);
            $lstMySpecifications[$lstSub[0]] = $lstSub[1];
        }
        return $lstMySpecifications;
    }
    public static function GetSimilarSpecifications($data){
        $str_union = $data["str_union"];
        $str_limiter = $data["str_limiter"];
        $my_url_code = $data["product_url_code"];
        $data = $data["similar_specifications"];
        $lstSimilarSpecifications = array();
        $lstSimSpec = explode($str_limiter,$data);
        for($i=0;$i<count($lstSimSpec);$i++){
            $lstSub = explode($str_union,$lstSimSpec[$i]);
            if(!array_key_exists($lstSub[0],$lstSimilarSpecifications)) {
                $lstSimilarSpecifications[$lstSub[0]] = array();
            }
            $lstSimilarSpecifications[$lstSub[0]][] = array(
                "url_code" => $lstSub[1],
                "value" => $lstSub[2],
                "is_my" => ($my_url_code==$lstSub[1])
            );
        }
        return $lstSimilarSpecifications;
    }
}
