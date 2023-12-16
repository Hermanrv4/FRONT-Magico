<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteSiteServiceProvider extends ServiceProvider {
    public function boot(){
        parent::boot();
    }
    public function map(){
        $this->mapRoutes();
    }
    protected function mapRoutes(){
        Route::namespace('App\Http\Modules\Site\Controllers')->group(base_path('app/Http/Modules/Site/route.php'));
    }
}
