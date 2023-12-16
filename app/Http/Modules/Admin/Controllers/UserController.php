<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\ApiService;
use Illuminate\Http\Request;

class UserController extends BaseAdminController {
    public function List(Request $request){
        return view(config($this->group.'.ui.page.user.list.view'));
    }
    public function GetOrderForUserOfDate($date_start, $date_end){
        return ApiService::Request($this->group, 'entity', 'user-get-order-of-date', ['date_start'=>$date_start, "date_end"=>$date_end])->response;
    }
    public function GetBillingForUserOfDate($date_start, $date_end){
        return ApiService::Request($this->group, 'entity', 'user-get-billing-of-date', ["option"=>"detail","date_start"=>$date_start, "date_end"=>$date_end])->response;
    }
}
