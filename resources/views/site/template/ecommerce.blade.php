<?php
use \App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\HtmlService;

$group = config('env.app_group_site');
$tracing = config('env.app_group_admin');
$lang = config($group.'.ui.template.ecommerce.lang');
$newsletter_id = 'cmpNewsLetter';

$mail_bussines = ParameterService::GetParameter("business_email");
$phone_bussines = ParameterService::GetParameter("business_phone");

/* $msg_discount_offer = json_decode(ParameterService::GetParameter("msg_discount_offer"),true); */
// LANDING
$msg_discount_offer = json_decode(ParameterService::GetParameter("msg_discount_offer2"),true);
$msg_discount_offer = json_decode(ParameterService::GetParameter("msg_discount_offer3"),true);

$msg_discount_offer = $msg_discount_offer['LANDING'];
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <!-- -->
        @yield('metas') <!-- <title>MÁGICO -page_title</title> -->
        <!-- -->
        <meta name="name"                       content="{!! ParameterService::GetParameter('meta_name') !!}">
        <meta name="keywords"                   content="{!! ParameterService::GetParameter('meta_keywords') !!}">
        <meta name="author"                     content="{!! ParameterService::GetParameter('meta_author') !!}">
        <!-- Facebook Bot -->
        <meta property="og:site_name"           content="{!! ParameterService::GetParameter('og_site_name') !!}">
        <meta property="og:title"               content="{!! ParameterService::GetParameter('og_title') !!}">
        <meta property="og:type"                content="{!! ParameterService::GetParameter('og_type') !!}">
        <meta property="og:url"                 content="{!! ParameterService::GetParameter('og_url') !!}">
        <meta property="og:description"         content="{!! ParameterService::GetParameter('og_description') !!}">
        <meta property="og:locale"              content="{!! ParameterService::GetParameter('og_locale') !!}">
        <meta property="og:image"               content="{!! HtmlService::ParseImage(ParameterService::GetParameter('og_image'),'banners') !!}">
        <meta property="og:image:secure_url"    content="{!! HtmlService::ParseImage(ParameterService::GetParameter('og_image_secure_url'),'banners') !!}">
        <meta property="og:image:alt"           content="{!! ParameterService::GetParameter('og_image_alt') !!}">
        <meta property="og:secure:alt"          content="{!! ParameterService::GetParameter('og_secure_alt') !!}">
        <!-- End Facebook Bot -->
        <!-- Twitter Bot -->
        <meta name="twitter:title"              content="{!! ParameterService::GetParameter('twitter_title') !!}">
        <meta name="twitter:description"        content="{!! ParameterService::GetParameter('twitter_description') !!}">
        <meta name="twitter:image"              content="{!! HtmlService::ParseImage(ParameterService::GetParameter('twitter_image'),'banners') !!}">
        <meta name="twitter:card"               content="{!! ParameterService::GetParameter('twitter_card') !!}">
        <meta name="twitter:url"                content="{!! ParameterService::GetParameter('twitter_url') !!}">
        <meta name="twitter:image:alt"          content="{!! ParameterService::GetParameter('twitter_image_alt') !!}">

        <style>
            :root {
                --theme-default: {!! ParameterService::GetParameter("principal_color") !!};
                --app_loader: url({{asset("resources/assets/".$group."/ecommerce/images/ajax-loader.gif")}});
            }
        </style>
        <style>

            :root {
                --app_default_color: #191919;
                --app_loading_url: url({{asset("resources/assets/".$group."/ecommerce/cs/img/basic/loading.svg")}});
            }

            @font-face {
                font-family: WesternBangBang;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Western-Bang-Bang.ttf")}});
            }
            @font-face {
                font-family: CustomAppFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Roboto-Light.ttf")}});
            }
            @font-face {
                font-family: CustomAppFontBold;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Roboto-Bold.ttf")}});
            }
            @font-face {
                font-family: CustomAppFontBlack;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Roboto-Black.ttf")}});
            }
            @font-face {
                font-family: CustomSecondFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/AbrilFatface-Regular.ttf")}});
            }
            @font-face {
                font-family: CustomThirdFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Jonah-Regular.ttf")}});
            }
            @font-face {
                font-family: CustomFourthFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Hellotropica_Demo.ttf")}});
            }
            @font-face {
                font-family: CustomFifthFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Marbre_Sans.otf")}});
            }
            @font-face {
                font-family: CustomSexthFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Billybond.ttf")}});
            }
            @font-face {
                font-family: CustomSeventhFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/Roboto-Regular.ttf")}});
            }
            @font-face {
                font-family: CustomEighthFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/impact.ttf")}});
            }
            @font-face {
                font-family: CustomNinethFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/BebasNeue-Regular.ttf")}});
            }
            @font-face {
                font-family: CustomTenFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/DINNextLTPro-LightCondensed.ttf")}});
            }
            @font-face {
                font-family: CustomElevenFont;
                src: url({{asset("resources/assets/".$group."/ecommerce/fonts/DINNextLTPro-BoldCondensed.otf")}});
            }
            *:not(.fa) {
                font-family: CustomAppFont
            }
            body{
                margin: 0px!important;
            }
            .classy-navbar{
                margin-left: 0%!important;
            }
            .swal2-error{
                border-color:red!important;
                color:red!important;
            }
            .swal2-icon.swal2-error{
                border-color:red!important;
                color:red!important;
            }
            .error-text{
                display: none;
                text-align: left!important;
            }
            .header_area .classynav ul li a{
                text-transform: uppercase;
            }
            .item-menu-1 {
                color:#F3E9E9!important;
                font-size:14px!important;
                width:122px!important;
            }
            .item-menu-2 {
                color:#F3E9E9!important;
                font-size:14px!important;
                width:189px!important;
            }
            .item-menu-3 {
                color:#F3E9E9!important;
                font-size:14px!important;
                width:136px!important;
            }
            .item-menu-4 {
                color:#F3E9E9!important;
                font-size:14px!important;
                width:98px!important;
            }
            .item-menu-5 {
                color:#F3E9E9!important;
                font-size:14px!important;
                width:145px!important;
            }
            .item-menu-6 {
                color:#F3E9E9!important;
                font-size:14px!important;
                width:110px!important;
            }
            .item-menu-7 {
                color:#F3E9E9!important;
                font-size:14px!important;
                width:130px!important;
            }
            .item-menu-8 {
                color:red!important;
                font-size:16px!important;
                width:120px!important;
            }

            .menu-normal{
                display:block!important;
            }
            .menu-responsive{
                display:none!important;
            }

            @media screen and (max-width: 992px)   {
                .menu-normal{
                    display:none!important;
                }
                .menu-responsive{
                    display:block!important;
                }
            }

            .footer-social{
                padding-left: 10px!important;
                padding-right: 15px!important;
                margin-top: 9px!important;
            }

            .text-modal-span{
                font-size: 22px!important;
            }

            .footer_tittles{
                color: #b6b4b4!important;
                font-family: CustomTenFont!important;
                font-size: 16px!important;
            }
            .footer_tittles:hover{
                font-family: CustomTenFont!important;
                color: #b6b4b4!important;
                font-size: 19px!important;
            }
            .main-nav-out{
                display:none;
                position: fixed!important;
                width: 400%!important;
                height: 200%!important;
            }


            .title_section {
                color: black!important;
                font-weight: 700;
                font-family: CustomElevenFont!important;
                font-size: 55px;
                line-height: .91667;
            }

            .mod-contact{
                height: 80vmin!important;
            }

            #scrollUp{
                position: fixed!important;
                z-index: 2147483647!important;
                display:block!important;
            }

            .email_recept{
                padding-bottom: 3px!important;
            }
            .header_area .classy-navbar {
                height: 85px!important;
                padding: 5px 0 5px 5%!important; }
            /*---Footer---*/

            @media (min-width: 320px) and (max-width: 767px)  {

                .h-desktop{
                    display: none!important;
                }
                .h-movile{
                    display: block!important;
                }
                #help-contact{
                     margin-top: 30px!important;
                }
                .text-center-x{
                    text-align: left!important;
                }
                .single_widget_area{
                    margin-top: -9px!important;

                }
            }

            .input-contact {
                padding-left: 15px!important;
                padding-right: 15px!important;
                padding-top: -1px!important;
            }

            @media only screen and (min-width: 200px) and (max-width: 759px)  {


                .order-details-confirmation{
                    padding-right: 32px!important;
                    padding-left: 35px!important;
                }
                .modal-text-1 {
                    font-size: 25px!important;
                }
                .mod-contact{
                    height: 136vmin!important;
                }
                .footer-social{
                    margin-top: 24px!important;
                }
                .email_recept{
                    padding-bottom: 4%!important;
                }
                .h-desktop{
                    display: none!important;
                }
                .h-movile{
                    display: block!important;
                }
                .title_section {
                    font-weight: 500!important;
                    font-size: 30px!important;

                }
                .text-center-x{
                    text-align: left!important;
                }
                .input-contact {
                    padding-left: 15px!important;
                    padding-right: 15px!important;
                    margin-top: 1px!important;
                }
            }
            @media only screen and (min-width: 763px) and (max-width: 769px)  {

                .order-details-confirmation{
                    padding-right: 32px!important;
                    padding-left: 35px!important;
                }
                .modal-text-1 {
                    font-size: 25px!important;
                }
                .mod-contact{
                    height: 100vmin!important;
                    padding-right: 7%!important;
                    padding-left: 7%!important;
                }
                .footer-social{
                    margin-top: 24px!important;
                }
                .email_recept{
                    padding-bottom: 4%!important;
                }
                .h-desktop{
                    display: none!important;
                }
                .h-movile{
                    display: block!important;
                }
                .title_section {
                    font-weight: 500!important;
                    font-size: 30px!important;

                }
                .text-center-x{
                    text-align: left!important;
                }
                .input-contact {
                    padding-left: 15px!important;
                    padding-right: 15px!important;
                    margin-top: 1px!important;
                }
            }
            @media only screen and (min-width: 771px) and (max-width: 991px)  {

                .mod-contact{

                }
                .order-details-confirmation{
                    padding-right: 32px!important;
                    padding-left: 35px!important;
                }
                .modal-text-1 {
                    font-size: 25px!important;
                }
                .footer-social{
                    margin-top: 24px!important;
                }
                .email_recept{
                    padding-bottom: 4%!important;
                }
                .h-desktop{
                    display: none!important;
                }
                .h-movile{
                    display: block!important;
                }
                .title_section {
                    font-weight: 500!important;
                    font-size: 30px!important;

                }
                .text-center-x{
                    text-align: left;
                }
                .input-contact {
                    padding-left: 15px!important;
                    padding-right: 15px!important;
                    margin-top: 1px!important;
                }
            }

            @media only screen and (min-width: 1200px) and (max-width: 1280px) {
                .header_area .classy-navbar{
                    padding:5px 0 5px 0;
                }
                .classy-navbar{
                    margin-left: -4%!important;
                }
                .item-menu-1 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:105px!important;
                }
                .item-menu-2 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:170px!important;
                }
                .item-menu-3 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:118px!important;
                }
                .item-menu-4 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:80px!important;
                }
                .item-menu-5 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:125px!important;
                }
                .item-menu-6 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:95px!important;
                }
                .item-menu-7 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:122px!important;
                }
                .item-menu-8 {
                    color:red!important;
                    font-size:16px!important;
                    width:auto!important;
                }
            }

            @media only screen and (min-width: 1281px) and (max-width: 1290px) {
                .header_area .classy-navbar{
                    padding:5px 0 5px 0;
                }
                .classy-navbar{
                    margin-left: -7%!important;
                }
                .item-menu-1 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:105px!important;
                }
                .item-menu-2 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:170px!important;
                }
                .item-menu-3 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:118px!important;
                }
                .item-menu-4 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:80px!important;
                }
                .item-menu-5 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:125px!important;
                }
                .item-menu-6 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:95px!important;
                }
                .item-menu-7 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:122px!important;
                }
                .item-menu-8 {
                    color:red!important;
                    font-size:16px!important;
                    width:auto!important;
                }
            }
            @media only screen and (min-width: 1291px) and (max-width: 1364px){
                .header_area .classy-navbar {
                    padding: 5px 0px 5px 2%; }
                .classy-navbar{
                    margin-left: -5%!important;
                }
                .item-menu-1 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:105px!important;
                }
                .item-menu-2 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:170px!important;
                }
                .item-menu-3 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:118px!important;
                }
                .item-menu-4 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:80px!important;
                }
                .item-menu-5 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:125px!important;
                }
                .item-menu-6 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:95px!important;
                }
                .item-menu-7 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:122px!important;
                }
                .item-menu-8 {
                    color:red!important;
                    font-size:16px!important;
                    width:auto!important;
                }
            }

            @media only screen and (min-width: 1365px) and (max-width: 1450px){
                .classy-navbar{
                    margin-left: -5%!important;
                }
                .item-menu-1 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:118px!important;
                }
                .item-menu-1 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:108px!important;
                }
                .item-menu-2 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:173px!important;
                }
                .item-menu-3 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:121px!important;
                }
                .item-menu-4 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:84px!important;
                }
                .item-menu-5 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:128px!important;
                }
                .item-menu-6 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:98px!important;
                }
                .item-menu-7 {
                    color:#F3E9E9!important;
                    font-size:14px!important;
                    width:125px!important;
                }
                .item-menu-8 {
                    color:red!important;
                    font-size:16px!important;
                    width:auto!important;
                }

            }


            .btn-out:focus{
                outline: none!important;
            }

            .text-center-x{
                text-align: left!important;
            }

            .title_font{
                font-family: WesternBangBang!important;
                font-size: 70px!important;
            }

            .modal-text-1 {
                color: black;
                font-weight: 700!important;
                font-family: CustomElevenFont!important;
                font-size: 45px!important;
                line-height: .91667!important;

            }
            .modal-btn-solid{
                margin-top: 5%;
                border-radius:unset;
                padding: 13px 29px;
                color: #ffffff!important;
                letter-spacing: 0.05em!important;
                background-image: linear-gradient(30deg, red 50%, transparent 50%);
                background-size: 850px!important;
                background-repeat: no-repeat;
                background-position: 0;
                -webkit-transition: background 300ms ease-in-out;
                transition: background 300ms ease-in-out; }

            .mini-btn-solid{
                border-radius:unset!important;
                padding: 13px 29px!important;
                color: #ffffff!important;
                letter-spacing: 0.05em!important;
                background-image: linear-gradient(30deg, red 50%, transparent 50%);
                background-size: 850px!important;
                background-repeat: no-repeat;
                background-position: 0;
                -webkit-transition: background 300ms ease-in-out;
                transition: background 300ms ease-in-out; }


            .mini-btn-solid:hover {
                color: #FFFFFF!important;
                background-color: #191919!important; }

            .modal-btn-solid:hover {
                color: #FFFFFF!important;
                background-color: #191919!important; }

            .float{
                position:fixed!important;
                width:50px!important;
                height:50px!important;
                bottom:40px!important;
                right:40px!important;
                background-color:#25d366!important;
                color:#FFF!important;
                border-radius:50px!important;
                text-align:center!important;
                font-size:30px!important;
                box-shadow: 2px 2px 3px #9!important;
                z-index:100!important;
            }
            .my-float{
                margin-top:10px!important;
            }
            .float:hover {
                font-size: 32px!important;
                color: white!important;
            }

            .content-legacy{
                padding: 0px 0px 10px 0px!important;
                text-align: left!important;
            }
            .body-legacy{
                margin: 0!important;
                font-size: 11px!important;
            }
            .a-legacy{
                text-decoration: underline!important;color:black!important;font-weight: 200;font-size: 10px!important;
            }
        </style>
        <style>
            .header_area .favourite-area a img, .header_area .user-login-info a img, .header_area .cart-area a img{
                position: relative;
                top: 27px;
            }
            @media (min-width: 1200px) and (max-width: 1280px){
                .header_area .favourite-area a img, .header_area .user-login-info a img, .header_area .cart-area a img{
                    position: relative;
                }
            }
            @media (min-width: 768px) and (max-width: 990px){
                .header_area .favourite-area a img, .header_area .user-login-info a img, .header_area .cart-area a img{
                    position: initial!important;
                    top: 0px!important;
                }
            }
            @media only screen and (max-width: 767px){
                 .header_area .favourite-area a, .header_area .user-login-info a, .header_area .cart-area a {
                    line-height: 25px!important;
                }
                .header_area .classy-navbar {
                    height: 65px!important;
                }
                .header_area .favourite-area a img, .header_area .user-login-info a img, .header_area .cart-area a img{
                    position: initial!important;
                    top: 27px;
                }
            }
            @media (min-width: 501px) and (max-width: 600px){
                .logo_responsive > img {
                    height: unset!important;
                    margin-left: 21px;
                }
            }
        </style>
        <style>
            .cookie-section {
                z-index: 999;
                position: fixed;
                bottom: 30px;
                left: 30px;
                background: #fff;
                max-width: 255px;
                text-align: center;
                padding: 10px;
            }
        </style>
    <link rel="apple-touch-icon" sizes="57x57"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-57x57.png")}}'>
    <link rel="apple-touch-icon" sizes="60x60"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-60x60.png")}}'>
    <link rel="apple-touch-icon" sizes="72x72"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-72x72.png")}}'>
    <link rel="apple-touch-icon" sizes="76x76"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-76x76.png")}}'>
    <link rel="apple-touch-icon" sizes="114x114"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-114x114.png")}}'>
    <link rel="apple-touch-icon" sizes="120x120"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-120x120.png")}}'>
    <link rel="apple-touch-icon" sizes="144x144"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-144x144.png")}}'>
    <link rel="apple-touch-icon" sizes="152x152"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-152x152.png")}}'>
    <link rel="apple-touch-icon" sizes="180x180"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/apple-icon-180x180.png")}}'>
    <link rel="icon" type="image/png" sizes="192x192"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/android-icon-192x192.png")}}'>
    <link rel="icon" type="image/png" sizes="32x32"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/favicon-32x32.png")}}'>
    <link rel="icon" type="image/png" sizes="96x96"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/favicon-96x96.png")}}'>
    <link rel="icon" type="image/png" sizes="16x16"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/favicon-16x16.png")}}'>
    <link rel="manifest"
          href='{{asset("resources/assets/".$group."/ecommerce/images/favicon/manifest.json")}}'>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage"
          content='{{asset("resources/assets/".$group."/ecommerce/images/favicon/ms-icon-144x144.png")}}'>
    <meta name="theme-color" content="#ffffff">
        <!-- CSS -->
        <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1052434691856115');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1052434691856115&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

        <!-- STYLE VIEW -->
         <!-- jQuery (Necessary for All JavaScript Plugins) -->
         <script src='{{asset("resources/assets/".$group."/ecommerce/js/jquery/jquery-2.2.4.min.js")}}'></script>
         <!-- Popper js -->
         <script src='{{asset("resources/assets/".$group."/ecommerce/js/popper.min.js")}}'></script>
         <!-- Bootstrap js -->
         <script src='{{asset("resources/assets/".$group."/ecommerce/js/bootstrap.min.js")}}'></script>
         <script src="https://unpkg.com/swiper/swiper-bundle.min.js">   </script>
         <!-- Plugins js -->
        @yield('top_scripts')
        <!-- FONTS -->
        <link rel="stylesheet" type="text/css" href='{{asset("resources/assets/".$group."/ecommerce/css/core-style.css")}}'>
        <link rel="stylesheet" type="text/css" href='{{asset("resources/assets/".$group."/ecommerce/css/style.css")}}'>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    </head>
    <a href="https://api.whatsapp.com/send?phone=51995565065&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20M%C3%A1gico." class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
    <body>
        <script>
            var page_content=null;
            var action=null;
            var section_content=null;
            var object_prod=null;
        </script>
        <div class="dv-loading-full" id="dvLoadingFull" style="z-index:9999999!important;display: none!important;">
            <span class="span-loading-full-text" id="spLoadingMessage"></span>
        </div>
        <div id="page">
            <!-- loader start -->
            @include(config('site.ui.template.ecommerce.skeleton_loader.view'))
            <!-- loader end -->
            <!-- header start -->
            @include(config('site.ui.template.ecommerce.header.view'))
            <!-- header end -->
            <!-- Body slider -->
            @yield('body')
            <!-- Body slider end-->
            <!-- footer -->
            @include(config('site.ui.template.ecommerce.footer.view'))
            <!-- footer end -->
        </div>
{{--  ANTIGUO DESCUENTO ANTIGUO DESCUENTO
		@if($msg_discount_offer['active']==1)
        <div class="cookie-section" id="msg-discount-landing" style="padding: 1%;display: block;background: red;">
	        <span style="color: white;">{!! $msg_discount_offer['text'] !!}<span style="
            text-decoration: underline;
            font-weight: bold;
            color: white;">{!! $msg_discount_offer['code'] !!}</span>!
            </span>
        </div>
		@endif
 --}}



        <!--modal popup start-->
        <?php /*
        @include(config('site.ui.component.newsletter.view'),array("container_id"=>$newsletter_id))
         */ ?>
        <!--modal popup end-->
        <div id="mySidenav" class="sidenav" style="display: none;z-index: 999999;width: 100%;position: fixed">
            <div class="navmenu-res-l" style="" onclick="closeNav()">
            </div>
            <div class="navmenu-res-r" style="right: 0;background-color: white;height: 100%;">
                <div style="text-align: end">
                    <a href="javascript:void(0)" class="" style="padding: 8px 8px;" onclick="closeNav()">&times;</a>
                </div>
                <div style="padding: 5%;height: 90vh;overflow: scroll;" id="navresponsive">
                    {!! HtmlService::GetCategoriesHeaderResponsive(null); !!}
                </div>
            </div>
        </div>
        <!-- Quick-view modal popup start-->
        <div id="dvPreview"></div>
        <!-- Quick-view modal popup end-->
        <div class="header_floating clearfix" id="input_to_search" style="display: none;opacity: 0.9">
            <div class="container">
                <div class="row text-center">
                    <!-- Single Widget Area -->
                    <div class="col-12 col-md-12">
                        <div class="shipping-contact checkout-contact">
                            <form method="get" action="#" onsubmit="return false;" style="z-index:9999999!important;">
                                <div class="input-group mb-3">
                                    <input name="m_search" id="m_search" onkeypress="return FindText(event);" type="text" class="form-control" placeholder="{!! trans($lang.'lbl_search') !!}" aria-label="" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" onclick="SearchSubmit()">Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  MODAL POP UP  -->
        <!-- Modal CORPORATIVO-->
        <div id="modalCorporative" class="modal hidden" tabindex="-1" role="dialog" aria-labelledby="ModalCorporative" aria-hidden="true" style="background:rgba(25,25,25,0.9);">
            <div class="modal-dialog modal-dialog-centered" role="document" style="">
                <div class="modal-content mod-contact" ><!--170vmin -->
                    <div style="position: fixed;top: 0px;left: 0px;width: 10000px;height: 10000px;" onclick="CloseContacCorporative()"></div>
                    <div class="modal-header" style="margin-left: 4%">
                        <button type="button" class="close" data-dismiss="modal" onclick="CloseContacCorporative()">&times;</button><br>
                    </div>
                    <div class="modal-body modal-background" style=" padding-bottom:1em;padding-right: 1em;padding-left: 1em;height:auto;width: auto; overflow-y: auto;">

                        <div style="text-align: center;margin-top:5%">
                            <p class="modal-text-1">{!! trans($lang.'lbl_pedido_corporativo_2') !!}</p>
                        </div>
                        <div style="background: white;padding:3px;" class="container-fluid" >
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;padding-left: 7%;padding-right: 7%;">
                                    <div style="text-align: center">
                                        <span class="text-modal-span">{{trans($lang.'lbl_pedido_corporativo_3')}}</span>
                                    </div>
                                </div>
                                <div class="col-md-12" style="text-align: center;padding: 7%">
                                    <div>
                                        <div >
                                            <!-- text input -->
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_names')}}:</label>
                                                <input id="name_corporative" type="text" class="form-control" placeholder="" onKeypress="return CheckInput(event)"  name="name_corporative" >
                                                <label class="error-text" id="error_name_corporative"></label>
                                            </div>
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_last_names')}}:</label>
                                                <input id="last_corporative" type="text" class="form-control" placeholder=""  onKeypress="return CheckInput(event)"  name="last_corporative" >
                                                <label class="error-text" id="error_last_corporative"></label>
                                            </div>
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_mail')}}:</label>
                                                <input id="mail_corporative" type="email" class="form-control" placeholder="" name="mail_corporative" >
                                                <label class="error-text" id="error_mail_corporative"></label>
                                            </div>
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_bussines')}}:</label>
                                                <input id="empresa_corporative" type="text" class="form-control" placeholder=""  name="empresa_corporative" >
                                                <label class="error-text" id="error_empresa_corporative"></label>
                                            </div>
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_phone')}}:</label>
                                                <input id="telefono_corporative" type="email" class="form-control" placeholder=""  onKeypress="return CheckNumberInput(event)"  name="telefono_corporative" >
                                                <label class="error-text" id="error_telefono_corporative"></label>
                                            </div>
                                            <!-- textarea -->
                                            <div class="form-group" style="margin-bottom:5%">
                                                <label style="display: table-cell;">{{trans($lang.'lbl_contact_inp_message')}}:</label>
                                                <textarea id="mensaje_corporative" class="form-control" rows="3" placeholder=""  onKeypress="return CheckInput(event)"  name="mensaje_corporative" ></textarea>
                                                <label class="error-text" id="error_mensaje_corporative"></label>
                                            </div>
                                            <div class="content-legacy">
                                                <p class="body-legacy">{!!trans($lang.'lbl_suscribe_plh_legacy')!!}
                                                    <a class="a-legacy" href="{{RouteService::GetSiteURL('info-politics-terms')}}">{!!trans($lang.'lbl_client_atention_terms')!!}</a>,
                                                    <a class="a-legacy" href="{{RouteService::GetSiteURL('info-politics-privacity')}}">{!!trans($lang.'lbl_client_atention_privacity')!!}</a>,
                                                    <a class="a-legacy" href="{{RouteService::GetSiteURL('info-politics-cookies')}}">{!!trans($lang.'lbl_client_atention_polity_cookies')!!}</a>,
                                                    <a class="a-legacy" href="{{RouteService::GetSiteURL('info-politics-tratament')}}">{!!trans($lang.'lbl_client_atention_dates_tratament')!!}</a>.
                                                </p>
                                            </div>
                                            <div style="margin-bottom:3%">

                                                <label class="label" style="color:black!important;">{!! $mail_bussines !!}</label><br>
                                                <label class="label" style="color:black!important;">{!! trans($lang.'lbl_contact_inp_phone') !!}: {!! $phone_bussines !!}</label>
                                                <br/>
                                                <button type="submit" style="margin-top: 4%" onclick="PedidoCorporativo()" class="btn btn-solid mini-btn-solid hvr-shrink" id="mcon-submit">{!!trans($lang.'lbl_btn_send')!!}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ##### MODAL CORPORATIVO AL FIN ##### -->
        <!-- Modal Contact-->
        <div id="modalContact" class="modal hidden" tabindex="-1" role="dialog" aria-labelledby="ModalContact" aria-hidden="true" style="background:rgba(25,25,25,0.9);">
            <div class="modal-dialog modal-dialog-centered" role="document" style="">
                <div class="modal-content mod-contact" ><!--170vmin -->
                    <div style="position: fixed;top: 0px;left: 0px;width: 10000px;height: 10000px;" onclick="CloseContactForm()"></div>
                    <div class="modal-header" style="margin-left: 3%">

                        <button type="button" class="close" data-dismiss="modal" onclick="CloseContactForm()">&times;</button><br>
                    </div>
                   <div class="modal-body modal-background" style=" padding-bottom:1em;padding-right: 1em;padding-left: 1em;height:auto;width: auto; overflow-y: auto;">

                        <div style="text-align: center;margin-top:5%">
                            <p class="modal-text-1">{!! trans($lang.'lbl_contact_title') !!}</p>
                        </div>
                        <div style="background: white;padding:3px;" class="container-fluid" >
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;padding-left: 7%;padding-right: 7%;">
                                    <div style="text-align: center">
                                        <span class="text-modal-span">{{trans($lang.'lbl_pedido_corporativo_3')}}</span>
                                    </div>
                                </div>
                                <div class="col-md-12" style="text-align: center;padding: 7%">
                                    <div>
                                        <div>
                                            <!-- text input -->
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_names')}}:</label>
                                                <input id="name_contact" onKeypress="return CheckInput(event)"  name="name_contact"  type="text" class="form-control" placeholder="">
                                                <label class="error-text" id="error_name_contact"></label>
                                            </div>
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_last_names')}}:</label>
                                                <input id="last_contact" onKeypress="return CheckInput(event)"  name="last_contact" type="text" class="form-control" placeholder="">
                                                <label class="error-text" id="error_last_contact"></label>
                                            </div>
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_mail')}}:</label>
                                                <input id="mail_contact" type="email" class="form-control" placeholder="">
                                                <label class="error-text" id="error_mail_contact"></label>
                                            </div>
                                            <div class="form-group" style="margin-bottom:3%">
                                                <label style="display: table-cell">{{trans($lang.'lbl_contact_inp_phone')}}:</label>
                                                <input id="telefono_contact" onKeypress="return CheckNumberInput(event)"
                                                       maxlength="9" name="telefono_contact" type="text" class="form-control" placeholder="">
                                                <label class="error-text" id="error_telefono_contact"></label>
                                            </div>
                                            <!-- textarea -->
                                            <div class="form-group" style="margin-bottom:5%">
                                                <label style="display: table-cell;">{{trans($lang.'lbl_contact_inp_message')}}:</label>
                                                <textarea id="mensaje_contact" class="form-control" rows="3" placeholder=""></textarea>
                                                <label class="error-text" id="error_mensaje_contact"></label>
                                            </div>

                                            <div class="content-legacy">
                                                <p class="body-legacy">{!!trans($lang.'lbl_suscribe_plh_legacy')!!}
                                                    <a class="a-legacy" href="{{RouteService::GetSiteURL('info-politics-terms')}}">{!!trans($lang.'lbl_client_atention_terms')!!}</a>,
                                                    <a class="a-legacy" href="{{RouteService::GetSiteURL('info-politics-privacity')}}">{!!trans($lang.'lbl_client_atention_privacity')!!}</a>,
                                                    <a class="a-legacy" href="{{RouteService::GetSiteURL('info-politics-cookies')}}">{!!trans($lang.'lbl_client_atention_polity_cookies')!!}</a>,
                                                    <a class="a-legacy" href="{{RouteService::GetSiteURL('info-politics-tratament')}}">{!!trans($lang.'lbl_client_atention_dates_tratament')!!}</a>.
                                                </p>
                                            </div>
                                            <div style="margin-bottom:3%">
                                                <label class="label" style="color:black!important;">{!! $mail_bussines !!}</label><br>
                                                <label class="label" style="color:black!important;">{!! trans($lang.'lbl_contact_inp_phone') !!}: {!! $phone_bussines !!}</label>
                                                <br/>
                                                <button type="submit" style="margin-top: 4%" onclick="ContacUsSend()" class="btn btn-solid mini-btn-solid hvr-shrink" id="mcon-submit">{!!trans($lang.'lbl_btn_send')!!}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  FIN MODAL POP UP  -->
        <script src='{{asset("resources/assets/".$group."/ecommerce/js/plugins.js")}}'></script>
        <!-- Classy Nav js -->
        <script src='{{asset("resources/assets/".$group."/ecommerce/js/classy-nav.min.js")}}'></script>
        <!-- Active js -->
        <script src="https://kit.fontawesome.com/99fa133a01.js" crossorigin="anonymous"></script>
        <script src='{{asset("resources/assets/".$group."/ecommerce/js/active.js")}}'></script>
        <script src='{{asset("resources/assets/".$group."/ecommerce/cs/js/sweetalert2-v2.all.js")}}'></script>
        <script src='{{asset("resources/assets/".$group."/ecommerce/cs/js/myscript.js")}}'></script>

        <script src="{{asset("resources/assets/".$group."/ecommerce/js/card.js")}}" type="text/javascript"></script>
        <script src="{{asset("resources/assets/".$group."/ecommerce/js/jquery.card.js")}}" type="text/javascript"></script>
        <!------------------------------------------------------------------------------------------------------------------------->

        <div class="fb-customerchat"
            page_id="94767902014"
            theme_color="#000000"
            greeting_dialog_display="fade"
            logged_in_greeting="Hola,¿En qué podemos ayudarte?" logged_out_greeting="Hola,¿En qué podemos ayudarte?">
        </div>
        <script>
            var contador = 0;
            $(window).on('load', function () {
                CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                UpdateQuantity()
                DocumentReady();
                $("#my_header .top_info .container .menu_toggler").css("display", "none");
                action="load";
                object="show";
                page_content = (page_content==null) ? 'home' : page_content;
                saveTracing($("title").html(), object, action, page_content, window.location.href, id_user, "{{Session::has(config('env.app_auth_site_session_id'))}}", null);
            });

            $(document).on("click", 'div.jcarousel ul li div.tovar_img.center div.open-project-link a.open-project.tovar_view', function(){
                objsend=(new String($(this).attr('onclick')).replace("OpenPreview('", '')).replace("');", '');
                object_prod=objsend;
                let is_detected=detected(objsend, 'SendAddToCart');
                let addCard=(new String($(this).siblings().attr('onclick')).replace("OpenPreview('", '')).replace("');", '');
                action="click";
                if(is_detected==true){
                    //add
                    objsend=addCard;
                }
                object=(is_detected==false ? "preview": 'addCard');
                page_content=(page_content==null ? 'home': page_content);
                saveTracing($("title").html(), object, action, page_content, window.location.href , id_user, "{{Session::has(config('env.app_auth_site_session_id'))}}", objsend);
            });

            $(document).on("click", 'div.tovar_img div.tovar_item_btns div.open-project-link a.open-project.tovar_view', function(){
                objsend=(new String($(this).attr('onclick')).replace("OpenPreview('", '')).replace("');", '');
                object_prod=objsend;
                let is_detected=detected(objsend, 'SendAddToCart');
                let addCard=(new String($(this).siblings().attr('onclick')).replace("OpenPreview('", '')).replace("');", '');
                action="click";
                if(is_detected==true){
                    //add
                    objsend=addCard;
                }
                object=(is_detected==false ? "preview": 'addCard');
                page_content=(page_content==null ? 'home': page_content);
                saveTracing($("title").html(), object, action, page_content, window.location.href , id_user, "{{Session::has(config('env.app_auth_site_session_id'))}}", objsend);
            });

            $(document).on("click", 'div.tovar_view_description.col-md-6 div.tovar_view_btn.center a.add_bag', function(){
                action="click";
                saveTracing($("title").html(), 'addCard', action, page_content, window.location.href , id_user, "{{Session::has(config('env.app_auth_site_session_id'))}}", objsend);
            });

            var dragging = false;
            var mps = null;
            $("body").on("mousedown", function(e) {
                var x = e.screenX;
                var y = e.screenY;
                dragging = false;
                $("body").on("mousemove", function(e) {
                    if (Math.abs(x - e.screenX) > 5 || Math.abs(y - e.screenY) > 5) {
                        dragging = true;
                    }
                });
            });
            $(window).scroll(function () {
                var sticky = $('#my_header'),
                    scroll = $(window).scrollTop();

                if (scroll >= 40) sticky.addClass('fixed');
                else sticky.removeClass('fixed');
            });
            function openNav() {
                document.getElementById("mySidenav").style.display = "";
            }
            $('.dropdown').on("click", function(e){
                setTimeout(function(){ document.getElementById("inpSearch").focus() }, 500);
            });
            function closeNav() {
                document.getElementById("mySidenav").style.display = "none";
            }
            function ViewByLink(link){
                location.href=link;
            }
            function OpenPreview(url_code){
                ShowFullLoading();
                var timeout = 0;
                if($("#quick-view").hasClass('show')){
                    $('#quick-view').modal('hide');
                    timeout=100;
                }
                setTimeout(
                    function() {
                        $("#dvPreview").html("");
                        @component(config($group.'.ui.component.engine.ajax.view'))
                        @slot('internal_request',true)
                        @slot('app_group',$group)
                        @slot('route','product-preview')
                        @slot('parameters',
                            "url_code: url_code"
                        )
                        @slot('result_success')
                        $("#dvPreview").append(response);
                        $("#quick-view").modal('show');
                        setTimeout(function(){
                            $('#prevSlider').flexslider({
                                animation: "slide",
                                animationLoop: true,
                                slideshowSpeed: 3500,
                                directionNav: false,
                                drag:true,
                                touch: true,
                                mousewheel:true,
                                prevText: "",
                                nextText: "",
                                controlNav: "thumbnails",
                            });
                        }, 200);

                        @endslot
                        @endcomponent
                    }
                , timeout);
                return false;
            }
            function SendAddToCart(product_id,qty_id,replace){
                ShowFullLoading();
                var qty = $("#"+qty_id).val();
                if(Number.isInteger(parseInt(qty,10))==true) {
                    AddToCart(product_id, parseInt(qty,10), replace,false);
                }else{
                    ShowErrorMessage("{!! trans($lang.'lbl_invalid_qty') !!}");
                     HideFullLoading();
                }
                return false;
            }
            function AddToCart(product_id,qty,replace,reload){
                ShowFullLoading();
                @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('internal_request',true)
                @slot('app_group',$group)
                @slot('route','cart-add')
                @slot('parameters',
                    "product_id:product_id,
                    qty:qty,
                    replace:(replace?1:0),
                    observations: null"
                )
                @slot('result_success')
                if(qty>0){
                    ShowMessageAddItem('success',
                            "{!! trans($lang.'success_tit_add_product_to_cart_list') !!}",
                            '<br><a href="{!! \App\Http\Common\Services\RouteService::GetSiteURL('cart') !!}"><button class="btn btn-success" style="border-color: #ED1D2D;background: #ED1D2D;"><b>IR AL CARRITO</b></button></a></div>');
                        $('#count_current_cart').text(response);
                }else{
                    location.reload();
                    //ShowSuccessMessage("{!! trans($lang.'lbl_title_success_rmv_to_cart') !!}","{!! trans($lang.'lbl_description_success_rmv_to_cart') !!}")
                }
                if(reload)location.reload();
                @endslot
                @slot('ajax_complete')
                HideFullLoading();
                @endslot
                @endcomponent
            }

            function LoadSlider(type,id_ref,id_location){
                @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('internal_request',true)
                @slot('app_group',$group)
                @slot('route','slider-view')
                @slot('parameters',"
                            'type': type,'id_ref': id_ref"
                        )
                @slot('result_success')
                $("#"+id_location).html("");
                $("#"+id_location).html(response);
                @endslot
                @slot('ajax_complete')
                $('.popular-products-slides').owlCarousel({
                    loop:true,
                    autoplay: true,
                    margin:10,
                    nav:true,
                    responsive:{
                        0:{
                            items:1,
                            dots:false
                        },
                        600:{
                            items:3,
                            dots:false
                        },
                        1000:{
                            items:5,
                            dots: true
                        }
                    },
                    navText: ["<i class='fa fa-chevron-left' style='font-size: 30px;position:absolute;top:17%;left:0%;color:red'></i>",
                                        "<i class='fa fa-chevron-right' style='font-size: 30px;position:absolute;top:17%;right:0%;color:red'></i>"]
                });
                HideFullLoading();
                @endslot
                @endcomponent
            }

        </script>
        @yield('bottom_scripts')
        <script>
            function saveTracing(page_title, object, action, value, section, id_user, is_valid, sendobj=null){
                console.log("tracing");
            }
            function detected(obj, valuedetected){
                if(obj.includes(valuedetected)){
                    return true;
                }else{
                    return false;
                }
            }
        </script>
        <script>
            $('.dropdown').on("click", function(e){
        setTimeout(function(){ document.getElementById("inpSearch").focus() }, 500);
    });

    function SendEmailContact(){
        var mail=$('#mail');
    }
    function IsEmail(email) {
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    function OpenContactForm() {
        $("#modalContact").show();
    }
    function CloseContactForm() {
        $('#modalContact').animate({opacity: 0}, 400, function () {
            $('#modalContact').hide();
            $('#modalContact').css('opacity', '1');
        });
        return false;
    }
    function CloseContacCorporative() {
        $('#modalCorporative').animate({opacity: 0}, 400, function () {
            $('#modalCorporative').hide();
            $('#modalCorporative').css('opacity', '1');
        });
        return false;
    }
    function ContacUs(){
        $("#modalContact").show();
    }

    function ContacCorporative(){
        $('#modalCorporative').css('display:block');
        $("#modalCorporative").show();
    }
    function CheckInput(){

        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }

    }

    function CheckNumberInput(){
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }

    function PedidoCorporativo(){

        let name = (document.getElementById('name_corporative').value).trim();
        let apellidos = (document.getElementById('last_corporative').value).trim();
        let correo = (document.getElementById('mail_corporative').value).trim();
        let empresa = (document.getElementById('empresa_corporative').value).trim();
        let telefono = (document.getElementById('telefono_corporative').value).trim();
        let mensaje = (document.getElementById('mensaje_corporative').value).trim();

            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',true)
            @slot('app_group',$group)
            @slot('route','customer-send-contact-mail')
            @slot('parameters',
                "name_:name,
                last_name_:apellidos,
                mail_:correo,
                phone_:telefono,
                is_company:1,
                name_company_:empresa,
                message_:mensaje,"
            )
            @slot('result_success')
                document.getElementById('name_corporative').value= '';
                document.getElementById('last_corporative').value= '';
                document.getElementById('mail_corporative').value= '';
                document.getElementById('empresa_corporative').value= '';
                document.getElementById('telefono_corporative').value= '';
                document.getElementById('mensaje_corporative').value= '';
            $('#modalCorporative').hide();
            ShowSuccessMessage();
            @endslot
            @slot('result_error')
            Swal.fire(
                'Campos incorrectos',
                'Complete los campos correctamente',
                'warning'
            )
            if(name==""){
                $("#name_corporative").addClass("error-field");
                $("#error_name_corporative").css("display","block");
                $("#error_name_corporative").text("{!! trans($lang.'lbl_error_contact_us_name') !!}");
            }
            if(apellidos==""){
                $("#last_corporative").addClass("error-field");
                $("#error_last_corporative").css("display","block");
                $("#error_last_corporative").text("{!! trans($lang.'lbl_error_contact_us_last') !!}");
            }
            if(correo=="" || correo.includes('@')==false){
                $("#mail_corporative").addClass("error-field");
                $("#error_mail_corporative").css("display","block");
                $("#error_mail_corporative").text("{!! trans($lang.'lbl_error_contact_us_mail') !!}");
            }
            if(empresa==""){
                $("#empresa_corporative").addClass("error-field");
                $("#error_empresa_corporative").css("display","block");
                $("#error_empresa_corporative").text("{!! trans($lang.'lbl_error_corporative_us_enterprise') !!}");
            }
            if(telefono=="" || telefono.length<6 || telefono.length>9){
                $("#telefono_corporative").addClass("error-field");
                $("#error_telefono_corporative").css("display","block");
                let msg_telefono = "{!! trans($lang.'lbl_error_contact_us_phone') !!}";
                msg_telefono = msg_telefono.replace(":min", 6);
                msg_telefono = msg_telefono.replace(":max", 9);
                $("#error_telefono_corporative").text(msg_telefono);
            }
            if(mensaje==""){
                $("#mensaje_corporative").addClass("error-field");
                $("#error_mensaje_corporative").css("display","block");
                $("#error_mensaje_corporative").text("{!! trans($lang.'lbl_error_contact_us_message') !!}");
            }
            @endslot
            @slot('ajax_complete')
            HideFullLoading();
            @endslot
            @endcomponent


    }
    function ContacUsSend(){

        let name = (document.getElementById('name_contact').value).trim();
        let apellidos = (document.getElementById('last_contact').value).trim();
        let correo = (document.getElementById('mail_contact').value).trim();
        let telefono = (document.getElementById('telefono_contact').value).trim();
        let mensaje = (document.getElementById('mensaje_contact').value).trim();

            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',true)
            @slot('app_group',$group)
            @slot('route','customer-send-contact-mail')
            @slot('parameters',
                "name_:name,
                last_name_:apellidos,
                mail_:correo,
                phone_:telefono,
                message_:mensaje,"
            )
            @slot('result_success')
            document.getElementById('name_contact').value= '';
            document.getElementById('last_contact').value= '';
            document.getElementById('mail_contact').value= '';
            document.getElementById('telefono_contact').value= '';
            document.getElementById('mensaje_contact').value= '';
            $('#modalContact').hide();

            ShowSuccessMessage();
            @endslot
            @slot('result_error')
            Swal.fire(
            '{!! trans($lang.'has_been_problem') !!}',
            '{!! trans($lang.'incomplete_form') !!}',
            'warning'
            )

            if(name==""){
                $("#name_contact").addClass("error-field");
                $("#error_name_contact").css("display","block");
                $("#error_name_contact").text("{!! trans($lang.'lbl_error_contact_us_name') !!}");
            }
            if(apellidos==""){
                $("#last_contact").addClass("error-field");
                $("#error_last_contact").css("display","block");
                $("#error_last_contact").text("{!! trans($lang.'lbl_error_contact_us_last') !!}");
            }
            if(correo=="" || correo.includes('@')==false){
                $("#mail_contact").addClass("error-field");
                $("#error_mail_contact").css("display","block");
                $("#error_mail_contact").text("{!! trans($lang.'lbl_error_contact_us_mail') !!}");
            }
            if(telefono=="" || telefono.length<6 || telefono.length>9){
                $("#telefono_contact").addClass("error-field");
                $("#error_telefono_contact").css("display","block");
                let msg_telefono = "{!! trans($lang.'lbl_error_contact_us_phone') !!}";
                msg_telefono = msg_telefono.replace(":min", 6);
                msg_telefono = msg_telefono.replace(":max", 9);
                $("#error_telefono_contact").text(msg_telefono);
            }
            if(mensaje==""){
                $("#mensaje_contact").addClass("error-field");
                $("#error_mensaje_contact").css("display","block");
                $("#error_mensaje_contact").text("{!! trans($lang.'lbl_error_contact_us_message') !!}");
            }
            @endslot
            @slot('ajax_complete')
            HideFullLoading();
            @endslot
            @endcomponent
    }

    function FindText(event) {

        let regex = new RegExp("^[a-zA-Z0-9 ]+$");
        let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

        if (event.keyCode === 13) {
            let value2 = $("#m_search").val();
            let url = "{!! \App\Http\Common\Services\RouteService::GetSiteURL('catalogue-search',['search'=>'SEARCH_VALUE']) !!}";
            url = url.replace("SEARCH_VALUE", value2);
            window.location.href = url;
            return false;
        }
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
    function SearchSubmit() {
        let value = $("#m_search").val();
        let texto = value.trim();

        if(texto!="" && texto != "." && texto != "*" && texto != "-" && texto!="/" && texto!=""){
            let url = "{!! \App\Http\Common\Services\RouteService::GetSiteURL('catalogue-search',['search'=>'SEARCH_VALUE']) !!}";
            url = url.replace("SEARCH_VALUE", texto);
            window.location.href = url;
        }

    }
    function SearchSubmit2() {
        let value2 = $("#inpSearch").val();
        let text = value2.trim();
        if(text!="" && text !="."){
            let url = "{!! \App\Http\Common\Services\RouteService::GetSiteURL('catalogue-search',['search'=>'SEARCH_VALUE']) !!}";
            url = url.replace("SEARCH_VALUE", text);
            window.location.href = url;
        }


    }

    function ManageMainNav(){
        var main=$("#MagMain").hasClass("active");

        if(main==false){//Open
            $("#main-nav-out").css("display", "block");
        }else{//Close
            $("#main-nav-out").css("display", "none");
        }
    }

    function CloseMainNav(){

        $("#main-mov").removeClass("menu-on");
        $("#MagMain").removeClass("active");
        $("#main-nav-out").css("display", "none");

    }

    function FindText2(event) {

        let regex = new RegExp("^[a-zA-Z0-9 ]+$");
        let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

        if (event.keyCode === 13) {
            let value2 = $("#inpSearch").val();

            let url = "{!! \App\Http\Common\Services\RouteService::GetSiteURL('catalogue-search',['search'=>'SEARCH_VALUE']) !!}";
            url = url.replace("SEARCH_VALUE", value2);
            window.location.href = url;
            return false;
        }
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }

    }
    function ShowInputToSearch() {
        if (contador===0){
            $("#input_to_search").css("display","block");
            setTimeout(function(){ document.getElementById("inpSearch").focus() }, 500);
            contador = 1;
        }else{
            $("#input_to_search").css("display","none");
            contador = 0;
        }
    }
    function SendContactForm() {
        let error = false;
        let name = $("#inpName").val();
        let mail = $("#inpMail").val();
        let phone = $("#inpPhone").val();
        let message = $("#inpMessage").val();

        $("#inpName").removeClass("error-field");
        $("#inpMail").removeClass("error-field");
        $("#inpPhone").removeClass("error-field");
        $("#inpMessage").removeClass("error-field");

        $(".error-text").css('display', 'none');
        $(".error-text").text("");

        if (name == "" || phone.length <7 || phone.length > 12) {
            $("#inpName").addClass("error-field");
            $("#lblErrorName").text("{!! trans($lang.'lbl_error_contact_name',["min"=>5,"max"=>100]) !!}");
            $("#lblErrorName").css('display', 'block');
            error = true;
        }
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (mail == "" || !regex.test(mail)) {
            $("#inpMail").addClass("error-field");
            $("#lblErrorMail").text("{!! trans($lang.'lbl_error_contact_mail') !!}");
            $("#lblErrorMail").css('display', 'block');
            error = true;
        }
        var rgx = /[^0-9]/;
        if (phone == "" || phone.length < 7 || phone.length > 15 || phone.search(rgx) !== -1) {
            $("#inpPhone").addClass("error-field");
            $("#lblErrorPhone").text("{!! trans($lang.'lbl_error_contact_phone',["min"=>7,"max"=>15]) !!}");
            $("#lblErrorPhone").css('display', 'block');
            error = true;
        }
        if (message == "" || message.length < 10 || message.length > 5000) {
            $("#inpMessage").addClass("error-field");
            $("#lblErrorMessage").text("{!! trans($lang.'lbl_error_contact_message',["min"=>10,"max"=>5000]) !!}");
            $("#lblErrorMessage").css('display', 'block');
            error = true;
        }
        if (error) return;
        ShowFullLoading(null);
    }


    function ShareSocial(social, url, prod_name, prod_photo) {
        var share_url = "";
        switch (social) {
            case 'facebook':
                share_url = "https://www.facebook.com/sharer/sharer.php?u=" + url;
                break;
            case 'googleplus':
                share_url = "https://plus.google.com/share?url=" + url;
                break;
            case 'pinterest':
                share_url = "http://pinterest.com/pin/create/button/?url=" + url + "&media=" + prod_photo + "&description=" + prod_name;
                break;
            case 'twitter':
                share_url = "https://twitter.com/intent/tweet?url=" + url + "&text=" + prod_name;
                break;
            case 'linkedin':
                share_url = "http://www.linkedin.com/shareArticle?mini=true&url=" + url + "&title=" + prod_name;
                break;
            case 'tumblr':
                share_url = "http://www.tumblr.com/share?v=3&u=" + url + "&t=" + prod_name;
                break;
        }
        window.open(share_url, '_blank');
    }

    function ChangeCurrency() {
        location.href = $("#selCurrency").val();
    }

    /*************************************************************************************************************************/
    /*************************************************************************************************************************/
    function AddProductToCart(product_variant_id, sel_quantity_id) {

        if ($('#' + sel_quantity_id).val() !== "") {

        } else {
            ShowErrorMessage("{{trans($lang.'lbl_not_quantity_selected')}}");
        }
    }

    function CloseSwalAddItem() {
        swal.close();
        setTimeout(function(){ location.reload(); }, 100);
    }

    function UpdateQuantity(){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('internal_request',true)
        @slot('app_group',$group)
        @slot('route','cart-qty')
        @slot('parameters',"")
        @slot('result_success')
        $('#count_current_cart').text(response);
        @endslot
        @slot('ajax_complete')
        HideFullLoading();
        @endslot
        @endcomponent
    }

    function AddToFavorites(product_variant_id) {
        ShowFullLoading(null);
    }

    /*************************************************************************************************************************/
    /*************************************************************************************************************************/
    function ShowFullLoading(message) {
        if (message == null) {
            $("#spLoadingMessage").html();
        } else {
            $("#spLoadingMessage").html(message);
        }
        $("#dvLoadingFull").show();
    }

    function ShowFullLoadingV2(message) {
        if (message == null) {
            $("#spLoadingMessage").html();
        } else {
            $("#spLoadingMessage").html(message);
        }
        $("#dvLoadingFull").show();
    }

    function HideFullLoading() {
        $("#spLoadingMessage").html('');
        $("#dvLoadingFull").hide();
    }

    function HideFullLoadingV2() {
        $("#spLoadingMessage").html('');
        $("#dvLoadingFull").hide();
    }

    /*************************************************************************************************************************/
    /*************************************************************************************************************************/
    function ShowCustomMessage(type, title, message) {
        swal({
            type: type,
            title: title,
            html: message,
            timer: 6000
        });
    }

    function ShowMessageAddItem(type, title, message) {

        Swal.fire({
            type: type,
            title: title,
            html: message,
            showConfirmButton: true,
            confirmButtonText: "Seguir comprando"
            // timer: 6000
        }).then((result) => {
            setTimeout(function(){ location.reload(); }, 100);
        })

    }

    function ShowSuccessMessage(customMessage) {
        swal({
            type: 'success',
            title: '{!! trans($lang.'success_message_title') !!}',
            html: (customMessage == null ? '{!! trans($lang.'success_message_description') !!}' : customMessage),
            timer: 3000
        });
    }

    function ShowSuccessMessageWithReload(customMessage) {
        swal({
            type: 'success',
            title: '{!! trans($lang.'success_message_title') !!}; ?>',
            html: (customMessage == null ? '{!! trans($lang.'success_message_description') !!}; ?>' : customMessage),
            timer: 3000
        }).then(function (result) {
            if (result.dismiss === swal.DismissReason.timer) {
            }
            location.reload();
        });
    }

    function ShowErrorMessage(customMessage) {
        swal({
            type: 'error',
            title: '{!! trans($lang.'error_message_title') !!}',
            html: (customMessage == null ? '{!! trans($lang.'error_message_description') !!}' : customMessage),
            timer: 3000
        });
    }

    /*************************************************************************************************************************/
    /*************************************************************************************************************************/
    function ViewVariant(url_code, in_popup) {

        if (in_popup) {
            $('#tovar_content').html("");
            OpenPreview("url_component_product_preview/" + url_code);
        } else {

            OpenURL("url_general_view_product/" + url_code);
        }
    }

    function OpenPreview(url) {

        $("#modalPreviewBody").html();

        $("#modalPreview").show();
        $("#modalPreviewBody").load(url, function (e) {
            LoadProductPreview(null);
            $("#modalPreviewBody").show(2000, function () {

            });
        });
    }

    function LoadProductPreview(id) {
        $('#carousel1').flexslider({
            animation: "slide",
            controlNav: false,
            directionNav: true,
            animationLoop: false,
            slideshow: false,
            direction: "vertical",
            asNavFor: '#slider1'
        });
        $('#slider1').flexslider({
            animation: "fade",
            controlNav: false,
            directionNav: true,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel1"
        });
        $("#ulslides").height("100%");
        jQuery('#carousel1 .slides li').click(function () {
            $('#carousel1 .slides li').removeClass('flex-active-slide');
            $(this).addClass('flex-active-slide');
            return false;
        });
        $('.basic').fancySelect();
        InitSliderGallery(id);
    }

    function ClosePreview() {
        $('#modalPreview').animate({opacity: 0}, 400, function () {
            $('#modalPreview').hide();
            $('#modalPreview').css('opacity', '1');
        });
        return false;
    }

    function InitSliderGallery(id) {
        if (id == null) id = "";
        var sWidth = $("#sb" + id).width();
        var len = $("#sb" + id + " .silder_panel").length;
        var index = 0;
        var picTimer;

        // create button
        var btn = "<a class='prev'></a><a class='next'></a>";
        $("#sb" + id).append(btn);

        // create navbar pictures
        for (var i = 0; i < len; i++) {
            $imgUrl = $("#sb" + id + " .silder_panel").eq(i).find("img").attr("src");
            // console.log($imgUrl)
            $navItem = '<div class="silder_nav_item"><img src="' + $imgUrl + '"></div>';
            $("#sb" + id + " .silder_nav").append($navItem);
        }

        // re-arrange slides
        $("#sb" + id + " .silder_con").css({
            "width": sWidth * (len + 2),
            "left": -sWidth
        });
        $("#sb" + id + " .silder_panel").eq(0).clone().appendTo($("#sb" + id + " .silder_con"));
        $("#sb" + id + " .silder_panel").eq(len - 1).clone().prependTo($("#sb" + id + " .silder_con"));

        // hover
        $("#sb" + id + " .silder_nav .silder_nav_item").mouseenter(function () {
            index = $("#sb" + id + " .silder_nav .silder_nav_item").index(this);
            showPics(index);
        }).eq(0).trigger("mouseenter");

        // Prev
        $("#sb" + id + " .prev").click(function () {
            index -= 1;
            showPics(index);
            // console.log(index);
            if (index == -1) {
                index = len - 1;
            }
        });

        // Next
        $("#sb" + id + " .next").click(function () {
            index += 1;
            showPics(index);
            // console.log(index);
            if (index >= len) {
                index = 0;
            }
        });

        // autoplay
        /*$("#sb"+id).hover(function () {
            clearInterval(picTimer);
        }, function () {
            // console.log("Start")
            showPics(index);
            /*picTimer = setInterval(function () {
                $("#sb"+id+" .next").trigger("click");
            }, 4000);*
        }).trigger("mouseleave");*/

        // showPics
        function showPics(index) {
            // position
            var nowLeft = -(index + 1) * sWidth;
            if (nowLeft == 0) {
                $("#sb" + id + " .silder_con").stop(true, false).animate({
                    "left": nowLeft
                }, 300, function () {
                    $("#sb" + id + " .silder_con").stop(true, false).css("left", -sWidth * len);
                });
            } else if (nowLeft == -(len + 1) * sWidth) {
                $("#sb" + id + " .silder_con").stop(true, false).animate({
                    "left": nowLeft
                }, 300, function () {
                    $("#sb" + id + " .silder_con").stop(true, false).css("left", -sWidth);
                });
            } else {
                $("#sb" + id + " .silder_con").stop(true, false).animate({
                    "left": nowLeft
                }, 300);
            }
            if (index == -1) {
                index = len - 1;
            }
            if (index >= len) {
                index = 0;
            }
            // nav
            $("#sb" + id + " silder_nav .silder_nav_item").stop(true, false).animate({
                "opacity": "0.6"
            }, 300).eq(index).stop(true, false).animate({
                "opacity": "1"
            }, 300);
            $("#sb" + id + " silder_nav .silder_nav_item").removeClass("current");
            $("#sb" + id + " silder_nav .silder_nav_item").eq(index).addClass("current");
        }
    }

</script>
<!------------------------------------------------------------------------------------------------------------------------->
<script>
	function AddSuscriber(correo=null,info_suscr){
        let email ="";
        if(correo==null){
            email = document.getElementById('mail_sus').value;
        }else{
            email = correo;
        }
		if(email!="" && email.includes('@')!=false){
             @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('internal_request',true)
                @slot('app_group',$group)
                @slot('route','customer-send-suscriber-mail')
                @slot('parameters',
                    "email_sus:email,
                    info_suscriber:info_suscr"
                )
                @slot('result_success')
                if(response==true){
                    Swal.fire(
                        '{!! trans($lang.'success_sus_title') !!}',
                        '{!! trans($lang.'successfull_sucribe') !!}',
                            'success'
                        )
                        $('#start_modal').modal('hide');
                }else{
                    Swal.fire(
                    '{!! trans($lang.'has_been_problem') !!}',
                    '{!! trans($lang.'already_suscribe') !!}',
                    'warning'
                    )
                }
                @endslot
                @slot('ajax_complete')
                HideFullLoading();
                @endslot
                @endcomponent
		}else{
            Swal.fire(
                'Oops',
                '{!! trans($lang.'invalid_mail') !!}',
                'error'
            )
		}

	}
        </script>
    </body>
</html>
