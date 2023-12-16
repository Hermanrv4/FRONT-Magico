<?php
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Modules\Site\Services\SiteService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.component.product.presentation.lang');

$lstSP = ApiService::Request(config('env.app_group_site'), 'entity', 'specification-get', array())->response;
$lstLP = array();
$currency_code=ParameterService::GetParameter("default_currency_code");
$quantity =ParameterService::GetParameter("slider_quantity");
if($type=="all"){
    $allCategories=ParameterService::GetParameter("all_Categories");
    $lstLP = ApiService::Request(config('env.app_group_site'), 'entity', 'product-catalogue', array('page_qty'=>$quantity,'currency_code'=>$currency_code,'categories'=>$allCategories))->response;
}else{
    $lstLP = ApiService::Request(config('env.app_group_site'), 'entity', 'product-catalogue', array('page_qty'=>$quantity,'currency_code'=>$currency_code,'categories'=>$id_ref))->response;
}
?>
<div class="popular-products-slides owl-carousel">
    @for($i=0;$i<20;$i++)
        @include(config($group.'.ui.component.product.box.view'),array("type"=>config($group.'.value.product.box-type.general'),"product_data"=>$lstLP[$i],"specifications"=>$lstSP))
    @endfor
</div>