<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use Illuminate\Http\Request;
use App\Http\Modules\Admin\Helpers\MailHelper;

class ElectronicDocumentController extends BaseAdminController{
    public function index(Request $request){
        return view(config($this->group.'.ui.page.generate-Fe.list.view'));
    }
    public function sendEmailDocument(Request $request){
        $email=$request["email"];
        //obtener los datos del cliente
        $objOrder = ApiService::Request($this->group, 'entity', 'order-get-all-billed', ["order_id"=>$request["id_order"] ] )->response;
        MailHelper::sendEmailSuccessDocument($email, $objOrder);
        return ApiResponse::SendSuccessResponse(null,$objOrder);
    }
}