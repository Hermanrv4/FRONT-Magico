<?php
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Admin\Services\HtmlService;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.template.main.menu.lang');

$urlDashboard = RouteService::GetAdminURL('dashboard');
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-company">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{!! HtmlService::ParseImage(ParameterService::GetParameter("logo_img"),'storage/app/loaded/img/logos') !!}" style="width:25px!important;height: auto!important;" class="img-circle elevation-2" alt="{!! ParameterService::GetParameter("og_site_name") !!}">
            </div>
            <div class="info">
                <a href="#" class="d-block"><b>{!! ParameterService::GetParameter("og_site_name") !!}</b></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                {!! \App\Http\Modules\Admin\Services\HtmlService::GetMenuOptions($lang) !!}
            </ul>
        </nav>
    </div>
</aside>
