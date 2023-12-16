<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use Illuminate\Support\Facades\Artisan;

class GeneralController extends BaseAdminController {
    public function Clear(){
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        //Artisan::call('view:cache');
        Artisan::call('route:clear');
        Artisan::call('route:list');
        return dd(Artisan::output());
    }
    public function Migrate(){
        Artisan::call("migrate");
        Artisan::call("db:seed");
        return dd(Artisan::output());
    }
}
