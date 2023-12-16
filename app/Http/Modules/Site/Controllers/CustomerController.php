<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\ApiService;
use App\Http\Modules\Site\Helpers\MailHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends BaseSiteController {
    public function Landing(Request $request){
        return view(config($this->group.'.ui.customer.landing.view'));
    }
    public function Register(Request $request){
        return view(config($this->group.'.ui.customer.register.view'));
    }
    public function SendWellcomeCustomerMail(Request $request){
        $objUser = ApiService::Request($this->group,'entity','user-by-id',["user_id"=>$request["user_id"]])->response;
        MailHelper::SendMail_Wellcome_Customer($objUser);
        return ApiResponse::SendSuccessResponse(null,$objUser);
    }
    public function AuthMarketplace(Request $request){
        $objUser = ApiService::Request($this->group,'entity','user-by-id',["user_id"=>$request["user_id"]])->response;
        if(Session::has(config('env.app_auth_site_session_id'))) Session::forget(config('env.app_auth_site_session_id'));
        Session::put(config('env.app_auth_site_session_id'),array("user"=>$objUser,"token"=>$request["token"]));

        if(Session::has(config('env.app_cart_site_session_id'))) {
            $objUser = Session::get(config('env.app_auth_site_session_id'))["user"];
            $lstCart = Session::get(config('env.app_cart_site_session_id'));
            for($i=0;$i<count($lstCart);$i++){
                $parameters = Array(
                    "user_id" => $objUser["id"]
                    ,"product_id" => $lstCart[$i]["product_id"]
                    ,"qty" => $lstCart[$i]["qty"]
                    ,"replace" => true
                    ,"observations" => (isset($lstCart[$i]["observations"])?$lstCart[$i]["observations"]:null)
                );
                ApiService::Request(config('env.app_group_site'), 'entity', 'cart-add', $parameters);
            }
        }
        Session::forget(config('env.app_cart_site_session_id'));

        return ApiResponse::SendSuccessResponse();
    }
    public function SendContactMail(Request $request){
        $parameters = array(
            'name'=>$request["name_"],
            'last_name'=>$request["last_name_"],
            'mail'=>$request["mail_"],
            'phone'=>$request["phone_"],
            'message'=>$request["message_"],
        );
 
        if(isset($request["is_company"])){
            $parameters["is_company"] = $request["is_company"];
            $parameters["name_company"]=$request["name_company_"];
        }else{
            $parameters["is_company"]=0;
        }
   
        $response = ApiService::Request(config('env.app_group_site'), 'entity', 'add-contact', $parameters)->response;
        if($response==null){
            return ApiResponse::SendErrorResponse(null,$response);
        }
        MailHelper::SendMail_Contact_Customer($parameters);
        return ApiResponse::SendSuccessResponse(null,null);
        
    }
    public function SendSuscriberMail(Request $request){
        
        $response = ApiService::Request(config('env.app_group_site'), 'entity', 'add-suscriber', array('email'=>$request["email_sus"],'info_suscriber'=>$request["info_suscriber"]))->response;
        $status=false;
        if($response!=null){
            MailHelper::SendMail_New_Suscriber($request["email_sus"]);
            $status=true;
        }
        return ApiResponse::SendSuccessResponse(null,$status);
    }
}
