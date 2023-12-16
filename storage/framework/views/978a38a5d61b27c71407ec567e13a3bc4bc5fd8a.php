<?php

use App\Http\Common\Services\ApiService;use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\SiteService;
use App\Http\Modules\Site\Services\HtmlService;
use \App\Http\Modules\Site\Services\ProductService;
use \App\Http\Common\Helpers\StringHelper;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.ecommerce.product.lang');

if(!isset($product_data) || $product_data == null) return ;
if(!isset($specifications) || $specifications == null) return ;

$arrPhotos = json_decode($product_data["product_photos"],true);

$lstPrices = ProductService::GetPrices($product_data);
$lstPreviews = ProductService::GetPreviews($specifications,$objSpColor,$objSpNeedUserInfo);
$lstMySpecifications = ProductService::GetMySpecifications($product_data);
$lstSimilarSpecifications = ProductService::GetSimilarSpecifications($product_data);

$simiLst =   ApiService::Request(config('env.app_group_site'), 'entity', 'product-spe-by-product-idspe', array("product_id" => $product_data["product_id"],"spe_id" => 1))->response;
$htmlPhotos = "";
$data_photos = $product_data["product_photos"];
$arrPhotos = json_decode($data_photos,true);
/*
for($i=0;$i<count($arrPhotos);$i++){
    if($arrPhotos[$i]!=""){
    $htmlPhotos=$htmlPhotos.'<li data-thumb="'.HtmlService::ParseImage($arrPhotos[$i],"products").'">
        <img style="width:350px;height:350px;object-fit: contain;object-position: center;" src="'.HtmlService::ParseImage($arrPhotos[$i],"products").'" alt="" /></li>';
    }
}
*/
if(isset($product_data["VISIBLE"])==false){
    $product_data["VISIBLE"] = 1;
}
$spColorCode = null;
$aditional_info = json_decode($product_data["aditional_info"],true);
$speList =   ApiService::Request(config('env.app_group_site'), 'entity', 'product-allspe-by-product', array("product_id" => $product_data["product_id"]))->response;
?>

<?php $__env->startSection('page_title',trans($lang.'page_title')); ?>
<?php $__env->startSection('metas',''); ?>
<?php $__env->startSection('top_scripts'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<style>
        .popular-products-slides .owl-controls .owl-nav .owl-prev:hover{
            background: none;
        }
        .popular-products-slides .owl-controls .owl-nav .owl-prev{
            background: none;
        }
        .popular-products-slides .owl-controls .owl-nav .owl-next{
            background: none;
        }
        .popular-products-slides .owl-controls .owl-nav .owl-next:hover{
            background: none;
        }
    .spacing_{
        display: block;
    }
    .swal2-popup .swal2-styled.swal2-confirm{
        color:black!important;
        text-decoration: underline!important;
        font-size: 14px!important;
        background-color:unset!important;
        padding: 0px!important;
    }
    .swal2-popup .swal2-styled.swal2-confirm:hover{
        color:black!important;
        text-decoration: underline!important;
        font-size: 14px!important;
        background-color:unset!important;
        padding: 0px!important;
    }
    .title_section{
        line-height: 1.5;
        text-align: initial;
        font-size: 35px;
        font-weight: normal;
    }
    .also{
        font-size: 55px;
        padding-left: 20px;
        padding-top: 5%;
    }
    .nopadd{
        padding: 0px;
        margin: 0px!important;
    }

    @media  only screen and (max-width: 991px){

        .spacing_{
            display: none;
        }

        .title_section{
            text-align: center;
            font-size: 30px;
        }

        .also{
            font-size: 30px;
            padding-left: 8px;
            padding-right: 8px;
        }
    }

    .out_of_stock{

        background-color:#EDEDED!important;
        color:#9b9b9b!important;
        cursor:not-allowed;
    }

    .with-stock{
        cursor:pointer;
    }

    .padding-5{
        padding-right: 5px;
        padding-left: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .product-img{
        width: 80%;
        left: 10%;
    }

    .h-movile{
        display:none;background-color: #0e0e0e; color: #fdfdfd;text-align: center;padding-left:10px;padding-right: 10px;
    }

    .h-desktop{
        display:block;background-color: #0e0e0e; color: #fdfdfd;text-align: center;padding-left:10px;padding-right: 10px;
    }

    ul, li {
        margin: 0;
        padding: 0;
        list-style: none
    }

    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {opacity: 0.7;}

    /* The Modal (background) */
    .modal-img {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 9999999999999999999; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content-img {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content-img, #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {-webkit-transform:scale(0)}
        to {-webkit-transform:scale(1)}
    }

    @keyframes  zoom {
        from {transform:scale(0)}
        to {transform:scale(1)}
    }

    /* The Close Button */
    .close-img {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close-img:hover,
    .close-img:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media  only screen and (max-width: 700px){
        .modal-content-img {
            width: 100%;
        }
    }

    /* Css para que el slider tenga flechas */
    .owl-buttons {
        display: none;
    }
    .owl-carousel:hover .owl-buttons {
        display: block;
    }

    .owl-item {
        text-align: center;
    }

    .owl-theme .owl-controls .owl-buttons div {
        background: transparent;
        color: #869791;
        font-size: 40px;
        line-height: 300px;
        margin: 0;
        padding: 0 60px;
        position: absolute;
        top: 0;
    }
    .owl-theme .owl-controls .owl-buttons .owl-prev {
        left: 0;
        padding-left: 20px;
    }
    .owl-theme .owl-controls .owl-buttons .owl-next {
        right: 0;
        padding-right: 20px;
    }
    .img-view {
        max-width:75%;
        max-height:75%;
        margin-left:15%;
    }


</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
    <!-- BREADCRUMBS -->
    <section style="padding: 3%">
    </section>
    <!-- //BREADCRUMBS -->
    <!-- Single Product Thumb -->
    <section class="single_product_details_area d-flex align-items-center unit_product" style="padding-top: 20px">
        <div class="single_product_thumb clearfix">
            <div class="product_thumbnail_slides owl-carousel">
                <?php for($i=0;$i<count($arrPhotos);$i++): ?>
                    <?php if($arrPhotos[$i]!=""): ?>
                        <a onclick="ShowModal('<?php echo HtmlService::ParseImage($arrPhotos[$i],'products'); ?>','<?php echo $product_data['product_name']; ?>')">
                            <img class="img-view" src="<?php echo HtmlService::ParseImage($arrPhotos[$i],'products'); ?>" alt="<?php echo $product_data['product_name']; ?>"/>
                        </a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if($arrPhotos[1]==''): ?>
                    <a onclick="ShowModal('<?php echo HtmlService::ParseImage($arrPhotos[0],'products'); ?>','<?php echo $product_data['product_name']; ?>')">
                        <img class="img-view" src="<?php echo HtmlService::ParseImage($arrPhotos[0],'products'); ?>" alt="<?php echo $product_data['product_name']; ?>"/>
                    </a> 
                <?php endif; ?>
            </div>
        </div>
        <!-- Single Product Description -->
        <div class="single_product_desc clearfix detail_description">
            <p class="title_section"><?php echo e($product_data["product_name"]); ?></p>
            <!-- Si es que está integrado con GEN, al precio se le debe añadir el IGV-->
                <p class="product-price">
                    <?php if($product_data["regular_price"]!=""): ?>
                        <span class="old-price"><?php echo e(($product_data["currency_symbol"]." ".number_format($product_data["regular_price"],2))); ?></span><br>
                    <?php endif; ?>
                    <span style="color:red;font-size: 90%;text-decoration: none;position:relative;top:-20px">
                        <?php echo ($product_data["regular_price"]=="" && $product_data["online_price"]=="" ?trans($lang.'lbl_no_price'):($product_data["currency_symbol"]." ".number_format($product_data["online_price"],2))); ?>

                    </span>
                </p>
            <?php if($aditional_info["is_description"] == 1): ?>
                <?php if($product_data["product_description"]!="" && $product_data["product_description"]!="-" ): ?>
                    <p class="product-desc" style="text-align: justify;line-height: 1.5;position: relative;top:-15px"><?php echo $product_data["product_description"]; ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <?php if($aditional_info["is_for_provincia"] == 1): ?>
                <!--<p class="product-desc" style="text-align: justify;line-height: 1.5;position: relative;top:-15px"> trans($lang.'lbl_only_lima') </p>-->
            <?php endif; ?>
            <div class="tovar_size_select">
                <p>
                    <b><?php echo trans($lang.'lbl_tamanos'); ?></b><br>
                    <?php for($i=0;$i<count($simiLst);$i++): ?>
                        <?php if($simiLst[$i]['id'] == $product_data["product_id"]): ?>
                            <?php if(intval($simiLst[$i]["stock"])>0): ?>
                                <a class="<?php echo $simiLst[$i]['id']; ?> active with-stock" style="width: 100px!important;height: 35px;font-size: 14px;line-height: 30px;">
                                    <?php echo $simiLst[$i]["value"]; ?>

                                </a>
                            <?php else: ?>
                                <a class="<?php echo $simiLst[$i]['id']; ?> active out_of_stock" style="width: 100px!important;height: 35px;font-size: 14px;line-height: 30px;">
                                    <?php echo $simiLst[$i]["value"]; ?>

                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if(intval($simiLst[$i]["stock"])>0): ?>
                                <a class="<?php echo $simiLst[$i]['id']; ?> with-stock" href="<?php echo RouteService::GetSiteURL('product',array($simiLst[$i]['url'])); ?>" style="width: 100px!important;height: 35px;font-size: 14px;line-height: 30px;">
                                    <?php echo $simiLst[$i]["value"]; ?>

                                </a>
                            <?php else: ?>
                                <a class="<?php echo $simiLst[$i]['id']; ?> out_of_stock" href="<?php echo RouteService::GetSiteURL('product',array($simiLst[$i]['url'])); ?>" style="width: 100px!important;height: 35px;font-size: 14px;line-height: 30px;">
                                    <?php echo $simiLst[$i]["value"]; ?>

                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endfor; ?>
                </p>
            </div>
            <!-- Cart & Favourite Box -->
            <div class="cart-fav-box d-flex align-items-center">
                <?php if($product_data["stock"]>0): ?>
                    <input type="hidden" value="1" id="selQuantity">
                <?php endif; ?>
            </div>
            <br>
            <!-- Cart & Favourite Box -->
            <div class="cart-fav-box d-flex align-items-center">
                <?php if($product_data["product_description"]!="" && $product_data["product_description"]!=null && $product_data["stock"]>0): ?>
                    <input type="hidden" id="qtyPreview" value="1">
                    <a onclick="SendAddToCart('<?php echo $product_data['product_id']; ?>','qtyPreview',false);"
                    name="addtocart" class="btn essence-btn" style="background: #ED1D2D"><?php echo e(trans($lang.'lbl_add_to_bag')); ?></a>
                <?php else: ?>
                    <?php if(intval($product_data["stock"])>0): ?>
                    <input type="hidden" id="qtyPreview" value="1">
                    <a onclick="SendAddToCart('<?php echo $product_data['product_id']; ?>','qtyPreview',false);"
                    name="addtocart" class="btn essence-btn" style="background: #ED1D2D"><?php echo e(trans($lang.'lbl_add_to_bag')); ?></a>
                    <?php else: ?>
                        <button name="addtocart" class="btn essence-btn" disabled><?php echo e(trans($lang.'lbl_no_stock')); ?></button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php if($aditional_info["is_description"] == 1): ?>
            <?php else: ?>
                <?php if($product_data["product_description"]=="" || $product_data["product_description"]=="-"): ?>
                    <div class="spacing_"><br><br><br><br><br><br><br>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>  
        <div class="single_product_thumb clearfix">
            <div class="row hidden-responsive">
                <div class="owl-carousel owl-theme" id="second_carousel">
                    <?php for($i=0;$i<count($arrPhotos);$i++): ?>
                        <?php if($arrPhotos[$i]!=""): ?>
                            <div class="item">
                                <a onclick="ShowModal('<?php echo HtmlService::ParseImage($arrPhotos[$i],'products'); ?>','<?php echo $product_data['product_name']; ?>')">
                                    <img style="width: 100%;" src="<?php echo HtmlService::ParseImage($arrPhotos[$i],'products'); ?>" />
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if($arrPhotos[1]==''): ?>
                        <div class="item">
                            <a onclick="ShowModal('<?php echo HtmlService::ParseImage($arrPhotos[0],'products'); ?>','<?php echo $product_data['product_name']; ?>')">
                                <img style="width: 100%;" src="<?php echo HtmlService::ParseImage($arrPhotos[0],'products'); ?>" />
                            </a>
                        </div>   
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if($aditional_info["is_detail"] == 1): ?>
            <div class="single_product_desc accordion_description clearfix" style="padding-top: 2%">
                <div class="accordion" id="accordionExample">
                    <div class="card" style="width: 100%">
                        <div class="card-header" id="headingOne"
                            style="padding: 0;border-bottom: 1px solid black!important;">
                            <h6 class="mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne">
                                <?php echo e(trans($lang.'lbl_tab_details')); ?>

                            </h6>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body" style="padding: 10px 0px 10px 0px!important;">
                                <?php for($i = 0; $i < count($speList); $i++): ?>
                                    <?php if($speList[$i]["value"]!="" && $speList[$i]["value"]!="-"): ?>
                                        <div class='row' style='padding-bottom: 10px!important;'>
                                            <div class='col-md-6 col-6'>
                                                <b><?php echo $speList[$i]["name"]; ?></b>
                                            </div>
                                            <div class='col-md-6 col-6'>
                                                <b><?php echo $speList[$i]["value"]; ?></b>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <div class="container" style="margin-top: 5%">
        <div class="row">
            <div style="width: 100%;text-align: -webkit-center">
                <h5 class="title_section also" style=""><?php echo e(trans($lang.'lbl_also_like')); ?></h5>
            </div>
            <div class="col-12" id="trending_now">
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal-img">
        <span class="close-img" onclick="closeModal()">&times;</span>
        <img class="modal-content modal-content-img" id="img01">
        <div id="caption"></div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom_scripts'); ?>
    <script type="application/javascript">
        function DocumentReady(){
            LoadSlider("all","","trending_now");
            $('.popular-products-slides').owlCarousel({
                items: 4,
                margin: 30,
                loop: true,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    992: {
                        items: 4
                    }
                }
            });
        }
        function OpenSimilarUrlCodePreview(code,value,url_code) {
            ShowFullLoading();
            if(value === 'NULL') return false;
            <?php
            $str_params = "''";
            $int_limiter = ParameterService::GetParameter('db_query_limiter');
            $int_union = ParameterService::GetParameter('db_query_union');
            for($x=0;$x<count($lstPreviews);$x++){
                $code = $lstPreviews[$x]["code"];
                $str_params = $str_params.($x==0?'':'+"'.$int_limiter.'"').'+"'.$code.'" + "'.$int_union.'" + $("#inpSP'.$code.'").val()';
                echo '$("#inpSP'.$code.'").val($("#inpOrigSP'.$code.'").val());'; //INICIALIZAMOS TODOS LOS HIDDEN PARA LUEGO MODIFICAR EL QUE SE DIO CLICK.
            }
			$product_url = RouteService::GetSiteURL('product', ['PROD_URL_CODE']);
            ?>
            $("#inpSP"+code).val(value);
			var product_url = ("<?php echo $product_url; ?>").replace("PROD_URL_CODE", url_code);
            var filters = <?php echo $str_params; ?>;
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('internal_request',false); ?>
            <?php $__env->slot('app_group',$group); ?>
            <?php $__env->slot('ws_group','entity'); ?>
            <?php $__env->slot('ws_name','product-similars'); ?>
            <?php $__env->slot('parameters','
                product_group_code: "'.$product_data["product_group_code"].'",
                excluded_product_url_code: "'.$product_data["product_url_code"].'",
                filters: filters,
                sel_specification: code+"'.$int_union.'"+$("#inpSP"+code).val(),
                currency_code: "'.SiteService::GetCurrencyCode().'"'); ?>
            <?php $__env->slot('result_success'); ?>
            if(response.length>0){
                location.href=(response[0]["product_url_code"]);
            }else{
                ShowErrorMessage("<?php echo trans($lang.'lbl_invalid_similar'); ?>");
			}
            <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        var modal = document.getElementById("myModal");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        // When the user clicks on <span> (x), close the modal
        function closeModal(){
            modal.style.display = "none";
        }
        function ShowModal(src,alt) {

            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            modalImg.src = src;
            captionText.innerHTML = alt;
            modal.style.display = "block";
        }
        /* Carousel de la galería pequeña de fotos */
        var galeria_carousel = $('#second_carousel');
        galeria_carousel.owlCarousel({
            items: 2,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            dots: true,
        });
        function ViewMoreProducts() {
            $('html,body').animate({
                scrollTop: $("#more_products").offset().top
            }, 2000);
        }
        $(window).on('load', function () {});
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config($group.'.ui.template.ecommerce.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/site/ecommerce/product.blade.php ENDPATH**/ ?>