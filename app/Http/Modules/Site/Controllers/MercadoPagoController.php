<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\ApiService;
use App\Http\Modules\Site\Helpers\MailHelper;
use App\Http\Modules\Site\Services\ProductService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Common\Helpers\DateHelper;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPagoController extends BaseSiteController {
    public function Request(Request $request){

            $mp_credentials = json_decode(ParameterService::GetParameter("integ_mercadopago"),true);
            \MercadoPago\SDK::setAccessToken($mp_credentials["access_token"]);
            $objOrder = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get', array("order_id" => $request["order_id"]))->response;
            $lstOrderDetail = ApiService::Request(config('env.app_group_site'), 'entity', 'order-detail-get-by-order', array("order_id" => $objOrder["id"]))->response;
            $objUser = ApiService::Request(config('env.app_group_site'), 'entity', 'user-by-id', array("user_id" => $objOrder["user_id"]))->response;
        
            $external_reference = $objOrder["token"];

            /*--- DECLARACIÓN DE ARTÍCULOS A MERCADOPAGO ---*/
            $items = array();

            /*--- DECLARACIÓN DEL COSTO DE ENVÍO POR LA ORDEN ---*/
            $item = new Item();
            $item->id = 0;
            $item->title = "Costo de envío";
            $item->description = "Costo de envió total por la orden.";
            $item->quantity = 1;
            $item->unit_price = floatval($objOrder["shipping_cost"]);
            $items[] = $item;

            /*--- DECLARACIÓN DE ITEMS DE LA ORDEN ---*/
            for ($i = 0; $i < count($lstOrderDetail); $i++) {
                $item = null;
                $objPrice = ApiService::Request(config('env.app_group_site'), 'entity', 'product-price-get-by-product', array("product_id" => $lstOrderDetail[$i]["product_id"], "currency_id" => $objOrder["currency_id"]))->response;
                $objProduct = ApiService::Request(config('env.app_group_site'), 'entity', 'product-by-id', array("product_id" => $lstOrderDetail[$i]["product_id"], "currency_id" => $objOrder["currency_id"]))->response;
                $lstFontBackPhotos = ProductService::GetFrontBackPhotos($objProduct);

                $item = new Item();
                $item->id = $objProduct["product_id"];
                $item->picture_url = $lstFontBackPhotos["front"];
                $item->title = $objProduct["product_name"];
                $item->description = $objProduct["product_description"];
                $item->quantity = intval($lstOrderDetail[$i]["quantity"]);
                $item->unit_price = $objPrice["online_price"];
                $items[] = $item;
            }
          
            /**************************** PAYMENT ********************************/
            /**************************************/
            $payment = new \MercadoPago\Payment();
            /*$payment->transaction_amount = $objOrder["total"];
            $payment->token = $request["token"];
            $payment->description = "Compra en Mágico";
            $payment->installments = $request["installments"];
            $payment->payment_method_id = $request["payment_method_id"];
            $payment->payer = array ('email' => $objUser["email"]);
            $payment->notification_url = RouteService::GetSiteURL('mercadopago-response');
            $payment->binary_mode = config('env.mercadopago_binary_mode');
            $payment->external_reference = $external_reference;
            $expiration_date = DateHelper::GetNow()->addMinutes(config('env.mercadopago_time_expire_preference'));
            $payment->date_of_expiration = $expiration_date->format('Y-m-d\TH:i:s.000P');*/
            $payment->transaction_amount = $objOrder['total'];
            $payment->token = $request['token'];
            $payment->description =$request['description'] ?? 'Compra en Mágico';
            $payment->installments = $request["installments"];
            $payment->payment_method_id = $request['payment_method_id'];
            $payment->issuer_id = $request['issuer_id'];
            $payment->payer = array ('email' => $objUser["email"]);
            $payment->external_reference = $external_reference;
            $expiration_date = DateHelper::GetNow()->addMinutes(config('env.mercadopago_time_expire_preference'));
            $payment->date_of_expiration = $expiration_date->format('Y-m-d\TH:i:s.000P');
            $payment->notification_url = RouteService::GetSiteURL('mercadopago-response');
            $payment->additional_info = array (
                'items' => $items
            );
            $payer = new \MercadoPago\Payer();
            $payer->email = $request['cardholderEmail'] ?? $request['email'];
            $payer->identification = array(
                "type" => $request['payer']['identification']['type'] ?? $request['identificationType'],
                "number" => $request['payer']['identification']['number'] ?? $request['identificationNumber']
            );
            $payment->payer = $payer;
            $payment->save();
            /***********************************************************************/
            $url = "";
            
            switch ($payment->status){
                case config($this->group.'.value.mercadopago.status.pending'):
                    $url = RouteService::GetSiteURL('order-pending',["token"=>$objOrder["token"]]);
                    break;
                case config($this->group.'.value.mercadopago.status.in_process'):
                    $url = RouteService::GetSiteURL('order-pending',["token"=>$objOrder["token"]]);
                    break;
                case config($this->group.'.value.mercadopago.status.cancelled'):
                    $url = RouteService::GetSiteURL('order-failed',["token"=>$objOrder["token"]]);
                    break;
                case config($this->group.'.value.mercadopago.status.refunded'):
                    $url = RouteService::GetSiteURL('order-pending',["token"=>$objOrder["token"]]);
                    break;
                case config($this->group.'.value.mercadopago.status.approved'):
                    $url = RouteService::GetSiteURL('order-success',["token"=>$objOrder["token"]]);
                    break;
                case config($this->group.'.value.mercadopago.status.rejected'):
                    $url = RouteService::GetSiteURL('order-failed',["token"=>$objOrder["token"]]);
                    break;
                default:
                MailHelper::SendMail('MAGICO MERCADOPAGO NO HA PROCESADO ORDER - '.$objOrder["id"], json_encode($request,true), 'andresalvareztt@gmail.com', 'Andres');
                MailHelper::SendMail('MAGICO MERCADOPAGO NO HA PROCESADO ORDER - '.$objOrder["id"], json_encode($payment,true), 'andresalvareztt@gmail.com', 'Andres');
                    $url = RouteService::GetSiteURL('order-failed',["token"=>$objOrder["token"]]);
            }

            /*if($objUser["email"] == 'andresalvareztt@gmail.com' || $objUser["email"] == 'aphang@magico.pe'){
                MailHelper::SendMail('MAGICO MERCADOPAGO ORDER POR CANTIDAD - '.$objOrder["id"], json_encode($payment,true), 'andresalvareztt@gmail.com', 'Andres');
            }*/

            return redirect($url);

    }
    public function Response(Request $request){
        $external_reference = null;
        $exception_message = "";
        $id_mercadopago = null;

        if(isset($request->data_id)){
            $id_mercadopago = intval($request->data_id);
        }else{
            if(isset($request->id)){
                $id_mercadopago = intval($request->id);
            }else{
                MailHelper::SendMail('ID NO ENCONTRADO', $request, 'andresalvareztt@gmail.com', 'Andres');
                return response("ERROR", 404);
            }
        }
        //$request_mp = Payment::find_by_id($request["data"]["id"]);
        try{
            /*--- CONFIGURACIÓN DE MERCADOPAGO ---*/
            $mp_credentials = json_decode(ParameterService::GetParameter("integ_mercadopago"),true);
            SDK::setAccessToken($mp_credentials["access_token"]);
            /*--- OBTENEMOS LA ORDER MEDIANTE EL TOKEN DE REFERENCIA ---*/
            $request_mp = Payment::find_by_id(intval($id_mercadopago));
            $external_reference = $request_mp->external_reference;
            $objOrder = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get-by-token', array("token" => $external_reference))->response;
            $pay_code = null;
            $payment_status = null;
            $payment_response = var_export($request_mp,true);

            /*--- TRANSFORMAMOS EL ESTADO MERCADOPAGO HACIA EL ESTADO EQUIMIUM ---*/
            switch ($request_mp->status){
                case config($this->group.'.value.mercadopago.status.pending'):
                    $payment_status = config($this->group.'.value.order.payment-status.pending');
                    break;
                case config($this->group.'.value.mercadopago.status.in_process'):
                    $payment_status = config($this->group.'.value.order.payment-status.pending');
                    break;
                case config($this->group.'.value.mercadopago.status.cancelled'):
                    $payment_status = config($this->group.'.value.order.payment-status.cancelled');
                    break;
                case config($this->group.'.value.mercadopago.status.refunded'):
                    $payment_status = config($this->group.'.value.order.payment-status.refunded');
                    break;
                case config($this->group.'.value.mercadopago.status.approved'):
                    $pay_code = $id_mercadopago;
                    $payment_status = config($this->group.'.value.order.payment-status.approved');
                    break;
                case config($this->group.'.value.mercadopago.status.rejected'):
                    $payment_status = config($this->group.'.value.order.payment-status.rejected');
                    break;
            }

            //MailHelper::SendMail('MAGICO MERCADOPAGO ORDER POR CANTIDAD - '.$payment_status, json_encode($payment_response,true), 'andresalvareztt@gmail.com', 'Andres');

            /*--- ACTUALIZAMOS LA ORDEN ---*/
            ApiService::Request(
                config('env.app_group_site')
                , 'entity'
                , 'order-update-payment-status'
                , array("order_id" => $objOrder["id"], "status" => $payment_status, "pay_code" => $pay_code, "response" => $payment_response))->response;

            /*--- ENVIAMOS CORREO SI ES QUE ES QUE NO SE NOTIFICÓ EL ESTADO ANTES ---*/
            $current_status = ($objOrder["payment_status"]==null?"":$objOrder["payment_status"]);
            
            if($current_status=="" || $current_status!=$payment_status){
                switch($payment_status){
                    case config($this->group.'.value.order.payment-status.approved'):
                        MailHelper::SendMail_Order_Success($objOrder["id"],config($this->group.'.value.order.payment-status.approved')); break;
                    case config($this->group.'.value.order.payment-status.pending'):
                        MailHelper::SendMail_Order_Pending($objOrder["id"]); break;

                    default:
                        MailHelper::SendMail_Notify_Order_Status($objOrder["id"],$payment_status); break;
                }
            }

        }catch (\Exception $ex){
            $exception_message = $ex->getMessage()."\n".$ex->getTraceAsString();
            MailHelper::SendMail('mercadopago', $exception_message, 'andresalvareztt@gmail.com', 'Andres');
        } finally {
            if($external_reference==null){
                $myfile = fopen("storage/logs/ORDER_MPID_.txt", "w+");
            }else{
                $myfile = fopen("storage/logs/ORDER_MPER_".$external_reference.".txt", "w+");
            }
            $mensaje = "/*--------------------------------------------------------------------------------------*/\n\n";
            $mensaje = $mensaje . "data: ".json_encode($request->all(),true)."\n\n";
            $mensaje = $mensaje . "excepton: ".$exception_message."\n\n";
            $mensaje = $mensaje . "/*--------------------------------------------------------------------------------------*/\n\n";
            fwrite($myfile,$mensaje);
            fclose($myfile);
        }
        return response("OK", 200);
    }
}
