<?php
$group = config('env.app_group_admin');
$lang = config($group.'.ui.template.main.header.lang');
?>
<nav class="main-header navbar navbar-expand navbar-dark navbar-company text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <a href="{!! \App\Http\Common\Services\RouteService::GetAdminURL('dashboard') !!}" class="nav-link">{!! trans($lang.'title') !!}</a>
        </li>
        
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="{!! \App\Http\Common\Services\RouteService::GetAdminURL('login-logauth') !!}" class="nav-link ml-auto">Cerrar sesion</a>
        </li>
    </ul>
</nav>
