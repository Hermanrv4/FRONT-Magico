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

<?php $__env->startSection('page_title',trans($lang.'page_title')); ?>
<?php $__env->startSection('metas',''); ?>
<?php $__env->startSection('top_scripts',''); ?>
<?php $__env->startSection('body'); ?>


<br>
<section class="contacts_block" style="position:relative;padding-top:10%">
    <div class="container">
        <div class="padbot30" >
            <center>
                <?php if($status == config($group.'.value.order.status.success')): ?>
                    <img src="<?php echo e(\App\Http\Modules\Site\Services\HtmlService::ParseImage('success.jpg','icon')); ?>" style="width:200px!important;height:200px!important;">
                <?php else: ?>
                    <img src="<?php echo e(\App\Http\Modules\Site\Services\HtmlService::ParseImage('error.jpg','icon')); ?>" style="width:200px!important;height:200px!important;">
                <?php endif; ?>
                <br/>
                <br/>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <h1 style="font-size: 16px;font-weight: bold;color: black;margin-bottom: 0px"><?php echo $title; ?></h1>
                    <p style="font-size: 16px;font-weight: bold;color: black"><?php echo $message; ?></p>
					<?php if($transaction!=""): ?>
                       <p style="line-height:1.5!important;text-transform: none!important;"><?php echo $transaction; ?></p>
                    <?php endif; ?>
                </div>
                <br/>

                
                <div class="col-md-12" style="text-align: center;">
                    <hr/>
                    <button class="btn-solid btn" style="background: red;color: white;" onclick="location.href='<?php echo RouteService::GetSiteURL('landing'); ?>'"><?php echo trans($lang.'lbl_continue_buying'); ?></button>
                    <hr/>
                </div>
            </center>
        </div>
    </div>
</section>
    <!-- breadcrumb end -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom_scripts'); ?>
    <script type="application/javascript">
        function DocumentReady(){
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config($group.'.ui.template.ecommerce.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/site/ecommerce/order.blade.php ENDPATH**/ ?>