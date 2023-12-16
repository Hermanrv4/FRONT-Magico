<?php

use Illuminate\Support\Facades\Session;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;
use App\Http\Common\Services\ParameterService;
use App\Http\Modules\Site\Services\HtmlService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.template.marketplace.header.lang');
$lstCurrencies = ApiService::Request(config('env.app_group_site'), 'entity', 'currency-get', array())->response;
$lstLanguages = config('laravellocalization.supportedLocales');
$lstLangKeys = array_keys($lstLanguages);
?>
<header class="header-tools marketplace">
    <div class="mobile-fix-option"></div>
    <div class="top-header">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header-contact">
                        <ul>
                            <li>{!! ParameterService::GetParameter('business_name') !!}</li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i><a style="color: white!important;" target="_blank" href="https://wa.me/{!! \App\Http\Common\Services\ParameterService::GetParameter('sn_whatsapp_num') !!}">{!! trans($lang.'lbl_call_us') !!}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 text-right">
                    <ul class="header-dropdown">
                        <li class="onhover-dropdown mobile-account">
                            <!--
                            if(Session::has(config('env.app_auth_site_session_id')))
                                php $objUser = Session::get(config('env.app_auth_site_session_id'))["user"]; ?>
                                <i class="fas fa-user" aria-hidden="true"></i> {!! $objUser["first_name"] !!}
                                <ul class="onhover-show-div">
                                    <li><a href="{!! \App\Http\Common\Services\RouteService::GetSiteURL('logout') !!}">{!! trans($lang.'lbl_logout') !!}</a></li>
                                </ul>
                            else
                                <i class="fas fa-user" aria-hidden="true"></i><a href="{!! \App\Http\Common\Services\RouteService::GetSiteURL('login') !!}"> {!! trans($lang.'lbl_login') !!}</a>
                            endif
                            -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid custom-container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo">
                            <!--
                            <a  href="{!! RouteService::GetSiteURL('landing') !!}"><img style="height: 75px;width: auto;" src="{!! HtmlService::ParseImage(ParameterService::GetParameter('logo_img')) !!}" class="img-fluid blur-up lazyload" alt=""></a>
                            -->
                        </div>
                    </div>
                    <div class="menu-right pull-right">
                        <div>
                            <nav id="main-nav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                    <li>
                                        <div class="mobile-back text-right">{!! trans($lang.'lbl_menu_back') !!}</i></div>
                                    </li>
                                    {!! HtmlService::GetCategoriesHeader(null) !!}
                                </ul>
                            </nav>
                        </div>
                        <div>
                            <div class="icon-nav">
                                <ul>
                                    <li class="onhover-div mobile-search">
                                        <div><img src="{{asset("resources/assets/".$group."/marketplace/img/icon/search.png")}}" onclick="OpenSearch()" class="img-fluid blur-up lazyload" alt=""> <i class="ti-search" onclick="OpenSearch()"></i></div>
                                        <div id="search-overlay" class="search-overlay">
                                            <div> <span class="closebtn" onclick="CloseSearch()" title="Close Overlay">×</span>
                                                <div class="overlay-content">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <form>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" id="inpSearch" placeholder="Ingrese un texto a buscar." onkeyup="((event.keyCode === 13)? GoToSearch() : false);">
                                                                    </div>
                                                                    <button type="button" class="btn btn-primary" onclick="GoToSearch();"><i class="fa fa-search"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="onhover-div mobile-cart" onclick="location.href='{!! \App\Http\Common\Services\RouteService::GetSiteURL('cart') !!}'" >
                                        <div><img src="{{asset("resources/assets/".$group."/marketplace/img/icon/cart.png")}}" onclick="location.href='{!! \App\Http\Common\Services\RouteService::GetSiteURL('cart') !!}'" class="img-fluid blur-up lazyload" alt=""> <i class="ti-shopping-cart"></i></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    function GoToSearch(){
        var search = $("#inpSearch").val();
        var url = "{!! \App\Http\Common\Services\RouteService::GetSiteURL('catalogue-search',["search"=>"SEARCH-VALUE-USER"]) !!}";
        if(search===""){
            ShowErrorMessage("Debe ingresar un texto a buscar.");
        }else{
            location.href =  url.replace("SEARCH-VALUE-USER", search);
            ShowSuccessMessage("Por favor, espere mientras se realiza la búsqueda.");
        }
        return false;
    }
    function OpenSearch() {
        document.getElementById("search-overlay").style.display = "block";
    }
    function CloseSearch() {
        document.getElementById("search-overlay").style.display = "none";
    }
</script>