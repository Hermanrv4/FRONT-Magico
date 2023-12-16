<?php

use App\Http\Common\Services\RouteService;

$lstRoutes = array_keys(RouteService::GetAdminRoute());
for($i=0;$i<count($lstRoutes);$i++){
    RouteService::GetAdminRoute($lstRoutes[$i]);
}
