<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Services\RouteService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends BaseSiteController {

    public $provider = 'facebook';

    public function RequestCustomer(){
        return Socialite::driver($this->provider)
            ->redirectUrl(RouteService::GetSiteURL('facebook-response-customer'))
            ->stateless()
            ->redirect();
    }
    public function RequestMarketplace(){
        return Socialite::driver($this->provider)
            ->redirectUrl(RouteService::GetSiteURL('facebook-response-ecommerce'))
            ->stateless()
            ->redirect();
    }
    public function ResponseCustomer(){
        try{
            $driverFB = Socialite::driver($this->provider)
                ->redirectUrl(RouteService::GetSiteURL('facebook-response-customer'))
                ->setHttpClient(new Client(['verify' => false]))
                ->fields(['name','first_name','last_name','email','gender','verified']);
            $user = $driverFB->stateless()->user();
            return view(config($this->group.'.ui.customer.register.view'))->with("userFB",$user);
        }catch (\Exception $ex){
            return view(config($this->group.'.ui.customer.register.view'));
        }
    }
    public function ResponseMarketplace(){
        try{
            $driverFB = Socialite::driver($this->provider)
                ->redirectUrl(RouteService::GetSiteURL('facebook-response-ecommerce'))
                ->setHttpClient(new Client(['verify' => false]))
                ->fields(['name','first_name','last_name','email','gender','verified']);
            $user = $driverFB->stateless()->user();
            return view(config($this->group.'.ui.ecommerce.login.view'))->with("userFB",$user);
        }catch (\Exception $ex){
            return view(config($this->group.'.ui.ecommerce.login.view'));
        }
    }
}
