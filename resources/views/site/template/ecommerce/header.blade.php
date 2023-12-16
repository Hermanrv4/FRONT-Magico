<?php

use Illuminate\Support\Facades\Session;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;
use App\Http\Common\Services\ParameterService;
use App\Http\Modules\Site\Services\HtmlService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.template.ecommerce.header.lang');
$lstCurrencies = ApiService::Request(config('env.app_group_site'), 'entity', 'currency-get', array())->response;
$lstLanguages = config('laravellocalization.supportedLocales');
$lstLangKeys = array_keys($lstLanguages);
$objUser=null;
$count_total = 0;

?>

<header class="header_area">
    <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between" style="background: #191919">

        <!-- Logo para la vista web -->
        <a class="nav-brand left_menu hidden-responsive" href="{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}">
            <img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage(ParameterService::GetParameter("logo_img"),'logos') }}" style="max-width: 150px" alt="">
        </a>
        <!-- Classy Menu -->
        <nav class="classy-navbar" id="essenceNav" style="">

            <!-- Navbar Toggler -->
            <div class="classy-navbar-toggler" onclick ="ManageMainNav()" style="margin-left: 5px">
                <span id="MagMain" class="navbarToggler"><span></span><span></span><span></span></span>
            </div>
            <!-- Menu -->
            <div id="main-mov" class="classy-menu menu_in_responsive" >
{{--                <!-- close btn -->--}}
{{--                <div class="classycloseIcon">--}}
{{--                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>--}}
{{--                </div>--}}
                <!-- Nav Start  108,176,122,84,130,96,130  CAJAS CHINAS-->
                <div id="main-nav-out" class="main-nav-out" onclick="CloseMainNav()"></div>
                <div  class="classynav |">
                      <ul class="sub_items">
                          {!! HtmlService::GetCategoriesHeader(null); !!}
                      </ul>
                    <hr class="responsive_hidden" style="width: 80%;margin-left: auto;margin-right: auto;">
                </div>
                <!-- Nav End -->
                <div style="display:none;width: 100%;height: 100%;" onclick="CloseMainNav()"></div>
            </div>
        </nav>

        <!-- Logo en menú responsive -->
        <a class="nav-brand responsive_hidden logo_responsive" href="{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}">
            <img width="100%" height="100%" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage(ParameterService::GetParameter("logo_img"),'logos') }}" alt="" style="max-width: 104px">
        </a>

        <div class="responsive_hidden options_in_menu">
            <div class="cart-area" style="display: inline-table;width: 32px;margin-left: -5px">
                <a style="left: 25%" href="{{App\Http\Common\Services\RouteService::GetSiteURL('cart')}}" id="essenceCartBtn"><strong style="opacity: 4;position: absolute;left: -10%;font-size: 15px;color: white;">{{($count_total==0)?"":$count_total}}</strong>
                    <img class="ext-icon" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('bag-2.png','icon') }}" alt="">
                </a>
            </div>

            <div class="dropdown" style="display: inline-block">
                <div class="cart-area" style="padding-right: 3%">
                    <a onclick="ShowInputToSearch()">
                        <img class="ext-icon" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('search2.svg','icon') }}" alt="">
                        <span class="caret"></span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Header Meta Data -->
        <div class="header-meta d-flex clearfix justify-content-end hidden-responsive right_menu">
            <!-- Cart Area -->
            <div class="cart-area" style="padding-right: 1%">
                <a href="{!! \App\Http\Common\Services\RouteService::GetSiteURL('cart') !!}" id="essenceCartBtn">
                    <?php
                    $value_total = $count_total."";
                    if($count_total==0){
                        $value_total = "";
                    }


                        $margin = "-30%";
                        $count_products = strlen($count_total."");
                        if($count_products == 2){
                            $margin = "-45%";
                        }
                        if($count_products == 3){
                            $margin = "-60%";
                        }
                    ?>
                    <strong id="count_current_cart" style="position: absolute;margin-left:{{$margin}};font-size: 16px;color:white">{{$value_total}}</strong>
                    <img  class="ext-icon" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('bag-2.png','icon') }}" alt="">
                </a>
            </div>

            <div class="dropdown" style="cursor: pointer; ">
                <div class="cart-area">
                    <a data-toggle="dropdown">
                        <img  class="ext-icon" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('search2.svg','icon') }}" alt="">
                        <span class="caret"></span>
                    </a>
                    <ul class="search_in_menu dropdown-menu">
                        {{-- <form method="get" action="#" onsubmit="return false;" style="z-index:9999999!important;">
                            <div class="input-group mb-3">
                                <input name="inpSearch" id="inpSearch" onkeypress="return FindText2(event);" type="text" class="form-control" placeholder="{!! trans($lang.'lbl_search') !!}" aria-label="" aria-describedby="basic-addon1">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button" onclick="SearchSubmit2()">Buscar</button>
                                </div>
                            </div>
                        </form> --}}

                        <form method="get" action="#" onsubmit="return false;" style="z-index:9999999!important;">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" id="inpSearch" autocomplete="off"
                                   style="font-size: 13px !important;" placeholder="Buscar" onkeyup="((event.keyCode === 13)? GoToSearch() : false);">

                                   <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button" onclick="GoToSearch()">Buscar</button>
                                </div>
                                </div>
                        </form>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    var id_user="{{isset($objUser['id'])==false ? '' : $objUser['id']}}";
    function GoToSearch(){
        var search = $("#inpSearch").val();
        var url = "{!! \App\Http\Common\Services\RouteService::GetSiteURL('catalogue-search',['search'=>'SEARCH-VALUE-USER']) !!}";
        /*   */

        if(search===""  || search===" "||search==="  "|| search==="   "){
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
    function ShowInputToSearch() {
        if (contador===0){
            $("#input_to_search").css("display","block");
            setTimeout(function(){ document.getElementById("m_search").focus() }, 500);
            contador = 1;
        }else{
            $("#input_to_search").css("display","none");
            contador = 0;
        }
    }
</script>