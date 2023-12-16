<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\ApiService;
use Illuminate\Http\Request;

    class TracingController extends BaseAdminController{
        public function index(Request $request){ 
            $objUser=null; 
            if(isset($request["code"])){
                $objUser=ApiService::Request($this->group, 'entity', 'Customer-Get', ['user_id'=>$request["code"]])->response;
            }
            return view(config($this->group.'.ui.page.tracing.list.view'), ["user"=>$objUser]);
        }
    }