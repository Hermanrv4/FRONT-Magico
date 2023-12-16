<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use Illuminate\Http\Request;

class ElectronicsController extends BaseAdminController{
    public function index(Request $request){
        return view(config($this->group.'.ui.page.electronics.list.view'));
    }
    public function list(Request $request, $code){
        return view(config($this->group.'.ui.page.electronics-list.list.view'), ["dni"=>$code]);
    }
}