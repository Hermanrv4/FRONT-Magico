<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use Illuminate\Http\Request;

    class TypesController extends BaseAdminController{
        public function index(Request $request){
            return view(config($this->group.'.ui.page.types.list.view'));
            /* return view(config($this->group.'.ui.page.currency.list.view')); */
        }
    }