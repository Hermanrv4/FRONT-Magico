<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.service.list.lang');

$default_id = ParameterService::GetParameter("default_id");

$objAdmin = \App\Http\Modules\Admin\Helpers\AppHelper::GetAdminData();
$is_internal_user = $objAdmin["company_id"]==null;
?>
@extends(config($group.'.ui.template.main.view'))
@section('page_title',trans($lang.'page_title'))
@section('metas','')
@section('top_scripts')
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/datatable/datatables.min.css")}}"/>
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/datatable/Buttons-1.6.1/css/buttons.dataTables.min.css")}}"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>


    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css"/>
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/fileupload/css/jquery.fileupload.css")}}" />
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/fileupload/css/jquery.fileupload-ui.css")}}" />
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/fileupload/css/jquery.fileupload-noscript.css")}}"/></noscript>
    <noscript><link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/fileupload/css/jquery.fileupload-ui-noscript.css")}}"/></noscript>
    <style>
        .choices{
            z-index: 100000!important;
        }
    </style>
@endsection
@section('body')
    <!--------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{!! trans($lang.'page_title') !!}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{!! trans($lang.'page_title') !!}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------->
    <div class="content">
        <div class="container-fluid">
            @if($is_internal_user)
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">{!! trans($lang.'lbl_filters_header') !!}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="row col-md-12">
                                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","selCompanyFilter",$lang.'form.filters.lbl_company',true,"col-md-12","fas fa-envelope") !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <button class="btn btn-dark col-md-2" style="margin: 5px!important;" onclick="GetResultByFilters()">{!! trans($lang.'btn_search') !!}</button>
                                <button class="btn btn-success col-md-2" style="margin: 5px!important;" onclick="OpenRegisterForm({!! $default_id !!});">{!! trans($lang.'btn_register') !!}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">{!! trans($lang.'lbl_filters_footer') !!}</div>
                </div>
            @else
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">{!! trans($lang.'lbl_filters_header') !!}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <button class="btn btn-success col-md-2" style="margin: 5px!important;" onclick="OpenRegisterForm({!! $default_id !!});">{!! trans($lang.'btn_register') !!}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">{!! trans($lang.'lbl_filters_footer') !!}</div>
                </div>
            @endif
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">{!! trans($lang.'lbl_results_header') !!}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbResults" width="100%" class="table table-bordered table-hover">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
            </div>
        </div>
    </div>
    <!--------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------->
    @component(config($group.'.ui.component.engine.modal.view'))
        @slot('modal_id','form_key_users')
        @slot('modal_title',strtoupper(trans($lang.'form.register.title')))
        @slot('modal_class_04','bg-dark')
        @slot('modal_body')
            <div class="form-group">
                <div class="row">
                    <div class="row col-md-12">
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","user_id",$lang.'form.register-key-user.user_id',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","key_user_description",$lang.'form.register-key-user.lbl_description',true,"col-md-12") !!}
                        <button class="btn btn-success col-md-3" style="margin: 5px!important;" onclick="RegisterKeyUser();">{!! trans($lang.'form.register-key-user.btn_register_key_user') !!}</button>
                        <input type="hidden" id="inpServiceKUId" value=""/>
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <table id="tbKeyUsers" style="width: 100%!important" class="table table-bordered table-hover">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        @endslot
    @endcomponent
    @component(config($group.'.ui.component.engine.modal.view'))
        @slot('modal_id','form_register')
        @slot('modal_title',strtoupper(trans($lang.'form.register.title')))
        @slot('modal_class_04','bg-dark')
        @slot('modal_body')
            <div class="form-group">
                <div class="row">
                    <div class="row col-md-12">
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","company_id",$lang.'form.register.lbl_company',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","service_type_id",$lang.'form.register.lbl_service_type',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","status_type_id",$lang.'form.register.lbl_status_type',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","name",$lang.'form.register.lbl_name',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","description",$lang.'form.register.lbl_description',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_date","start_at",$lang.'form.register.lbl_start_at',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","hours_per_day",$lang.'form.register.lbl_hours_per_day',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select_multiple","available_days",$lang.'form.register.lbl_available_days',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","leader_collaborator_id",$lang.'form.register.lbl_leader_collaboratorr',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","billing_type_id",$lang.'form.register.lbl_billing_type',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_price","cost",$lang.'form.register.lbl_cost',true,"col-md-6") !!}
                        <input type="hidden" id="inpServiceId" value="-1">
                        <label class="col-md-12" style="color:red">{!! trans($lang.'form.register.lbl_message_no_taxes') !!}</label>
                        <div class="col-md-12">
                            <hr/>
                            <label>{!! trans($lang.'form.register.lbl_attacheds.title') !!}</label>
                            <form id="fileupload" method="POST" enctype="multipart/form-data">
                                <div class="fileupload-buttonbar col-md-12">
                                    <span class="btn btn-success fileinput-button col-md-3">
                                        <i class="fas fa-plus"></i>
                                        <span>{!! trans($lang.'form.register.lbl_attacheds.upload.add') !!}</span>
                                        <input type="file" name="files[]" multiple />
                                    </span>
                                    <button type="submit" class="btn btn-primary start col-md-3">
                                        <i class="fas fa-upload"></i>
                                        <span>{!! trans($lang.'form.register.lbl_attacheds.upload.start') !!}</span>
                                    </button>
                                </div>
                                <hr/>
                                <table id="tbAttacheds" role="presentation" class="table table-striped col-md-12">
                                    <tbody class="files"></tbody>
                                </table>
                            </form>
                            <script id="template-upload" type="text/x-tmpl">
                                {% for (var i=0, file; file=o.files[i]; i++) { %}
                                <tr class="template-upload">
                                  <td>
                                      <input type="hidden" class="hidName" value="{%=file.name%}" />
                                      <input type="hidden" class="hidSize" value="{%=o.formatFileSize(file.size)%}" />
                                      <input type="hidden" class="hidLoaded" value="0" />
                                      <p class="name">{%=file.name%}</p>
                                      <strong class="error text-danger"></strong>
                                  </td>
                                  <td>
                                      <p class="size">{!! trans($lang.'form.register.lbl_attacheds.upload.proceesing') !!}</p>
                                      <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                                  </td>
                                  <td>
                                      {% if (!o.options.autoUpload && o.options.edit && o.options.loadImageFileTypes.test(file.type)) { %}
                                        <button class="btn btn-success edit" data-index="{%=i%}" disabled>
                                            <i class="fas fa-edit"></i>
                                            <span>{!! trans($lang.'form.register.lbl_attacheds.upload.file.edit') !!}</span>
                                        </button>
                                      {% } %}
                                      {% if (!i && !o.options.autoUpload) { %}
                                          <button class="btn btn-primary start" disabled>
                                              <i class="fas fa-upload"></i>
                                            <span>{!! trans($lang.'form.register.lbl_attacheds.upload.file.start') !!}</span>
                                          </button>
                                      {% } %}
                                      {% if (!i) { %}
                                          <button class="btn btn-warning cancel">
                                              <i class="fas fa-ban-circle"></i>
                                            <span>{!! trans($lang.'form.register.lbl_attacheds.upload.file.cancel') !!}</span>
                                          </button>
                                      {% } %}
                                  </td>
                                </tr>
                                {% } %}
                            </script>
                            <script id="template-download" type="text/x-tmpl">
                                {% for (var i=0, file; file=o.files[i]; i++) { %}
                                  <tr class="template-download">
                                      <td>
                                          <input type="hidden" class="hidName" value="{%=file.name%}" />
                                          <input type="hidden" class="hidSize" value="{%=o.formatFileSize(file.size)%}" />
                                          <input type="hidden" class="hidLoaded" value="1" />
                                          <p class="name">
                                              {% if (file.url) { %}
                                                  <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                                              {% } else { %}
                                                  <span>{%=file.name%}</span>
                                              {% } %}
                                          </p>
                                          {% if (file.error) { %}
                                              <div><span class="label label-danger">{!! trans($lang.'form.register.lbl_attacheds.upload.file.error') !!}</span> {%=file.error%}</div>
                                          {% } %}
                                      </td>
                                      <td>
                                          <span class="size">{%=o.formatFileSize(file.size)%}</span>
                                      </td>
                                      <td>
                                          {% if (file.deleteUrl) { %}
                                              <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                                  <i class="fas fa-trash"></i>
                                                  <span>{!! trans($lang.'form.register.lbl_attacheds.upload.file.delete') !!}</span>
                                              </button>
                                          {% } else { %}
                                              <button class="btn btn-warning cancel">
                                                  <i class="fas fa-ban-circle"></i>
                                                  <span>{!! trans($lang.'form.register.lbl_attacheds.upload.file.cancel') !!}</span>
                                              </button>
                                          {% } %}
                                      </td>
                                  </tr>
                                {% } %}
                            </script>
                            <input type="hidden" id="inpUserId" value="-1">
                            <hr/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: right!important;">
                        <button class="btn btn-success col-md-3" style="margin: 5px!important;" id="btnRegister" onclick="RegisterEntity();">{!! trans($lang.'form.register.btn_save_entity') !!}</button>
                    </div>
                </div>
            </div>
        @endslot
    @endcomponent
    <!--------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------->
@endsection
@section('bottom_scripts')
    <script type="text/javascript" src="{{asset("resources/assets/".$group."/main/datatable/datatables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("resources/assets/".$group."/main/datatable/Buttons-1.6.1/js/dataTables.buttons.min.js")}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
    <!-- Include Choices JavaScript (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/vendor/jquery.ui.widget.js")}}"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <!-- blueimp Gallery script -->
    <script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/jquery.iframe-transport.js")}}"></script>
    <!-- The basic File Upload plugin -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/jquery.fileupload.js")}}"></script>
    <!-- The File Upload processing plugin -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/jquery.fileupload-process.js")}}"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/jquery.fileupload-image.js")}}"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/jquery.fileupload-audio.js")}}"></script>
    <!-- The File Upload video preview plugin -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/jquery.fileupload-video.js")}}"></script>
    <!-- The File Upload validation plugin -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/jquery.fileupload-validate.js")}}"></script>
    <!-- The File Upload user interface plugin -->
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/jquery.fileupload-ui.js")}}"></script>
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="{{asset("resources/assets/".$group."/main/fileupload/js/cors/jquery.xdr-transport.js")}}"></script>
    <![endif]-->

    <script type="application/javascript">
        var upload_url = window.location.origin+'/resources/assets/admin/main/fileupload/php/';
        var upload_directory = window.location.origin+'/storage/app/loaded/files/';
        var default_id = parseInt("{!! $default_id !!}");
        var default_name = "{!! trans($lang.'lbl_default_select') !!}";
        var data = [];
        data.push({id:default_id, text:default_name, selected: true});
        var selAvailableDays = null;
        var originalAttacheds = null;
        <!-- ************************************************************************* -->
        function DocumentReady(){
            'use strict';
            $('#fileupload').fileupload({url: upload_url});
            $("#inpIdentifier").inputFilter(function (value) {return justDecimals(value)});
            $("#cost").inputFilter(function (value) {return justDecimals(value)});
            $('#start_at').datetimepicker({format: 'DD/MM/YYYY'});

            FillFilterSelects();
            FillRegisterSelects();
            GetResultByFilters();
        }
        <!-- ************************************************************************* -->
        function FillFilterSelects(){
            var data_companies = data.slice();
            <?php
            $lstCompanies = ApiService::Request(config('env.app_group_admin'), 'entity', 'company-get', ($is_internal_user?array():array("company_id"=>$objAdmin["company_id"])))->response;
            for($i=0;$i<count($lstCompanies);$i++){
                echo "data_companies.push({id:".$lstCompanies[$i]["id"].", text:'".$lstCompanies[$i]["legal_name"]." (".$lstCompanies[$i]["commercial_name"].")', selected: false});\n";
            }
            ?>
            $('#selCompanyFilter').html("");
            $('#selCompanyFilter').select2({theme: 'bootstrap4',tags: false,data: data_companies});
            $("#selCompanyFilter").val(default_id).trigger('change');
            $('#company_id').html("");
            $('#company_id').select2({theme: 'bootstrap4',tags: false,data: data_companies});
            $("#company_id").val(default_id).trigger('change');
        }
        function FillRegisterSelects(){
            /****************************************************************************************/
            //COMPANY LLENADO JUNTO CON FILTERS....
            /****************************************************************************************/
            var data_service_types = data.slice();
            <?php
            $lstServiceTypes = ApiService::Request(config('env.app_group_admin'), 'entity', 'type-service-get', array())->response;
            for($i=0;$i<count($lstServiceTypes);$i++){
                echo "data_service_types.push({id:".$lstServiceTypes[$i]["id"].", text:'".$lstServiceTypes[$i]["name_localized"]."', selected: false});\n";
            }
            ?>
            $('#service_type_id').html("");
            $('#service_type_id').select2({theme: 'bootstrap4',tags: false,data: data_service_types});
            $("#service_type_id").val(default_id).trigger('change');
            /****************************************************************************************/
            var data_billing_types = data.slice();
            <?php
            $lstServiceTypes = ApiService::Request(config('env.app_group_admin'), 'entity', 'type-billing-get', array())->response;
            for($i=0;$i<count($lstServiceTypes);$i++){
                echo "data_billing_types.push({id:".$lstServiceTypes[$i]["id"].", text:'".$lstServiceTypes[$i]["name_localized"]."', selected: false});\n";
            }
            ?>
            $('#billing_type_id').html("");
            $('#billing_type_id').select2({theme: 'bootstrap4',tags: false,data: data_billing_types});
            $("#billing_type_id").val(default_id).trigger('change');
            /****************************************************************************************/
            var data_status_types = data.slice();
            <?php
            $lstServiceTypes = ApiService::Request(config('env.app_group_admin'), 'entity', 'type-service-status-get', array())->response;
            for($i=0;$i<count($lstServiceTypes);$i++){
                echo "data_status_types.push({id:".$lstServiceTypes[$i]["id"].", text:'".$lstServiceTypes[$i]["name_localized"]."', selected: false});\n";
            }
            ?>
            $('#status_type_id').html("");
            $('#status_type_id').select2({theme: 'bootstrap4',tags: false,data: data_status_types});
            $("#status_type_id").val(default_id).trigger('change');
            /****************************************************************************************/
            var data_collaborator = data.slice();
            <?php
            $lstCollaborators = ApiService::Request(config('env.app_group_admin'), 'entity', 'collaborator-get', array())->response;
            for($i=0;$i<count($lstCollaborators);$i++){
                echo "data_collaborator.push({id:".$lstCollaborators[$i]["id"].", code:'".$lstCollaborators[$i]["code"]."', text:'".$lstCollaborators[$i]["user_last_name"].", ".$lstCollaborators[$i]["user_first_name"]." (".$lstCollaborators[$i]["code"].")', selected: false});\n";
            }
            ?>
            $('#leader_collaborator_id').html("");
            $('#leader_collaborator_id').select2({theme: 'bootstrap4',tags: false,data: data_collaborator});
            $("#leader_collaborator_id").val(default_id).trigger('change');
            /****************************************************************************************/
            selAvailableDays = new Choices('#available_days', { removeItemButton: true, position: 'bottom', searchEnabled: true, searchFields: ['label'] });
            var data_available_days = [];
            data_available_days.push({value:"1", label:"{!! trans($lang.'lbl_days_01') !!}"});
            data_available_days.push({value:"2", label:"{!! trans($lang.'lbl_days_02') !!}"});
            data_available_days.push({value:"3", label:"{!! trans($lang.'lbl_days_03') !!}"});
            data_available_days.push({value:"4", label:"{!! trans($lang.'lbl_days_04') !!}"});
            data_available_days.push({value:"5", label:"{!! trans($lang.'lbl_days_05') !!}"});
            data_available_days.push({value:"6", label:"{!! trans($lang.'lbl_days_06') !!}"});
            data_available_days.push({value:"7", label:"{!! trans($lang.'lbl_days_07') !!}"});
            selAvailableDays.setChoices(data_available_days);
            selAvailableDays.setChoiceByValue(["1","2","3","4","5"]);
            /****************************************************************************************/
        }
        <!-- ************************************************************************* -->
        <!-- ************************************************************************* -->
        function ValidateFilters(){
            var messages = "";
            if(messages !== ""){
                ShowErrorMessage("{!! trans($lang."lbl_default_error") !!}",messages);
                return false;
            }
            return true;
        }
        function GetResultByFilters(){
            if(!ValidateFilters()) return;
            var company_id = $("#selCompanyFilter").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','service-get')
                @slot('parameters', ($is_internal_user?'':'"company_id": company_id'))
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable( '#tbResults' ) ) {
                        table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                    $("#tbResults >thead").html("");
                    $("#tbResults >tbody").html("");
                    var headers = [];
                    var table_body = "";

                    if(response.length===0){
                        $("#tbResults >thead").html("<tr><th>{!! trans($lang.'lbl_default_noresult_title') !!}</th></tr>");
                        $("#tbResults >tbody").html("<tr><td>{!! trans($lang.'lbl_default_noresult_message') !!}</td></tr>");
                    }else {
                        $("#tbResults >thead").html("<tr>" +
                            "<th>{!! trans($lang.'result_table.col_service_id') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_company') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_service_type') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_code') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_name') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_start_at') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_collaborator_leader') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_billing_type') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_cost') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_status') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_options') !!}</th>"+
                        "</tr>");
                        response.forEach(function (row) {
                            table_body = table_body + "<tr>";
                            table_body = table_body + "<td>" + (row["id"] === null ? "" : row["id"]) + "</td>";
                            table_body = table_body + "<td>" + (row["company_legal_name"] === null ? "" : row["company_legal_name"]) + "</td>";
                            table_body = table_body + "<td>" + (row["service_type_name"] === null ? "" : row["service_type_name"]) + "</td>";
                            table_body = table_body + "<td>" + (row["code"] === null ? "" : row["code"]) + "</td>";
                            table_body = table_body + "<td>" + (row["name"] === null ? "" : row["name"]) + "</td>";
                            table_body = table_body + "<td>" + (row["start_at"] === null ? "" : row["start_at"]) + "</td>";
                            table_body = table_body + "<td>" + row["leader_collaborator_last_name"] + ", "+ row["leader_collaborator_first_name"] + "</td>";
                            table_body = table_body + "<td>" + (row["billing_type_name"] === null ? "" : row["billing_type_name"]) + "</td>";
                            table_body = table_body + "<td>" + row["currency_symbol"] + " " + parseFloat(row["cost"]).toFixed(2) + "</td>";
                            table_body = table_body + "<td>" + (row["service_status_type_name"] === null ? "" : row["service_status_type_name"]) + "</td>";
                            table_body = table_body + "<td>" +
                                    "<div class='btn-group'>" +
                                    "   <button type='button' class='btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group' onclick='PutFront(this,"+'\u0022'+"tb-btn-group"+'\u0022'+")' data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}" +
                                    "       <span class='sr-only'></span>" +
                                    "       <div class='dropdown-menu' role='menu' x-placement='bottom-start'>" +
                                    "           <a class='dropdown-item' href='#' onclick='OpenViewKeyUsers("+row["id"]+",\""+row["name"]+"\","+row["company_id"]+");'>{!! trans($lang.'result_table.options.view_key_users') !!}</a>" +
                                    "           <a class='dropdown-item' href='#' onclick='return false;'>{!! trans($lang.'result_table.options.view_attacheds') !!}</a>" +
                                    "           <a class='dropdown-item' href='#' onclick='return false;'>{!! trans($lang.'result_table.options.view_sprints') !!}</a>" +
                                    "           <a class='dropdown-item' href='#' onclick='return false;'>{!! trans($lang.'result_table.options.view_tickets') !!}</a>" +
                                    "           <li class='dropdown-divider'></li>" +
                                    "           <a class='dropdown-item' href='#' onclick='OpenRegisterForm("+row["id"]+");'>{!! trans($lang.'result_table.options.edit') !!}</a>" +
                                    "           <a class='dropdown-item' href='#' onclick='DeleteEntity("+row["id"]+");'>{!! trans($lang.'result_table.options.delete') !!}</a>" +
                                    "       </div>" +
                                    "   </button>" +
                                    "</div>" +
                                "</td>";
                            table_body = table_body + "</tr>";
                        });
                        $("#tbResults >tbody").html(table_body);
                    }
                    $('#tbResults').DataTable({
                        "dom": 'l<"pull-left"f><"pull-right"B>rt<"pull-left"i><"pull-right"p>',
                        buttons: [
                            {extend: 'copyHtml5',exportOptions: {columns: "thead th:not(.noExport)"}},
                            {extend: 'excelHtml5', exportOptions: {columns: "thead th:not(.noExport)"}},
                            {extend: 'csvHtml5',exportOptions: {columns: "thead th:not(.noExport)"}},
                            {extend: 'pdfHtml5',orientation: 'landscape',exportOptions: {columns: "thead th:not(.noExport)"}},
                        ],
                        orderCellsTop: true,fixedHeader: true,paging: false,searching: true,ordering: false,responsive: true,autoWidth: false,
                    });
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
        }
        <!-- ************************************************************************* -->
        function ValidateRegister(){
            var messages = "";

            @if($is_internal_user)
            if($("#company_id").val()==default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_company") !!}";
            @else
            if($("#company_id").val()!={!! $objAdmin["company_id"] !!}) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_company") !!}";
            @endif

            if($("#service_type_id").val()===default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_service_type") !!}";
            if($("#code").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_code") !!}";
            if($("#name").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_name") !!}";
            if($("#description").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_description") !!}";
            if($("#start_at").val().length===0|| !justDate($("#start_at").val())) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_start_at") !!}";
            if($("#hours_per_day").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_hours_per_day") !!}";
            if(selAvailableDays.getValue(true).length==0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_available_days") !!}";
            if($("#leader_collaborator_id").val()===default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_leader_collaborator") !!}";
            if($("#billing_type_id").val()===default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_billing_type") !!}";
            if($("#status_type_id").val()===default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_status_type") !!}";

            if($("#cost").val().length===0|| !justDecimals($("#cost").val())) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_cost") !!}";

            if(messages !== ""){
                ShowErrorMessage("{!! trans($lang."lbl_default_error") !!}",messages);
                return false;
            }
            return true;
        }
        function RegisterEntity(){
            if(!ValidateRegister()) return;
            var service_id = $("#inpServiceId").val();
            var company_id = $("#company_id").val();
            var service_type_id = $("#service_type_id").val();
            var code = $("#code").val();
            var name = $("#name").val();
            var description = $("#description").val();
            var start_at = $("#start_at").val();
            var hours_per_day = $("#hours_per_day").val();
            var available_days = JSON.stringify(selAvailableDays.getValue(true));
            var leader_collaborator_id = $("#leader_collaborator_id").val();
            var billing_type_id = $("#billing_type_id").val();
            var cost = $("#cost").val();
            var currency_id = $("#currency_id_cost").val();
            GetDataFromFUTable("tbAttacheds");
            var attacheds = JSON.stringify(myAttachedData);
            var status_type_id = $("#status_type_id").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','service-register')
                @slot('parameters',"
                    'id':service_id,
                    'company_id':company_id,
                    'service_type_id':service_type_id,
                    'code':code,
                    'name':name,
                    'description':description,
                    'start_at':start_at,
                    'hours_per_day':hours_per_day,
                    'available_days':available_days,
                    'leader_collaborator_id':leader_collaborator_id,
                    'billing_type_id':billing_type_id,
                    'cost':cost,
                    'currency_id':currency_id,
                    'attacheds':attacheds,
                    'status_type_id':status_type_id,
                ")
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                    DeleteFileUploadedCompletely();
                    GetResultByFilters();
                    $("#form_register").modal('hide');
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
        }
        function OpenRegisterForm(service_id){
            filesToDelete = [];
            myAttachedData = []
            $("#tbAttacheds >tbody").html("");
            @if(!$is_internal_user)
            $("#company_id").prop('disabled', true);
            @endif
            if(service_id==default_id){
                $("#inpServiceId").val(service_id);
                $("#service_type_id").val(default_id);
                $("#code").val("");
                $("#name").val("");
                $("#description").val("");
                $("#start_at").val("");
                $("#hours_per_day").val("");
                selAvailableDays.setChoiceByValue(["1","2","3","4","5"]);
                $("#leader_collaborator_id").val(default_id);
                $("#billing_type_id").val(default_id);
                $("#cost").val("");
                @if(!$is_internal_user)
                $("#company_id").prop('disabled', true);
                $("#company_id").val({!! $objAdmin["company_id"] !!}).trigger('change');
                @else
                $("#company_id").val(default_id).trigger('change');
                @endif
                $("#btnRegister").text("{!! trans($lang.'form.register.btn_save_entity') !!}");
                $("#form_register").modal('show');
            }else{
                $("#btnRegister").text("{!! trans($lang.'form.register.btn_update_entity') !!}");
                @component(config($group.'.ui.component.engine.ajax.view'))
                    @slot('app_group',$group)
                    @slot('ws_group','entity')
                    @slot('ws_name','service-get')
                    @slot('parameters',"'service_id':service_id")
                    @slot('result_success')
                        var entity = response[0];
                        $("#inpServiceId").val(entity["id"]);
                        $("#service_type_id").val(entity["service_type_id"]).trigger('change');
                        $("#code").val(entity["code"]);
                        $("#name").val(entity["name"]);
                        $("#description").val(entity["description"]);
                        $("#start_at").val(entity["start_at"]);
                        $("#hours_per_day").val(parseInt(entity["hours_per_day"]));
                        try{
                            selAvailableDays.setChoiceByValue(JSON.parse(entity["available_days"]));
                        }catch (e){
                            selAvailableDays.setChoiceByValue(["1","2","3","4","5"]);
                        }
                        $("#leader_collaborator_id").val(entity["leader_collaborator_id"]).trigger('change');
                        $("#billing_type_id").val(entity["billing_type_id"]).trigger('change');
                        InitPriceInput("cost",entity["currency_id"],entity["cost"]);
                        $("#status_type_id").val(entity["status_type_id"]).trigger('change');
                        if(entity["company_id"]==null){
                            $("#company_id").val(default_id).trigger('change');
                        }else{
                            $("#company_id").val(entity["company_id"]).trigger('change');
                        }

                        try{
                            originalAttacheds = JSON.parse(entity["attacheds"]);
                        }catch (e){
                            originalAttacheds = [];
                        }

                        var htmlTable = '';
                        var attacheds = originalAttacheds;
                        for(var i=0;i<attacheds.length;i++){
                            var file_name = attacheds[i]["name"];
                            var file_size = attacheds[i]["size"];
                            htmlTable = htmlTable +
                                '<tr class="template-download in" id="futable_tr_'+i+'">' +
                                '   <td>' +
                                '       <input type="hidden" class="hidName" value="'+file_name+'" />' +
                                '       <input type="hidden" class="hidSize" value="'+file_size+'" />' +
                                '       <input type="hidden" class="hidLoaded" value="1" />' +
                                '       <p class="name"><a href="'+upload_directory+file_name+'" title="'+file_name+'" download="'+file_name+'">'+file_name+'</a></p>' +
                                '   </td>' +
                                '   <td><span class="size">'+file_size+'</span></td>' +
                                '   <td>' +
                                '       <button class="btn btn-danger delete" onclick=\'DeleteFileUploadedTemporary("futable_tr_'+i+'","'+upload_url+'/Index.php?file='+file_name+'&amp;_method=DELETE")\'>' +
                                '           <i class="fas fa-trash"></i><span>Delete</span>' +
                                '       </button>' +
                                '   </td>' +
                                '</tr>';
                        }

                        $("#tbAttacheds >tbody").html(htmlTable);

                        $("#form_register").modal('show');
                    @endslot
                    @slot('result_error')
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    @endslot
                @endcomponent
            }
        }
        function DeleteEntity(service_id){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','service-delete')
            @slot('parameters',"
                'id':service_id,
            ")
            @slot('result_success')
            ShowSuccessMessage("{{trans($lang.'form.delete.msg_title_success')}}","{{trans($lang.'form.delete.msg_description_success')}}");
            GetResultByFilters();
            @endslot
            @slot('result_error')
            ShowFormErrors(null,null,response,[]);
            HideFullLoading();
            @endslot
            @endcomponent
        }
        <!-- ************************************************************************* -->
        function ValidateRegisterKeyUser(){
            var messages = "";

            if($("#user_id").val()===default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register-key-user.errors.msg_invalid_user_id") !!}";
            if($("#key_user_description").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register-key-user.errors.msg_invalid_description") !!}";

            if(messages !== ""){
                ShowErrorMessage("{!! trans($lang."lbl_default_error") !!}",messages);
                return false;
            }
            return true;
        }
        function RegisterKeyUser(){
            if(!ValidateRegisterKeyUser()) return;
            var service_id = $("#inpServiceKUId").val();
            var user_id = $("#user_id").val();
            var key_user_description = $("#key_user_description").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','service-key-user-register')
            @slot('parameters',"
                'id':default_id,
                'service_id':service_id,
                'user_id':user_id,
                'description':key_user_description,
            ")
            @slot('result_success')
            ShowSuccessMessage("{{trans($lang.'form.register-key-user.msg_title_success')}}","{{trans($lang.'form.register-key-user.msg_description_success')}}");
            LoadKeyUsers(service_id);
            $("#form_register").modal('hide');
            @endslot
            @slot('result_error')
            ShowFormErrors(null,null,response,[{"description":"key_user_description"}]);
            HideFullLoading();
            @endslot
            @endcomponent
        }
        function FillRegisterKeyUserSelects(company_id){
            var data_users = data.slice();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','user-get-by-company-id')
            @slot('parameters', '"company_id": company_id')
            @slot('result_success')
            response.forEach(function (row) {
                data_users.push({id:row["id"], text:row["last_name"]+", "+row["first_name"], selected: false});
            });
            $('#user_id').html("");
            $('#user_id').select2({theme: 'bootstrap4',tags: false,data: data_users});
            $("#user_id").val(default_id).trigger('change');
            @endslot
            @slot('result_error')
            ShowFormErrors(null,null,response,[]);
            HideFullLoading();
            @endslot
            @endcomponent
        }
        function OpenViewKeyUsers(service_id,title,company_id){
            FillRegisterKeyUserSelects(company_id);
            $("#inpServiceKUId").val(service_id);
            $("#form_key_users-title").html("<b>"+"{!! trans($lang.'form.register-key-user.title') !!}".replace(":service_title", title)+"</b>");
            $("#form_key_users").modal('show');
            LoadKeyUsers(service_id);
        }
        function LoadKeyUsers(service_id){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','service-key-user-get')
            @slot('parameters', '"service_id":service_id')
            @slot('result_success')
            if ( $.fn.dataTable.isDataTable( '#tbKeyUsers' ) ) {
                table = $('#tbKeyUsers').DataTable();
                table.destroy();
            }
            $("#tbKeyUsers >thead").html("");
            $("#tbKeyUsers >tbody").html("");
            var table_body = "";
            if(response.length===0){
                $("#tbKeyUsers >thead").html("<tr><th>{!! trans($lang.'lbl_default_noresult_title') !!}</th></tr>");
                $("#tbKeyUsers >tbody").html("<tr><td>{!! trans($lang.'lbl_default_noresult_message') !!}</td></tr>");
            }else {
                $("#tbKeyUsers >thead").html("<tr>" +
                    "<th>{!! trans($lang.'key_user_table.col_key_user_name') !!}</th>"+
                    "<th>{!! trans($lang.'key_user_table.col_key_user_email') !!}</th>"+
                    "<th>{!! trans($lang.'key_user_table.col_key_user_phone') !!}</th>"+
                    "<th>{!! trans($lang.'key_user_table.col_description') !!}</th>"+
                    "<th>{!! trans($lang.'key_user_table.col_options') !!}</th>"+
                    "</tr>");
                response.forEach(function (row) {
                    table_body = table_body + "<tr>";
                    table_body = table_body + "<td>" + row["key_user_last_name"] + ", " + row["key_user_first_name"] + "</td>";
                    table_body = table_body + "<td>" + (row["key_user_email"] === null ? "" : row["key_user_email"]) + "</td>";
                    table_body = table_body + "<td>" + (row["key_user_phone"] === null ? "" : row["key_user_phone"]) + "</td>";
                    table_body = table_body + "<td>" + (row["description"] === null ? "" : row["description"]) + "</td>";
                    table_body = table_body + "<td>" +
                        "<div class='btn-group'>" +
                        "   <button type='button' class='btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group' onclick='PutFront(this,"+'\u0022'+"tb-btn-group"+'\u0022'+")' data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'key_user_table.options.title') !!}" +
                        "       <span class='sr-only'></span>" +
                        "       <div class='dropdown-menu' role='menu' x-placement='bottom-start'>" +
                        "           <a class='dropdown-item' href='#' onclick='DeleteKeyUser("+row["id"]+");'>{!! trans($lang.'key_user_table.options.delete') !!}</a>" +
                        "       </div>" +
                        "   </button>" +
                        "</div>" +
                        "</td>";
                    table_body = table_body + "</tr>";
                });
                $("#tbKeyUsers >tbody").html(table_body);
            }
            $('#tbKeyUsers').DataTable({
                "dom": 'l<"pull-left"f><"pull-right"B>rt<"pull-left"i><"pull-right"p>',
                buttons: [
                    {extend: 'copyHtml5',exportOptions: {columns: "thead th:not(.noExport)"}},
                    {extend: 'excelHtml5', exportOptions: {columns: "thead th:not(.noExport)"}},
                    {extend: 'csvHtml5',exportOptions: {columns: "thead th:not(.noExport)"}},
                    {extend: 'pdfHtml5',orientation: 'landscape',exportOptions: {columns: "thead th:not(.noExport)"}},
                ],
                orderCellsTop: true,fixedHeader: true,paging: false,searching: true,ordering: false,responsive: true,autoWidth: false,
            });
            $("#tbKeyUsers_wrapper").css("width","100%");
            @endslot
            @slot('result_error')
            ShowFormErrors(null,null,response,[]);
            HideFullLoading();
            @endslot
            @endcomponent
        }
        function DeleteKeyUser(service_key_user_id){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','service-key-user-delete')
            @slot('parameters',"
                'id':service_key_user_id,
            ")
            @slot('result_success')
            ShowSuccessMessage("{{trans($lang.'form.delete-key-user.msg_title_success')}}","{{trans($lang.'form.delete-key-user.msg_description_success')}}");
            LoadKeyUsers($("#inpServiceKUId").val());
            @endslot
            @slot('result_error')
            ShowFormErrors(null,null,response,[]);
            HideFullLoading();
            @endslot
            @endcomponent
        }
    </script>
@endsection