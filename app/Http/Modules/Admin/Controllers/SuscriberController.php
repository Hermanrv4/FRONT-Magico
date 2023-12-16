<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use Illuminate\Http\Request;

class SuscriberController extends BaseAdminController {
    public function index(Request $request){
        return view(config($this->group.'.ui.page.suscriber.list.view'));
    }
}