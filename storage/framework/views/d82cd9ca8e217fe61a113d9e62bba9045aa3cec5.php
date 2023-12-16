<?php

use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CategoryService;
use App\Http\Modules\Site\Services\SiteService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.component.filter.lang');

$category_id = isset($category_id)?$category_id:null;

$categories = array();
if($category_id==null){
    $arrCat = ApiService::Request(config('env.app_group_site'), 'entity', 'category-root-parents', array())->response;
}else{
    $arrCat=array();
    $arrCat[] = ApiService::Request(config('env.app_group_site'), 'entity', 'category-by-id', array("category_id"=>$category_id))->response;
}

for($i=0;$i<count($arrCat);$i++){
    $cat_id = ApiService::Request(config('env.app_group_site'), 'entity', 'category-by-urlcode', array('url_code'=>$arrCat[$i]["url_code_localized"]))->response;
    if(count($cat_id)>0) {
        $categories[] = $cat_id["id"];
        $categories = array_merge($categories, CategoryService::GetChildCategories($cat_id["id"]));
    }
}
$categories = implode(ParameterService::GetParameter('db_query_union'), $categories);

$data_filters = ApiService::Request(config('env.app_group_site'), 'entity', 'product-get-filters', array("categories"=>$categories,"currency_code"=>SiteService::GetCurrencyCode()))->response;
$min_price = $data_filters["prices"][0]["MIN_PRICE"]==null?0:$data_filters["prices"][0]["MIN_PRICE"];
$max_price = $data_filters["prices"][0]["MAX_PRICE"]==null?0:$data_filters["prices"][0]["MAX_PRICE"];

$lstCategories = ApiService::Request(config('env.app_group_site'), 'entity', 'category-root-parents', array())->response;
?>

<div id="sidebar" class="col-lg-3 col-md-3 col-sm-3 padbot50">
    <div class="sidepanel widget_categories">
        <h3>Product Categories</h3>
        <ul>
            <?php
            for($i=0;$i<count($lstCategories);$i++){
                echo '<li><a href="'.RouteService::GetSiteURL("catalogue-category", [$lstCategories[$i]["url_code_localized"]]).'" >'.$lstCategories[$i]["name_localized"].'</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="sidepanel widget_pricefilter">
        <h3>Filter by price</h3>
        <input type="hidden" id="order_by" value="0">
        <div id="price-range" class="clearfix">
            <label for="amount">Range:</label>
            <input type="text" id="amount"/>
            <div class="padding-range"><div id="slider-range"></div></div>
        </div>
    </div>
</div>

<?php /**PATH /var/www/html/magico.pe/resources/views/site/component/filter.blade.php ENDPATH**/ ?>