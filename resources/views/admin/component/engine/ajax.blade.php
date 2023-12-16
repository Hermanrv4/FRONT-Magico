<?php
$app_group = config('env.app_group_admin');
?>
$.ajax({
    {!! \App\Http\Common\Services\ApiService::GetApiAjaxCall($app_group,$ws_group,$ws_name) !!}
    ,data: {
        {!! isset($parameters)?$parameters:'' !!}
    }
    ,success: function (data) {
        var message = data["{!! config('app.value.result.message.key')!!}"];
        var response = data["{!! config('app.value.result.response.key')!!}"];
        if(data["{!! config('app.value.result.status.key')!!}"] == "{!! config('app.value.result.status.value.success') !!}"){
            {!! isset($result_success)?$result_success:'' !!}
        }else{
        @if(isset($result_error))
            {!! $result_error !!}
        @else
            if(data["message"] != null || data["message"] != ""){
                ShowErrorMessage("{!! trans(config($app_group.'.ui.component.engine.ajax.lang').'alert_error_api_title') !!}",data["message"]);
            }else{
                ShowErrorMessage("{!! trans(config($app_group.'.ui.component.engine.ajax.lang').'alert_error_api_title') !!}",data["{!! config('app.value.result.message.key')!!}"]);
            }
            {!! isset($result_error_after)?$result_error_after:'' !!}
        @endif
        }
    }
    ,error: function (data) {
    @if(isset($ajax_error))
        {!! $ajax_error !!}
    @else
        ShowErrorMessage(
            "{!! trans(config($app_group.'.ui.component.engine.ajax.lang').'alert_error_ajax_title') !!}",
            "{!! trans(config($app_group.'.ui.component.engine.ajax.lang').'alert_error_ajax_message') !!}"
        );
        {!! isset($ajax_error_after)?$ajax_error_after:'' !!}
    @endif
    }
    ,complete: function (data) {
        {!! isset($ajax_complete)?$ajax_complete:'' !!}
    }
});
