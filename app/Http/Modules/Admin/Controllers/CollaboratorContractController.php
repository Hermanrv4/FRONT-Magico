<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use Illuminate\Http\Request;

class CollaboratorContractController extends BaseAdminController {
    public function List($code = null){
        if($code==null) $code = ParameterService::GetParameter("default_id");
        return view(config($this->group.'.ui.page.collaborator_contract.list.view'))->with("code",$code);
    }
}
