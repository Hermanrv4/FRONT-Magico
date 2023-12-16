<?php
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CartService;
use App\Http\Modules\Site\Services\ProductService;
use App\Http\Modules\Site\Services\SiteService;
use App\Http\Common\Helpers\AppHelper;
use App\Http\Modules\Site\Services\HtmlService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.ecommerce.cart.lang');

$lstCartProducts = CartService::GetCart();
$total = 0;
$total_items = 0;
$currency_symbol = "";
$lstSpecifications = ApiService::Request(config('env.app_group_site'), 'entity', 'specification-get', array())->response;
?>

<?php $__env->startSection('page_title',trans($lang.'page_title')); ?>
<?php $__env->startSection('metas',''); ?>
<?php $__env->startSection('top_scripts'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("resources/assets/".$group."/ecommerce/css/color.css")); ?>">
<style>
    .tovar_section{
        margin-top: 5%;
    }
    .also-resumen{
        margin-top: 0%;
    }
    @media  only screen and (max-width: 768px) {
        .essence-btn{
            margin-bottom: -5%;
        }
    }
    .cost-prev{
        font-weight:bolder;
        text-align: center;
        font-size: 15px;
        width: 100%;
    }
    @media  only screen and (max-width: 991px){
        .also-resumen{
            margin-top: 25px;
        }

        .btn_optional_address{
            width: 46%;
        }

        .order-details-confirmation{
            padding-right: 32px;
            padding-left: 35px;
        }
        .order-details-form{
            width: 80%;
        }
        .cost-prev{
            width: 84%;
        }
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<div class="container" style="padding-top: 1%">
    <div class="row tittle_ch_resume">
        <h5><b><?php echo trans($lang.'page_title'); ?></b></h5>
    </div>
    <div class="row">
        <div class="col-lg-9 col-md-9 padbot40">
            <?php
            if(count($lstCartProducts)==0){ ?>
                <div class="alert alert-info" role="alert"><?php echo trans($lang.'lbl_no_items'); ?></div>
                <?php }else{

                    $error_prices = false;
                    $product_data = null;
                    for($i=0;$i<count($lstCartProducts);$i++){
                        $product_data = ApiService::Request(config('env.app_group_site'), 'entity', 'product-by-id', ["currency_code"=> SiteService::GetCurrencyCode(),"product_id" => $lstCartProducts[$i]["product_id"]])->response;
                        $currency_symbol = $product_data['currency_symbol'];
                        if($product_data["online_price"] == ''){
                            $error_prices = true;
                        }
                    }
                
                if($error_prices==true){?>
                    <div class="alert alert-info" role="alert"><?php echo trans($lang.'lbl_no_prices_for_items',["prm1"=>$product_data["currency_symbol"]]); ?></div>
            <?php }else{ ?>
                    <div class="order-details-checkout">
                        <?php
                        for($i=0;$i<count($lstCartProducts);$i++){   
                            $product_data = ApiService::Request(config('env.app_group_site'), 'entity', 'product-by-id', ["currency_code"=> SiteService::GetCurrencyCode(),"product_id" => $lstCartProducts[$i]["product_id"]])->response;
                            $specifications = explode($product_data["str_limiter"],$product_data["specifications"]);
                            $lstEspecificationPreview = explode($product_data["str_union"],$specifications[0]);
                            
                            if($product_data['stock']>0 && $product_data['online_price']!="" && $product_data['online_price']!=null ){
                                $img_01 = null;
                                $lstProductImages = json_decode($product_data["product_photos"],true);
                                $Currency = $product_data["currency_symbol"];
                                $sub_total = $product_data['online_price'] * $lstCartProducts[$i]['qty'];
                                $total_items = $total_items + $lstCartProducts[$i]['qty'];
                                $url_link = RouteService::GetSiteURL('product',array($product_data["product_url_code"]));
                                $url_photo = HtmlService::ParseImage($lstProductImages[0],'products');
                                $total = $total + $sub_total;
                            ?>
                                <div class="hidden-responsive" style="max-height: 120px;margin-top: 3%;padding-bottom: 3%;">
                                        <div class="div-item" style="width: 100px">
                                           <a href="<?php echo $url_link; ?>" target="_blank">
                                               <img src="<?php echo $url_photo; ?>" width="90px" alt="">
                                           </a>
                                        </div>
                                <div class="div-item" style="font-size:50px;width: 350px;padding-left: 4%;text-align: left">
                                    <p style="cursor:pointer;margin-top:27px;font-weight: bold;color: black;font-size: 13px" onclick="OpenURL('<?php echo $url_link; ?>')" target="_blank"><?php echo $product_data["product_name"]; ?></p>
                                </div>
                                <div class="div-item" style="width: 90px!important;font-weight: bold;padding-top: 5%;font-size: 44px">
                                    <a style="font-size: 13px"><?php echo $product_data['currency_symbol']; ?> <?php echo number_format($product_data['online_price'],2); ?></a>
                                </div>
                                <div class="div-item button-contenedor" style="margin-top: 4%">
                                       <button class="btn-more-products" onclick="AddToCartInside(<?php echo $product_data['product_id']; ?>,<?php echo $product_data['online_price']; ?>,-1);">-</button>
                                       <button class="btn-quantity-products" id="btn_<?php echo $product_data["product_id"]; ?>" style="width: 57px"><?php echo $lstCartProducts[$i]['qty']; ?></button>
                                       <input type="hidden" style="display:none" id="inpQty_<?php echo $product_data["product_id"]; ?>" value="<?php echo $lstCartProducts[$i]['qty']; ?>"><input type="hidden" style="display:none" id="inpQty_<?php echo $product_data["product_id"]; ?>" value="<?php echo $lstCartProducts[$i]['qty']; ?>">
                                       <input type="hidden" style="display:none" id="inpQty_zero" value="0">
                                       <button class="btn-less-products" onclick="AddToCartInside(<?php echo $product_data['product_id']; ?>,<?php echo $product_data['online_price']; ?>,1);">+</button>
                                </div>
                                 <div class="div-item" style="width: 120px!important;font-weight: bold;padding-top: 5%;font-size: 44px">
                                    <a style="font-size: 13px"><?php echo $product_data['currency_symbol']; ?> <label id="lbl_subtotal_web_<?php echo $product_data['product_id']; ?>"><?php echo number_format($sub_total,2); ?></a>
                                </div>
                                <div class="div-item" style="width: 55px;padding-top: 4%;font-weight: bold;font-size: 49px">
                                    <a href="javascript:void(0);" style="color: black;font-size: 20px" onclick="SendAddToCart(<?php echo $product_data['product_id']; ?>,'inpQty_zero',1);">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                                </div>
                                <!-- RESPONSIVE SECTION -->
                                <div class="row div-item-responsive">
                                        <div class="col-xs-4 col-4" style="display: inline-block;padding-right: 0%;padding-top: 2%">
                                            <a href="#" onclick="OpenURL('<?php echo $url_link; ?>')" target="_blank">
                                                <img style="max-width:120%" src="<?php echo $url_photo; ?>" alt="" style="vertical-align: bottom">
                                            </a>
                                        </div>
                                        <div class="col-xs-6 col-6" style="display: inline-block;padding-right: 0%">
                                            <div class="col-xs-12">
                                            <a style="font-weight: bold;color: black" onclick="OpenURL('<?php echo $url_link; ?>')" target="_blank"><?php echo $product_data['product_name']; ?></a>
                                            <ul class="variation">
                                                <li class="variation-Color" style="font-size: 12px;"><?php echo $lstEspecificationPreview[0]; ?>: <span><?php echo $lstEspecificationPreview[1]; ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-xs-12">
                                            <button class="btn-more-products" onclick="AddToCartInside(<?php echo $product_data['product_id']; ?>,<?php echo $product_data['online_price']; ?>,-1);">-</button>
                                            <button class="btn-quantity-products"><?php echo $lstCartProducts[$i]['qty']; ?></button>
                                            <button class="btn-less-products" onclick="AddToCartInside(<?php echo $product_data['product_id']; ?>,<?php echo $product_data['online_price']; ?>},1);">+</button>
                                        </div>
                                        <div class="col-xs-12" style="font-weight: bold;"><?php echo $product_data['currency_symbol']; ?><label id="lbl_subtotal_mob_<?php echo $product_data["product_id"]; ?>"><?php echo number_format($sub_total,2); ?></div>
                                    </div>
                                    <div class="col-xs-2 col-2" style="display:inline-block;padding-right: 0%">
                                        <a href="javascript:void(0);" style="padding-top: 100%;font-size: 17px;position: absolute;color: black" onclick="SendAddToCart(<?php echo $product_data['product_id']; ?>,'inpQty_zero',1);">
                                            <span style="font-size: 20px;font-weight: bold" aria-hidden="true">&times;</span>
                                        </a>
                                    </div>
                                </div>
                                <?php
                                }
                            }
                            ?>
                    </div>
                    <?php } 
                } 
            ?>
            <a href="<?php echo RouteService::GetSiteURL('landing'); ?>" class="responsive100 block-web"  style="margin-top: 3%;color: black;text-align: center;text-decoration-line: underline;font-size: 1rem!important;"><?php echo e(trans($lang.'lbl_keep_buying')); ?></a>
        </div>
        <div class="col-lg-3 col-md-3" id="dvPaymentResume">
            <div class="order-details-confirmation order-details-checkout">
                <ul class="order-details-form mb-2">
                    <li>
                        <span style="font-size: 15px"><?php echo trans($lang.'lbl_prices_subtotal'); ?></span>
                        <span style="font-size: 15px"><?php echo $currency_symbol.' '; ?></span><span  id="total_price_div"><?php echo number_format($total,2); ?></span></li>
                </ul>
                <div class="cost-prev"><span style="font-size: 13px;width:100%;" ><?php echo trans($lang.'env_cost'); ?></span></div>
               
            </div>
            <a class="btn essence-btn" href="<?php echo \App\Http\Common\Services\RouteService::GetSiteURL('checkout',["token"=>AppHelper::GetToken()]); ?>" style="width: 100%;background: red"><span style="margin-left:-5%"><?php echo trans($lang.'lbl_continue_buy'); ?></span></a>
        </div>
    </div>
</div>

<div class="container also-resumen">
    <div class="row">
            <h5 class="title_section" style="padding-left: 20px;padding-top: 5%;"><?php echo trans($lang.'lbl_also_maybe_like'); ?></h5>
                    <div class="col-12" id="trending_now">
                    </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom_scripts'); ?>
    <script type="application/javascript">
        
        function DocumentReady(){
            <?php if(count($lstCartProducts)==0): ?>
            let url_home = "<?php echo \App\Http\Common\Services\RouteService::GetSiteURL('landing'); ?>";
            swal({
                type: 'error',
                title: '<?php echo trans($lang."lbl_no_items"); ?>',
                html: '<br><a href="<?php echo \App\Http\Common\Services\RouteService::GetSiteURL('landing'); ?>"><button class="btn btn-success" style="border-color: #ED1D2D;background: #ED1D2D;"><b>IR A COMPRAR</b></button></a></div>',
                showConfirmButton: false,
            });
            <?php endif; ?>
            LoadSlider("id","6","trending_now");
        }
        $(window).on('load', function () {});

        var currency = "<?php echo $currency_symbol; ?>";
        var total = <?php echo $total; ?>;
        function AddToCartInside(product_id,price,qty){
            var current_qty = parseInt($("#inpQty_"+product_id).val());
            var new_qty = current_qty+parseInt(qty);
            
            var observations = '';
            price = parseFloat(price);
            if(new_qty>0){
                <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('internal_request',true); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('route','cart-add'); ?>
                <?php $__env->slot('loader','(qty!=0)'); ?>
                <?php $__env->slot('parameters',
                    "product_id:product_id,
                    qty:new_qty,
                    replace:1,
                    observations:observations"
                ); ?>
                <?php $__env->slot('result_success'); ?>
                total = total + (price*qty);

                $("#inpQty_"+product_id).val(new_qty);
                $("#inpMovQty_"+product_id).text(new_qty);
                $("#btn_"+product_id).text(new_qty);
 
                $("#lbl_subtotal_web_"+product_id).text(parseFloat(price*new_qty).toFixed(2));
                $("#lbl_subtotal_mob_"+product_id).text(parseFloat(price*new_qty).toFixed(2));
                $('#total_price_div').text(parseFloat(total).toFixed(2));
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('ajax_complete'); ?>
                HideFullLoading();
                <?php $__env->endSlot(); ?>
                <?php echo $__env->renderComponent(); ?>
            }else{
                if(new_qty==0){
                    SendAddToCart(product_id,'inpQty_zero',1);
                }
            }
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config($group.'.ui.template.ecommerce.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/site/ecommerce/cart.blade.php ENDPATH**/ ?>