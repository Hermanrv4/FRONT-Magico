<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Helpers\AppHelper;
use App\Http\Common\Helpers\DateHelper;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CartService;
use App\Http\Common\Responses\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class ECommerceController extends BaseSiteController {

    public function Home(Request $request){
        return redirect(RouteService::GetSiteURL('customer-landing'));
    }
    public function Landing(Request $request){
        return view(config($this->group.'.ui.ecommerce.landing.view'))->with("ped_corp",0);
    }
    public function Login(Request $request){
        $lstCart = CartService::GetCart();
        if(count($lstCart)==0){
            return redirect(RouteService::GetSiteURL('landing'));
        }
        return view(config($this->group.'.ui.ecommerce.login.view'));
    }
    public function Logout(Request $request){
        Session::forget(config('env.app_auth_site_session_id'));
        return redirect(RouteService::GetSiteURL('landing'));
    }
    public function Cart(Request $request){
        return view(config($this->group.'.ui.ecommerce.cart.view'));
    }
    public function Checkout($token){
        $lstCart = CartService::GetCart();
        if(Session::has(config('env.app_auth_site_session_id'))) {
            if (!Session::has(config('env.app_checkout_site_session_id'))) {
                Session::put(config('env.app_checkout_site_session_id'), array());
            }
            /*--------------------------------------------------------------------------*/
            $data = Session::get(config('env.app_checkout_site_session_id'));
            

            if($token == null){
                $token = AppHelper::GetToken();
            }

            if (!array_key_exists($token,$data)){
                $data[$token] = array();
                $data[$token]["cart"] = $lstCart;
                $data[$token]["ubication_id"] = null;
                Session::put(config('env.app_checkout_site_session_id'),$data);
            }

            if(count($lstCart)==0){
                return redirect(RouteService::GetSiteURL('landing'));
            }
            /*--------------------------------------------------------------------------*/
            return view(config($this->group.'.ui.ecommerce.checkout.view'))->with("data",$data[$token])->with("token",$token);
        }else{
            if(count($lstCart)==0){
                return redirect(RouteService::GetSiteURL('landing'));
            }
            return redirect(RouteService::GetSiteURL('login'));
        }
    }
    public function OrderSuccess(Request $request){
        ApiService::Request(config('env.app_group_site'), 'entity', 'cart-clear-for-user', array("user_id" => Session::get(config('env.app_auth_'.$this->group.'_session_id'))["user"]["id"]));
        return view(config($this->group.'.ui.ecommerce.order.view'))->with("token",$request["token"])->with("status",config($this->group.'.value.order.status.success'));
    }
    public function OrderPending(Request $request){
        ApiService::Request(config('env.app_group_site'), 'entity', 'cart-clear-for-user', array("user_id" => Session::get(config('env.app_auth_'.$this->group.'_session_id'))["user"]["id"]));
        return view(config($this->group.'.ui.ecommerce.order.view'))->with("token",$request["token"])->with("status",config($this->group.'.value.order.status.pending'));
    }
    public function OrderFailed(Request $request){
        return view(config($this->group.'.ui.ecommerce.order.view'))->with("token",$request["token"])->with("status",config($this->group.'.value.order.status.failed'));
    }
    public function ViewSlider(Request $request){
        $html_preview = view(config($this->group.'.ui.component.product.presentation.view'))
            ->with("type", $request["type"])
            ->with("id_ref", $request["id_ref"])
            ->with("id", $request["id"])
            ->render();
        return ApiResponse::SendSuccessResponse(null,str_replace('\n','',$html_preview)."");
    }
    public function TermsAndConditions(){
        return view(config($this->group.'.ui.ecommerce.terms.view'));
    }
    public function PoliticsAndPrivacity(){
        return view(config($this->group.'.ui.ecommerce.politics.view'));
    }

    public function InfoPoliticsOurHor(){
        return view(config($this->group.'.ui.ecommerce.politics.view'))->with('info_type','our_hrs_contact');
    }
    public function InfoPoliticsTermCond(){
        return view(config($this->group.'.ui.ecommerce.politics.view'))->with('info_type','terms_and_condition');
    }
    public function InfoPoliticsCostEnv(){
        return view(config($this->group.'.ui.ecommerce.politics.view'))->with('info_type','time_and_cost_env');
    }
    public function InfoPoliticsPrivacity(){
        return view(config($this->group.'.ui.ecommerce.politics.view'))->with('info_type','politics_privacity');
    }
    public function InfoPoliticsCookies(){
        return view(config($this->group.'.ui.ecommerce.politics.view'))->with('info_type','politics_cookies');
    }
    public function InfoPoliticsTratament(){
        return view(config($this->group.'.ui.ecommerce.politics.view'))->with('info_type','dates_tratament');
    }
    public function InfoPoliticsOurShops(){
        return view(config($this->group.'.ui.ecommerce.politics.view'))->with('info_type','our_shops');
    }    
    public function InfoPoliticsOurHistory(){
        return view(config($this->group.'.ui.ecommerce.politics.view'))->with('info_type','our_history');
    }
    
}
