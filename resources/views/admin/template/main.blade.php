<?php
use \App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\ApiService;
use App\Http\Modules\Admin\Services\HtmlService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.template.main.lang');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <meta name="name"                       content="{!! ParameterService::GetParameter("meta_name") !!}">
        <meta name="description"                content="{!! ParameterService::GetParameter("meta_description") !!}">
        <meta name="keywords"                   content="{!! ParameterService::GetParameter("meta_keywords") !!}">
        <meta name="author"                     content="{!! ParameterService::GetParameter("meta_author") !!}">
        <!-- Facebook Bot -->
        <meta property="og:site_name"           content="{!! ParameterService::GetParameter("og_site_name") !!}">
        <meta property="og:title"               content="{!! ParameterService::GetParameter("og_title") !!}">
        <meta property="og:type"                content="{!! ParameterService::GetParameter("og_type") !!}">
        <meta property="og:url"                 content="{!! ParameterService::GetParameter("og_url") !!}">
        <meta property="og:description"         content="{!! ParameterService::GetParameter("og_description") !!}">
        <meta property="og:locale"              content="{!! ParameterService::GetParameter("og_locale") !!}">
        <meta property="og:image"               content="{!! ParameterService::GetParameter("og_image") !!}">
        <meta property="og:image:alt"           content="{!! ParameterService::GetParameter("og_image_alt") !!}">
        <!-- End Facebook Bot -->

        @yield('metas','')
        <link rel="icon" href="{!! HtmlService::ParseImage(ParameterService::GetParameter("favicon_img")) !!}" type="image/x-icon">
        <link rel="shortcut icon" href="{!! HtmlService::ParseImage(ParameterService::GetParameter("favicon_img")) !!}" type="image/x-icon">
        <title>@yield('page_title')</title>
        <style>
            :root {
                --theme-default: {!! ParameterService::GetParameter("principal_color") !!};
                --app_loader: url({{asset("resources/assets/".$group."/img/ajax-loader.gif")}});
            }
        </style>
        <link rel="stylesheet" href="{{asset('resources/assets/'.$group.'/main/plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('resources/assets/'.$group.'/main/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        <link rel="stylesheet" href="{{asset('resources/assets/'.$group.'/main/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/css/adminlte.css")}}">
        <link rel="stylesheet" href="{{asset("resources/assets/".$group."/own/css/app.css")}}">
        <link rel="stylesheet" href="{{asset("resources/assets/".$group."/extra/sweetalert2/css/sweetalert2.min.css")}}">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
        @yield('top_scripts')
    </head>
    <body class="hold-transition sidebar-mini text-sm">
        <div class="wrapper">
            @include(config($group.'.ui.template.main.header.view'))
            @include(config($group.'.ui.template.main.menu.view'))
            <div class="content-wrapper">
                @yield('body')
            </div>
            @include(config($group.'.ui.template.main.footer.view'))
        </div>
        <script src="{{asset("resources/assets/".$group."/main/plugins/jquery/jquery.min.js")}}"></script>
        <script src="{{asset('resources/assets/'.$group.'/main/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{asset("resources/assets/".$group."/own/js/loadimage.js")}}"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>        
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script> $.widget.bridge('uibutton', $.ui.button) </script>
        <script src="{{asset("resources/assets/".$group."/main/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
        <script src="{{asset('resources/assets/'.$group.'/main/plugins/sparklines/sparkline.js')}}"></script>
        <script src="{{asset('resources/assets/'.$group.'/main/plugins/moment/moment.min.js')}}"></script>
        <script src="{{asset('resources/assets/'.$group.'/main/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{asset('resources/assets/'.$group.'/main/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <script src="{{asset("resources/assets/".$group."/main/js/adminlte.js")}}"></script>
        <script src="{{asset("resources/assets/".$group."/own/js/app.js")}}"></script>
        <script src="{{asset("resources/assets/".$group."/extra/sweetalert2/js/sweetalert2.all.min.js")}}"></script>
        @yield('bottom_scripts')
        <script>
            
            var CSRF_TOKEN;
            $(window).on('load', function () {
                
                CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                function DocumentReady(){
                }
            });
        </script>
    </body>
</html>
