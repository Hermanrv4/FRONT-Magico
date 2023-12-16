<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Helpers\MailHelper;
use App\Http\Modules\Site\Services\ProductService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;
use Illuminate\Support\Facades\Session;

class IzziPayController extends BaseSiteController {
    

    public function getToken(Request $request){
        $izzipay = json_decode(ParameterService::GetParameter("integ_izzipay"),true);
        $objOrder = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get-by-token', array("token" => $request["token"]))->response;
        $url = $izzipay["url"];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $currency_code = ParameterService::GetParameter("default_currency_code");
        /*$headers = array(
        "Accept: application/json",
        "Authorization: Basic " . base64_encode('67560873' . ':' . 'testpassword_sS4uwrnkkyYnOnXnnyOIgUrVtistsEZ1JI7Qztd1dajts'),
        );*/
        $parameters = array("amount"=>number_format($objOrder["total"], 2, '.', ',')*100+0,"currency"=>'PEN',"orderId"=>$request["id_order"],"customer"=>array("email"=>$request["email"]));
        $headers = array("Authorization: Basic ".base64_encode($izzipay["user"].':'.$izzipay["password"]));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameters));
        $resp = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($resp);
            if($res->status=="SUCCESS"){
                return ApiResponse::SendSuccessResponse(null,json_encode($res->answer));
            }else{
                return ApiResponse::SendErrorResponse(null,json_encode($res->answer));
            }
        }

    public function GenerateFrom(Request $request){

        $objOrder = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get-by-token', array("token" => $request["token"]))->response;
        $html= view(config($this->group.'.ui.component.paymentType.view'))
        ->with("tokenForm",$request["tokenForm"])->with("token",$objOrder["token"])->render();
        return ApiResponse::SendSuccessResponse(null,$html);
    }  

    public function Response(Request $request){
        $response = json_decode($request["kr-answer"]);
        $objOrder = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get', array("order_id" => ($response->orderDetails)->orderId))->response;  
        $status = ParameterService::GetParameter("approved_status");
        $trx_details =  ($response->transactions)[0]->transactionDetails;
        $pay_code = $trx_details->externalTransactionId;
        if($objOrder==null){
            $status = null;
        }
            /*--- ACTUALIZAMOS LA ORDEN ---*/
        ApiService::Request(
                config('env.app_group_site')
                , 'entity'
                , 'order-update-payment-status'
                , array("order_id" => $objOrder["id"], "status" => $status, "pay_code" => $pay_code, "response" => $request["kr-answer"]))->response;

        /*--- ENVIAMOS CORREO SI ES QUE ES QUE NO SE NOTIFICÓ EL ESTADO ANTES ---*/
        $current_status = ($objOrder["payment_status"]==null?"":$objOrder["payment_status"]);
        if($current_status=="" || $current_status!=$status) MailHelper::SendMail_Notify_Order_Status($objOrder["id"],$status);

        if($objOrder==null){
            return redirect(RouteService::GetSiteURL('order-failed'));
        }else{
            if($response->orderStatus=="PAID"){
                return redirect(RouteService::GetSiteURL('order-success',["token"=>$objOrder["token"]]));
            }else{
                return redirect(RouteService::GetSiteURL('order-failed',["token"=>$objOrder["token"]]));
            }
        }
            
      }
}
