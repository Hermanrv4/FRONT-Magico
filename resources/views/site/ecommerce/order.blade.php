<?php

use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.ecommerce.order.lang');

$token = isset($token)?$token:null;
$status = isset($status)?$status:null;
$objOrder = null;
$transaction = "";
if(isset($token)){
  $objOrder = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get-by-token', array("token" => $token))->response;  
  $transaction = trans($lang.'lbl_trx_order_status_'.$status,["trx"=>$objOrder["token"]]);
}


$class = "";
$icon = "";

$title = trans($lang.'lbl_title_order_status_'.$status);
$message = trans($lang.'lbl_message_order_status_'.$status);

switch ($status){
    case config($group.'.value.order.status.success'):
        $class = "success-text";
        $icon = "fa fa-check-circle";
        break;
    case config($group.'.value.order.status.pending'):
        $class = "success-text order-pending";
        $icon = "fa fa-exclamation-triangle";
        break;
    case config($group.'.value.order.status.failed'):
        $class = "success-text order-fail";
        $icon = "fa fa-exclamation";
        break;
}
?>
@extends(config($group.'.ui.template.ecommerce.view'))
@section('page_title',trans($lang.'page_title'))
@section('metas','')
@section('top_scripts','')
@section('body')


<br>
<section class="contacts_block" style="position:relative;padding-top:10%">
    <div class="container">
        <div class="padbot30" >
            <center>
                @if($status == config($group.'.value.order.status.success'))
                    <img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('success.jpg','icon') }}" style="width:200px!important;height:200px!important;">
                @else
                    <img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('error.jpg','icon') }}" style="width:200px!important;height:200px!important;">
                @endif
                <br/>
                <br/>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <h1 style="font-size: 16px;font-weight: bold;color: black;margin-bottom: 0px">{!! $title !!}</h1>
                    <p style="font-size: 16px;font-weight: bold;color: black">{!! $message !!}</p>
					@if($transaction!="")
                       <p style="line-height:1.5!important;text-transform: none!important;">{!! $transaction !!}</p>
                    @endif
                </div>
                <br/>

                
                <div class="col-md-12" style="text-align: center;">
                    <hr/>
                    <button class="btn-solid btn" style="background: red;color: white;" onclick="location.href='{!! RouteService::GetSiteURL('landing') !!}'">{!! trans($lang.'lbl_continue_buying') !!}</button>
                    <hr/>
                </div>
            </center>
        </div>
    </div>
</section>
    <!-- breadcrumb end -->
@endsection
@section('bottom_scripts')
    <script type="application/javascript">
        function DocumentReady(){
        }
    </script>
@endsection
