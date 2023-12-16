<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.user.list.lang');

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
        @slot('modal_id','form_register')
        @slot('modal_title',strtoupper(trans($lang.'form.register.title')))

        @slot('modal_class_04','bg-dark')
        @slot('modal_body')
            <div class="form-group">
                <div class="row">
                    <div class="row col-md-12">
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","dni",$lang.'form.register.lbl_dni',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","first_name",$lang.'form.register.lbl_first_name',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","last_name",$lang.'form.register.lbl_last_name',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","phone",$lang.'form.register.lbl_phone',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","email",$lang.'form.register.lbl_email',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","password",$lang.'form.register.lbl_password',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","repassword",$lang.'form.register.lbl_repassword',true,"col-md-12") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","company_id",$lang.'form.register.lbl_company',true,"col-md-12") !!}
                        <label class="col-md-12" style="color:red" id="lblClaveAlert">{!! trans($lang.'form.register.lbl_message_passwords') !!}</label>
                        <input type="hidden" id="inpUserId" value="-1">
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
                @slot('ws_name','user-get')
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
                            "<th>{!! trans($lang.'result_table.col_user_id') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_company') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_dni') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_first_name') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_last_name') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_email') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_phone') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_active') !!}</th>"+
                            "<th>{!! trans($lang.'result_table.col_options') !!}</th>"+
                        "</tr>");
                        response.forEach(function (row) {
                            table_body = table_body + "<tr>";
                            table_body = table_body + "<td>" + (row["id"] === null ? "" : row["id"]) + "</td>";
                            table_body = table_body + "<td>" + (row["company"] === null ? "" : row["company"]) + "</td>";
                            table_body = table_body + "<td>" + (row["dni"] === null ? "" : row["dni"]) + "</td>";
                            table_body = table_body + "<td>" + (row["first_name"] === null ? "" : row["first_name"]) + "</td>";
                            table_body = table_body + "<td>" + (row["last_name"] === null ? "" : row["last_name"]) + "</td>";
                            table_body = table_body + "<td>" + (row["email"] === null ? "" : row["email"]) + "</td>";
                            table_body = table_body + "<td>" + (row["phone"] === null ? "" : row["phone"]) + "</td>";
                            table_body = table_body + "<td style='text-align: center;cursor: pointer ;'> <i class='fas fa-" + (row["is_active"] === 1 ? "check":"times") + "' style='color:" + (row["is_active"] === 1 ? "green":"red") + "' onclick='ChangeStatus(\""+row["id"]+"\","+(row["is_active"] === 1 ? 0:1)+");'></i></td>";
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
            if($("#dni").val().length===0 || !justNumbers($("#dni").val())) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_dni") !!}";
            if($("#first_name").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_first_name") !!}";
            if($("#last_name").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_last_name") !!}";
            if($("#phone").val().length===0 || !justNumbers($("#phone").val())) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_phone") !!}";
            if($("#email").val().length===0) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_email") !!}";
            if($("#password").val().length===0 && $("#inpUserId").val()==default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_password") !!}";
            if($("#repassword").val()!==$("#password").val()) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_repassword") !!}";
            @if($is_internal_user)
                if($("#company_id").val()==default_id) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_company") !!}";
            @else
                if($("#company_id").val()!={!! $objAdmin["company_id"] !!}) messages = messages+(messages===""?"":"<br/>")+"{!! trans($lang."form.register.errors.msg_invalid_company") !!}";
            @endif

            if(messages !== ""){
                ShowErrorMessage("{!! trans($lang."lbl_default_error") !!}",messages);
                return false;
            }
            return true;
        }
        function RegisterEntity(){
            if(!ValidateRegister()) return;
            var user_id = $("#inpUserId").val();
            var dni = $("#dni").val();
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var phone = $("#phone").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var repassword = $("#repassword").val();
            var company_id = $("#company_id").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','user-register')
                @slot('parameters',"
                    'id':user_id,
                    'dni':dni,
                    'first_name':first_name,
                    'last_name':last_name,
                    'phone':phone,
                    'email':email,
                    'password':password,
                    'repassword':repassword,
                    'company_id':company_id,
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
        function OpenRegisterForm(user_id){
            @if(!$is_internal_user)
            $("#company_id").prop('disabled', true);
            @endif
            if(user_id==default_id){
                $("#lblClaveAlert").hide();
                $("#inpUserId").val(default_id);
                $("#dni").val("");
                $("#first_name").val("");
                $("#last_name").val("");
                $("#phone").val("");
                $("#email").val("");
                $("#password").val("");
                $("#repassword").val("");
                @if(!$is_internal_user)
                $("#company_id").prop('disabled', true);
                $("#company_id").val({!! $objAdmin["company_id"] !!}).trigger('change');
                @else
                $("#company_id").val(default_id).trigger('change');
                @endif
                $("#btnRegister").text("{!! trans($lang.'form.register.btn_save_entity') !!}");
                $("#form_register").modal('show');
            }else{
                $("#lblClaveAlert").show();
                $("#btnRegister").text("{!! trans($lang.'form.register.btn_update_entity') !!}");
                @component(config($group.'.ui.component.engine.ajax.view'))
                    @slot('app_group',$group)
                    @slot('ws_group','entity')
                    @slot('ws_name','user-get')
                    @slot('parameters',"'user_id':user_id")
                    @slot('result_success')
                        var entity = response[0];
                        $("#inpUserId").val(entity["id"]);
                        $("#dni").val(entity["dni"]);
                        $("#first_name").val(entity["first_name"]);
                        $("#last_name").val(entity["last_name"]);
                        $("#phone").val(entity["phone"]);
                        $("#email").val(entity["email"]);
                        $("#password").val("");
                        $("#repassword").val("");
                        if(entity["company_id"]==null){
                            $("#company_id").val(default_id).trigger('change');
                        }else{
                            $("#company_id").val(entity["company_id"]).trigger('change');
                        }
                        $("#form_register").modal('show');
                    @endslot
                    @slot('result_error')
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    @endslot
                @endcomponent
            }
        }
        function DeleteEntity(user_id){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','user-delete')
            @slot('parameters',"
                'id':user_id,
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