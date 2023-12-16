<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use Illuminate\Http\Request;

class CollaboratorController extends BaseAdminController {
    public function List(Request $request){
        return view(config($this->group.'.ui.page.collaborator.list.view'));
    }
}
