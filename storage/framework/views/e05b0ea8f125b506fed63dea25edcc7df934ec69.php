<?php
$app_group = config('env.app_group_admin');
?>
$.ajax({
    <?php echo \App\Http\Common\Services\ApiService::GetInternalAjaxCall($app_group,$route,$parameters); ?>

    ,data: {
        <?php echo isset($parameters)?$parameters:''; ?>

    }
    ,success: function (data) {
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
        <?php echo isset($ajax_complete)?$ajax_complete:''; ?>

    }
});
<?php /**PATH /var/www/html/magico.pe/resources/views/admin/component/engine/ajax_internal.blade.php ENDPATH**/ ?>