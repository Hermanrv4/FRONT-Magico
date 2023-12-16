<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Modules\Admin\Helpers\MailHelper;

class SaleController extends BaseAdminController{
    public function index($code=null, $id=null){
        if($code == null) $code = ParameterService::GetParameter("default_id");
        return view(config($this->group.'.ui.page.sale.list.view'), ["code"=>$code]);
    }
    //envios de correos
    public function statusReceptorSendEmail(Request $request){
        $objOrder=ApiService::Request($this->group, 'entity', 'order-get', ["order_id"=>$request["id"]] )->response;
        $estatus=ApiService::Request($this->group, 'entity', 'type-get', ["type_id"=>$request["status"]] )->response;
        MailHelper::SendMail_Notify_Order_Status($objOrder, $estatus["name_localized"]);
        return ApiResponse::SendSuccessResponse(null, $objOrder);
    }
    public function GetOrderForStatusOfDate($date_start, $date_end, $id_status){
        return ApiService::Request($this->group, 'entity', 'order-get-status-of-date', ['date_start'=>$date_start, 'date_end'=>$date_end, 'option'=>'detail', 'id_status'=>$id_status])->response;
    }
    public function GetOrderOfDate($date_start, $date_end){
        return ApiService::Request($this->group, 'entity', 'order-get-of-date', ['date_start'=>$date_start, 'date_end'=>$date_end])->response;
    }
}