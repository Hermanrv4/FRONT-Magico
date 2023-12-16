<?php
namespace App\Http\Modules\Site\Services;

use App\Http\Common\Helpers\DateHelper;
use App\Http\Common\Helpers\StringHelper;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CartService{
    public static function ModifyCart($product_id,$qty,$replace,$observations){
        if(Session::has(config('env.app_auth_site_session_id'))){
            Session::forget(config('env.app_cart_site_session_id'));
            $objUser = Session::get(config('env.app_auth_site_session_id'))["user"];
            $parameters = Array(
                "user_id" => $objUser["id"]
                ,"product_id" => $product_id
                ,"qty" => $qty
                ,"replace" => $replace
                ,"observations" => $observations
            );
            ApiService::Request(config('env.app_group_site'), 'entity', 'cart-add', $parameters);
        }else{
            CartService::ModifyUnLoggedCart($product_id,$qty,$replace,$observations);
        }
    }
    public static function ModifyUnLoggedCart($product_id,$qty,$replace,$observations){
        $cart = array();
        if(Session::has(config('env.app_cart_site_session_id'))){
            $cart = Session::get(config('env.app_cart_site_session_id'));
        }
        /*----------------------------------------------------------------------------*/
        $product_exists = false;
        for($i=0;$i<count($cart);$i++){
            if($cart[$i]["product_id"]==$product_id){
                $product_exists = true;
                if($replace){
                    $cart[$i]["qty"] = $qty;
                }else{
                    $cart[$i]["qty"] = $cart[$i]["qty"] + $qty;
                }
                if($observations!=null){
                    $cart[$i]["observations"] = $observations;
                }
                break;
            }
        }
        if(!$product_exists && $qty>0){
            $cart[] = array(
                "product_id" => $product_id,
                "qty" => $qty,
                "observations" => StringHelper::IsNull($observations,""),
            );
        }
        /*----------------------------------------------------------------------------*/
        $cart_result = array();
        for($i=0;$i<count($cart);$i++){
            if($cart[$i]["qty"]>0) $cart_result[] = $cart[$i];
        }
        /*----------------------------------------------------------------------------*/
        Session::put(config('env.app_cart_site_session_id'),$cart_result);
    }
    public static function GetCart(){
        if(!Session::has(config('env.app_auth_site_session_id'))){
            $lstCart = Session::get(config('env.app_cart_site_session_id'));
            return ($lstCart==null?array():$lstCart);
        }else{
            Session::forget(config('env.app_cart_site_session_id'));
            $objUser = Session::get(config('env.app_auth_site_session_id'))["user"];
            $lstCart = ApiService::Request(config('env.app_group_site'), 'entity', 'cart-get', ["user_id" => $objUser["id"]])->response;
            $cart = array();
            for($i=0;$i<count($lstCart);$i++){
                $cart[] = array(
                    "product_id" => $lstCart[$i]["product_id"],
                    "qty" => $lstCart[$i]["quantity"],
                    "observations" => $lstCart[$i]["observations"]
                );
            }
            return $cart;
        }
    }
    public static function GetTotalCartItems()
    {
        $qty = 0;

        if (!Session::has(config('env.app_auth_site_session_id'))) {
            $lstCart = Session::get(config('env.app_cart_site_session_id'));
            if ($lstCart == null || count($lstCart) == 0) return 0;
            for ($i = 0; $i < count($lstCart); $i++) {
                $qty += $lstCart[$i]["qty"];
            }
            return $qty;
        }
        else {
            Session::forget(config('env.app_cart_site_session_id'));
            $objUser = Session::get(config('env.app_auth_site_session_id'))["user"];
            $lstCart = ApiService::Request(config('env.app_group_site'), 'entity', 'cart-get', ["user_id" => $objUser["id"]])->response;
            if ($lstCart == null || count($lstCart) == 0) return 0;
            for ($i = 0; $i < count($lstCart); $i++) {
                $qty += $lstCart[$i]["quantity"];
            }
            return $qty;
        }
    }
    public static function GetAmountTotal()
    {

        if (!Session::has(config('env.app_auth_site_session_id'))) {
            $lstCart = Session::get(config('env.app_cart_site_session_id'));
        } else {
            Session::forget(config('env.app_cart_site_session_id'));
            $objUser = Session::get(config('env.app_auth_site_session_id'))["user"];
            $lstCart = ApiService::Request(config('env.app_group_site'), 'entity', 'cart-get', ["user_id" => $objUser["id"]])->response;

        }

        $total_price_cart = 0;
        for ($i = 0; $i < count($lstCart); $i++) {
            $product_data = ApiService::Request(config('env.app_group_site'), 'entity', 'product-by-id', ["currency_code" => SiteService::GetCurrencyCode(), "product_id" => $lstCart[$i]["product_id"]])->response;
            $lstPrices = ProductService::GetPrices($product_data);
            $qty = 0;
            if(isset($lstCart[$i]["quantity"])){
                $qty =$lstCart[$i]["quantity"];
            }else{
                $qty =$lstCart[$i]["qty"];
            }

            $price = $lstPrices["principal"];
            $subtotal = $price * $qty;

            $price = round($price, 2);
            $subtotal = round($subtotal, 2);

            $currency_symbol = $product_data["currency_symbol"];
            $total_price_cart = $total_price_cart + $subtotal;

        }
        return $total_price_cart;
    }
    public static function VerifyCoupon(){
        
    }
}