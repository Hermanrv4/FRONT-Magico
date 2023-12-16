<?php
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CartService;
use App\Http\Modules\Site\Services\ProductService;
use App\Http\Modules\Site\Services\SiteService;
use App\Http\Modules\Site\Services\HtmlService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Common\Helpers\AppHelper;

$group = config('env.app_group_site');
$lang = config($group.'.ui.ecommerce.login.lang');
$lstCartProducts = CartService::GetCart();
?>
@extends(config($group.'.ui.template.ecommerce.view'))
@section('page_title',trans($lang.'page_title'))
@section('metas','')
@section('top_scripts')
<link rel="stylesheet" type="text/css" href="{{asset("resources/assets/".$group."/ecommerce/css/color.css")}}">
<style>
    .order-details-checkout{
        border: none!important;
    }
    .btn-responsive{
        min-width: 150px;
    }
    .checkout_area{
        padding-top: 15%!important;
    }
    @media only screen and (max-width: 991px){
        .btn-responsive{
            padding: 0px 25px;
            min-width: auto;
        }
        
        .checkout_area{
            padding-top: 25%!important;
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
<div class="checkout_area section-padding-80" style="padding-top: 10%">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                    <div>
                        <div>
                            <a class="btn essence-btn in_step" style="width: 100%" data-toggle="collapse"
                               href="#summary_collapse" aria-expanded="false" aria-controls="summary_collapse">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-lg-12" style="text-align: left">
                                        {!! trans($lang.'lbl_show_cart_list') !!}
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
                                                        $sub_total = $product_data["online_price"] * $lstCartProducts[$i]['qty'];
                                                        $url_link = RouteService::GetSiteURL('product',array($product_data["product_url_code"]));
                                                        $url_photo = HtmlService::ParseImage($lstProductImages[0],'products');
                                                    ?>
                                                    <div class="hidden-responsive" style="margin-top: 1%;padding-bottom: 1%;">
                                                        <div style="width:100%;margin-left:80px;margin-right: 80px">
                                                            <div class="div-item" style="width: max-content">
                                                               <a onclick="OpenURL('{!! $url_link !!}')" target="_blank">
                                                                   <img style="max-width:140px" src="{!! $url_photo !!}" width="140px" alt="">
                                                               </a>
                                                            </div>
                                                            <div class="div-item" style="width: 471px;text-align: center">
                                                                <a style="font-weight: bold;color: black;font-size: initial" onclick="OpenURL('{!! $url_link  !!}')" target="_blank">{!! $product_data["product_name"] !!}</a>
                                                                <ul class="variation">
                                                                </ul>
                                                            </div>
                                                            <div class="div-item" style="width: 100px!important;font-weight: bold;">
                                                                <a style="font-weight: bold;color: black;font-size: initial">{!! $product_data["currency_symbol"] !!} {!! number_format($product_data["online_price"],2) !!}</a>
                                                            </div>
                                                            <div class=" div-item" style="width: 100px!important;font-weight: bold;text-align: center">
                                                                <a style="font-weight: bold;color: black;font-size: initial">{!! $lstCartProducts[$i]['qty'] !!}</a>
                                                            </div>
                                                            <div class="div-item" style="width: 100px!important;font-weight: bold;">
                                                                <a style="font-weight: bold;color: black;font-size: initial">{!! $product_data["currency_symbol"] !!} {!! number_format($sub_total,2) !!}</a>
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
                                                            <a style="font-weight: bold;color: black" onclick="OpenURL('{!! $url_link  !!}')" target="_blank">{!! $product_data["product_name"] !!}</a>
                                                            <ul class="variation"> 
                                                                <li class="variation-Color" style="font-size: 12px;">{!! $lstEspecificationPreview[0] !!}: <span>{!! $lstEspecificationPreview[1] !!}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <span class="btn-quantity-products">{!! $lstCartProducts[$i]['qty'] !!}</span>
                                                        </div>
                                                        <div class="col-xs-12" style="font-weight: bold;">{!! $Currency !!} <label id="lbl_subtotal_{!! $product_data["product_id"] !!}">{!! number_format($sub_total,2) !!}</div>
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
                        </div>
                    </a>
                <div class="collapse" id="summary_collapse" style="border:1px solid var(--app_default_color);">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 margintop2" style="padding:0">
                <div class="order-details-confirmation order-details-checkout row" style="margin-left: 0px">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label for="email" style="font-size: 16px;margin-top: 10px;">{!!trans($lang.'lbl_input_lbl_email')!!}</label>
                            <input type="email" id="log_email" class="form-control" placeholder="" required>
                            <label class="error-text" id="error_mail_login"></label>
                        </div>
                        <div class="content-legacy">
							<p class="body-legacy">{!!trans($lang.'lbl_suscribe_plh_legacy')!!}
								<a class="a-legacy" href="">{!!trans($lang.'lbl_client_atention_terms')!!}</a>,
								<a class="a-legacy" href="">{!!trans($lang.'lbl_client_atention_privacity')!!}</a>,
								<a class="a-legacy" href="">{!!trans($lang.'lbl_client_atention_polity_cookies')!!}</a>,
								<a class="a-legacy" href="">{!!trans($lang.'lbl_client_atention_dates_tratament')!!}</a>.
							</p>
						</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn essence-btn" onclick="LoginUser()" style="background:red;float: right;margin-top: 0%;">Continuar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
     <!-- ##### Checkout Area Start ##### -->
    <!-- ##### Checkout Area End ##### -->                   
@endsection
@section('bottom_scripts')
    <script type="application/javascript">
        var facebook_id = null;
        function DocumentReady(){
        }
        $(window).on('load', function () {});
        function LoginUser(){
            ShowFullLoading();
            let email = $("#log_email").val();
            $(".error-text").css('display', 'none');
            $(".error-text").text("");

            if (IsEmail(email) == false) {
                $("#email_step_1").addClass("error-field");
                $("#error_mail_login").css("display","block");
                $("#error_mail_login").text("Ingrese un correo válido");
            }else{
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',false)
            @slot('app_group',$group)
            @slot('ws_group','authentication')
            @slot('ws_name','customer-email-login')
            @slot('parameters',"
                'email': email,
                'password': 'ABCDEF123456!!!',
                'is_password': 0
            ")
            @slot('result_success')
            AuthUserInMarketplace(response["user"]["id"],response["token"]);
            @endslot
            @slot('result_error')
            @endslot
            HideFullLoading();
            @endcomponent
            }
        }
        function SendWellcomeCustomerMail(user_id,token){
            ShowFullLoading();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',true)
            @slot('app_group',$group)
            @slot('route','customer-send-wellcome-mail')
            @slot('parameters',"
                'user_id': user_id,
            ")
            @slot('result_success')
			 AuthUserInMarketplace(user_id,token);
            @endslot
            @slot('result_error')
            ShowFormErrors(null,message,response);
            @endslot
            @endcomponent
        }
        function AuthUserInMarketplace(user_id,token){
            ShowFullLoading();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('internal_request',true)
            @slot('app_group',$group)
            @slot('route','customer-auth-ecommerce')
            @slot('parameters',"
                'user_id': user_id,
                'token': token
            ")
            @slot('result_success')
            setTimeout(
                function() {
                    location.href = "{!! \App\Http\Common\Services\RouteService::GetSiteURL('checkout',['token'=>AppHelper::GetToken()]) !!}";
                }, 1500);
            @endslot
            @slot('result_error')
            ShowFormErrors(null,message,response);
            @endslot
            @endcomponent
        }
    </script>
@endsection
