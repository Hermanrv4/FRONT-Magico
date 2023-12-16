<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Helpers\MailHelper;
use App\Http\Common\Helpers\AppHelper;
use App\Http\Modules\Site\Services\ProductService;
use App\Http\Modules\Site\Services\HtmlService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;
use MercadoPago\SDK;
use MercadoPago\Payment;

use Illuminate\Support\Facades\Session;

class GeneralController extends BaseSiteController {
    
    public function Clear(){
        

        /*--- CONFIGURACIÓN DE MERCADOPAGO ---*/
        //$mp_credentials = json_decode(ParameterService::GetParameter("integ_mercadopago"),true);
        //SDK::setAccessToken($mp_credentials["access_token"]);
        /*--- OBTENEMOS LA ORDER MEDIANTE EL TOKEN DE REFERENCIA ---*/
        //$request_mp = Payment::find_by_id(intval('123'));
		
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        /*Artisan::call('view:clear');
        Artisan::call('view:cache');*/
        Artisan::call('route:clear');
        Artisan::call('route:list');
        return dd(Artisan::output());
    }
    public function Test(Request $request){
        $count = 0;
        for($i=1;$i<=111;$i++){
            for($j=1;$j<=3;$j++) {
                $count++;
                $img = 'storage/app/loaded/img/products/foto'.($i).'.'.($j).'.jpg';
                file_put_contents($img, file_get_contents('https://picsum.photos/512/512?random='.$count));
            }
        }
        /*$lstUsers = \App\Http\Common\Services\ApiService::Request('site','entity','user-get')->response;

        for($i=0;$i<count($lstUsers);$i++){
            $objUser = ApiService::Request($this->group,'entity','user-by-id',["user_id"=>$lstUsers[$i]["id"]])->response;
            MailHelper::SendMail_Wellcome_Customer($objUser);
        }*/
        return "OK";
    }
	public function GetNonExistentPhotos(Request $request){
		
		$data = ApiService::Request(config('env.app_group_site'), 'entity', 'product-all', array())->response;

        $images = array();
        for($i=0;$i<count($data);$i++){

            $arrPhotos = json_decode($data[$i]["photos"],true);
            $entro = false;
            for($j=0;$j<count($arrPhotos);$j++){
                if($arrPhotos[$j]!=""){
                    if(!in_array(HtmlService::ParseImage($arrPhotos[$j],"products"),$images)) {
                        $images[] = HtmlService::ParseImage($arrPhotos[$j], "products");
                    }
                    $entro = true;
                }
            }
            if(!$entro){dd($data[$i]);}
        } 

        $img_404 = array();

        for($i=0;$i<count($images);$i++){
            $handle = curl_init(AppHelper::EncodeUrl($images[$i]));
			curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            if($httpCode != 200) {
                $img_404[] = $images[$i];
            }
            curl_close($handle);
        }

        dd($img_404);
	}
}
