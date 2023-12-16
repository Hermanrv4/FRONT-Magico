<?php
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CartService;
use App\Http\Modules\Site\Services\ProductService;
use App\Http\Modules\Site\Services\SiteService;
use \Illuminate\Support\Facades\Session;
use App\Http\Modules\Site\Services\HtmlService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.ecommerce.checkout.lang');

$data = isset($data)?$data:array("cart"=>array());
$token = isset($token)?$token:null;
$total = 0;
$currency_symbol = "";
$currency_code = SiteService::GetCurrencyCode();

$type_pay=ParameterService::GetParameter('default_pasarela');
$credentials=ParameterService::GetParameter($type_pay);
$ubication_types = ParameterService::GetParameter($type_pay);
$comision = 0 ;
$objUser = Session::get(config('env.app_auth_site_session_id'))["user"];
$lstCartProducts = CartService::GetCart();
$total_ = CartService::GetAmountTotal();
$total_items = 0;
$shipping = 0;
$mp_credentials = json_decode(ParameterService::GetParameter("integ_mercadopago"),true);
$show_shops = ParameterService::GetParameter("view_shops");

//$lstDiscount = ApiService::Request(config('env.app_group_site'), 'entity', 'discount-get', array())->response;
$lstShops = ApiService::Request(config('env.app_group_site'), 'entity', 'shops-list', array())->response;



//DELIVERY
$delivery_id_par = ParameterService::GetParameter("DELIVERY_ID");
//SHOP
$shop_id_par = ParameterService::GetParameter("SHOP_ID");
?>
@extends(config($group.'.ui.template.ecommerce.view'))
@section('page_title',trans($lang.'page_title'))
@section('metas')
<title>{{trans($lang.'title_default')}}</title>
<meta name="description" content="{{trans($lang.'description_default')}}"/>
@endsection
@section('top_scripts')
<link rel="stylesheet" href="{{asset('resources/assets/'.$group.'/ecommerce/css/select2-bootstrap4.min.css')}}">

<style>
    .always_visible{
        display: block!important;
    }
    .error-field{
        border-color: #aa0a00 !important;
        background-color: rgba(170, 10, 0, .1) !important;
    }
    .div-text-name-card{
        text-align: left;
        margin-top: 5%;
        margin-left: 10%;
        margin-right: 10%;
    }
    .p-text-name-card{
        color: #6d6d6d;
        font-weight: 700!important;
        font-family: CustomElevenFont!important;
        font-size: 24px!important;
        line-height: .91667!important;
        margin-bottom: 0;
    }
    .delivery_msg{
        display: block;
    }
    .shop_msg{
        display: none;
    }
    .res_card_dis{
        font-size: 11px;
        font-weight: bold;
    }
    .card_active {
        background: black!important;
        color: white!important;
    }
    .btn_card{
        display: inline-block;
        min-width: 100px;
        height: 40px;
        color: black;
        border-radius: 0!important;
        border: 1px solid black;
        padding: 0 40px;
        text-transform: uppercase;
        font-size: 12px;
        background-color: white;
        letter-spacing: 1.5px;
        font-weight: 600;

        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        line-height: 0;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .visible_always{
        display: block!important;
    }
    .nice-select{
        display: none!important;
    }
    .value_cup_div_text{
        font-family: 'CustomAppFontBold';
        font-size: 20px;
    }
    .order-details-checkout{
        border: none!important;
    }
    .btn-responsive{
        min-width: 150px;
    }
    @media only screen and (max-width: 991px){
        .btn-responsive{
            padding: 0px 25px;
            min-width: auto;
        }
        .checkout_area{
            padding-top: 18%!important;
        }
    }
    .order-details-checkout{
        border:none;
    }
    .element_delivery_method{
        border: 1px solid black;
    }
    .btn-add-address{
        margin-left: -2%;
    }
    .swal2-icon.swal2-info{
        border-color:red;
        color:red;
        width:4.5em;
        height:4.5em;
    }
    .swal2-icon.swal2-error{
        border-color:red;
        color:red;
    }
    .swal2-x-mark-line-left{
        background-color:red;
    }
    .swal2-x-mark-line-right{
        background-color:red;
    }
    @media only screen and (max-width: 320px) and (min-width: 300px){
        .btn-add-address{
            margin-left: -68%;
            font-size: 88%;
        }
        .btn_optional_address{
            margin-left: -35%;
        }
        .btn-add-add{
            margin-left: -35%;
        }
    }
    @media only screen and (max-width: 360px) and (min-width: 321px){
        .btn-add-address{
            margin-left: -46%;
        }
        .btn_optional_address{
            margin-left: -35%;
        }
        .btn-add-add{
            margin-left: -35%;
        }
    }
    @media only screen and (max-width: 373px) and (min-width: 361px) {
        .btn-add-address{
            margin-left: -35%;
        }
        .btn_optional_address{
            margin-left: -35%;
        }
        .btn-add-add{
            margin-left: -35%;
        }
    }
    @media only screen and (max-width: 376px) and (min-width: 374px) {
        .btn-add-address{
            margin-left: -35%;
        }
        .btn_optional_address{
            margin-left: -35%;
        }
        .btn-add-add{
            margin-left: -35%;
        }
    }
    @media only screen and (max-width: 411px) and (min-width: 377px) {
        .btn-add-address{
            margin-left: -18%;
        }.btn_optional_address{
             margin-left: -35%;
         }
        .btn-add-add{
            margin-left: -35%;
        }
    }
    @media only screen and (max-width: 413px) and (min-width: 412px) {
        .btn-add-address{
            margin-left: -30%;
        }
        .btn_optional_address{
            margin-left: -35%;
        }
        .btn-add-add{
            margin-left: -35%;
        }
    }
    @media only screen and (max-width: 415px) and (min-width: 414px) {
        .btn-add-address{
            margin-left: -16%;
        }
        .btn_optional_address{
            margin-left: -35%;
        }
        .btn-add-add{
            margin-left: -35%;
        }
    }
    @media only screen and (max-width: 767px) and (min-width: 416px) {
        .btn-add-address{
            margin-left: -30%;
        }
        .btn_optional_address{
            margin-left: -35%;
        }
        .btn-add-add{
            margin-left: -35%;
        }
    }
    @media only screen and (max-width: 790px) and (min-width: 768px) {
        .btn-add-address{
            margin-left: -45%;
        }
        .btn_optional_address{
            margin-left: -35%;
        }
        .btn-add-add{
            margin-left: -35%;
        }
    }
</style>
@endsection
@section('body')
    <!-- ##### Checkout Area Start ##### -->
    <div class="checkout_area section-padding-80" style="padding-top: 10%">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div>
                        <a class="btn essence-btn in_step" style="width: 100%" data-toggle="collapse"
                           href="#summary_collapse" aria-expanded="false" aria-controls="summary_collapse">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-12" style="text-align: left">
                                    {!! trans($lang.'show_list_cart') !!}
                                    <i id="icon_right" style="display: contents" class="fa fa-caret-right"
                                       aria-hidden="true"></i>
                                    <i id="icon_down" style="display: none" class="fa fa-caret-down"
                                       aria-hidden="true"></i>

                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="collapse" id="summary_collapse" style="border:1px solid var(--app_default_color);">
                        <div class="mt-3">
                            @if(count($lstCartProducts)==0)
                            <div class="alert alert-info" role="alert">{!! trans($lang.'lbl_no_items') !!}</div>
                            @else
                                <?php
                                    for($i=0;$i<count($lstCartProducts);$i++){
                                        $error_prices = false;
                                        $product_data = ApiService::Request(config('env.app_group_site'), 'entity', 'product-by-id', ["currency_code"=> SiteService::GetCurrencyCode(),"product_id" => $lstCartProducts[$i]["product_id"]])->response;
                                        $specifications = explode($product_data["str_limiter"],$product_data["specifications"]);
                                        $lstEspecificationPreview = explode($product_data["str_union"],$specifications[0]);
                                        if($product_data["online_price"]==null || $product_data["online_price"]==""){ ?>
                                            <div class="alert alert-info" role="alert">{!! trans($lang.'lbl_no_prices_for_items',["prm1"=>$product_data["currency_symbol"]]) !!}</div>
                                        <?php }
                                        else{ 
                                            if ($lstCartProducts[$i]['qty'] > 0){
                                                $lstProductImages = json_decode($product_data["product_photos"],true);
                                                $Currency = $product_data["currency_symbol"];
                                                $currency_symbol = $Currency;
                                                $sub_total = $product_data['online_price'] * $lstCartProducts[$i]['qty'];
                                                $url_link = RouteService::GetSiteURL('product',array($product_data["product_url_code"]));
                                                $url_photo = HtmlService::ParseImage($lstProductImages[0],'products');
                                                $total_items = $total_items + $lstCartProducts[$i]['qty'];
                                            ?>
                                            <div class="hidden-responsive" style="margin-top: 1%;padding-bottom: 1%;">
                                                <div style="width:100%;margin-left:80px;margin-right: 80px">
                                                    <div class="div-item" style="width: max-content">
                                                       <a onclick="OpenURL('{!! $url_link !!}')" target="_blank">
                                                           <img style="max-width:140px" src="{!! $url_photo !!}" width="140px" alt="">
                                                       </a>
                                                    </div>
                                                    <div class="div-item" style="width: 471px;text-align: center">
                                                        <a style="font-weight: bold;color: black;font-size: initial" onclick="OpenURL('{!! $url_link  !!}')" target="_blank">{!! $product_data['product_name'] !!}</a>
                                                        <ul class="variation">
                                                        </ul>
                                                    </div>
                                                    <div class="div-item" style="width: 100px!important;font-weight: bold;">
                                                        <a style="font-weight: bold;color: black;font-size: initial">{!! $product_data['currency_symbol'] !!} {!! number_format($product_data['online_price'],2) !!}</a>
                                                    </div>
                                                    <div class=" div-item" style="width: 100px!important;font-weight: bold;text-align: center">
                                                        <a style="font-weight: bold;color: black;font-size: initial">{!! $lstCartProducts[$i]['qty'] !!}</a>
                                                    </div>
                                                    <div class="div-item" style="width: 100px!important;font-weight: bold;">
                                                        <a style="font-weight: bold;color: black;font-size: initial">{!! $product_data['currency_symbol'] !!} {!! number_format($sub_total,2) !!}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- RESPONSIVE SECTION -->
                                            <div class="row div-item-responsive">
                                                <div class="col-xs-4 col-4" style="display: inline-block;padding-right: 0%;padding-top: 2%">
                                                    <a href="#" onclick="OpenURL('{!! $url_link !!}')" target="_blank">
                                                        <img style="max-width:120%" src="{!! $url_photo !!}" alt="" style="vertical-align: bottom">
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 col-6" style="display: inline-block;padding-right: 0%">
                                                    <div class="col-xs-12">
                                                    <a style="font-weight: bold;color: black" onclick="OpenURL('{!! $url_link  !!}')" target="_blank">{!! $product_data['product_name'] !!}</a>
                                                    <ul class="variation"> 
                                                        <li class="variation-Color" style="font-size: 12px;">{!! $lstEspecificationPreview[0] !!}: <span>{!! $lstEspecificationPreview[1] !!}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xs-12">
                                                    <span class="btn-quantity-products">{!! $lstCartProducts[$i]['qty'] !!}</span>
                                                </div>
                                                <div class="col-xs-12" style="font-weight: bold;">{!! $Currency !!} <label id="lbl_subtotal_{!! $product_data['product_id'] !!}">{!! number_format($sub_total,2) !!}</div>
                                                </div>
                                                <div class="col-xs-2 col-2" style="display:inline-block;padding-right: 0%">
                                                      </div>
                                                </div>
                                        <?php } 
                                        }
                                    }
                                ?>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <br>
                
                <div class="col-lg-6 col-md-6 margintop2">
                    
                    <div class="text-center essence-btn in_step" style="width: 100%;margin-bottom: 0!important;">{!! trans($lang.'lbl_block_1') !!}</div>
                    <h6 style="margin-top: 3%">{!! trans($lang.'lbl_block_1_sub_1') !!}</h6>
                    <div class="row">
                        @if($show_shops == 0)
                            <div class="col-md-6 col-6">
                                <button class="btn essence-btn responsive100 method_active btn-responsive" disabled style="margin-top: 3%;width: 100%;cursor:pointer" 
                                onclick="" id="btn_shop">{!! trans($lang.'lbl_block_1_sub_1_1') !!}
                                </button>
                            </div>
                        @else
                            <div class="col-md-6 col-6">
                                <button class="btn essence-btn responsive100 method_active btn-responsive" style="margin-top: 3%;width: 100%;cursor:pointer" 
                                onclick="ShowShops()" id="btn_shop">{!! trans($lang.'lbl_block_1_sub_1_1') !!}</button>
                            </div>
                        @endif
                        <div class="col-md-6 col-6">
                            <button class="btn essence-btn responsive100 btn-responsive" style="margin-top: 3%;width: 100%"
                                    onclick="ShowDeliveryAddresses()" id="btn_delivery">{!! trans($lang.'lbl_block_1_sub_1_2') !!}
                            </button>
                        </div>
                    </div>
                    <br>
                    <h6 class="delivery_msg">{!! trans($lang.'lbl_env_msg_delivery') !!}</h6>
                    <h6 class="shop_msg">{!! trans($lang.'lbl_env_msg_shop') !!}</h6>

                    <div class="essence-btn" style="padding: 0 20px;height: auto;width: 100%;margin-bottom: 0!important;">
                        <p style="text-transform: none;font-size: 12px;margin-top: 1rem;text-align: justify;color: white;line-height: 1.5;">{!! trans($lang.'lbl_only_card') !!}</p>
                    </div>
                    <!-- EN TIENDA -->
                    <div class="order-details-confirmation order-details-checkout" style="padding: 10px 0px 10px 0px;!important;display: none" id="is_in_shop">
                        <div class="row" name="slide_shops" style="width: 100%;margin-left: 0px">
                            @if (count($lstShops)!=0)
                                @for($i = 0;$i < count($lstShops);$i++)
                                <div class='shop_information' onclick="shop_select_id('{{$lstShops[$i]['id']}}');" id="shop_{{$lstShops[$i]['id']}}" style="margin-top: 8px;width: 100%;border-radius:3px;cursor:pointer">
                                    <div class="col-md-12"  style="width: 100%" >
                                        <h6 style="margin-bottom: 0px;margin-top: 1px">
                                            <b>{{$lstShops[$i]['name_localized']}} - {{$lstShops[$i]['address']}}, {{ $lstShops[$i]['ubication_name'] }}</b>
                                        </h6>
                                    </div>
                                </div>
                                @endfor
                            @endif
                        </div>
                    </div>
                        <!-- DELIVERY -->
                    <div class="order-details-confirmation order-details-checkout" id="is_delivery"
                             style="display: block;padding: 10px 0px 10px 0px!important;">
                        <input class="form-control" type="hidden" id="inp_last_ubication" name="inp_last_ubication" value="">
                        <div>
                            <div id="optional_address" style="display: block;">
                                <hr>
                                    <div class="col-md-6">
                                        <input type="text" id="inpPhone" value=" " style="display: none"
                                               placeholder="{!! trans($lang.'lbl_register_inp_phone') !!}">
                                        <label class="error-text" id="lblErrorPhone" style="display: none;"></label>
                                    </div>
                                    <div class="col-md-12" id="dvAddressButtons" style="padding: 0px;text-align:-webkit-right">

                                    </div>
                                    <input type="hidden" id="sel_district">
                                    <div class="col-md-12" style="margin-bottom: 1%;padding-right: 0px;padding-left: 0px">
                                        <label>{!! trans($lang.'lbl_register_inp_address') !!}</label>
                                        <input type="text" class="form-control" id="inpAddress" value=""
                                               placeholder="{!! trans($lang.'lbl_register_inp_address') !!}">
                                        <label class="error-text" id="lblErrorAddress" style="display: none;"></label>
                                        <label style="padding-top: 2%">{!! trans($lang.'lbl_register_inp_reference') !!}</label>
                                        <input type="text" class="form-control" id="inpReference" value=""
                                               placeholder="{!! trans($lang.'lbl_register_inp_reference') !!}">
                                        <label class="error-text" id="lblErrorReference" style="display: none;"></label>
                                    </div>
                                    <input class="form-control" type="hidden" id="inp_last_ubication"
                                           name="inp_last_ubication" value="">
                                </div>
                            </div>
                        </div>
                        <img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('banner_checkout.png','banners') }}" style="width: 100%;">
                    </div>
                    <div class="col-lg-6 col-md-6 margintop2">
                        <div class="text-center essence-btn in_step" style="width: 100%" id="personal_information">{!! trans($lang.'lbl_block_2') !!}</div>
                        <div class="order-details-confirmation order-details-checkout">
                            <ul class="order-details-form mb-4">
                                <?php
                                $first_name=$objUser["first_name"];
                                $last_name=$objUser["last_name"];
                                $identification_code=$objUser["dni"];
                                $email=$objUser["email"];
                                $phone=$objUser["phone"];
                                ?>
                                <input class=""  id="first_name_hi" name="first_name_hi" type="hidden"
                                       value="{{$objUser["first_name"]}}">
                                <input class=""  id="last_name_hi" name="last_name_hi" type="hidden"
                                       value="{{$objUser["last_name"]}}">
                                <input class=""  id="identification_code_hi" name="identification_code_hi" type="hidden"
                                       value="{{$objUser["dni"]}}">
                                <input class=""  id="email_hi" name="email_hi" type="hidden"
                                       value="{{$objUser["email"]}}">
                                <input class=""  id="phone_hi" name="phone_hi" type="hidden"
                                       value="{{$objUser["phone"]}}">
                                <?php

                                ?>
                                <li><span class="span_step">{!! trans($lang.'lbl_register_inp_first_name') !!}</span>
                                    <input class="form-control input_step" onKeypress="return CheckInput(event)" id="first_name" name="first_name" type="text"
                                           value="{{$objUser["first_name"]}}"></li>
                                <li><span class="span_step">{!! trans($lang.'lbl_register_inp_last_name') !!}</span>
                                    <input class="form-control input_step" onKeypress="return CheckInput(event)" id="last_name" name="last_name" type="text"
                                           value="{{$objUser["last_name"]}}">
                                </li>
                                <li><span class="span_step">{!! trans($lang.'lbl_register_inp_identification_code') !!}/ RUC</span>
                                    <input class="form-control input_step" onKeypress="return CheckNumberInput(event)" id="identification_code"
                                           maxlength="13" name="identification_code" type="text"
                                           value="{{$objUser["dni"]}}">
                                </li>
                                <li><span class="span_step">{!! trans($lang.'lbl_register_inp_email') !!}</span>
                                    <input class="form-control input_step" id="email" name="email" type="text"
                                           value="{{$objUser["email"]}}">
                                </li>
                                <li><span class="span_step">{!! trans($lang.'lbl_register_inp_phone') !!}</span>
                                    <input class="form-control input_step" maxlength="9" onKeypress="return CheckNumberInput(event)" id="phone" name="phone" type="text"
                                           value="{{$objUser["phone"]}}">
                                </li>
                            </ul>
                            <p style="color:red">{!! trans($lang.'lbl_security_email') !!}</p>
                            <input style="margin-left: 1%" type="checkbox" class="form-check-input" id="checkOptionRecived" name="checkOptionRecived" checked>
                            <label style="margin-left: 8%" class="form-check-label" for="checkOptionRecived" id="method-by">{!! trans($lang.'lbl_myself_recib_shop') !!}</label>
                            <!-- Opciones persona externa -->


                            <div style="display:none" id="ex_information">
                                <br>
                                <span id="title_ex"><b>{!!trans($lang.'lbl_block_2')!!}</b></span><br>
                                <ul class="order-details-form mb-4">

                                    <li><span class="span_step">{!! trans($lang.'lbl_register_inp_first_name') !!}</span>
                                        <input class="form-control input_step" onKeypress="return CheckInput(event)" id="ex_first_name" name="ex_first_name" type="text"
                                               value=""></li>
                                    <li><span class="span_step">{!! trans($lang.'lbl_register_inp_last_name') !!}</span>
                                        <input class="form-control input_step" onKeypress="return CheckInput(event)" id="ex_last_name" name="ex_last_name" type="text"
                                               value="">
                                    </li>
                                    <li><span class="span_step">{!! trans($lang.'lbl_register_inp_identification_code') !!}</span>
                                        <input class="form-control input_step" onKeypress="return CheckNumberInput(event)" id="ex_identification_code"
                                               maxlength="8" name="ex_identification_code" type="text"
                                               value="">
                                    </li>
                                    <li><span class="span_step">{!! trans($lang.'lbl_register_inp_phone') !!}</span>
                                        <input class="form-control input_step" maxlength="9" onKeypress="return CheckNumberInput(event)" id="ex_phone" name="ex_phone" type="text"
                                               value="">
                                    </li>
                                </ul>
                                <p style="color:red">{!! trans($lang.'lbl_only_form') !!}</p>

                            </div>
							<div class="content-legacy">
								<p class="body-legacy" style="" >{!!trans($lang.'lbl_suscribe_plh_legacy')!!}
									<a class="a-legacy" style="" href="">{!!trans($lang.'lbl_client_atention_terms')!!}</a>,
									<a class="a-legacy" style="" href="">{!!trans($lang.'lbl_client_atention_privacity')!!}</a>,
									<a class="a-legacy" style="" href="">{!!trans($lang.'lbl_client_atention_polity_cookies')!!}</a>,
									<a class="a-legacy" style="" href="">{!!trans($lang.'lbl_client_atention_dates_tratament')!!}</a>.
								</p>
							</div>
						</div>
                    </div>
                    <div class="col-lg-6 col-md-6 margintop2">
                        <div class="text-center essence-btn in_step" style="width: 100%">{!!trans($lang.'lbl_block_3')!!}</div>
                        <div class="order-details-confirmation order-details-checkout">

                            <div id="after_resume" style="display: block">
                                <ul class="order-details-form mb-1">
                                    <li style="text-transform: uppercase;padding: 10px 0!important;">{{trans($lang.'lbl_total_items')}}<span>{{$total_items}}</span></li>
                                    <li style="text-transform: uppercase;padding: 10px 0!important;">{{trans($lang.'lbl_prices_shipping')}}<span id="current_shipping">{!! $currency_symbol !!} 0.00</span></li>
                                    <li style="text-transform: uppercase;padding: 10px 0!important;">{{trans($lang.'lbl_prices_total')}}<span id="current_total">{!! $currency_symbol !!} {!! number_format($total_,2); !!}</span></li>
                                    <li style="text-transform: uppercase;padding: 10px 0!important;"><span style="font-family:'CustomAppFontBlack'">{{trans($lang.'lbl_total_discount')}}</span><span id="current_discount_total" style="font-family:'CustomAppFontBlack'">{!! $currency_symbol !!} {!! number_format($total_,2); !!}</span></li>
                                </ul>
                                <div class="row lst-oferts" style="display:none">
                                    <div class="col-md-12 col-12">
                                        <p style="color: red;font-family: 'CustomAppFontBlack';margin-bottom: 0.5rem;">{{trans($lang.'lbl_discounts_for_you')}}</p>
                                    </div>

                                    <p class="responsive100" style="width:100%; margin-top: 3%;color: blue;font-family:'CustomAppFontBold';font-size: 12px;cursor:pointer;text-align: center" id="btn-have-cup">
                                        {{trans($lang.'lbl_do_you_have_cupon_discount')}}
                                    </p>
                                </div>
                                <div class="row cup-div" style="display: flex">
                                    <div class="col-md-6 col-12" style="padding-top: 3%;">
                                        <span class="" style="position: relative;top: 25%;font-family: 'CustomAppFont';font-weight: bold;">{{trans($lang.'lbl_enter_your_cupon')}}</span>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-top: 3%">
                                        <div style="display: inline-flex">
                                            <input class="form-control" style="border: 1px solid black;border-radius: unset;" placeholder="AQUÍ" id="cup_code_inp" name="cup_code_inp" type="text"
                                                   value="">
                                            <button class="btn essence-btn responsive100" style="min-width: 73px;padding: 0px;margin-left: 2px;background: black;text-transform: uppercase;" id="btn-cup-validate">
                                                {{trans($lang.'validate')}}
                                            </button>
                                        </div>
                                        <div>
                                            <label id="cup-response" style="font-size: 12px;text-transform: uppercase;margin-top: 0.5rem;color:#ed1c24;font-family: 'CustomAppFontBlack';"></label>
                                        </div>

                                    </div>
                                    <p class="responsive100" style="display: none;width:100%; margin-top: 3%;color: blue;font-family:'CustomAppFontBold';font-size: 12px;cursor:pointer;text-align: center" id="btn-have-card">
                                        {{trans($lang.'lbl_do_you_have_card_discount')}} 
                                    </p>
                                </div>
                                <ul>
                                    <input style="margin-left: 0%" type="checkbox" class="form-check-input" id="Terms-Cond" name="Terms-Cond" onchange="CheckState()">
                                    <label style="margin-left: 25px" onclick="OpenMod('termcond')" class="form-check-label" id="terms-cond">{{trans($lang.'lbl_aggre_atention_terms')}}</label>
                                </ul>

                                <button class="btn essence-btn responsive100" disabled style="margin-top: 3%;background: #ED1D2D;text-transform: uppercase;" onclick="OpenMod('payMod')" id="btn-pay-start">
                                    {{trans($lang.'lbl_btn_pay')}}
                                </button>
                                
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 margintop2">
                        <div class="text-center essence-btn in_step" style="width: 100%">{{trans($lang.'lbl_block_4')}}</div>
                            <div class="order-details-confirmation order-details-checkout" style="padding: 10px 0px 10px 0px;text-align: center!important">
                                <img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('methods.png','banners') }}" alt="" style="">
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="izzpay" tabindex="-1" role="dialog" aria-labelledby="izzpayTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body izzipay-body">
              
            </div>
            <div class="modal-footer">
              
            </div>
          </div>
        </div>
      </div>


    <div id="termcond" class="modal hidden" tabindex="-1" role="dialog" aria-labelledby="TermCond" aria-hidden="true" style="background:rgba(25,25,25,0.9);">
        <div class="modal-dialog modal-dialog-centered" role="document" style="">
            <div class="modal-content mod-contact" ><!--170vmin -->
                <div style="position: fixed;top: 0px;left: 0px;width: 10000px;height: 10000px;" onclick="CloseMod('termcond')"></div>
                <div class="modal-header" style="margin-left: 3%">

                    <button type="button" class="close" data-dismiss="modal" onclick="CloseMod('termcond')">&times;</button><br>
                </div>
                <div class="modal-body modal-background" style="padding-top: 0;padding-bottom:1em;padding-right: 1em;padding-left: 1em;height:auto;width: auto; overflow-y: auto;margin-bottom: 5%">

                    <div style="text-align: center;margin-top:5%">
                        <p class="modal-text-1">{!! trans($lang.'TermCond_title') !!}</p>
                    </div>
                    <div style="background: white;padding:3px;" class="container-fluid" >
                        <div class="row" style="padding-left: 5%;padding-right: 5%;padding-bottom: 5%">
                            {!! trans($lang.'lbl_info_html_for_politics') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="payMod" class="modal hidden" tabindex="-1" role="dialog" aria-labelledby="PayMod" aria-hidden="true" style="background:rgba(25,25,25,0.9);">
        <div class="modal-dialog modal-dialog-centered" role="document" style="">
            <div class="modal-content mod-contact" ><!--170vmin -->
                <div style="position: fixed;top: 0px;left: 0px;width: 10000px;height: 10000px;" onclick="CloseMod('payMod')"></div>
                <div class="modal-header" style="margin-left: 3%">

                    <button type="button" class="close" data-dismiss="modal" onclick="CloseMod('payMod')">&times;</button><br>
                </div>
                <div class="modal-body modal-background" style="padding-top: 0;padding-bottom:1em;padding-right: 1em;padding-left: 1em;height:auto;width: auto; overflow-y: auto;margin-bottom: 5%">

                    <div class="div-text-name-card" style="">
                        <p class="p-text-name-card"></p>
                    </div>
                    <div style="background: white;padding:3px;" class="container-fluid" >
                        <div class="row" style="padding-left: 5%;padding-right: 5%;padding-bottom: 5%">
                            <div class="checkout-details" style="font-size: 14px">
                                <div class="col-md-12">
                                    <div class="demo-container">
                                        <div class="card-wrapper my-3"></div>
                                        <div class="form-container active">
                                            <form id="form-checkout" name="form-checkout" action="{!! \App\Http\Common\Services\RouteService::GetSiteURL("mercadopago-request") !!}" method="{!! \App\Http\Common\Services\RouteService::GetSiteURLMethod('mercadopago-request') !!}">
                                                <input name="cardNumberx" type="text" id="card_numberx" style="display:none!important">
                                                <input type="hidden" id="order_id" name="order_id" value="">
                                                <input class="form-control" type="hidden" id="_token" name="_token" value="{!! csrf_token()!!}">
                                                <div style="padding-left: 5%;display: flex;text-transform: uppercase;padding: 10px 30px;">
                                                    <span style="font-family:'CustomAppFontBlack';width: 50%;">{{trans($lang.'lbl_prices_total')}}:</span>
                                                    <span id="card_total" style="font-family:'CustomAppFontBlack';width: 50%;text-align: end"></span>
                                                </div>
                                                <div style="padding-left: 5%;display: flex;text-transform: uppercase;padding: 10px 30px;">
                                                    <span style="font-family:'CustomAppFontBlack';width: 50%;">{{trans($lang.'lbl_total_discount')}}:</span>
                                                    <span id="card_total_discount" style="font-family:'CustomAppFontBlack';width: 50%;text-align: end"></span>
                                                </div>
                                                <div style="padding-left: 5%;display: none;text-transform: uppercase;padding: 10px 30px;" id="disc-card">
                                                    <p style="text-transform: initial;font-family:'CustomAppFontBlack';color:red;font-size: 12px;cursor: pointer" id="disc-card-act">{{trans($lang.'exist_discount_card')}}</p>
                                                </div>
                                                @csrf
                                                <div class="row mb-2">
                                                    <div class="col-md-12 col-sm-12">
                                                        <input class="form-control" placeholder="{{trans($lang.'lbl_register_inp_card_number')}}" name="cardNumber" id="card_number"  oncopy="return false" onpaste="return false">
                                                        <input type="hidden" name="payment_method_id" id="payment_method_id"/>
                                                        <select style="display:none" name="issuer" id="form-checkout__issuer">
                                                            <option value="" disabled selected>{{trans($lang.'lbl_issuer_default')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-12 col-sm-12">
                                                        <input name="cardholderEmail" placeholder="{{trans($lang.'lbl_register_inp_email')}}" class="form-control mb-0" style="font-size: 14px;
                                                        border-radius: 4px;border: 1px solid #ccc;padding: 6px 12px;height: 34px;" type="email" id="cardholderEmail">
                                            
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-12 col-sm-12">
                                                        <input name="cardholderName" placeholder="{{trans($lang.'lbl_register_inp_first_name')}}" class="form-control mb-0" style="font-size: 14px;
                                                        border-radius: 4px;border: 1px solid #ccc;padding: 6px 12px;height: 34px;" type="text" id="people_name">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-6 col-sm-6 mb-2">
                                                            <input class="form-control" name="expiry" id="expiry" placeholder="MM/YY">
                                                            <input type="text" name="cardExpirationMonth" id="cardExpirationMonth" style="display:none"/>
                                                            <input type="text" name="cardExpirationYear" id="cardExpirationYear" style="display:none"/>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 mb-2">
                                                        <input placeholder="CVC" class="form-control" name="securityCode" type="number" id="card_cvc">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 mb-2">
                                                        <select class="form-control visible_always" style="height: 40px" name="identificationType" id="docType" >
                                                            <option value="" disabled selected>{{trans($lang.'lbl_document_type_default')}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 mb-2">
                                                        <input placeholder="********" style="font-size: 14px;border-radius: 4px;border: 1px solid #ccc;padding: 6px 12px;display:block!important" 
                                                        class="form-control" type="text" name="identificationNumber" id="docNumber"/>
                                                    </div>
                                                </div>
                                                <div id="view_dues" class="row" style="display: none;">
                                                    <div class="col-md-12 col-sm-12">
                                                        <label for="installments">{{trans($lang.'lbl_cuotas')}}</label>
                                                            <select id="installments" class="form-control" name="installments">
                                                                <option value="" disabled selected>{{trans($lang.'lbl_cuotas_default')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-2"></div>
                                                        <div class="col-md-8 col-sm-8">
                                                        </div>
                                                        <div class="col-md-2 col-sm-2"></div>
                                                    </div>
                                                    <input id="MPHiddenInputToken" name="token" type="hidden" />
                                                    <input id="MPHiddenInputPaymentMethod" name="payment_method_id" type="hidden" />
                                                    <input id="transactionAmmount" name="transactionAmmount" type="hidden"/>
                                                    <input id="description" name="description" type="hidden" value="{{trans($lang.'lbl_description_default')}}" />
                                                    <button style="display:none" type="submit" id="form-checkout__submit">{{trans($lang.'lbl_btn_pay')}}</button>
                                            
                                                </form>
                                        </div>
                                    </div>
                                </div>

                                <div id="dvPayment" class="payment-box text-center">
                                    <hr/>
                                    <button class="btn essence-btn responsive100" style="width: 90%;margin-top: 3%;background: black;text-transform: uppercase;" id="btn-pay-ord">
                                        {!! trans($lang.'lbl_btn_pay') !!}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('bottom_scripts') 
   

    <!--<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>-->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <!--<script src="asset("resources/assets/".$group."/ecommerce/js/bootstrap-datetimepicker.min.js")"></script>-->
    
    <script type="text/javascript" src="{{asset("resources/assets/".$group."/ecommerce/js/select2.full.min.js")}}"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
   
    <script type="application/javascript">

        var lima_id = {!! ParameterService::GetParameter("ubication_lima") !!};

        var level = 0;
        var type_store = {{ $delivery_id_par }};
        var type_delivery = {{ $delivery_id_par }};
       
        var shop_id = null;
        var city_loc_id = null;
        var name_city = '';

        var ubication_types = JSON.parse('{!! ParameterService::GetParameter("ubication_types") !!}');
        var check_term = 0;
        var ubi_loc_id = null;
        /**********************************/
        var lst_cards = [];
        /**********************************/
        var digits_verif = 0;
        var bin_verifi = "";
        /**********************************/
        var id_currency_dis = "";
        var error = false;

        /* DISCOUNT */
        var curr_id_ = null;
        var value_discount_ = null;
        var text_discount_ = "";
        var disc_id_ = null;
        var tmp_id_card = null;
        var tmp_id_cup = null;
        /********/
        var disc_app = 0;
        var disc_card = 0;
        /** PR **/
        var total_mount = parseFloat('{!! $total_ !!}').toFixed(2);
        var discount = parseFloat('0.00').toFixed(2);
        var discount_cup = parseFloat('0.00').toFixed(2);
        var discount_card = parseFloat('0.00').toFixed(2);
        var curr_symbol = '{!! $currency_symbol !!}';
        var shipp = parseFloat('0.00').toFixed(2);
        /******/
        var mp = null;
        
        $(document).ready(function(){

            mp = new MercadoPago('{{$mp_credentials["public_key"]}}');
            const cardNumberElement = document.getElementById('card_number');
            cardNumberElement.addEventListener('keyup', async () => {
            try {
                const paymentMethodElement = document.getElementById('MPHiddenInputPaymentMethod');
                let cardNumber = cardNumberElement.value;
    
                if (cardNumber.replace(/\s/g, "").length < 6 && paymentMethodElement.value) return paymentMethodElement.value = "";
    
                if (cardNumber.replace(/\s/g, "").length >= 6 && !paymentMethodElement.value) {
                    
                    
                    let bin = cardNumber.replace(/\s/g, "").substring(0,6);
                    ChargeDiscount(bin);
                    const paymentMethods = await mp.getPaymentMethods({'bin': bin});
    
                    const { id: paymentMethodID, additional_info_needed, issuer } = paymentMethods.results[0];
    
                    // Assign payment method ID to a hidden input.
                    paymentMethodElement.value = paymentMethodID;
    
                    // If 'issuer_id' is needed, we fetch all issuers (getIssuers()) from bin.
                    // Otherwise we just create an option with the unique issuer and call getInstallments().
                    additional_info_needed.includes('issuer_id') ? getIssuers() : (() => {
                        const issuerElement = document.getElementById('form-checkout__issuer');
                        createSelectOptions(issuerElement, [issuer]);
                        getInstallments();
                    })()
                    }
                }catch(e) {
                    console.error('error getting payment methods: ', e)
                }
            });
            /*$("#card_number").bind({
                paste : function(){
                    CopPastCard();
                }
            });*/
        });
        /*function doPay(event) {
            event.preventDefault();
            if (!doSubmit) {
                var card_not_spaces = $('#form-checkout__cardNumber').val().replace(' ', '');
                $('#form-checkout__cardNumber').val(card_not_spaces);
                var $form = document.querySelector('#form-checkout');
                window.Mercadopago.createToken($form, sdkResponseHandler);
                return false;
            } else {
                
                ClearFormPayment();
                doSubmit = false;
            }
        }*/

        </script>
        
        <script>

            function createSelectOptions(elem, options, labelsAndKeys = { label : "name", value : "id"}){
                const {label, value} = labelsAndKeys;
    
                elem.options.length = 0;
    
                const tempOptions = document.createDocumentFragment();
    
                options.forEach( option => {
                    const optValue = option[value];
                    const optLabel = option[label];
    
                    const opt = document.createElement('option');
                    opt.value = optValue;
                    opt.textContent = optLabel;
    
                    tempOptions.appendChild(opt);
                });
    
                elem.appendChild(tempOptions);
            }
    
            function LoadDocumentsTypes(){
                (async function getIdentificationTypes () {
                    try {
                        const identificationTypes = await mp.getIdentificationTypes();
                        const docTypeElement = document.getElementById('docType');
                        createSelectOptions(docTypeElement, identificationTypes)
                    }catch(e) {
                        return console.error('Error getting identificationTypes: ', e);
                    }
                })()
            }

            // Step #getIssuers
            const getIssuers = async () => {
                try {
                    const cardNumber = document.getElementById('card_number').value;
                    const paymentMethodId = document.getElementById('MPHiddenInputPaymentMethod').value;
                    const issuerElement = document.getElementById('form-checkout__issuer');
    
                    const issuers = await mp.getIssuers({paymentMethodId: paymentMethodID, bin: cardNumber.replace(/\s/g, "").slice(0,6)});
    
                    createSelectOptions(issuerElement, issuers);
    
                    getInstallments();
                }catch(e) {
                    console.error('error getting issuers: ', e);
                    Swal.fire({
                            icon: 'error',
                            title: '{!! trans($lang."txt_mp_title_error") !!}',
                            text: '{!! trans($lang."txt_mp_error_issuer") !!}'
                            });
                }
            };
    
            const getInstallments = async () => {
                try {
                const installmentsElement = document.getElementById('installments');
                const cardNumber = document.getElementById('card_number').value;
                
                if(Number.isNaN(discount)==true){
                    discount = 0;
                }
                let current_total = Number(total_mount) + Number(shipp);
                let current_total_discount = Number(current_total) - Number(discount);
    
                if(current_total!=current_total_discount){
                    $('#card_total_discount').css("color","red");
                    $('#card_total_discount').text('{!! $currency_symbol !!}' +' '+ parseFloat(current_total_discount).toFixed(2));
                }
    
                $('#transactionAmmount').value = parseFloat(current_total_discount).toFixed(2);
                const installments = await mp.getInstallments({
                    amount: parseFloat(current_total_discount).toFixed(2),
                    bin: cardNumber.replace(/\s/g, "").slice(0,6)
                });
                
                    createSelectOptions(installmentsElement, installments[0].payer_costs, {label: 'recommended_message', value: 'installments'})
                    $('#view_dues').css('display','block');
                    $('#installments').css('display','block');
                }catch(e) {
                    console.error('error getting installments: ', e);
                    Swal.fire({
                            icon: 'error',
                            title: '{!! trans($lang."txt_mp_title_error") !!}',
                            text: '{!! trans($lang."txt_mp_error_cuotas") !!}'
                            });
                }
            }
    
            // Step #createCardToken
            const formElement = document.getElementById('form-checkout');
            formElement.addEventListener('submit', e => createCardToken(e));
    
            const createCardToken = async (event) => {
            try {
                if(Number.isNaN(discount)==true){
                        discount = 0;
                    }
                    let current_total = Number(total_mount) + Number(shipp);
                    let current_total_discount = Number(current_total) - Number(discount);
                    document.getElementById('transactionAmmount').value = parseFloat(current_total_discount).toFixed(2);
                const tokenElement = document.getElementById('MPHiddenInputToken');
    
                if (!tokenElement.value) {
                    event.preventDefault();
                    GenerateMonthAndYear();
                    const token = await mp.createCardToken({
                        cardNumber: document.getElementById('card_number').value.replace(/\s/g, ""),
                        cardholderName: document.getElementById('people_name').value,
                        identificationType: document.getElementById('docType').value,
                        identificationNumber: document.getElementById('docNumber').value,
                        securityCode: document.getElementById('card_cvc').value,
                        cardExpirationMonth: document.getElementById('cardExpirationMonth').value,
                        cardExpirationYear: document.getElementById('cardExpirationYear').value
                    });
    
                    tokenElement.value = token.id;
                    formElement.requestSubmit();
                }
    
            }catch(e) {
                console.error('error creating card token: ', e);
                Swal.fire({
                    icon: 'error',
                    title: '{!! trans($lang."txt_mp_title_error") !!}',
                    text: '{!! trans($lang."txt_mp_error_form_send") !!}'
                    });
            }
            }
        </script>
        <script>

        function UpdateInstallments(bin) {
            if(Number.isNaN(discount)==true){
                discount = 0;
            }
            let current_total = Number(total_mount) + Number(shipp);
            let current_total_discount = Number(current_total) - Number(discount);
            try {
                var installment =  mp.getInstallments({
                    amount: '1000',
                    locale: 'es-PE',
                    bin: bin,
                    processingMode: 'aggregator'
                    }, function (status, response) {
                        if (status == 200) {
                            document.getElementById('installments').options.length = 0;
                            response[0].payer_costs.forEach(installment => {
                                let opt = document.createElement('option');
                                opt.text = installment.recommended_message;
                                opt.value = installment.installments;
                                document.getElementById('installments').appendChild(opt);
                                $('#installments').css("display", "block");
                            });
                        } else {
                            ShowErrorMessage('installments method info error: ' + response);
                        }
                    });
            }catch(e) {
                console.error('error creating installments: ', e);
            }
        }
        $( "#btn-have-cup" ).on( "click", function() {
            ClearCardsSelec();
            $('.lst-oferts').css("display","none");
            $('.cup-div').css("display","flex");
        });
        $( "#btn-have-card" ).on( "click", function() {
            ClearCardsSelec();
            $('.cup-div').css("display","none");
            $('.lst-oferts').css("display","flex");
        });
        $( "#btn-cup-validate" ).on( "click", function() {
            let code_cup = $('#cup_code_inp').val();
            ChargeCupon(code_cup);

        });
        $("#btn-pay-start").on( "click", function() {

            /*let card_total = Number(total_mount) + Number(shipp);
            $("#card_total").text('{!! $currency_symbol !!}' + ' ' + parseFloat(card_total).toFixed(2));
            let card_total_discount = Number(card_total) - Number(discount);
            $("#card_total_discount").text('{!! $currency_symbol !!}' + ' ' + parseFloat(card_total_discount).toFixed(2));

            let current_card = $('.card_active').attr('id');
            if(current_card!=null){
                let id_disc = current_card;
                id_disc = id_disc.replace('btn_card_', '');
                $('.p-text-name-card').text($('#config_name_'+id_disc).val());
                $('#form-checkout__cardNumber').val($('#config_bin_'+id_disc).val());
            }
            guessPaymentMethod();
            $('#payMod').show();*/
        });
        $( "#btn-pay-ord" ).on( "click", function() {
            if($("#order_id").val()!="" && $("#order_id").val()!=null){
                ShowFullLoading();
                $("#form-checkout__submit").click();
            }else{
                PayOrder();
            }
        });
        $('#disc-card-act').on("click",function(){
            Swal.fire({
                type: 'info',
                title: '',
                html: '{!! trans($lang."body_replace_cupon") !!}',
                }).then((result) => {
                    $('#disc-card').css("display","none");
                    $('#cup-response').val('');
                    $('#cup_code_inp').val('');
                disc_app = 0;
                disc_card = 1;
                discount_cup = 0;
                discount = discount_card;
                disc_ic = tmp_id_card;
                let current_total =  Number(total_mount) + Number(shipp);
                let current_discount_total = Number(current_total) - Number(discount);
                $('#current_discount_total').text('{!! $currency_symbol !!}' +" "+ parseFloat(current_discount_total).toFixed(2));
                guessPaymentMethod();
                });
        });
        $('#card_number').keyup(function(){
            /*$('#card_numberx').val($('#card_number').val());
            let cardnumber = document.getElementById("card_number").value;
            cardnumber = cardnumber.replace(/\s/g, "");
            if (cardnumber.length == 6) {
                ChargeDiscount(cardnumber);
                UpdateInstallments(cardnumber.substring(0,6));
            }*/
        });
        $('#expiry').keyup(function (){
            
            if($("#expiry").val().length == 7){
                GenerateMonthAndYear();
            }else{
                $('#cardExpirationMonth').val('');
                $('#cardExpirationYear').val('');
            }
        });
        function DocumentReady(){
            
            check_term = 0;
            $('#checkOptionRecived').click(function () {
                if (!this.checked) {
                    $("#ex_information").css('display', 'block');


                }else{
                    $("#ex_information").css('display', 'none');
                }
            });
            $('#sel_department').change(function() { LoadProvinces($('#sel_department').val()); });
            $('#sel_province').change(function() { LoadDistricts($('#sel_province').val()); });
            $('#sel_district').change(function() { LoadShippingPrices($('#sel_district').val()); });
            LoadInitialData();

        }
        function updateCard(){
            //InitFormMerc();
            $('#card_number').value= $('#cardNumberx').value;
            $('#cardNumberx').value='';
        }
        function InitFormMerc(){
            LoadDocumentsTypes();
            PrepareCard();
            /*if(Number.isNaN(discount)==true){
                discount = 0;
            }
            let current_total = Number(total_mount) + Number(shipp);
            let current_total_discount = Number(current_total) - Number(discount);
            const cardForm = mp.cardForm({
            amount: parseFloat(current_total_discount).toFixed(2),
            autoMount: true,
            form: {
                id: "form-checkout",
                cardholderName: {
                id: "people_name",
                placeholder: "Titular de la tarjeta",
                },
                cardholderEmail: {
                id: "cardholderEmail",
                placeholder: "E-mail",
                },
                cardNumber: {
                id: "card_number",
                placeholder: "Número de tarjeta",
                },
                cardExpirationMonth: {
                id: "cardExpirationMonth",
                placeholder: "MM",
                },
                cardExpirationYear: {
                id: "cardExpirationYear",
                placeholder: "YY",
                },
                securityCode: {
                id: "card_cvc",
                placeholder: "CVC",
                },
                installments: {
                id: "installments",
                placeholder: "Cuotas",
                },
                identificationType: {
                id: "docType",
                placeholder: "Tipo de documento",
                },
                identificationNumber: {
                id: "docNumber",
                placeholder: "Número de documento",
                },
                issuer: {
                id: "form-checkout__issuer",
                placeholder: "Banco emisor",
                },
            },
            callbacks: {
                    onFormMounted: error => {
                        if (error) return console.warn("Form Mounted handling error: ", error);
                        console.log("Form mounted");
                    },
                    onSubmit: event => {
                        event.preventDefault();
                        if(Number.isNaN(discount)==true){
                            discount = 0;
                        }
                        console.log('onSubmit enviado');
                        let current_total = Number(total_mount) + Number(shipp);
                        let current_total_discount = Number(current_total) - Number(discount);

                        const {
                            paymentMethodId,
                            issuerId,
                            cardholderEmail: email,
                            transaction_amount: amount,
                            token,
                            installments,
                            identificationNumber,
                            identificationType,
                        } = cardForm.getCardFormData();
                        let order_id=$("#order_id").val();

                        fetch("{{RouteService::GetSiteURL('mercadopago-request')}}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            token,
                            issuerId,
                            order_id,
                            paymentMethodId,
                            transactionAmount: Number(current_total_discount),
                            installments: Number(installments),
                            payer: {
                                email,
                                identification: {
                                    type: identificationType,
                                    number: identificationNumber,
                                },
                            },
                        }),
                        }).then(response=>response.json())
                        .then(responseJson=>window.location.href=responseJson.response['url'])
                        .catch(error=>console.log(error));

                    },
                    onFetching: (resource) => {
                        console.log("Fetching resource: ", resource);
                        $('#issuer_id').addClass('always_visible');
                        $('#docType').addClass('always_visible');

                        $('#installments').addClass('always_visible');
                        $('#view_dues').addClass('always_visible');
                        
                    },
                },
        
            });*/
        }
        $(window).on('load', function () {});
        var default_id = -1;
        var default_text = "{!! trans($lang.'lbl_default_select') !!}";
        var input_level = ['sel_country','sel_department','sel_province','sel_district'];
        var ubication_id_level = null;
        function CopPastCard(){
            let inp_card_n = document.getElementById("card_number").value;
            inp_card_n = inp_card_n.replace(/\s/g, "");
            if(inp_card_n.length > 6){
                ChargeDiscount(inp_card_n);
                //UpdateInstallments(inp_card_n.substring(0,6));
            }
        }
        function LoadInitialData(){
            ShowOptionalAddress();
            $("#receiver_first_name").val("{!! $objUser["first_name"] !!}");
            $("#receiver_last_name").val("{!! $objUser["last_name"] !!}");
            $("#receiver_email").val("{!! $objUser["email"] !!}");
            $("#receiver_phone").val("{!! $objUser["phone"] !!}");
            $("#receiver_dni").val("{!! $objUser["dni"] !!}");
            LoadDepartments(1);
        }
        function LoadCountries(){
            LoadUbications(-1,1);
        }
        function ShowShops(){
            $("#is_in_shop").css('display', 'block');
            $("#is_delivery").css('display', 'none');

            $(".delivery_msg").css('display', 'none');
            $(".shop_msg").css('display', 'block');

            $('.ubi_select').removeClass('error-field');
            $('#inpAddress').removeClass('error-field');
            type_store = {{ $shop_id_par }};
            $("#btn_shop").removeClass().addClass("btn essence-btn responsive100");
            $("#btn_delivery").removeClass().addClass("btn essence-btn responsive100 method_active");
        }
        function ShowDeliveryAddresses(){
            $("#is_in_shop").css('display', 'none');
            $("#is_delivery").css('display', 'block');

            $(".delivery_msg").css('display', 'block');
            $(".shop_msg").css('display', 'none');

            $('.shop_information').removeClass('method_active');
            $('.shop_information').removeClass('gray-backg');
            type_store = {{ $delivery_id_par }};
            level = 0;
            shop_id = null;
            city_loc_id = null;
            name_city = '';
            $("#btn_delivery").removeClass().addClass("btn essence-btn responsive100");
            $("#btn_shop").removeClass().addClass("btn essence-btn responsive100 method_active");
        }
        function OpenMod(id) {
            if(id=='payMod'){
                ClearFormPayment();
                let error = false;
                /************************************* VALIDACIONES ******************************/
                $('.ubi_select').removeClass('error-field');
                $('error-text').val('');
                $('.input_step').removeClass('error-field');

                if($('#Terms-Cond').is(':checked')){
                    //VALIDATE USER DATA
                    let chk_name = $('#first_name').val();
                    let chk_last_name = $('#last_name').val();
                    let chk_document = $('#identification_code').val();
                    let chk_phone_number = $('#phone').val();
                    let chk_mail = $('#email').val();

                    let state=document.getElementById("checkOptionRecived").checked;
                    if(state==false){
                        chk_name = $('#ex_first_name').val();
                        chk_last_name = $('#ex_last_name').val();
                        chk_document = $('#ex_identification_code').val();
                        chk_phone_number = $('#ex_phone').val();
                    }
                    if(chk_name==''){
                        error = true;
                        if(state==true){
                            $('#first_name').addClass('error-field');
                        }else{
                            $('#ex_first_name').addClass('error-field');
                        }
                    }
                    if(chk_last_name==''){
                        error = true;
                        if(state==true){
                            $('#last_name').addClass('error-field');
                        }else{
                            $('#ex_last_name').addClass('error-field');
                        }
                    }
                    if(chk_document==''){
                        error = true;
                        if(state==true){
                            $('#identification_code').addClass('error-field');
                        }else{
                            $('#ex_identification_code').addClass('error-field');
                        }
                    }
                    if(chk_phone_number==''){
                        error = true;
                        if(state==true){
                            $('#phone').addClass('error-field');
                        }else{
                            $('#ex_phone').addClass('error-field');
                        }
                    }
                    if(chk_mail!='{{$objUser["email"]}}'){
                        error = true;
                        $('#email').addClass('error-field');
                    }
                    /////////////////////////////////////////////
                    //VALIDATE UBICATION SELECTED
                    if(type_store==type_delivery){
                        //DELIVERY
                        
                        let stateSelectUbications = CheckUbications();
                        if($('#inpAddress').val().length <4){
                            $('#inpAddress').addClass('error-field');
                            $('#lblErrorAddress').val("{!! trans($lang.'lbl_no_address') !!}");
                            error = true;
                        }
                        if(has_delivery_price==false){
                            error = true;
                        }
                        if(stateSelectUbications==false){
                            error = true;
                        }
                    }else{
                        //RECOJO EN TIENDA
                        if(shop_id==null){
                            error = true;
                        }
                    }
                    /*********************************************************************************/
                }else{
                    error = true;
                }
                 /********************************/
                if(error!=true){
                    /*$('#form-checkout').card({
                    container: '.card-wrapper',
                    });*/
           
                    //mps.getIdentificationTypes();
                    $('#docType').css("display","block!important");
                    //document.querySelector('#form-checkout').addEventListener('submit', doPay);


                    let card_total = Number(total_mount) + Number(shipp);
                    $("#card_total").text('{!! $currency_symbol !!}' + ' ' + parseFloat(card_total).toFixed(2));
                    let card_total_discount = Number(card_total) - Number(discount);
                    $("#card_total_discount").text('{!! $currency_symbol !!}' + ' ' + parseFloat(card_total_discount).toFixed(2));

                    let current_card = $('.card_active').attr('id');
                    if(current_card!=null){
                        let id_disc = current_card;
                        id_disc = id_disc.replace('btn_card_', '');
                        //$('.p-text-name-card').text($('#config_name_'+id_disc).val());
                        //$('#form-checkout__cardNumber').val($('#config_bin_'+id_disc).val());
                    }
                    //guessPaymentMethod();
                    InitFormMerc();
                    setTimeout(function(){ 
                        $("#"+id).show(); 
                    },3000);
                }else{
                    if(type_store==type_delivery){
                        Swal.fire({
                        type: 'error',
                        title: '{!! trans($lang."lbl_so_sorry") !!}',
                        html: '{!! trans($lang."lbl_error_forms") !!}',
                        }).then((result) => {
                            $('html, body').animate({scrollTop:150}, 'slow');
                        });
                    }else{
                        Swal.fire({
                        type: 'error',
                        title: '{!! trans($lang."lbl_so_sorry") !!}',
                        html: '{!! trans($lang."lbl_no_shop") !!}',
                        }).then((result) => {
                            $('html, body').animate({scrollTop:150}, 'slow');
                        });
                    }
                }
                    
            }else{
                $("#"+id).show();
            }
        }
        function CloseMod(id) {
            $('#'+id).animate({opacity: 0}, 400, function () {
                $('#'+id).hide();
                $('#'+id).css('opacity', '1');
            });
            if(id=="payMod"){
                $('#disc-card').css("display","none");
                disc_card = 0;
                discount = 0;
                discount_card = 0;
                if(Number(discount_cup)> 0){
                    discount = discount_cup;
                    disc_id_ = tmp_id_cup;
                }
                let current_total =  Number(total_mount) + Number(shipp);
                let current_discount_total = Number(current_total) - Number(discount);
                $('#current_discount_total').text('{!! $currency_symbol !!}' +" "+ parseFloat(current_discount_total).toFixed(2));
                ClearFormPayment();
            }
            return false;
        }      
        function shop_select_id(id){
            shop_id = id;
            $('.shop_information').removeClass('method_active');
            $('.shop_information').removeClass('gray-backg');

            $('#shop_'+id).addClass('gray-backg');
            $('#shop_'+id).addClass('method_active');
        }
        function ShowOptionalAddress() {
            $("#optional_address").css('display', 'block');
            $("#btn_optional_address").css('display', 'none');

        }  
        function CheckState(){
            if($('#Terms-Cond').is(':checked')){
                Check_status = true;
                $('#btn-pay-start').attr("disabled", false);
            }else{
                Check_status = false;
                $('#btn-pay-start').attr("disabled", true);
            }
        } 
        var has_delivery_price = false;
        function LoadDepartments(country_id){
            LoadUbications(country_id,2);
        }
        function LoadProvinces(department_id){
            LoadUbications(department_id,3);
        }
        function LoadDistricts(province_id){
            LoadUbications(province_id,4);
        }
        function LoadUbications(root_ubication,level,city=0){
                @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('internal_request',false)
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-get')
                @slot('parameters',"'root_ubication_id': root_ubication,")
                @slot('result_success')
                var query = '';
                let data = response;
                let qty_data = data.length;
                let is_id_ship = false;
                if (qty_data > 0) {
                    if(level == (ubication_types.length - 1)){
                        is_id_ship = true;
                    }
                    if(city==0){
                        let id = "inp_sel_ubications_" + level;
                        query = query + '<div id="dv_level_' + level + '" style="padding-bottom: 10px!important;padding-left: 0px;padding-right: 0px" class="col-md-12">';
                        level = level + 1;    
                        query = query + '   <label>' + ubication_types[level-2].group + '</label>';
                        query = query + '   <select class="form-control ubications ubi_select" id="' + id + '" name="' + id + '" onchange="ChangeUbication(\'' + id + '\','+(level)+','+is_id_ship+');">';
                        query = query + '       <option value="-1">{!!trans($lang."lbl_default_option_ubication")!!}</option>';
                        for (let i = 0; i < qty_data; i++) {
                            if(data[i].code!=''){
                                query = query + '   <option value="' + data[i].id + '">' + data[i].name_localized + '</option>';
                            }
                        }
                        query = query + '   </select>';
                        query = query + '   <label class="error-text" id="error_' + id + '" style="display: none;"></label>';

                        query = query + '</div>';
                        $(query).insertBefore("#dvAddressButtons");
                    }else{
                        let is_there = 0;
                        let id = "inp_sel_ubications_" + level;
                        query = query + '<div id="dv_level_' + level + '" style="padding-bottom: 10px!important;padding-left: 0px;padding-right: 0px" class="col-md-12">';
                        level = level + 1;    
                        query = query + '   <label>' + ubication_types[level-2].group + '</label>';
                        query = query + '   <select class="form-control ubications ubi_select" id="' + id + '" name="' + id + '" onchange="ChangeUbication(\'' + id + '\','+(level)+','+is_id_ship+');">';
                        query = query + '       <option value="-1">{!!trans($lang."lbl_default_option_ubication")!!}</option>';
                        for (let i = 0; i < qty_data; i++) {
                            if(data[i].code == ''){
                                is_there = 1;
                                query = query + '   <option value="' + data[i].id + '">' + data[i].name_localized + '</option>';
                            }
                        }
                        query = query + '   </select>';
                        query = query + '   <label class="error-text" id="error_' + id + '" style="display: none;"></label>';

                        query = query + '</div>';
                        if(is_there ==0){
                            query = '';
                        }
                        $(query).insertBefore("#dvAddressButtons");
                    }
                    
                }
                @endslot
                @slot('result_error')
                @endslot
                @endcomponent
        }
        function ChangeUbication(id,level,is_sp) {
            let selectCurrent = level - 1;
            let id_value = $('#'+id).val();
            DeleteUbicationSelects(selectCurrent);

            if(is_sp == true){
                LoadShippingPrices(id_value);
                if(level == ubication_types.length && $('#inp_sel_ubications_2').val()!=lima_id){
                    name_city = '';
                    let prov_id = $('#inp_sel_ubications_3').val();
                    LoadUbications(prov_id,level,1);
                }
            }else{
                LoadUbications(id_value, level);
                if(selectCurrent == ubication_types.length){
                    let selectCity = null;
                    name_city = $('select[name="inp_sel_ubications_5"] option:selected').text();
                }
            }
        }
        function DeleteUbicationSelects(selChanged) {
            if (selChanged == null) {
                level = 0;
            } else {
                var current_level = selChanged + 1;
                for (let i = current_level; i <= level; i++) {
                    $("#dv_level_" + i).remove();
                }
                level = current_level;
            }
        }
        function LoadShippingPrices(id){
            ubi_loc_id = id;
            ShowFullLoading();
                let mount_tot = total_mount;
                @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('internal_request',true)
                @slot('app_group',$group)
                @slot('route','get-cost-env')
                @slot('parameters',
                    "ubication_id:id,"
                )
                @slot('result_success')
                if(response.status==true){
                    has_delivery_price = true;
                    text_cost =  response.costo_envio;
                    shipp = parseFloat(response.costo_envio).toFixed(2);
                    
                    let current_total =  Number(total_mount) + Number(shipp);

                    let current_discount_total = Number(current_total) - Number(discount);

                    $('#current_shipping').text('{!! $currency_symbol !!}' +" "+ parseFloat(shipp).toFixed(2));
                    $('#current_total').text('{!! $currency_symbol !!}' +" "+ parseFloat(current_total).toFixed(2));

                    $('#current_discount_total').text('{!! $currency_symbol !!}' +" "+ parseFloat(current_discount_total).toFixed(2));
                    msg = response.message;
                    stat = 1;
                    opt_del = 1;
                }
                else{
                    has_delivery_price = false;
                    msg = response.message;
                    $('#current_shipping').text('{!! $currency_symbol !!}'+" 0.00");
                    stat = 0;
                    error= true;
                    
                    Swal.fire({
                        title: '<strong>{!! trans($lang."lbl_so_sorry") !!}</strong>',
                        type: 'info',
                        html: msg,
                        showConfirmButton: true,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonText:
                            '{!! trans($lang."lbl_ok") !!}',
                        confirmButtonAriaLabel: '{!! trans($lang."lbl_ok") !!}',
                        cancelButtonText:
                            '<i class="fa fa-thumbs-down"></i>',
                        cancelButtonAriaLabel: '{!! trans($lang."lbl_ok") !!}'
                    }).then((result) => {
                        if(response.type==1){
                            window.location.href='{!! App\Http\Common\Services\RouteService::GetSiteURL("cart") !!}';
                        }else{
                            $("#dv_level_5").remove();
                        }
                    });
                }
                @endslot
                @slot('ajax_complete')
                HideFullLoading();
                @endslot
                @endcomponent
        }
        function GetShippPrice(id){
            if(id!=null){
                ShowFullLoading();
                let mount_tot = total_mount;
                @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('internal_request',true)
                @slot('app_group',$group)
                @slot('route','get-cost-env')
                @slot('parameters',
                    "ubication_id:id,"
                )
                @slot('result_success')
                    has_delivery_price = true;
                    text_cost =  response.costo_envio;
                    return response.costo_envio;
                @endslot
                @slot('ajax_complete')
                HideFullLoading();
                @endslot
                @endcomponent
            }else{
                return 0;
            }
                
        }
        function PayOrder(){
            ShowFullLoading();
            let chk_name = '';
            let chk_last_name = '';
            let chk_document = '';
            let chk_phone_number = '';
            let chk_mail = $('#email').val();

            let state=document.getElementById("checkOptionRecived").checked;


            if(state==true){
                chk_name = $('#first_name').val();
                chk_last_name = $('#last_name').val();
                chk_document = $('#identification_code').val();
                chk_phone_number = $('#phone').val();
            }else{
                chk_name = $('#ex_first_name').val();
                chk_last_name = $('#ex_last_name').val();
                chk_document = $('#ex_identification_code').val();
                chk_phone_number = $('#phone').val();
            }
            /****************************************************************/
                if(name_city!=''){
                    let html_val = '{!! trans($lang."lbl_city_received") !!}';
                    html_val = html_val.replace(':prm',name_city);
                        Swal.fire({
                            title: '<strong>{!! trans($lang."title_city_received") !!}</strong>',
                            type: 'info',
                            html: html_val,
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText:
                                'ENTENDIDO',
                            confirmButtonAriaLabel: 'ENTENDIDO',
                            cancelButtonText:
                                '<i class="fa fa-thumbs-down"></i>',
                            cancelButtonAriaLabel: 'ENTENDIDO'
                        })
                        .then((result) => {
                            @component(config($group.'.ui.component.engine.ajax.view'))
                            @slot('internal_request',false)
                            @slot('app_group',$group)
                            @slot('ws_group','entity')
                            @slot('ws_name','order-register')
                            @slot('parameters',"
                                'user_id': ".$objUser['id'].",
                                'currency_code': '".$currency_code."',
                                'receiver_first_name': chk_name,
                                'receiver_last_name': chk_last_name,
                                'receiver_email': chk_mail,
                                'receiver_phone': chk_phone_number,
                                'receiver_dni': chk_document,
                                'ubication_id': ubi_loc_id,
                                'city': city_loc_id,
                                'shipp_c': shipp,
                                'for_my': state,
                                'id_discount':disc_id_,
                                'type_store':type_store,
                                'shop_id':shop_id,
                                'text_discount':discount,
                                'address': $('#inpAddress').val(),
                                'reference': $('#inpReference').val(),
                                'token': '".$token."',
                                'cart': '".json_encode($lstCartProducts,true)."',")
                            @slot('result_success')
                                $("#order_id").val(response["order_id"]);
                                ShowFullLoading();
                                setTimeout(function(){
                                    $("#form-checkout__submit").click();
                                },1000);
                                
                            @endslot
                            @slot('result_error')
                            //ShowCustomMessage('error','{!! trans($lang."error_message") !!}',message);
                            Swal.fire({
                            icon: 'error',
                            title: '{!! trans($lang."error_message") !!}',
                            text: message
                            });
                            @endslot
                            @endcomponent
                        });
                }else{
                    @component(config($group.'.ui.component.engine.ajax.view'))
                        @slot('internal_request',false)
                        @slot('app_group',$group)
                        @slot('ws_group','entity')
                        @slot('ws_name','order-register')
                        @slot('parameters',"
                        'user_id': ".$objUser['id'].",
                        'currency_code': '".$currency_code."',
                        'receiver_first_name': chk_name,
                        'receiver_last_name': chk_last_name,
                        'receiver_email': chk_mail,
                        'receiver_phone': chk_phone_number,
                        'receiver_dni': chk_document,
                        'ubication_id': ubi_loc_id,
                        'city': city_loc_id,
                        'shipp_c': shipp,
                        'for_my': state,
                        'id_discount':disc_id_,
                        'type_store':type_store,
                        'shop_id':shop_id,
                        'text_discount':discount,
                        'address': $('#inpAddress').val(),
                        'reference': $('#inpReference').val(),
                        'token': '".$token."',
                        'cart': '".json_encode($lstCartProducts,true)."',")
                    @slot('result_success')
                        $("#order_id").val(response["order_id"]);
                        ShowFullLoading();
                            setTimeout(function(){
                                $("#form-checkout__submit").click();
                            },1000);
                            
                    @endslot
                    @slot('result_error')
                    //ShowCustomMessage('error','{!! trans($lang."error_message") !!}',message);
                    Swal.fire({
                            icon: 'error',
                            title: '{!! trans($lang."error_message") !!}',
                            text: message
                            });
                    @endslot
                    @endcomponent
                }
        }
        function ChargeCupon(code_cup){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',false)
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','discount-validate')
            @slot('parameters',"code:code_cup,")
            @slot('result_success')
                if(response.length!=0){
                    discount = parseFloat(response.value).toFixed(2);
                    text_discount_ = response.value;
                    
                    let value_text_discount = "";
                    /**********************/
                    /*if(response.card_info!=null){
                        digits_verif = response.card_info.digits;
                        bin_verifi = response.card_info.bin;
                    }*/
                    /*******************/
                    curr_id_ = response.currency_id;
                    disc_id_ = response.id;
                    tmp_id_cup = response.id;
                    /*******************/
                    let current_total = total_mount;
                    let current_discount_total = null;
                    value_discount_ = Number(0);
                    if(response.free_shipping==1){
                        shipp = 0;
                        $('#current_shipping').text('{!! $currency_symbol !!}' +" "+ parseFloat(shipp).toFixed(2));
                    }
                    if(response.currency_id!=null){
                        value_text_discount = response.symbol + discount;
                        value_discount_ = discount;
                        id_currency_dis = response.currency_id
                    }else{
                        value_text_discount = discount + "%";
                        value_discount_ = (Number(total_mount) * Number(discount)) / 100;
                    }
                    discount_cup = value_discount_;
                    discount = value_discount_;

                    disc_app = 1;
                    disc_card = 0;
                    /********************************************************************/
                    if(current_total < value_discount_){
                        let message = '{!! trans($lang."lbl_discount_cupon_error") !!}'
                        $('#current_discount_total').text ('{!! $currency_symbol !!}' +' '+ parseFloat(total_mount).toFixed(2));
                        $('#cup-response').text(message);  
                    }
                    else{
                        /****************************/
                        current_total = Number(total_mount) + Number(shipp);
                        current_discount_total = Number(current_total) - Number(value_discount_);
                        /****************************/
                        let message = '{!! trans($lang."lbl_discount_cupon_applied") !!}'
                        $('#current_discount_total').text ('{!! $currency_symbol !!}' +' '+ parseFloat(current_discount_total).toFixed(2));
                        message = message.replace(':prm1', value_text_discount);
                        $('#cup-response').text(message);  
                    }
                }else{
                    disc_app = 0;
                    disc_card = 0;
                    disc_id_= null;
                    current_total = Number(total_mount) + Number(shipp);
                    current_discount_total = Number(current_total);
                    $('#current_discount_total').text ('{!! $currency_symbol !!}' +' '+ parseFloat(current_discount_total).toFixed(2));
                    $('#cup-response').text('{!! trans($lang."lbl_cupon_error") !!}');
                }
            @endslot
            @slot('result_error')
            @endslot
            @endcomponent
        }   
        function ChargeDiscount(digits){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',false)
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','discount-card-by-card')
            @slot('parameters',"digits:digits,")
            @slot('result_success')
            if(response.length!=0){
                    disc_app = 1;
                    discount = parseFloat(response.value).toFixed(2);
                    text_discount_ = response.value;

                    let value_text_discount = "";
                    /**********************/
                    /*digits_verif = $('#config_digits_'+id_dis).val();
                    bin_verifi = $('#config_bin_'+id_dis).val();*/
                    /*******************/
                    curr_id_ = response.currency_id;
                    disc_id_ = response.id;
                    /*******************/

                    if(response.currency_id!=null){
                        value_text_discount = response.symbol + discount;
                        value_discount_ = discount;
                        id_currency_dis = response.currency_id
                    }else{
                        value_text_discount = discount + "%";
                        value_discount_ = (Number(total_mount) * Number(discount)) / 100;
                    }
                    /****************************/
                    let current_total = Number(total_mount) + Number(shipp);
                    let current_discount_total = Number(current_total) - Number(value_discount_);
                    /****************************/

                    let message = '{!! trans($lang."lbl_discount_applied") !!}'
                    $('#current_discount_total').text ('{!! $currency_symbol !!}' +' '+ parseFloat(current_discount_total).toFixed(2));
                    message = message.replace(':prm1', value_text_discount);
                    $('#res_card_dis_'+digits).css("color","#0bb80b");
                    $('#res_card_dis_'+digits).text(message);

                    if(current_total!=current_discount_total){
                        $('#card_total_discount').css("color","red");
                        $('#card_total_discount').text('{!! $currency_symbol !!}' +' '+ parseFloat(current_discount_total).toFixed(2));
                    }
                }else{
                    disc_app = 0;
                    $('#res_card_dis_'+digits).text('');
                }
            @endslot
            @slot('result_error')
            @endslot
            @endcomponent
        }
        function GetCards(bin){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',false)
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','discount-get')
            @slot('parameters',"")
            @slot('result_success')
            let cards = response.cards;
            let select_card = null;
            let query = '';

                lst_cards = [];
                for(let i =0;i<cards.length;i++){
                    if(cards[i].card_info!=null){
                        let card_info = cards[i].card_info;
                        if(card_info.code == bin){
                            let cards_obj = {id: cards[i].id,bin: card_info.bin,code: card_info.code,name: card_info.name_card,digits: card_info.digits, value: cards[i].value, currency: cards[i].currency_id};
                            lst_cards.push(cards_obj); 
                            select_card = cards[i];
                        }
                    }
                }
                if(select_card!=null){
                    tmp_id_card = select_card.id;
                    if(select_card.symbol!=null){
                        val_discount_ = select_card.symbol + " " + parseFloat(select_card.value).toFixed(2);
                        value_discount_ = Number(parseFloat(select_card.value).toFixed(2));
                    }else{
                        val_discount_ = parseFloat(select_card.value).toFixed(2) + "%";
                        value_discount_ = (Number(total_mount) * Number(parseFloat(select_card.value).toFixed(2))) / 100;
                    }
                    if(disc_app==1){
                        if(Number(value_discount_)>Number(discount)){
                            discount_card = value_discount_;
                            $('#disc-card').css("display","block");
                        }
                    }else{
                        disc_id_ = select_card.id;
                        discount = value_discount_;
                    }
                    let current_discount_total = Number(current_total) - Number(value_discount_);
                    //val_discount_ = val_discount_.replace('.00','');
                }
            @endslot
            @slot('result_error')
            @endslot
            @endcomponent
        }
        function GetCardById(bin){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',false)
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','discount-card-by-card')
            @slot('parameters',"id:bin")
            @slot('result_success')
            let select_card = response;
            let query = '';

                if(select_card!=null){
                    tmp_id_card = select_card.id;
                    if(select_card.symbol!=null){
                        val_discount_ = select_card.symbol + " " + parseFloat(select_card.value).toFixed(2);
                        value_discount_ = Number(parseFloat(select_card.value).toFixed(2));
                    }else{
                        val_discount_ = parseFloat(select_card.value).toFixed(2) + "%";
                        value_discount_ = (Number(total_mount) * Number(parseFloat(select_card.value).toFixed(2))) / 100;
                    }

                    if(disc_app==1){
                        if(Number(value_discount_)>Number(discount)){
                            discount_card = value_discount_;
                            $('#disc-card').css("display","block");
                        }
                    }else{
                        disc_id_ = select_card.id;
                        discount = value_discount_;
                    }
                    let current_discount_total = Number(current_total) - Number(value_discount_);
                    //val_discount_ = val_discount_.replace('.00','');
                }
            @endslot
            @slot('result_error')
            @endslot
            @endcomponent
        }
        function GetListDiscount(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',false)
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','discount-get')
            @slot('parameters',"")
            @slot('result_success')
            let cards = response.cards;
            let coupon = response.coupon;
            let query = '';
            for(let i =0;i<cards.length;i++){
                let card_info = cards[i].card_info;
                query = query +'<div class="col-md-6 col-12">';
                query = query +'<button class="btn-card-offer btn_card responsive100 btn-responsive" style="margin-top: 3%;width: 100%" id="btn_card_'+cards[i].id+'">';
                
                let img = '{!! HtmlService::ParseImage("btncard.png","products") !!}';
                img = img.replace('btncard.png',card_info.image);
                query = query +'<img style="width: 50px" src="'+img+'">';
                let value_text = "";
                if(cards[i].symbol!=null){
                    value_text = cards[i].symbol + " " + parseFloat(cards[i].value).toFixed(2);
                }else{
                    value_text = parseFloat(cards[i].value).toFixed(2) + "%";
                }
                value_text = value_text.replace('.00','');


                /**********************************************/
                let card_code = "";
                let card_name = "";
                let card_bin = "";
                let card_digits = 0;
                let card_val = cards[i].value;
                let card_currency_id = cards[i].currency_id;
                if(card_info!=null){
                    card_code = card_info.code;
                    card_name = card_info.name_card;
                    card_bin = card_info.bin;
                    card_digits = card_info.digits;
                }
                /**********************************************/
                query = query +'<span class="value_cup_div_text">'+ value_text +'</span>';
                query = query +'</button>';
                query = query +'<input type="hidden" id="config_code_'+cards[i].id+'" value="'+card_info.code+'">';
                query = query +'<input type="hidden" id="config_name_'+cards[i].id+'" value="'+card_info.name_card+'">';
                query = query +'<input type="hidden" id="config_bin_'+cards[i].id+'" value="'+card_info.bin+'">';
                query = query +'<input type="hidden" id="config_digits_'+cards[i].id+'" value="'+card_info.digits+'">';
                query = query +'<label class="res_card_dis" id="res_card_dis_'+cards[i].id+'"></span>';
                query = query +'</div>';
            }
            if(query!=''){
                $('#btn-have-cup').before(query);
                $('.lst-oferts').css("display","flex");
                $('#btn-have-card').css("display","block");
            }
                
            $(".btn_card").on("click",function(){
                $('.res_card_dis').text('');
                $('.p-text-name-card').text('');
                $('#form-checkout__cardNumber').val('');

                let current_id = $('.card_active').attr('id');
                let id_card = $(this).attr('id');
                let id_disc = id_card;
                id_disc = id_disc.replace('btn_card_', '');
                $(".btn_card").removeClass("card_active");
                if(id_card!=current_id){
                    $("#"+id_card).addClass("card_active");
                    ChargeDiscount(id_disc);
                }else{
                    ClearCardsSelec();
                }
            })
            if(coupon.length<1){
                $('#btn-have-cup').css("display","none");
            }
            @endslot
            @slot('result_error')
            @endslot
            @endcomponent
        }
        function guessPaymentMethod() {
            let cardnumber = document.getElementById("form-checkout__cardNumber").value;
            cardnumber = cardnumber.replace(/\s/g, "");
            if (cardnumber.length >= 6) {
                $('#view_dues').hide();
                let card = cardnumber.substring(0, 6);
                issuer_id += 1;
                $('#issuer_id').val(issuer_id);
                window.Mercadopago.getPaymentMethod({
                    "bin": card
                }, setPaymentMethod);
            }
        }
        function setPaymentMethod(status, response) {
            /*if (status == 200) {
                let paymentMethodId = response[0].id;
                let element = document.getElementById('payment_method_id');
                element.value = paymentMethodId;
                $('#p-text-name-card').val(paymentMethodId);
                let cardnumber = document.getElementById("form-checkout__cardNumber").value;
                cardnumber = cardnumber.replace(/\s/g, "");
                if (cardnumber.length < 10) {
                    GetCardById(paymentMethodId);
                }
                getInstallments();
            } else {
                doSubmit = false;
                
            }*/
        }
        function getInstallmentsss() {
            if(Number.isNaN(discount)==true){
                discount = 0;
            }
            let current_total = Number(total_mount) + Number(shipp);
            let current_total_discount = Number(current_total) - Number(discount);

            if(current_total!=current_total_discount){
                $('#card_total_discount').css("color","red");
                $('#card_total_discount').text('{!! $currency_symbol !!}' +' '+ parseFloat(current_total_discount).toFixed(2));
            }
        }
        function sdkResponseHandler(status, response) {
            if (status != 200 && status != 201) {
                doSubmit = false;
                
                ShowErrorMessage("Por Favor verifique los datos ingresados.");
                ClearFormPayment();
                doSubmit = false;

            } else {
                $('#p-text-name-card').val(response.id);
                var form = document.querySelector('#form-checkout');
                var card = document.createElement('input');
                card.setAttribute('name', 'token');
                card.setAttribute('type', 'hidden');
                card.setAttribute('value', response.id);
                form.appendChild(card);
                doSubmit=true;
                form.submit();
            }
        }
        function GenerateMonthAndYear() {
            var arrMesAnho = $('#expiry').val().split('/');
                $('#cardExpirationMonth').val(arrMesAnho[0].trim());
                $('#cardExpirationYear').val('20' + arrMesAnho[1].trim());
        }
        function ClearFormPayment() {
            //mps.clearSession();
            $('#card_number').val('');
            $('#payment_method_id').val('');
            $('#people_name').val('');
            $('#expiry').val('');
            $('#cardExpirationYear').val('');
            $('#cardExpirationMonth').val('');
            $('#card_cvc').val('');
            $('#cardholderEmail').val('');
            $('#docNumber').val('');
            $('#view_dues').css('display','none');
            $('#installments').css('display','none');
            $('#card_total_discount').css('color','black');
        }
        function ClearCardsSelec(){
                disc_app = 0;
                $('.p-text-name-card').text('');
                $('#form-checkout__cardNumber').val('');
                let current_discount_total = Number(current_total) - Number(shipp);
                $('#current_discount_total').text ('{!! $currency_symbol !!}' +' '+ parseFloat(current_discount_total).toFixed(2));
                $('.res_card_dis').text('');
                curr_id_ = null;
                value_discount_ = 0;
                disc_id_ = null;
                $('#cup_code_inp').val('');  
                $('.btn-card-offer').removeClass('card_active');
                $('#current_total').text('{!! $currency_symbol !!}'+ parseFloat(current_total).toFixed(2));
        }
        function Calculate(){
        } 
        function CheckUbications(){
            let status = true;
            let items = document.getElementsByClassName("ubi_select");
                for(let i=0;i<items.length;i++){
                    let id_val = items[i].getAttribute("id");
                    if($('#'+id_val).val()==-1){
                        status = false;
                        let id_ = id_val.replace('inp_sel_ubications_','');
                        $('#inp_sel_ubications_'+id_).addClass('error-field');
                        $('#error_'+id_).val("{!! trans($lang.'lbl_option_no_selected') !!}");
                    }
                }
            return status;
        }
        function PrepareCard(){
            var card = new Card({
            // a selector or DOM element for the form where users will
            // be entering their information
            form: '#form-checkout', // *required*
            // a selector or DOM element for the container
            // where you want the card to appear
            container: '.card-wrapper', // *required*

            formSelectors: {
                numberInput: 'input#card_number', // optional — default input[name="number"]
                expiryInput: 'input#expiry', // optional — default input[name="expiry"]
                cvcInput: 'input#card_cvc', // optional — default input[name="cvc"]
                nameInput: 'input#people_name' // optional - defaults input[name="name"]
            },
            });
        }
    </script>
@endsection

