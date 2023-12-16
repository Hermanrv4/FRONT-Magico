<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.collaborator_contract.list.lang');

$default_id = ParameterService::GetParameter("default_id");

$objAdmin = \App\Http\Modules\Admin\Helpers\AppHelper::GetAdminData();
$is_internal_user = $objAdmin["company_id"]==null;
$collaborator_id = $default_id;
$code = isset($code)?$code:null;
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
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/plugins/daterangepicker/daterangepicker.css")}}">
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
                                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","selCollaboratorFilter",$lang.'form.filters.lbl_collaborator',true,"col-md-12","fas fa-envelope") !!}
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
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","collaborator_id",$lang.'form.register.lbl_collaborator',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","boss_collaborator_id",$lang.'form.register.lbl_boss_collaborator',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","position_id",$lang.'form.register.lbl_position',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_price","salary",$lang.'form.register.lbl_salary',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_date","start_at",$lang.'form.register.lbl_start_at',true,"col-md-6") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_date","end_at",$lang.'form.register.lbl_end_at',true,"col-md-6") !!}
                        <label class="col-md-12" style="color:red">{!! trans($lang.'form.register.lbl_message_end_at') !!}</label>
                        <input type="hidden" id="inpCollaboratorContractId" value="-1">
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
    <!-- InputMask -->
    <script src="{{asset("resources/assets/".$group."/main/plugins/moment/moment.min.js")}}"></script>
    <script src="{{asset("resources/assets/".$group."/main/plugins/inputmask/min/jquery.inputmask.bundle.min.js")}}"></script>
    <!-- date-range-picker -->
    <script src="{{asset("resources/assets/".$group."/main/plugins/daterangepicker/daterangepicker.js")}}"></script>

    <script type="application/javascript">
        var default_id = parseInt("{!! $default_id !!}");
        var default_name = "{!! trans($lang.'lbl_default_select') !!}";
        var data = [];
        data.push({id:default_id, text:default_name, selected: true});
        <!-- ************************************************************************* -->
        function DocumentReady(){
            $("#salary").inputFilter(function (value) {return justDecimals(value)});
            $('#start_at').datetimepicker({format: 'DD/MM/YYYY'});
            $('#end_at').datetimepicker({format: 'DD/MM/YYYY'});

            FillFilterSelects();
            FillRegisterSelects();
            GetResultByFilters();
        }
        <!-- ************************************************************************* -->
        function FillFilterSelects(){
            var data_collaborator = data.slice();
            <?php
            if($code==null) $collaborator_id = $default_id;
            $lstCollaborators = ApiService::Request(config('env.app_group_admin'), 'entity', 'collaborator-get', array())->response;
            for($i=0;$i<count($lstCollaborators);$i++){
                if($code!=null){
                    if($code = $lstCollaborators[$i]["code"]) $collaborator_id=$lstCollaborators[$i]["id"];
                }
                echo "data_collaborator.push({id:".$lstCollaborators[$i]["id"].", code:'".$lstCollaborators[$i]["code"]."', text:'".$lstCollaborators[$i]["user_last_name"].", ".$lstCollaborators[$i]["user_first_name"]." (".$lstCollaborators[$i]["code"].")', selected: false});\n";
            }
            ?>
            /****************************************************************************************/
            $('#selCollaboratorFilter').html("");
            $('#selCollaboratorFilter').select2({theme: 'bootstrap4',tags: false,data: data_collaborator});
            $("#selCollaboratorFilter").val("{!!$collaborator_id!!}").trigger('change');
            $("#selCollaboratorFilter").on('select2:selecting', function(e) {
                var url = "{!! \App\Http\Common\Services\RouteService::GetAdminURL("collaborator-contract-list",["code"=>"route_parameter"]) !!}";
                window.location.href = url.replace("route_parameter",e.params.args.data.code);
            });
            /****************************************************************************************/
            $('#boss_collaborator_id').html("");
            $('#boss_collaborator_id').select2({theme: 'bootstrap4',tags: false,data: data_collaborator});
            $("#boss_collaborator_id").val(default_id).trigger('change');
            /****************************************************************************************/
            $('#collaborator_id').html("");
            $('#collaborator_id').select2({theme: 'bootstrap4',tags: false,data: data_collaborator});
            $("#collaborator_id").val(default_id).trigger('change');
        }
        function FillRegisterSelects(){
            /****************************************************************************************/
            //COLLABORATORS LLENADO JUNTO CON FILTERS....
            /****************************************************************************************/
            var data_position = data.slice();
            <?php
            $lstPositions = ApiService::Request(config('env.app_group_admin'), 'entity', 'position-get', array())->response;
            for($i=0;$i<count($lstPositions);$i++){
                echo "data_position.push({id:".$lstPositions[$i]["id"].", text:'".$lstPositions[$i]["name_localized"]."', selected: false});\n";
            }
            ?>
            $('#position_id').html("");
            $('#position_id').select2({theme: 'bootstrap4',tags: false,data: data_position});
            $("#position_id").val(default_id).trigger('change');
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
            var collaborator_id = $("#selCollaboratorFilter").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','collaborator-contract-get')
                @slot('parameters', '"collaborator_id": collaborator_id')
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
                            "<th>{!! trans($lang.'result_table.col_collaborator_contract_id') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_position') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_boss') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_salary') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_start_at') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_end_at') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_options') !!}</th>"+
                        "</tr>");
                        response.forEach(function (row) {
                            table_body = table_body + "<tr>";
                            table_body = table_body + "<td>" + (row["id"] === null ? "" : row["id"]) + "</td>";
                            table_body = table_body + "<td>" + (row["position_name"] === null ? "" : row["position_name"]) + "</td>";
                            if(row["boss_collaborator_code"]==null){
                                table_body = table_body + "<td>" + " - " + "</td>";
                            }else{
                                table_body = table_body + "<td>" + row["boss_collaborator_code"] + " - " + row["boss_collaborator_first_name"] + ", " + row["boss_collaborator_first_name"] + "</td>";
                            }
                            table_body = table_body + "<td>" + row["currency_symbol"] + " " + parseFloat(row["salary"]).toFixed(2) + "</td>";
                            table_body = table_body + "<td>" + (row["start_at"] === null ? " - " : row["start_at"]) + "</td>";
                            table_body = table_body + "<td>" + (row["end_at"] === null ? " - " : row["end_at"]) + "</td>";
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

            if($("#collaborator_id").val()==default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_collaborator") !!}";
            if($("#position_id").val()==default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_position") !!}";
            if($("#salary").val().length===0 || !justDecimals($("#salary").val())) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_salary") !!}";
            if($("#start_at").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_start_at") !!}";
            else if (!justDate($("#start_at").val())) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_format_start_at",["format"=>\App\Http\Common\Services\ParameterService::GetParameter("date_format")]) !!}";
            if($("#end_at").val().length!==0 && !justDate($("#end_at").val())) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_format_end_at",["format"=>\App\Http\Common\Services\ParameterService::GetParameter("date_format")]) !!}";

            if(messages !== ""){
                ShowErrorMessage("{!! trans($lang."lbl_default_error") !!}",messages);
                return false;
            }
            return true;
        }
        function RegisterEntity(){
            if(!ValidateRegister()) return;
            var collaborator_contract_id = $("#inpCollaboratorContractId").val();
            var collaborator_id = $("#collaborator_id").val();
            var position_id = $("#position_id").val();
            var boss_collaborator_id = $("#boss_collaborator_id").val();
            var salary = $("#salary").val();
            var currency_id = $("#currency_id_salary").val();
            var start_at = $("#start_at").val();
            var end_at = $("#end_at").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','collaborator-contract-register')
                @slot('parameters',"
                    'id':collaborator_contract_id,
                    'collaborator_id':collaborator_id,
                    'position_id':position_id,
                    'boss_collaborator_id':boss_collaborator_id,
                    'currency_id':currency_id,
                    'salary':salary,
                    'start_at':start_at,
                    'end_at':end_at,
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
        function OpenRegisterForm(collaborator_contract_id){
            $("#collaborator_id").prop('disabled', true);
            if($("#selCollaboratorFilter").val()==default_id){
                ShowErrorMessage("{!! trans($lang.'lbl_no_collaborator_selected') !!}");
                return false;
            }
            if(collaborator_contract_id==default_id){
                $("#inpCollaboratorContractId").val(default_id);
                $("#collaborator_id").val($("#selCollaboratorFilter").val()).trigger('change');
                $("#position_id").val(default_id).trigger('change');
                $("#boss_collaborator_id").val(default_id).trigger('change');
                InitPriceInput("salary");
                $("#start_at").val("");
                $("#end_at").val("");
                $("#btnRegister").text("{!! trans($lang.'form.register.btn_save_entity') !!}");
                $("#form_register").modal('show');
            }else{
                $("#btnRegister").text("{!! trans($lang.'form.register.btn_update_entity') !!}");
                @component(config($group.'.ui.component.engine.ajax.view'))
                    @slot('app_group',$group)
                    @slot('ws_group','entity')
                    @slot('ws_name','collaborator-contract-get')
                    @slot('parameters',"'collaborator_contract_id':collaborator_contract_id")
                    @slot('result_success')
                        var entity = response[0];
                        $("#inpCollaboratorContractId").val(entity["id"]);
                        $("#collaborator_id").val(entity["collaborator_id"]).trigger('change');
                        $("#position_id").val(entity["position_id"]).trigger('change');
                        if(entity["boss_collaborator_id"]===null){
                            $("#boss_collaborator_id").val(default_id).trigger('change');
                        }else{
                            $("#boss_collaborator_id").val(entity["boss_collaborator_id"]).trigger('change');
                        }
                        InitPriceInput("salary",entity["currency_id"],entity["salary"]);
                        $("#start_at").val(entity["start_at"]);
                        $("#end_at").val(entity["end_at"]);
                        $("#form_register").modal('show');
                    @endslot
                    @slot('result_error')
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    @endslot
                @endcomponent
            }
        }
        function DeleteEntity(collaborator_contract_id){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','collaborator-contract-delete')
            @slot('parameters',"
                'id':collaborator_contract_id,
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