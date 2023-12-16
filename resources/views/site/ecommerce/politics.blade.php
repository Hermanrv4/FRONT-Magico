<?php
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CartService;
use App\Http\Modules\Site\Services\ProductService;
use App\Http\Modules\Site\Services\SiteService;
use \Illuminate\Support\Facades\Session;

$group = config('env.app_group_site');
$lang = config($group.'.ui.ecommerce.politics.lang');

?>
@extends(config($group.'.ui.template.ecommerce.view'))
@section('page_title',trans($lang.'page_title'))
@section('metas')
 <title>{{trans($lang.'title_default')}}</title>
 <meta name="description" content="{{trans($lang.'description_default')}}">
@endsection
@Section('top_scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
<link rel="stylesheet" href="{{asset(config("constants.default_resources_root_folder").'\assets\css\ekko-lightbox.css')}}">
<link rel="stylesheet" href="{{asset(config("constants.default_resources_root_folder").'\assets\css\gallery-grid.css')}}"><!-- gallery-grid -->
<link rel="stylesheet" href="{{asset(config("constants.default_resources_root_folder").'\assets\css\hover.css')}}">
<style>
    .nopadd{
        padding: 0px;
        margin: 0px!important;
    }
.footer_widget_menu{
    margin-left: 0px;
}
    .tz-gallery{
        padding-left: 15%;
        padding-right: 15%;
    }

    @media (min-width: 992px){
        .padding-5{
            padding-right: 10px;
            padding-left: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
    }

    @media only screen and (max-width: 320px) {

        .tz-gallery{
            padding-left: 5%;
            padding-right: 5%;
        }

        .title_font{
            font-size: 30px;
        }
    }

    @media only screen and (max-width: 360px) and (min-width: 321px) {
        .tz-gallery{
            padding-left: 5%;
            padding-right: 5%;
        }

        .title_font{
            font-size: 30px;
        }
    }

    @media only screen and (max-width: 320px) and (min-width: 300px){
        #swiper_home{
            padding-top: 7%;
        }
    }
    @media only screen and (max-width: 360px) and (min-width: 321px){
        #swiper_home{
            padding-top: 6%;
        }
    }
    @media only screen and (max-width: 411px) and (min-width: 361px) {
        .tz-gallery{
            padding-left: 5%;
            padding-right: 5%;
        }
        #swiper_home{
            padding-top: 6%;
        }

        .title_font{
            font-size: 30px;
        }
    }
    @media only screen and (max-width: 413px) and (min-width: 412px) {
        .tz-gallery{
            padding-left: 5%;
            padding-right: 5%;
        }
        #swiper_home{
            padding-top: 5%;
        }
        .title_font{
            font-size: 30px;
        }
    }
    @media only screen and (max-width: 415px) and (min-width: 414px) {
        .tz-gallery{
            padding-left: 5%;
            padding-right: 5%;
        }
        #swiper_home{
            padding-top: 6%;
        }
        .title_font{
            font-size: 30px;
        }
    }
    @media only screen and (max-width: 767px) and (min-width: 416px) {
        .tz-gallery{
            padding-left: 5%;
            padding-right: 5%;
        }
        #swiper_home{
            padding-top: 3%;
        }
        .title_font{
            font-size: 30px;
        }
    }
    @media only screen and (max-width: 1023px) and (min-width: 768px) {
        .tz-gallery{
            padding-left: 5%;
            padding-right: 5%;
        }

        #swiper_home{
            padding-top: 2%;
        }

        .title_font{
            font-size: 30px;
        }
    }
    @media (max-width: 991px) {

        .card-desktop{
            display: none;
        }
        .card-movil{
            display: block;
        }

        .tz-gallery{
            padding-left: 5%;
            padding-right: 5%;
        }
        .swiper-pagination-bullet{
            width: 7px;
            height: 7px;
            background: rgba(146, 146, 146, 0.56);
            opacity: 3;
        }
        .swiper-pagination-bullet-active{
            width: 7px;
            height: 7px;
            background: rgba(255, 0, 0, 0.59);
            opacity: 3;
        }
        #swiper_home{
            padding-bottom: 6%;
        }
        #swiper_home > .swiper-button-prev{
            display: none;
        }
        #swiper_home > .swiper-button-next{
            display: none;
        }
        .my_card_button{
            padding: 2px 10px;
        }
        .title_font{
            font-size: 30px;
        }
    }

</style>
@endsection
@section('body')
    <!-- breadcrumb start -->
    <section class="breadcrumb parallax margbot30" style="min-height: 120px!important;"></section>
    <section class="contacts_block">
        <div class="container">
            <div class="row padbot30" style="padding: 2em">
                {!! trans($lang.'lbl_info_html_for_'.$info_type) !!}
            </div>
        </div>
    </section>
@endsection