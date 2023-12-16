<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.position.list.lang');

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
    <div class="content">
        <div class="container-fluid">
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
        @slot('modal_id','form_register')
        @slot('modal_title',strtoupper(trans($lang.'form.register.title')))
        @slot('modal_class_04','bg-dark')
        @slot('modal_body')
            <div class="form-group">
                <div class="row">
                    <div class="row col-md-12">
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","root_position_id",$lang.'form.register.lbl_root_position',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","description",$lang.'form.register.lbl_description',true,"col-md-12") !!}
                        <input type="hidden" id="position_id" value="-1">
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

    <script type="application/javascript">
        var default_id = parseInt("{!! $default_id !!}");
        var default_name = "{!! trans($lang.'lbl_default_select') !!}";
        var data = [];
        data.push({id:default_id, text:default_name, selected: true});
        <!-- ************************************************************************* -->
        function DocumentReady(){
            $("#inpIdentifier").inputFilter(function (value) {return justDecimals(value)});
            FillRegisterSelects();
            GetResultByFilters();
        }
        <!-- ************************************************************************* -->
        function FillRegisterSelects(){
            var data_positions = data.slice();
            <?php
            $lstCompanies = ApiService::Request(config('env.app_group_admin'), 'entity', 'position-get', array())->response;
            for($i=0;$i<count($lstCompanies);$i++){
                echo "data_positions.push({id:".$lstCompanies[$i]["id"].", text:'".$lstCompanies[$i]["name_localized"]."', selected: false});\n";
            }
            ?>
            $('#root_position_id').html("");
            $('#root_position_id').select2({theme: 'bootstrap4',tags: false,data: data_positions});
            $("#root_position_id").val(default_id).trigger('change');
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
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','position-get')
                @slot('parameters', '')
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
                            "<th>{!! trans($lang.'result_table.col_position_id') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_root_position') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_code') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_name') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_description') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_options') !!}</th>"+
                        "</tr>");
                        response.forEach(function (row) {
                            table_body = table_body + "<tr>";
                            table_body = table_body + "<td>" + (row["id"] === null ? "" : row["id"]) + "</td>";
                            table_body = table_body + "<td>" + (row["root_position"] === null ? "" : row["root_position"]) + "</td>";
                            table_body = table_body + "<td>" + (row["code"] === null ? "" : row["code"]) + "</td>";
                            table_body = table_body + "<td>" + (row["name_localized"] === null ? "" : row["name_localized"]) + "</td>";
                            table_body = table_body + "<td>" + (row["description_localized"] === null ? "" : row["description_localized"]) + "</td>";
                            table_body = table_body + "<td>" +
                                    "<div class='btn-group'>" +
                                    "   <button type='button' class='btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group' onclick='PutFront(this,"+'\u0022'+"tb-btn-group"+'\u0022'+")' data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}" +
                                    "       <span class='sr-only'></span>" +
                                    "       <div class='dropdown-menu' role='menu' x-placement='bottom-start'>" +
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
            if($("#code").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_code") !!}";

            messages = messages+(messages===""?"":"<br/>")+LocalizedInputValidate("name",
                function(value){
                    return !(value.trim().length === 0);
                },"{!! trans($lang."form.register.errors.msg_invalid_name") !!}");

            messages = messages+(messages===""?"":"<br/>")+LocalizedInputValidate("description",
                function(value){
                    return !(value.trim().length === 0);
                },"{!! trans($lang."form.register.errors.msg_invalid_description") !!}");

            if(messages !== ""){
                ShowErrorMessage("{!! trans($lang."lbl_default_error") !!}",messages);
                return false;
            }
            return true;
        }
        function RegisterEntity(){
            if(!ValidateRegister()) return;
            var position_id = $("#position_id").val();
            var root_position_id = $("#root_position_id").val();
            var code = $("#code").val();
            var name = $("#name").val();
            var description = $("#description").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','position-register')
                @slot('parameters',"
                    'id':position_id,
                    'root_position_id':root_position_id,
                    'code':code,
                    'name':name,
                    'description':description
                ")
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                    GetResultByFilters();
                    $("#form_register").modal('hide');
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
        }
        function OpenRegisterForm(position_id){
            if(position_id==default_id){
                $("#position_id").val(default_id);
                $("#root_position_id").val(default_id).trigger('change');
                $("#code").val("");
                InitLocalizedInput("name",null);
                InitLocalizedInput("description",null);
                $("#btnRegister").text("{!! trans($lang.'form.register.btn_save_entity') !!}");
                $("#form_register").modal('show');
            }else{
                $("#btnRegister").text("{!! trans($lang.'form.register.btn_update_entity') !!}");
                @component(config($group.'.ui.component.engine.ajax.view'))
                    @slot('app_group',$group)
                    @slot('ws_group','entity')
                    @slot('ws_name','position-get')
                    @slot('parameters',"'position_id':position_id")
                    @slot('result_success')
                        var entity = response[0];
                        $("#position_id").val(entity["id"]);
                        if(entity["root_position_id"]==null){
                            $("#root_position_id").val(default_id).trigger('change');
                        }else{
                            $("#root_position_id").val(entity["root_position_id"]).trigger('change');
                        }
                        $("#code").val(entity["code"]);
                        InitLocalizedInput("name",entity["name"]);
                        InitLocalizedInput("description",entity["description"]);
                        $("#form_register").modal('show');
                    @endslot
                    @slot('result_error')
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    @endslot
                @endcomponent
            }
        }
        function DeleteEntity(position_id){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','position-delete')
            @slot('parameters',"
                'id':position_id,
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
    </script>
@endsection