<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteAdminServiceProvider extends ServiceProvider {
    public function boot(){
        parent::boot();
    }
    public function map(){
        $this->mapRoutes();
    }
    protected function mapRoutes(){
        Route::namespace('App\Http\Modules\Admin\Controllers')->group(base_path('app/Http/Modules/Admin/route.php'));
    }
}
