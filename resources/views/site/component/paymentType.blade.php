<?php

use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CategoryService;
use App\Http\Modules\Site\Services\SiteService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.component.paymentType.lang');
$izzipay = json_decode(ParameterService::GetParameter("integ_izzipay"),true);
?>
<script 
   src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js" 
   kr-public-key="{!! $izzipay["user"] !!}:{!! $izzipay["public_key"] !!}" 
   kr-post-url-success="{!! \App\Http\Common\Services\RouteService::GetSiteURL('izzipay-response')!!}">
  </script>

  <!-- theme and plugins. should be loaded after the javascript library -->
  <!-- not mandatory but helps to have a nice payment form out of the box -->
  <link rel="stylesheet" 
  href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.css">
 <script 
  src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js">
 </script> 
<div class="kr-embedded" 
kr-form-token="{!! $tokenForm !!}">

 <!-- payment form fields -->
 <div class="kr-pan"></div>
 <div class="kr-expiry"></div>
 <div class="kr-security-code"></div>

 <!-- payment form submit button -->
 <button class="kr-payment-button"></button>

 <!-- error zone -->
 <div class="kr-form-error"></div>
</div>

