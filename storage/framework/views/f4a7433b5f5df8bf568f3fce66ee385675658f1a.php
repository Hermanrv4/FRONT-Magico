<?php

use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;

use App\Http\Modules\Site\Services\HtmlService;
use App\Http\Common\Services\ParameterService;
use App\Http\Modules\Site\Services\CategoryService;
use App\Http\Modules\Site\Services\SiteService;
use Illuminate\Support\Facades\Session;

$group = config('env.app_group_site');
$tracing = config('env.app_group_admin');
$lang = config($group.'.ui.ecommerce.catalogue.lang');

$name_category = "";
$code = null;
$category_id = null;
$codecategory="";

if(isset($category)){
    if($category!=null){
        $code = $category;
        $category = isset($category)?ApiService::Request(config('env.app_group_site'), 'entity', 'category-by-urlcode', array("url_code"=>$category))->response:null;
        $category_id = $category["id"];
        $name_category = $category["name_localized"];  
        $codecategory=$category['code'];
    }
}else{
    $code = 'Búsqueda: '.$search;
}


$sale = isset($sale)?$sale:0;
$search = isset($search)?$search:null;
//////////////////////////////////////////////////////////////////////////////
$title_site = '';
$description_site = '';
/////////////////////////////////////////////////////////////////////////////




/////////////////////////////////////////////////////////////////////////////
if($search==null){
    switch ($category_id) {
        case 1:
            $title_site=trans($lang.'title_cajas_chinas');
            $description_site = trans($lang.'meta_cajas_chinas');
            break;
        case 2:
            $title_site=trans($lang.'title_cilindros_parrilleros');
            $description_site = trans($lang.'meta_cilindros_parrilleros');
            break;
        case 3:
            $title_site=trans($lang.'title_rejillas_al_palo');
            $description_site = trans($lang.'meta_rejillas_al_palo');
            break;
        case 4:
            $title_site=trans($lang.'title_parrillas');
            $description_site = trans($lang.'meta_parrillas');
            break;
        case 5:
            $title_site=trans($lang.'title_edicion_limitada');
            $description_site = trans($lang.'meta_edicion_limitada');
            break;
        case 6:
            $title_site=trans($lang.'title_accesorios');
            $description_site = trans($lang.'meta_accesorios');
            break;
        case 7:
            $title_site=trans($lang.'title_complementos');
            $description_site = trans($lang.'meta_complementos');
            break;
        case 8:
            $title_site=trans($lang.'title_combos');
            $description_site = trans($lang.'meta_combos');
            break;
        default:
            $title_site='';
            $description_site = '';
            break;
    }
}else{
    $title_site=trans($lang.'title_default');
    $description_site = trans($lang.'description_default');
}

$categories = array();
    //$image_banner = HtmlService::ParseImage('banners/banner_default_thebeer.png');
    if($category_id!=null){
        $title_banner = $category["name_localized"];
        $categories = array_merge(array($category_id), CategoryService::GetChildCategories($category_id));
        //$image_banner = HtmlService::ParseImage($category["banner"],'banners');
    }else{
        $title_banner = trans($lang.'lbl_all_catalogue');
        $arrCat = ApiService::Request(config('env.app_group_site'), 'entity', 'category-root-parents', array("category_id"=>Session::get(config('env.app_market_view_session_id'))))->response;
        for($i=0;$i<count($arrCat);$i++){
            $cat_id = ApiService::Request(config('env.app_group_site'), 'entity', 'category-by-urlcode', array('url_code'=>$arrCat[$i]["url_code_localized"]))->response;
            if(count($cat_id)>0) {
                $categories[] = $cat_id["id"];
                $categories = array_merge($categories, CategoryService::GetChildCategories($cat_id["id"]));
            }
        }
    } 

$categories = implode(ParameterService::GetParameter('db_query_union'), $categories);    
$int_limiter = ParameterService::GetParameter('db_query_limiter');
$data_filters = ApiService::Request(config('env.app_group_site'), 'entity', 'product-get-filters', array("categories"=>$categories,"currency_code"=>SiteService::GetCurrencyCode()))->response;
$min_price = $data_filters["prices"][0]["min_price"]==null?0:$data_filters["prices"][0]["min_price"];
$max_price = $data_filters["prices"][0]["max_price"]==null?0:$data_filters["prices"][0]["max_price"];

$msgcategories=ParameterService::GetParameter('msg_discount_offer2');
$msg_discount_offer = json_decode(ParameterService::GetParameter("msg_discount_offer2"),true);
$msg_discount_offer =$msg_discount_offer[$codecategory];

$msgcategories=ParameterService::GetParameter('msg_discount_offer3');
$msg_discount_offer3 = json_decode(ParameterService::GetParameter("msg_discount_offer3"),true);
$msg_discount_offer3 =$msg_discount_offer3[$codecategory];



?>

<?php $__env->startSection('page_title',trans($lang.'page_title')); ?>
<?php $__env->startSection('metas'); ?>
<title><?php echo e($title_site); ?></title>
<meta name="description" content="<?php echo e($description_site); ?>"/>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('top_scripts'); ?>

    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset("resources/assets/".$group."/ecommerce/cs/css/ion.rangeSlider.css")); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset("resources/assets/".$group."/ecommerce/cs/css/ion.rangeSlider.css")); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset("resources/assets/".$group."/ecommerce/cs/css/jquery-bar-rating.css")); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset("resources/assets/".$group."/ecommerce/css/swiper.css")); ?>">
          <script
        src="<?php echo e(asset("resources/assets/".$group."/ecommerce/js/swiper.js")); ?>"></script>
    <style>
        
        .title_section{
            padding-bottom: 5%!important;
        }
        .card-header {
            border-bottom: 0px!important;
        }
        .single-mega{
            margin-left: 0px!important;
            margin-right: 0px!important;
        }
        .btn-link {
            color: black !important;
            opacity: 1 !important;
        }

        .product_sort{
            margin-left: 85%!important;
        }
        .shop{
            padding-top: 100px!important;
        }
        @media  only screen and (max-width: 991px) {

            .product_sort{
                margin-left: 10%!important;
            }
            .shop{
                padding-top: 0px!important;
            }
            .card-header {
                border-bottom: 1px solid rgba(0, 0, 0, .125);
                padding: .0rem 1.25rem!important;
            }
            .collapse{
                padding: 0rem 1.25rem!important;
            }
            .single-mega{
                margin-left: 6%!important;
                margin-right: 6%!important;
            }
            #dvListProductData{
                margin-top: 5%!important;
            }
        }
    </style>
    <style>

        .loader {
            width: 60px;
        }

        .loader-wheel {
            animation: spin 1s infinite linear;
            border: 2px solid rgba(30, 30, 30, 0.5);
            border-left: 4px solid #fff;
            border-radius: 50%;
            height: 50px;
            margin-bottom: 10px;
            width: 50px;
        }

        .loader-text {
            color: #fff;
            font-family: arial, sans-serif;
        }

        .loader-text:after {
            content: 'Loading';
            animation: load 2s linear infinite;
        }

        @keyframes  spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes  load {
            0% {
                content: 'Loading';
            }
            33% {
                content: 'Loading.';
            }
            67% {
                content: 'Loading..';
            }
            100% {
                content: 'Loading...';
            }
        }
    </style>
    <script
        src="<?php echo e(asset("resources/assets/".$group."/ecommerce/cs/js/ion.rangeSlider.js")); ?>"></script>
    <script
        src="<?php echo e(asset("resources/assets/".$group."/ecommerce/cs/js/jquery-bar-rating.js")); ?>"></script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('body'); ?>
   
            

                <?php if($msg_discount_offer3['active']==1): ?>
                <script>
                </script>
                        <div class="cookie-section" style="padding: 1%;display: block;background: red;">
                            <span style="color: white;"><?php echo $msg_discount_offer3['text']; ?><span style="
                            text-decoration:;
                            font-weight: bold;
                            color: white;"><?php echo $msg_discount_offer3['code']; ?></span>
                            </span>
                    </div>
                <?php endif; ?> 




    




    <!-- BREADCRUMBS -->
    <section class="breadcrumb parallax margbot10"></section>
    <!-- //BREADCRUMBS -->
    <section class="shop">
        <div class="container">
            <div class="header_list" style="text-align: center;padding-top: 50px!important;">
                <h1 id="title_result_search" class="title_section">
                </h1>
                <div id="dvListProductData" class="sorting_options clearfix row">
                    <div class="product_sort">
                        <div class="classy-nav-container breakpoint-off">
                                <select id="order_by" onchange="ReloadWithSortBy();">
                                    <option
                                        value="0" disabled><?php echo trans($lang.'lbl_sort_by'); ?></option>
                                    <option
                                        value="1" selected><?php echo trans($lang.'lbl_sort_by_price_asc'); ?></option>
                                    <option
                                        value="2" ><?php echo trans($lang.'lbl_sort_by_price_dsc'); ?></option>
                                    <option
                                        value="3" ><?php echo trans($lang.'lbl_sort_by_name_asc'); ?></option>

                                </select>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="hidden-responsive">
            <div class="row">
                <div class="col-lg-12 col-sm-12 padbot20">
                    <div class="row shop_block" id="dvGridProducts">
                    </div>
                    <div id="next_pagination"></div>
                </div>
            </div>
            <div style="margin-left: 50%">
                <div id="loading_next_products" class="loader" style="display: none">
                    <div class="loader-wheel"></div>
                    <div class="loader-text"></div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('bottom_scripts'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>
    <script type="application/javascript">
        page_content="<?php echo e($code); ?>";
        var page_num = 1;
        var is_loading = false;
        var is_max_count = false;
        var total = 0;
        var txt_search = '<?php echo $search; ?>';
        var categories_list = "<?php echo $categories; ?>";
        var is_sale = 0;
        var lst_products = "";

        function DocumentReady(){
            $("#txt_price").bootstrapSlider({});
        
    //DESCOMENTAR LANDING  DESCOMENTAR LANDING  DESCOMENTAR LANDING  DESCOMENTAR LANDING  DESCOMENTAR LANDING  DESCOMENTAR LANDING  
            LoadProducts();
            document.getElementById('msg-discount-landing').style.display='none'; 
        }
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 2000 && !is_loading && !is_max_count) {
                LoadProducts();
            }
        });
        function LoadProducts(){
            is_loading = true;
            let price_min = $('#price_min').text().replace('<?php echo e($data_filters["currency"]["symbol"]); ?>', '');
            let price_max = $('#price_max').text().replace('<?php echo e($data_filters["currency"]["symbol"]); ?>', '');
            let lstcategoriesfilters = "";
            let filters_list = "";
            ShowFullLoading();
            let order_by = $('#order_by').val();
                if(txt_search==null || txt_search=='' || txt_search=='null'){
                    txt_search = ''; 
                }
                if(categories_list==null || categories_list==''){
                    categories_list=null;
                }
                <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('internal_request',true); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('route','product-catalogue'); ?>
                <?php $__env->slot('parameters',"categories: categories_list,
                    sale: is_sale,
                    search: txt_search,
                    page_num: page_num,
                    filters: filters_list,
                    min_price: price_min,
                    max_price: price_max,
                    order: order_by,
                    categories_filter: lstcategoriesfilters,
                    lst_products: lst_products,"
                    ); ?>
                    <?php $__env->slot('result_success'); ?>
                    ShowFullLoading();
              
                    lst_products = response[1];
                    let message = "<?php echo trans($lang.'lbl_counter'); ?>";
                    let html_items = response[0];
                    
                    if (page_num == 1) {
                        if(response[1].length != 0){
                            
                            if(txt_search!="" && txt_search!="null"){
                                $('#title_result_search').text("Resultados de '"+txt_search+"'")
                            }else{
                                $('#title_result_search').text("<?php echo $name_category; ?>");
                            }

                            $("#dvGridProducts").html("");
                            $("#dvGridProducts").html(html_items);
                            //$('html, body').animate({scrollTop:150}, 'slow');
                        }else{
                            $('#title_result_search').text("Su búsqueda de '"+txt_search+"' no tuvo resultados"); 
                        }
                        
                    }
                    else {
                        if (response[1].length > 0) {
                            $("#dvGridProducts").append(html_items);
                            //$('html, body').animate({scrollTop:150}, 'slow');
                        }
                        if (response[1].length == 0){
                            is_max_count = true;
                        }
                    }
                    page_num = page_num + 1;
                    setTimeout(function () {
                        var tovar_img_h = $('.tovar_img_wrapper img').height();
                        $('.tovar_img_wrapper').css('height', tovar_img_h);
                        HideFullLoading();
                        is_loading = false;
                    }, 500);

                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('ajax_complete'); ?>
                    <?php $__env->endSlot(); ?>
                    <?php echo $__env->renderComponent(); ?>
        }

        function ReloadWithSortBy(){
            let order_by = $('#order_by').val();
            page_num = 1;
            if(order_by!=0){
                LoadProducts();
            }
        }


     
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make(config($group.'.ui.template.ecommerce.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/site/ecommerce/catalogue.blade.php ENDPATH**/ ?>