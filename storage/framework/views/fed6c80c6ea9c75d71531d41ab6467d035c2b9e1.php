<?php
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\HtmlService;
use App\Http\Modules\Site\Services\ProductService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.component.product.box.lang');

if(!isset($product_data) || $product_data == null) return ;
if(!isset($specifications) || $specifications == null) return ;

$lstFontBackPhotos = ProductService::GetFrontBackPhotos($product_data);
$lstPrices = ProductService::GetPrices($product_data);
$lstPreviews = ProductService::GetPreviews($specifications,$objSpColor,$objSpNeedUserInfo);
$lstMySpecifications = ProductService::GetMySpecifications($product_data);
$lstSimilarSpecifications = ProductService::GetSimilarSpecifications($product_data);
$spColorCode = null;
if(isset($product_data["visible"])==false){
    $product_data["visible"] = 1;
}

if($objSpColor != null) $spColorCode = $objSpColor["code"];
$data_photos = $product_data["product_photos"];
$arrPhotos = json_decode($data_photos,true);
?>
<?php if($type == config($group.'.value.product.box-type.general')): ?>

<div class="single-product-wrapper">
	<a href="<?php echo RouteService::GetSiteURL('product',array($product_data["product_url_code"])); ?>">
        <!-- Product Image -->
        <div class="product-img">
            <img class="image-new" src="<?php echo HtmlService::ParseImage($arrPhotos[0],"products"); ?>" alt="<?php echo $product_data["product_name"]; ?>">

            <!-- Hover Thumb -->
            <?php if($arrPhotos[1]!=""): ?>
            <img class="hover-img" src="<?php echo HtmlService::ParseImage($arrPhotos[1],"products"); ?>" alt="<?php echo $product_data["product_name"]; ?>">
            <?php endif; ?>
        </div>
    </a>
    <!-- Product Description -->
    <div class="product-description text-center" style="padding-top:0px">
                <h6><?php echo $product_data["product_name"]; ?></h6>

        <p class="product-price">
        <?php if($product_data["regular_price"]!=null): ?>
        <span class="old-price"><?php echo $product_data["currency_symbol"]." ".number_format(round($product_data["regular_price"],2),2); ?></span><br>
        <?php endif; ?>
        <span style="color:red;font-size: 150%;text-decoration: none;position:relative;top:-10px"><?php echo $product_data["currency_symbol"]." ".number_format(round($product_data["online_price"],2),2); ?></span>
        </p>
    </div>
</div>

<?php elseif($type == config($group.'.value.product.box-type.catalogue')): ?>
<div class="tovar_wrapper col-md-4" style="padding-bottom: 15px!important;">
    <div class="single-product-wrapper">
        <a href="<?php echo RouteService::GetSiteURL('product',array($product_data["product_url_code"])); ?>">
            <!-- Product Image -->
            <div class="product-img">
                <img class="image-new" src="<?php echo HtmlService::ParseImage($arrPhotos[0],"products"); ?>" alt="<?php echo $product_data["product_name"]; ?>">

                <!-- Hover Thumb -->
                <?php if($arrPhotos[1]!=""): ?>
                <img class="hover-img" src="<?php echo HtmlService::ParseImage($arrPhotos[1],"products"); ?>" alt="<?php echo $product_data["product_name"]; ?>">
                <?php endif; ?>
            </div>
        </a>
        <!-- Product Description -->
        <div class="product-description text-center" style="padding-top:0px">
            <h6 style="text-align: center;line-height: 1.5"><?php echo $product_data["product_name"]; ?></h6>

            <p class="product-price" style="text-align: center">
            <?php if($product_data["regular_price"]!=null): ?>
            <span class="old-price" style="font-size: 14px"><?php echo $product_data["currency_symbol"]." ".number_format(round($product_data["regular_price"],2),2); ?></span><br>
            <?php endif; ?>
            <span style="color:red;font-size: 150%;text-decoration: none;position:relative;top:-15px"><?php echo $product_data["currency_symbol"]." ".number_format(round($product_data["online_price"],2),2); ?></span>
            </p>
        </div>
    </div>
</div>
<?php elseif($type == config($group.'.value.product.box-type.mini')): ?>
    <div class="media">
        <a href="#"><img class="img-fluid blur-up lazyload" src="<?php echo $imgFront; ?>" alt=""></a>
        <div class="media-body align-self-center">
            <a href="#">
                <h6><?php echo $product_data["product_name"]; ?></h6>
            </a>
            <?php if(round($lstPrices["other"])!=null): ?>
            <h5 style="text-decoration:line-through;"> <?php echo $product_data["currency_symbol"]." ".number_format(round($lstPrices["other"],2),2); ?></h5>
            <?php endif; ?>
            <h4><?php echo $product_data["currency_symbol"]." ".number_format(round($lstPrices["principal"],2),2); ?></h4>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/magico.pe/resources/views/site/component/product/box.blade.php ENDPATH**/ ?>