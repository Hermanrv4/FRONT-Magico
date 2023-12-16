<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use Illuminate\Http\Request;

class PositionController extends BaseAdminController {
    public function List(Request $request){
        return view(config($this->group.'.ui.page.position.list.view'));
    }
}
