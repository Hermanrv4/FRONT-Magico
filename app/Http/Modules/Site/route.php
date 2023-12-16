<?php

use App\Http\Common\Services\RouteService;
use Illuminate\Support\Facades\Route;

$lstRoutes = array_keys(RouteService::GetSiteRoute());
for($i=0;$i<count($lstRoutes);$i++){
    RouteService::GetSiteRoute($lstRoutes[$i]);
}

