<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\ApiService;
use Illuminate\Http\Request;

class ProductGroupController extends BaseAdminController{
    public function index(Request $request){
        return view(config($this->group.'.ui.page.groups.list.view'));
    }
    public function GetDataProductGroupBillingOfDate($date_start, $date_end){
        return ApiService::Request($this->group, 'entity', 'product-group-get-data-billing-of-date', ['date_start'=>$date_start, "date_end"=>$date_end])->response;
    }
}