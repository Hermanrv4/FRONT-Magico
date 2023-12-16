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
@if(!isset($loader))
    ShowFullLoading();
@else
    if({!! $loader !!}){
        ShowFullLoading();
    }
@endif
$.ajax({
    @if($internal_request)
        {!! ApiService::GetInternalAjaxCall($app_group,$route,$route_parameters) !!}
    @else
        {!! ApiService::GetApiAjaxCall($app_group,$ws_group,$ws_name) !!}
    @endif
    ,data: {
        {!! isset($parameters)?$parameters:'' !!}
    }
    ,success: function (data) {
        var locale = "{{Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale()}}";
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
        {!! isset($ajax_complete)?$ajax_complete:'HideFullLoading();' !!}
    }
});
