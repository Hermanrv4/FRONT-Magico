<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\RouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseAdminController {
    public function Default(Request $request){
        return redirect(RouteService::GetAdminURL('dashboard'));
    }
    public function Login(Request $request){
        return view(config($this->group.'.ui.page.login.view'));
    }
    public function LoginAutorized(Request $request){
        $array = array(
            "token" => $request["admin_token"],
            config('env.app_group_admin') => $request["admin_data"],
        );
        Session::put(config('env.app_auth_admin_session_id'),$array);
        return self::Default($request);
    }
    public function LogAuth(Request $request){
        Session::forget(config('env.app_auth_admin_session_id'));
        return redirect(RouteService::GetAdminURL('login'));
    }
}
