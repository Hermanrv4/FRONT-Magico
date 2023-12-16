<?php
use App\Http\Common\Services\ParameterService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.ecommerce.landing.lang');
$lstBanners = json_decode(ParameterService::GetParameter("banners"),true);
$lstCards = json_decode(ParameterService::GetParameter("cards"),true);
$lstVideos = json_decode(ParameterService::GetParameter("videos"),true);


//INITIAL MESSAGE
$msgStartModal = ParameterService::GetParameter("MESSAGE_INITIAL_MODAL");
$tittStartModal = ParameterService::GetParameter("TITTLE_INITIAL_MODAL");

$showModal = ParameterService::GetParameter("view_initial_modal");

?>
@extends(config($group.'.ui.template.ecommerce.view'))
@section('page_title',trans($lang.'page_title'))
@section('metas')
<title>{{trans($lang.'title_default')}}</title>
<meta name="description" content="{{trans($lang.'description_default')}}"/>
@endsection
@section('top_scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <link rel="stylesheet" href='{{asset("resources/assets/".$group."/ecommerce/css/ekko-lightbox.css")}}'>
    <link rel="stylesheet" href='{{asset("resources/assets/".$group."/ecommerce/css/gallery-grid.css")}}'>
    <link rel="stylesheet" href='{{asset("resources/assets/".$group."/ecommerce/css/hover.css")}}'>
    <link rel="stylesheet" type='text/css' href='{{asset("resources/assets/".$group."/ecommerce/css/instagram_home.css")}}'>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/> 
    <style>
        .ekko-lightbox .modal-dialog .modal-content{
            border: 0px solid rgba(0,0,0,.2)!important;
        }
        .ekko-lightbox .modal-dialog{
            height: max-content!important;
        }
        .line_name{
            font-size: 20px!important;
        }
        .cards_home{
            padding: 0;
            min-width: 100px!important;
        }
        .socios-div{
            font-size:20px!important;
        }
        .swiper-banner{
            bottom: 10px!important;
        }
        @media (max-width: 991px)  {
            .socios-div{
                font-size:16px!important;
            }
            .swiper-banner{
                /*bottom: -5px!important;*/
            }
        }


        @media (min-width: 992px){
            .padding-5{
                padding-right: 10px!important;
                padding-left: 10px!important;
                padding-top: 10px!important;
                padding-bottom: 10px!important;
            }
        }

    </style>
    <link rel="stylesheet" type="text/css" href='{{asset("resources/assets/".$group."/ecommerce/css/swiper.css")}}'>
    <style>
        .desktop_banner{
            display:block!important;
        }

        .mobile_banner{
            display:none!important;
        }

        .swiper-button-next:after, .swiper-button-prev:after{
            display: none!important;
        }

        .modal-header-2 {
            border: 0!important;
            padding: 0!important;
            position: relative!important;
        }
        .modal-header-2 .close {
            margin: 0!important;
            position: absolute!important;
            top: -10px!important;
            right: -10px!important;
            width: 23px!important;
            height: 23px!important;
            border-radius: 23px!important;
            background-color: red!important;
            color: white!important;
            font-size: 9px!important;
            opacity: 1!important;
            z-index: 10!important;
        }


    </style>
    <style>
        .btn-ver-productos{
            background:red!important;
            color:white!important;
            font-family:CustomElevenFont!important;
            border:none!important;
            padding-top: 7%!important;
            padding-bottom:7%!important;
            padding-left:9%!important;
            padding-right:9%!important;
            font-size:150%!important;
            line-height:34px!important;
        }
        .btn-ver-ofertas{
        color:white;font-family:CustomElevenFont;border:none;padding-top: 10%;padding-bottom: 7%;padding-left: 15%;padding-right: 15%;font-size:150%;line-height:34px;
        }



        .close-video{
            font-size: 250%;cursor: pointer;position: absolute;color: white;top: 24%;right: 30%;opacity:4;
        }

        @media only screen and (max-width: 991px) {

            .desktop_banner{
                display:none!important;
            }

            .mobile_banner{
                display:block!important;
            }


            .close-video{
                top: 30%!important;
                right: 2%!important;
            }

            .btn-ver-productos{
                width:200px;
                font-size:80%!important;
                line-height: 34px!important;
                padding-top: 1%!important;
                padding-bottom:1%!important;
                padding-left:3%!important;
                padding-right:3%!important;
            }


            .btn-ver-ofertas{
                width:200px!important;
                background:red!important;
                font-size:80%!important;
                line-height: 34px!important;
                padding-top: 1%!important;
                padding-bottom:1%!important;
                padding-left:3%!important;
                padding-right:3%!important;
            }

            /*.btn-ver-ofertas{
                width:120px;
                background:red;
                font-size:80%;
                padding:0%;
                line-height: 25px;
            }*/
        }


        .popular-products-slides .owl-controls .owl-nav .owl-prev:hover{
            background: none;
        }
        .popular-products-slides .owl-controls .owl-nav .owl-prev{
            background: none;
        }
        .popular-products-slides .owl-controls .owl-nav .owl-next{
            background: none;
        }
        .popular-products-slides .owl-controls .owl-nav .owl-next:hover{
            background: none;
        }
        .tz-gallery{
            padding-left: 15%!important;
            padding-right: 15%!important;
        }

        #swiper_home{ 
            padding-top: 4%!important;
        }

        .modal-body{
            padding:0px!important;
        }

        .nopadd{
            padding: 0px!important;
            margin: 0px!important;
        }

        .padding-5{
            padding-right: 5px!important;
            padding-left: 5px!important;
            padding-top: 5px!important;
            padding-bottom: 5px!important;
        }

        .product-img{
            width: 80%!important;
            /*height: 80%!important;*/
            left: 10%!important;
        }

        .h-movile{
            display:none!important;
            background-color: #0e0e0e!important;
            color: #fdfdfd!important;
            text-align: center!important;
            padding-left:10px!important;
            padding-right: 10px!important;
        }

        .h-desktop{
            display:block!important;
            background-color: #0e0e0e!important;
            color: #fdfdfd!important;
            text-align: center!important;
            padding-left:10px!important;
            padding-right: 10px!important;
        }


        .swiper-button-style{
            background: rgba(0,0,0,0.2)!important;
            display:flex!important;
            align-items: center!important;
            padding: 7px!important;
            width: 3%!important;
            height: 7%!important;
        }

        .swiper-container {
            width: 100%!important;
            height: auto!important;
            padding-top:0px!important;
            margin-left: auto!important;
            margin-right: auto!important;
        }
        .swiper-slide {
            text-align: center!important;
            font-size: 18px!important;
            background: #fff!important;
            display: -webkit-box!important;
            display: -ms-flexbox!important;
            display: -webkit-flex!important;
            display: flex!important;
            -webkit-box-pack: center!important;
            -ms-flex-pack: center!important;
            -webkit-justify-content: center!important;
            justify-content: center!important;
            -webkit-box-align: center!important;
            -ms-flex-align: center!important;
            -webkit-align-items: center!important;
            align-items: center!important;
        }

        @media only screen and (max-width: 320px) {

            .tz-gallery{
                padding-left: 5%!important;
                padding-right: 5%!important;
            }

            .title_font{
                font-size: 30px!important;
            }
            #swiper_home{
                padding-top: 21%!important;
            }
        }

        @media only screen and (max-width: 360px) and (min-width: 321px) {
            .tz-gallery{
                padding-left: 5%!important;
                padding-right: 5%!important;
            }

            .title_font{
                font-size: 30px!important;
            }
        }

        @media only screen and (max-width: 320px) and (min-width: 300px){
            #swiper_home{
                padding-top: 20%!important;
            }
        }
        @media only screen and (max-width: 360px) and (min-width: 321px){
            #swiper_home{
                padding-top: 17%!important;
            }
        }
        @media only screen and (max-width: 411px) and (min-width: 361px) {
            .tz-gallery{
                padding-left: 5%!important;
                padding-right: 5%!important;
            }
            #swiper_home{
                padding-top: 15%!important;
            }

            .title_font{
                font-size: 30px!important;
            }
        }
        @media only screen and (max-width: 413px) and (min-width: 412px) {
            .tz-gallery{
                padding-left: 5%!important;
                padding-right: 5%!important;
            }
            #swiper_home{
                padding-top: 5%!important;
            }
            .title_font{
                font-size: 30px!important;
            }
        }
        @media only screen and (max-width: 415px) and (min-width: 414px) {
            .tz-gallery{
                padding-left: 5%!important;
                padding-right: 5%!important;
            }
            #swiper_home{
                padding-top: 15%!important;
            }
            .title_font{
                font-size: 30px!important;
            }
        }
        @media only screen and (max-width: 767px) and (min-width: 416px) {
            .tz-gallery{
                padding-left: 5%!important;
                padding-right: 5%!important;
            }
            #swiper_home{
                padding-top: 3%!important;
            }
            .title_font{
                font-size: 30px!important;
            }
        }
        @media only screen and (max-width: 1023px) and (min-width: 768px) {
            .tz-gallery{
                padding-left: 5%!important;
                padding-right: 5%!important;
            }

            #swiper_home{
                padding-top: 8%!important;
            }

            .title_font{
                font-size: 30px!important;
            }
        }
        @media only screen and (max-width: 1200px) and (min-width: 1024px) {

            .close-video{
                top: 15%!important;
                right: 23%!important;
            }
        }
        @media only screen and (max-width: 1300px) and (min-width: 1201px) {

            .close-video{
                top: 15%!important;
                right: 23%!important;
            }
        }
        @media (max-width: 991px) {

            .card-desktop{
                display: none!important;
            }
            .card-movil{
                display: block!important;
            }

            .tz-gallery{
                padding-left: 5%!important;
                padding-right: 5%!important;
            }
            .swiper-pagination-bullet{
                width: 7px!important;
                height: 7px!important;
                background: rgba(146, 146, 146, 0.56)!important;
                opacity: 3!important;
            }
            .swiper-pagination-bullet-active{
                width: 7px!important;
                height: 7px!important;
                background: rgba(255, 0, 0, 0.59)!important;
                opacity: 3!important;
            }
            #swiper_home{
                padding-bottom: 6%!important;
            }
            #swiper_home > .swiper-button-prev{
                display: none!important;
            }
            #swiper_home > .swiper-button-next{
                display: none!important;
            }
            .my_card_button{
                padding: 2px 10px!important;
            }
            .title_font{
                font-size: 30px!important;
            }
        }
    </style>
    <style>
        .cookie-section {
            display: none;
        }
    </style>
@endsection
 
@section('body')
        <div id="swiper_home" class="swiper-container">
            <div class="swiper-wrapper">
                @for($i=0;$i<count($lstBanners);$i++)
                    <div class="swiper-slide">
                        @if($lstBanners[$i]['link_text']!="")
                        <div  style='position: absolute;bottom: 7%;width: max-content'>
                            <button  class='btn btn-lg active btn-ver-productos' style='white-space: nowrap;position:relative;z-index: 99999999;background:red' onclick="window.location.href='{!! $lstBanners[$i]['link_url'] !!}'">{!! $lstBanners[$i]['link_text'] !!}</button>
                        </div>
                        @endif
                        <div class="swiper-slide">
                            <a style="width:100%!important;" href='{!! $lstBanners[$i]["link_url"] !!}'>
                            <img alt="{!! $lstBanners[$i]['subtitle'] !!}"  title="{!! $lstBanners[$i]['title'] !!}" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage($lstBanners[$i]['image'],'banners') }}" style="width:100%;height: auto;"/>
                            </a>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="swiper-pagination swiper-banner" style=""></div>
            <div class="swiper-button-next"><img alt="" title="" class="hvr-rotate" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('arrow-2.png','icon') }}" style="width:100%;height: auto;margin-left: 2%"/></div>
            <div class="swiper-button-prev"><img alt="" title="" class="hvr-rotate" src="{{\App\Http\Modules\Site\Services\HtmlService::ParseImage('arrow-2.png','icon') }}" style="width:100%;height: auto;margin-right: 2%"/></div>
        </div>

        <div class="top_catagory_area clearfix" style="padding-top: 3%;padding-bottom: 1%;margin-left: auto;margin-right: auto">
            <div class="container gallery-container" style="padding-right: unset;padding-left: unset;margin-left: unset;margin-right: unset;display: contents">
                <div class="tz-gallery">
                    <p class="text-center title_section">{{trans($lang.'title_card_section')}}</p>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="row">
                                @for($i=0;$i<6;$i++)
                                    <div class="col-6 col-md-4 padding-5">
                                        <a class="lightbox" href="{!! $lstCards[$i]['link_url'] !!}">
                                            <img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage($lstCards[$i]['image'],'cards') }}" alt="{!! $lstCards[$i]['subtitle'] !!}">
                                        </a>
                                    </div>
                                @endfor
                            </div>
                            <div class="row">
                                @for($i=6;$i<count($lstCards);$i++)
                                    <div class="col-6 col-md-6 padding-5">
                                        <a class="lightbox" href="{!! $lstCards[$i]['link_url'] !!}">
                                            <img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage($lstCards[$i]['image'],'cards') }}" alt="{!! $lstCards[$i]['subtitle'] !!}">
                                        </a>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ##### MOST POPULAR VIDEOS START ##### -->
        <div class="top_catagory_area clearfix" style="padding-top: 2%;padding-bottom: 1%;margin-left: auto;margin-right: auto">
            <div class="container gallery-container" style="padding-right: unset;padding-left: unset;margin-left: unset;margin-right: unset;display: contents">
                <div class="tz-gallery">
                    <p class="text-center title_section">{{trans($lang.'title_video_section')}}</p>
                    <div class="row nopadd">
                        <div class="col-md-9 nopadd" style="align-self:center;padding-left:2%;padding-right:7px!important;z-index:1!important;padding-bottom:7px!important;">
                            <div class="col-sm-12 col-md-12 nopadd ">
                                <a class="lightbox" href="{!! $lstVideos[0]['link_url'] !!}" data-toggle="lightbox" data-gallery="mixedgallery">
                                    <img class="nopadd" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage($lstVideos[0]['image'],'banners') }}" alt="{!! $lstVideos[0]['subtitle'] !!}">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 nopadd" style="align-self:center;">
                            @for($i=1;$i<count($lstVideos);$i++)
                                <div class="col-sm-12 col-md-12 nopadd">
                                    <div class="col-md-12 nopadd" style="padding-left:5px!important;padding-right:5px!important;padding-bottom:6px!important;">
                                        <a class="lightbox" href="{!! $lstVideos[$i]['link_url'] !!}" data-toggle="lightbox" data-gallery="mixedgallery">
                                            <img class="nopadd" src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage($lstVideos[$i]['image'],'banners') }}" alt="{!! $lstVideos[$i]['subtitle'] !!}">
                                        </a>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container gallery-container" style="padding-right: unset;padding-left: unset;margin-left: unset;margin-right: unset;display: contents">
            <div class="tz-gallery" style="padding-top: 2%">
                <p class="text-center title_section">{{trans($lang.'title_products_section')}}</p>
                <div class="row nopadd">
                    <div class="col-12" id="trending_now">
                    </div>
                </div>
            </div>
        </div>
 
        <div class="top_catagory_area clearfix" style="padding-top: 2%;padding-bottom:2%;margin-left: auto;margin-right: auto">
            <div class="container gallery-container" style="padding-right: unset;padding-left: unset;margin-left: unset;margin-right: unset;display: contents">
                <div class="tz-gallery">
                    <p class="text-center title_section socios-div">{{trans($lang.'title_partners_section')}}</p>
                    <div class="row nopadd">
                        <div class="owl-carousel owl-theme" id="partners">
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/6pagos_bbva.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/beef_beef.jpeg")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/canastera.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/casa_fuego.PNG")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/curacao.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/diners.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/falabella.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/gooprices.JPG")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/interbank.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/iridium.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/juntoz.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/latam.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/lazaclick.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/linio.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/listo_grill.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/makro.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/metro.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/plazavea.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/primeclub.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/promart.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/promotick.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/puntos_vida.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/retail.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/ripley.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/scotiapuntos.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/sodimac.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/tbs.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/tu_caserito.jpg")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/vivanda.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/wong.png")}}' alt=""></div>
                            <div class="item" style="width: 100%;height: 80%"><img style="width: 70px;height: 50px;object-fit: contain;object-position: center;" src='{{asset("resources/assets/".$group."/ecommerce/images/partners/todo_parrillas.png")}}' alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <br/>
    <!-- ##### Modal START-->
    <div class="modal fade" id="start_modal" tabindex="-1" role="dialog" aria-labelledby="ModalStart" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="">
            <div class="modal-content">
                <button type="button" class="close btn-out" data-dismiss="modal" aria-label="Close" style="padding: 5px;text-align:-webkit-right;text-align:right">
                    <span aria-hidden="true" style="color:black;right: 3%" >&times;</span>
                </button>
                <div class="modal-body modal-background" style=" padding-bottom:10px;padding-left: 1em;padding-right: 1em">
                    <div style="background: white;padding:10px;" class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="text-align: center">
                                    <p class="modal-text-1">{{ $tittStartModal }}</p>
                                </div>
                                <div style="text-align: center">
                                    <span class="text-modal-span" style="font-size:20px">{{ $msgStartModal }}</span>
                                </div>
                            </div>
                            <div class="col-md-12" style="text-align: center;padding-top: 5%">
                                <div>
                                    <input id="mail_sus" type="email" style="margin-bottom:5%;border-radius:unset" class="form-control" name="EMAIL" placeholder="Ingresa tu correo" required="required">
                                    <span class="text-modal-span" style="margin-top:2%">{{trans($lang.'lbl_modal_footer_1')}}</span>
                                    <div>
                                        <button onclick="AddSuscriber()" class="btn btn-solid modal-btn-solid hvr-shrink" id="ms-submit">{{trans($lang.'lbl_btn_send')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <!-- ##### MODAL AL FIN ##### -->
    <!-- ##### Modal EVENTO-->
    <div class="modal fade" id="evt_modal" tabindex="-1" role="dialog" aria-labelledby="ModalEvt" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="">
            <div class="modal-content">
                    <button type="button" class="close btn-out" data-dismiss="modal" aria-label="Close" style="padding: 5px;text-align:-webkit-right;text-align:right">
                        <span aria-hidden="true" style="color:black;right: 3%" >&times;</span>
                    </button>
                    <div class="modal-body modal-background" style=" padding-bottom:10px;padding-left: 1em;padding-right: 1em">
                        <div style="background: white;padding:10px;" class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center">
                                        <p class="modal-text-1">{{trans($lang.'lbl_title_modal_2')}}</p>
                                    </div>
                                    <div style="text-align: center;">
                                        <span class="text-modal-span" style="margin:5%">{{trans($lang.'lbl_body_modal_2')}}</span>
                                    </div>
                                </div>
                                <div class="col-md-12" style="text-align: center;padding-top: 5%">
                                    <div>
                                        <input id="mail_evt" type="email" style="margin-bottom:5%;border-radius:unset" class="form-control" name="email" placeholder="Ingresa tu correo" required="required">
                                        <span class="text-modal-span" style="margin-top:2%">{{trans($lang.'lbl_modal_footer_2')}}</span>
                                        <div>
                                            <button onclick="AddEvent()" class="btn btn-solid modal-btn-solid hvr-shrink" id="ms-submit">{{trans($lang.'lbl_btn_send')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- ##### MODAL AL FIN ##### -->
@endsection
@section('bottom_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/anchor-js/3.2.1/anchor.min.js"></script>
<script src='{{asset("resources/assets/".$group."/ecommerce/js/ekko-lightbox.js")}}'></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    baguetteBox.run('.tz-gallery');
</script>
<script type="application/javascript">
    new Swiper('#swiper_home', {
        slidesPerView: 'auto',
        loop: true,
        lazy: true,
        autoPlay:true,
        autoHeight: true,
        keyboard: {
            enabled: true,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
        },
    });
    new Swiper('#swiper_cards', {
        slidesPerView: 3,
        loop: true,
        lazy: true,
        autoHeight: true,
        centeredSlides: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            320: {
                slidesPerView: 2,
                spaceBetween: 20,
            }
        },
    });

</script>
<script>
    var target = null;
    $('.img_thumb').hover(function(e){
        target = $(this);
        $(target[0].firstElementChild).fadeIn(200);
    }, function(){
        $(target[0].firstElementChild).fadeOut(200);
    });

</script>
<script type="application/javascript">
    var owl = $('#first_carousel');
    var owl2 = $('#scond_carousel');
    var owl_2 = $('#second_carousel');
    var main_slider = $('#main_slider');
    var partners = $('#partners');
    var new_in = $('#new_in');
    var show_initial_modal = {{ $showModal }};


    var ejecutando = false;
    $(document).on('click', '[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', function(event) {
        event.preventDefault();
        return $(this).ekkoLightbox({
            alwaysShowClose: true,
            onShown: function() {
                if (window.console) {

                }
            },
            onNavigate: function(direction, itemIndex) {
                if (window.console) {
                    //return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                }
            }
        });
    });

    function DocumentReady() {
        ls = window.localStorage;

        if(ls.getItem('suscriber')==null && {{$ped_corp}}==0){
            if(show_initial_modal == 1 || show_initial_modal == '1'){
                $('#start_modal').modal('show');
                ls.setItem('suscriber',"1");
            }
        }

        if({{$ped_corp}}==1){
            $('#modalCorporative').modal('show');
        }
        LoadSlider("all","","trending_now");
        if({{$ped_corp}}==1){
            $('#modalCorporative').modal('show');
        }
        //Programmatically call
        $('#open-image').click(function (e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        $('#open-youtube').click(function (e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });

        // navigateTo
        $(document).on('click', '[data-toggle="lightbox"][data-gallery="navigateTo"]', function(event) {
            event.preventDefault();

            return $(this).ekkoLightbox({
                onShown: function() {
                    this.modal().on('click', '.modal-footer a', function(e) {
                        e.preventDefault();
                        this.navigateTo(2);
                    }.bind(this));
                }
            });
        });

        anchors.options.placement = 'left';
        anchors.add('h3');
        $('code[data-code]').each(function() {

            var $code = $(this),
                $pair = $('div[data-code="'+$code.data('code')+'"]');

            $code.hide();
            var text = $code.text($pair.html()).html().trim().split("\n");
            var indentLength = text[text.length - 1].match(/^\s+/)
            indentLength = indentLength ? indentLength[0].length : 24;
            var indent = '';
            for(var i = 0; i < indentLength; i++)
                indent += ' ';
            if($code.data('trim') == 'all') {
                for (var i = 0; i < text.length; i++)
                    text[i] = text[i].trim();
            } else  {
                for (var i = 0; i < text.length; i++)
                    text[i] = text[i].replace(indent, '    ').replace('    ', '');
            }
            text = text.join("\n");
            $code.html(text).show();

        });
    }
    //Declaración de sliders
    owl.owlCarousel({
        items: 3,
        loop: true,
        margin: 10,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive:{
            0:{
                items:1,
                dots: true,
                autoplay: false
            },
            600:{
                items:1,
                dots: true,
                autoplay: false
            },
            1000:{
                items:3,
                dots: false,
                autoplay: false
            }
        }
    });
    owl2.owlCarousel({
        items: 2,
        loop: true,
        margin: 10,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive:{
            0:{
                items:1,
                dots: true,
                autoplay: false
            },
            600:{
                items:1,
                dots: true,
                autoplay: false
            },
            1000:{
                items:2,
                dots: false,
                autoplay: false
            }
        }
    });
    partners.owlCarousel({
        loop:true,
        autoplay: true,
        margin:10,
        dots:false,
        responsive:{
            0:{
                items:3
            },
            600:{
                items:5
            },
            1000:{
                items:10
            }
        }
    })
    new_in.owlCarousel({
        loop:true,
        autoplay: true,
        margin:10,
        dots:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
    owl_2.owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        dots: true,
    });
    main_slider.owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 2000,
        responsiveClass:true,
        autoplayHoverPause: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        },
        dots: true,
        nav: true,
        navText: ["<img style='position: absolute; top: 40%;left: 2%; background: unset;' src='{{asset(config("constants.default_resources_root_folder").'/assets/img/core-img/flechas1-01.png')}}'>",
            "<img style='position: absolute; top: 40%;right: 2%; background: unset;' src='{{asset(config("constants.default_resources_root_folder").'/assets/img/core-img/flecha2-01.png')}}'>"]
    });
</script>
@endsection
