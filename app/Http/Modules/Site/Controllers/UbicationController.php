<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Modules\Site\Services\CartService;
use App\Http\Modules\Site\Services\SiteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MercadoPago\Payment;

class UbicationController extends BaseSiteController {

    public function GetCostEnv(Request $request){
        $currency_code = ParameterService::GetParameter("default_currency_code");

        $shipping_prices = ApiService::Request(config('env.app_group_site'), 'entity', 'shipping-price-get', array('ubication_id'=>$request["ubication_id"],"currency_code"=>$currency_code))->response;
        /*************************** SE PROCEDE A VERIFICAR SI EXISTE UN COSTO DE ENVÍO PARA ESA UBICACIÓN **************************/
        if($shipping_prices["price"]==null){
            /***************************** SE DICE QUE NO HAY ENVÍO PARA ESA LOCALIDAD ************************************/
            $msg = "Lo sentimos, actualmente no contamos con entregas hacia esta localidad.";
            $data = array('message'=>$msg,'type'=>0,'status'=>false);
            return ApiResponse::SendSuccessResponse(null,$data);
        }else{
            $cost = 0;
            $district = ApiService::Request(config('env.app_group_site'), 'entity', 'ubication-get-by-id', array('ubication_id'=>$request["ubication_id"]))->response;
            $provinc = ApiService::Request(config('env.app_group_site'), 'entity', 'ubication-get-by-id', array('ubication_id'=>$district["root_ubication_id"]))->response;
            $department = ApiService::Request(config('env.app_group_site'), 'entity', 'ubication-get-by-id', array('ubication_id'=>$provinc["root_ubication_id"]))->response;

            $lstCart = CartService::GetCart();
            $lima_id = ParameterService::GetParameter("ubication_lima");

            /*********** SE PROCEDE A REVISAR SI EL PRECIO ES FIJO (ESTO OBLIGA QUE ESTE DENTRO DE LIMA) ******************/
            if($shipping_prices["is_static"]==1){
                $cost = round($shipping_prices["price"],2);
                $data = array('costo_envio'=>$cost,'message'=>'','status'=>true);
            }
            else{
                /********** SIZE DE LOS PRODUCTOS ***********/
                $size_accesories = 0;
                $max_size_accesorie = -1;
                $size_others = 0;
                $max_size_other = -1;
                /************ VARIABLES DE RESPUESTA ************/
                $cost = 0;
                $msg = "";
                $type = 0;
                $status = false;
                $data = array();
                /******** CONTADORES DE LOS PRODUCTOS POR CATEGORÍA ********/
                $count_accesories = 0;
                $count_not_provinc = 0;
                /***********************************************************/
                $total_count = 0;

                $accesories_id = ParameterService::GetParameter("category_accesories");
                for($i=0;$i<count($lstCart);$i++){                            
                    $product_data = ApiService::Request(config('env.app_group_site'), 'entity', 'product-by-id', ["currency_code"=> SiteService::GetCurrencyCode(),"product_id" => $lstCart[$i]["product_id"]])->response;
                    $aditional_info = json_decode($product_data["aditional_info"]);
                    
                    if($aditional_info->is_for_provincia == 0){
                        $msg_pro = "<br>-".$product_data["product_name"];
                        $count_not_provinc++;
                    }
                    $total_count =  $total_count + (int)$lstCart[$i]["qty"];
                    /* ************************************************ */
                    if($product_data["category_id"]==$accesories_id){
                        $size_accesories = round($size_accesories,2)+(round($product_data["shipping_size"],2)*$lstCart[$i]["qty"]);
                        if($max_size_accesorie<round($product_data["shipping_size"],2)){
                            $max_size_accesorie = round($product_data["shipping_size"],2);
                        }
                        $count_accesories++;
                    }
                    else{
                        $size_others = round($size_others,2) + (round($product_data["shipping_size"],2)*$lstCart[$i]["qty"]);
                        if($max_size_other<round($product_data["shipping_size"],2)){
                            $max_size_other = round($product_data["shipping_size"],2);
                        }
                    }
                }

                //EN CASO DE QUE SEA PARA PROVINCIA

                if($department["id"]!=$lima_id){
                    if($count_not_provinc>0){
                        $msg = "No se ha podido realizar tu compra porque contiene productos<br>de venta exclusiva para Lima Metropolitana.";
                        $msg = $msg.$msg_pro;
                        $type = 1;
                        $data = array('message'=>$msg,'type'=>$type,'status'=>$status);
                    }
                    else{
                        
                        $value_size_accesories = 0.0;
                        if($total_count==1){
                            if($count_accesories==1){
                                $value_size_accesories = round($max_size_accesorie,2);
                            }
                        }

                        $status = true;
                        if($count_accesories>1){
                                $value_size_accesories = round($max_size_accesorie,2);
                        }

                        $sum_ = floatval($value_size_accesories) + floatval($size_others);

                        $cost = round($shipping_prices["price"],2) * ($sum_);
                        $data = array('costo_envio'=>$cost,'message'=>$msg,'status'=>$status);
                    }
                }
                //EN CASO SEA PARA LIMA
                else{
                    $status = true;
                    if($max_size_accesorie==-1){
                        $max_size_accesorie=0;
                    }
                    if($max_size_other==-1){
                        $max_size_other = 0;
                    }

                    $max_for_lima = $max_size_accesorie;
                    if($max_size_other>$max_size_accesorie){
                        $max_for_lima = $max_size_other;
                    }

                    $cost = round($shipping_prices["price"],2) * ($max_for_lima);
                    $data = array('costo_envio'=>$cost,'message'=>$msg,'status'=>$status);
                }
            }
            return ApiResponse::SendSuccessResponse(null,$data);
        }
        
        //return ApiResponse::SendSuccessResponse($ubications);
    }
}
