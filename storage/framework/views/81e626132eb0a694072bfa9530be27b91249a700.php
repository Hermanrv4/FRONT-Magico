<?php
use \App\Http\Common\Services\ApiService;

$internal_request = (isset($internal_request)?$internal_request:false);
$app_group = (isset($app_group)?$app_group:null);

$route = (isset($route)?$route:null);
$route_parameters = (isset($route_parameters)?$route_parameters:array());

$ws_group = (isset($ws_group)?$ws_group:null);
$ws_name = (isset($ws_name)?$ws_name:null);

$parameters = (isset($parameters)?$parameters:"");
?>
<?php if(!isset($loader)): ?>
    ShowFullLoading();
<?php else: ?>
    if(<?php echo $loader; ?>){
        ShowFullLoading();
    }
<?php endif; ?>
$.ajax({
    <?php if($internal_request): ?>
        <?php echo ApiService::GetInternalAjaxCall($app_group,$route,$route_parameters); ?>

    <?php else: ?>
        <?php echo ApiService::GetApiAjaxCall($app_group,$ws_group,$ws_name); ?>

    <?php endif; ?>
    ,data: {
        <?php echo isset($parameters)?$parameters:''; ?>

    }
    ,success: function (data) {
        var locale = "<?php echo e(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale()); ?>";
        var message = data["<?php echo config('app.value.result.message.key'); ?>"];
        var response = data["<?php echo config('app.value.result.response.key'); ?>"];
        if(data["<?php echo config('app.value.result.status.key'); ?>"] == "<?php echo config('app.value.result.status.value.success'); ?>"){
            <?php echo isset($result_success)?$result_success:''; ?>

        }else{
        <?php if(isset($result_error)): ?>
            <?php echo $result_error; ?>

        <?php else: ?>
            if(data["message"] != null || data["message"] != ""){
                ShowErrorMessage("<?php echo trans(config($app_group.'.ui.component.engine.ajax.lang').'alert_error_api_title'); ?>",data["message"]);
            }else{
                ShowErrorMessage("<?php echo trans(config($app_group.'.ui.component.engine.ajax.lang').'alert_error_api_title'); ?>",data["<?php echo config('app.value.result.message.key'); ?>"]);
            }
            <?php echo isset($result_error_after)?$result_error_after:''; ?>

        <?php endif; ?>
        }
    }
    ,error: function (data) {
    <?php if(isset($ajax_error)): ?>
        <?php echo $ajax_error; ?>

    <?php else: ?>
        ShowErrorMessage(
            "<?php echo trans(config($app_group.'.ui.component.engine.ajax.lang').'alert_error_ajax_title'); ?>",
            "<?php echo trans(config($app_group.'.ui.component.engine.ajax.lang').'alert_error_ajax_message'); ?>"
        );
        <?php echo isset($ajax_error_after)?$ajax_error_after:''; ?>

    <?php endif; ?>
    }
    ,complete: function (data) {
        <?php echo isset($ajax_complete)?$ajax_complete:'HideFullLoading();'; ?>

    }
});
<?php /**PATH /var/www/html/magico.pe/resources/views/site/component/engine/ajax.blade.php ENDPATH**/ ?>