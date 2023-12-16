<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use Illuminate\Http\Request;

class DashboardController extends BaseAdminController {
    public function Dashboard(Request $request){
        return view(config($this->group.'.ui.page.dashboard.view'));
    }
}
