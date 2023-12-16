<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\ApiService;
use App\Http\Modules\Site\Services\CartService;
use App\Http\Modules\Site\Services\SiteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends BaseSiteController {
    public function Add(Request $request){
        CartService::ModifyCart($request["product_id"],$request["qty"],$request["replace"],$request["observations"]);
        $count = CartService::GetTotalCartItems();
        if($count==0){
            $count='';
        }
        return ApiResponse::SendSuccessResponse($count);
    }

    public function getQuantity(Request $request){
        $qty = CartService::GetTotalCartItems();
        if($qty == 0){
            $qty = "";
        }
        return ApiResponse::SendSuccessResponse(null,$qty."");
    }

    public function getPrice(Request $request){
        $price = CartService::GetAmountTotal();
        return ApiResponse::SendSuccessResponse(null,$price."");
    }
    
    public function FilterConfigbyUbications(Request $request){
         $lstCartProducts = CartService::GetCart();
         for($i=0;$i<($lstCartProducts);$i++){
             $product_data = ApiService::Request(config('env.app_group_site'), 
             'entity', 'product-by-id', 
             ["currency_code"=> SiteService::GetCurrencyCode(),"product_id" => $lstCartProducts[$i]["product_id"]])->response;
             $aditional_info = $product_data[$i]["aditional_info"];
         }
    }
}
