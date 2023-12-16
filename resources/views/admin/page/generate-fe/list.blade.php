<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.generate-Fe.list.lang');
/* $lang = config($group.'.ui.page.idioms.list.lang'); */
$ruc = config('greenter.ruc');
$default_id = ParameterService::GetParameter("default_id");

?>
@extends(config($group.'.ui.template.main.view'))
@section('page_title',trans($lang.'page_title'))
@section('metas','')
@section('top_scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/datatable/datatables.min.css")}}"/>
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/datatable/Buttons-1.6.1/css/buttons.dataTables.min.css")}}"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
@endsection
@section('body')
{{-- tarjeta --}}
<div class="content-header">
  <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 text-dark">
                <i class="fa fa-leaf" aria-hidden="true"></i>  
                {!! trans($lang.'page_title') !!}</h1>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">{!! trans($lang.'page_title') !!}</a></li>
              </ol>
          </div>
      </div>
  </div>
</div>
{{-- tarjeta --}}
{{-- segunda tarjeta --}}
<div class="content">
  <div class="container-fluid">
      {{-- @if($is_internal_user) --}}
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
                            <div class="col-sm-6">
                                <div class="form-group container p-auto">
                                    <label for="fec-emi-doc">Fecha de emision</label>
                                    <input type="date" name="" id="fec-emi-doc" class="form-control">
                                </div>
                            </div>
                                <div class="col-sm-6">
                                    <div class="form-group container p-auto">
                                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","currency",$lang.'form.register.lbl_currency_fe',true,"") !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: right!important;">
                            {{-- <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form-register-subs" id="btnopenform" >{!! trans($lang.'btn_register') !!}</button> --}}
                        </div>
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
          <div class="card-body table-responsive">
              <table id="tbResults" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                  <thead>
                    <th>{!! trans($lang.'result_table.col_id') !!}</th>
                    {{-- <th>{!! trans($lang.'result_table.col_tip_doc') !!}</th> --}}
                    {{-- <th>{!! trans($lang.'result_table.col-num-doc') !!}</th> --}}
                    <th>{!! trans($lang.'result_table.col_customer') !!}</th>
                    <th>{!! trans($lang.'result_table.col_currency') !!}</th>
                    <th>{!! trans($lang.'result_table.col_base_imponible') !!}</th>
                    <th>{!! trans($lang.'result_table.col_monto_tot') !!}</th>
                    <th>{!! trans($lang.'result_table.col_fec_emi') !!}</th>
                    <th>{!! trans($lang.'result_table.col_status_doc') !!}</th>
                    <th>ESTADO DE PAGO</th>
                    {{-- <th>{!! trans($lang.'result_table.col_payment_status') !!}</th> --}}
                    <th>{!! trans($lang.'result_table.col_options') !!}</th>
                  </thead>
                  <tbody id="tablebody"></tbody>
              </table>
          </div>
          <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
      </div>
  </div>
</div>
{{-- segunda tarjeta --}}
<!--Modales-->
@component(config($group.'.ui.component.engine.modal.view'))
@slot('modal_id', 'form-register-subs')
@slot('modal_title', strtoupper(trans($lang.'page_title')))
@slot('modal_class_02','-')
@slot('modal_class_04', 'bg-dark')
@slot('modal_body')
        <div class="form-group">
            <div class="row col-md-12" id="content">
                {{-- select para el tipo de grupo --}}
                <input type="text" name="defaultid" hidden id="defaultid">
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code',true,"col-md-12") !!}
                {{-- <div class="section-check d-flex row col-md-12 justify-content-around">
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","is_color",$lang.'form.register.lbl_color',true," my-auto mx-auto d-inline") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","is_html",$lang.'form.register.lbl_html',true," my-auto mx-auto d-inline") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","is_image",$lang.'form.register.lbl_image',true," my-auto mx-auto d-inline") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","is_preview",$lang.'form.register.is_preview',true,"my-auto mx-auto d-inline") !!}
                </div> --}}
                <div class="row container">
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name',true,"col-md-12") !!}
                </div>
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save" style="margin: 5px!important;" id="btnRegister" class="btn btn-success form-control"> </button>
                    </div>
                </div>
@endslot
@endcomponent
<!--Modales-->


<!--Modal para el correo electronico-->
@component(config($group.'.ui.component.engine.modal.view'))
@slot('modal_id', 'form-send-email')
@slot('modal_title', strtoupper(trans($lang.'lbl_send_msg')));
@slot('modal_class_02','modal-md')
@slot('modal_class_04', 'bg-dark')
@slot('modal_body')
        <div class="form-group">
            <div class="row">
                <input type="text" hidden id="id_user_email">
                <input type="text" hidden id="id_order_email">
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","email",$lang.'form.register.lbl_email',true,"col-md-12") !!}
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button style="margin: 5px!important;" id="btn-send" class="btn btn-success form-control">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            {!! trans($lang.'btn_send_email') !!}
                        </button>
                    </div>
                </div>
@endslot
@endcomponent
<!--Modales-->
<!--Modal para la respuesta de sunat-->
@component(config($group.'.ui.component.engine.modal.view'))
@slot('modal_id', 'form-response-sunat')
@slot('modal_title', strtoupper(trans($lang.'lbl_response_sunat')));
@slot('modal_class_02','modal-lg')
@slot('modal_class_04', 'bg-dark')
@slot('modal_body')
        <div class="form-group">
            <div class="card card-dark container">
                <div class="card-header">
                    <h3 class="card-title">{!! trans($lang.'lbl_results_header') !!}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="tbSunatResponse" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                          <th>{!! trans($lang.'result_table.col_id') !!}</th>
                          <th>{!! trans($lang.'result_table.col-num-doc') !!}</th>
                          {{-- <th>{!! trans($lang.'result_table.col_tip_doc') !!}</th> --}}
                          <th>{!! trans($lang.'result_table.col_status_doc') !!}</th>
                         {{--  <th>{!! trans($lang.'result_table.col_obs') !!}</th> --}}
                          <th>{!! trans($lang.'result_table.col_options') !!}</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
            </div>
        </div>
@endslot
@endcomponent
<!--Modales-->

<!--Modales-->
<!--Modal para generar un documento-->
@component(config($group.'.ui.component.engine.modal.view'))
@slot('modal_id', 'form-generate-sunat')
@slot('modal_title', strtoupper(trans($lang.'lbl_generate_doc')));
@slot('modal_class_02','modal-lg')
@slot('modal_class_04', 'bg-dark')
@slot('modal_body')
        <div class="container">
            <form action="" method="post" id="form-generate-doc">
                <div class="form-group" id="form-header-doc">
                    {{-- <div class="row border container my-3 p-3">
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","doc",$lang.'form.register.lbl_document',true,"col-md-5") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","serie",$lang.'form.register.lbl_serie',true,"col-md-3") !!}
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","correlativo",$lang.'form.register.lbl_correlativo',true,"col-md-4") !!}
                    </div> --}}
                    <div class="form-group border container my-3 p-3">
                        <div class="row">
                            <input type="text" hidden id="order_id">
                            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","name_customer",$lang.'form.register.lbl_full_name',true,"col-md-8") !!}
                            {{-- {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","last_name_customer",$lang.'form.register.lbl_last_name',true,"col-md-5") !!} --}}
                            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","num_doc",$lang.'form.register.lbl_doc_customer',true,"col-md-4") !!}
                            {{-- {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","name_customer",$lang.'form.register.lbl_name',true,"col-md-7") !!} --}}
                            {{-- {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","last_name_customer",$lang.'form.register.lbl_last_name',true,"col-md-5") !!} --}}
                            {{-- {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","num_doc",$lang.'form.register.lbl_doc_customer',true,"col-md-5") !!} --}}
                        </div>
                        <div class="row  my-3 d-flex justify-content-around">
                            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","currency_form",$lang.'form.register.lbl_currency_fe',true,"col-md-4") !!}
                            <div class="form-group col-sm-4">
                                <label for="#fec-date-emi">{{ trans($lang.'form.register.lbl_fec_emi.title') }}</label>
                                <input type="date" class="form-control" id="fec-date-emi">
                            </div>
                        </div>
                        <div class="row mt-1">
                            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","phone_customer",$lang.'form.register.lbl_phone_customer',true,"col-md-5") !!}
                            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","email_customer",$lang.'form.register.lbl_email',true,"col-md-7") !!}
                        </div>

                    </div>
                    <div class="row border container my-3 p-3 d-flex justify-content-around">
                        
                        {{-- {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","address_form",$lang.'form.register.lbl_address',true,"col-md-6") !!} --}}
                    </div>
                </div>
                <div class="form-group" id="form-detail-doc">
                    <table width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">{{ trans($lang.'result_detail.col_id') }}</th>
                                <th>{{ trans($lang.'result_detail.col_codigo') }}</th>
                                <th>{{ trans($lang.'result_detail.col_name_prod') }}</th>
                                <th>{{ trans($lang.'result_detail.col_precio') }}</th>
                                <th>{{ trans($lang.'result_detail.col_cant') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="row border container my-3 p-3 d-flex justify-content-around">
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","sub_total",$lang.'form.register.lbl_sub_tot',true,"col-md-3") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","cost_envio",$lang.'form.register.lbl_cost_envio',true,"col-md-3") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","total",$lang.'form.register.lbl_tot',true,"col-md-3") !!}
                </div>
            </form>
        </div>
@endslot
@slot('modal_footer')
    <div class="row container my-3 d-flex justify-content-around">
        <button id="btn-save-document" type="button" class="btn btn-success" onclick="generateBilling()" >
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
            {{ trans($lang.'btn_send_doc') }}
        </button>
        <button id="btn-cancel-document" type="button" class="btn btn-danger" onclick="invoidedBilling()" >
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
            {{ trans($lang.'btn_cance_doc') }}
        </button>
        <button type="button" class="btn btn-warning" onclick="closeModal()">
            <i class="fa fa-ban" aria-hidden="true"></i>
            {{ trans($lang.'btn_cancel_doc') }} 
        </button>
    </div>
@endslot
@endcomponent
<!--Modales-->
<!--scrits-->
<script>
    

    window.onload=function(){
        loadData("{{$default_id}}");
        LoadCurrency($("#currency"));
        $("#inp-container-cost_envio label").html("");
        $("#inp-container-cost_envio label").html("Costo de envio");
        $("#email").attr("readonly", true);
        $("#btn-save-document").on("click", function(){
            $("#btn-save-document").attr("disabled", true);
        });
        $("#btn-cancel-document").on("click", function(){
            $("#btn-cancel-document").attr("disabled", true);
        });
        $("#btn-send").on("click", function(){
            sendEmailDocument($("#email").val(), $("#id_user_email").val(), $("#id_order_email").val());
        });
        //evento de botones
        $("#currency").on("change", function(){
            let valchange=$("#currency").val();
            let fec=$("#fec-emi-doc").val();
            console.log(fec);
            loadFilter(fec, valchange);
        });
        $("#fec-emi-doc").on("change", function(){
            let fec_emision=$("#fec-emi-doc").val();
            let valchange=$("#currency").val();
            console.log(valchange);
            loadFilter(fec_emision, (valchange=="-1")? null : valchange );
        });
        let icon=`<i class="fa fa-paper-plane" aria-hidden="true"></i>`;
        $(icon).insertBefore($("#form-generate-sunat-title b"));
    }
    function LoadCurrency(obj){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','currency-get')
                @slot('parameters', "")
                @slot('result_success')
                    obj.html("");
                    let query="";
                    query=`<option value="-1">{{trans($lang.'lbl_default_select')}}</option>`;
                    for(let item of response){
                        query=query+`<option value="${item.id}">${item.name_localized + " - " + item.symbol}</option>`;
                    }
                    obj.append(query);
                    obj.select2();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function closeModal(){
        $("#form-generate-sunat").modal("hide");
    }
    function loadFilter(date=null, currency=null){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-billed-get-filter')
                @slot('parameters', " 'fec_emision': date, 'currency': currency")
                @slot('result_success')
                if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                    $("#tbResults tbody").html("");
                    console.log(response);
                    let query="";
                    let value="";
                        for(let row of response){
                            if(row.electronic_billing_sale_status=="1"){
                                value="EMITIDO SIN OBSERVACIONES";
                            }else if(row.electronic_billing_sale_status=="2"){
                                value="EMITIDO CON OBSERVACIONES";
                            }else if(row.electronic_billing_sale_status=="3"){
                                value="RECHAZADO";
                            }else if(row.electronic_billing_sale_status=="4"){
                                value="CDR INVALIDO";
                            }else{
                                value="SIN EMITIR";
                            }
                            query=query+`<tr>
                                            <td scope="row">${row.id}</td>
                                            <td>${row.user_first_name + " " + row.user_last_name}</td>
                                            <td>${row.currency_name}</td>
                                            <td>${row.sub_total}</td>
                                            <td>${row.total}</td>
                                            <td>${row.ordered_at}</td>
                                            <td>${value}</td>
                                            <td>${(row.col_payment_status==null) ? "" : row.col_payment_status }</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                                        <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                            <a class='dropdown-item' href='#' onclick='generateDoc(${row.id}, ${row.electronic_billing_sale_status})'>
                                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                                                {!! trans($lang.'result_table.options.generate') !!}</a>
                                                            <a class='dropdown-item' href='#' onclick='responseSunat(${row.id})'>
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                                {!! trans($lang.'result_table.options.cdr') !!}</a>
                                                            <a class='dropdown-item' href='#' onclick='sendEmail(${row.id}, ${row.electronic_billing_sale_status})'>
                                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                {!! trans($lang.'result_table.options.send-email') !!} </a>
                                                        </div>
                                                    </button>    
                                                </div>
                                            </td>
                                        </tr>`;
                        }
                        $("#tbResults tbody").append(query);
                        $("#tbResults").DataTable({
                        responsive: true,
                        language: {
                        processing:     "Recopilando informacion...",
                        search:         "Buscador",
                        lengthMenu:    "Ver _MENU_ Elementos",
                        info:           "desde elemento _START_ ; _END_ de _TOTAL_ elementos",
                        infoEmpty:      "Mostrando 0 a 0 de 0 entradas (filtrado de 1 entradas totales)",
                        infoPostFix:    "",
                        loadingRecords: "Chargement en cours...",
                        zeroRecords:    "No hay datos",
                        emptyTable:     "No se encontraron datos",
                        paginate: {
                            first:      "Primero",
                            previous:   "Anterior",
                            next:       "Siguiente",
                            last:       "Ultimo"
                            },
                    }});
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function validastatus(estatus){
        let value="";
        if(estatus=="1"){
            value="EMITIDO SIN OBSERVACIONES";
        }else if(estatus=="2"){
            value="EMITIDO CON OBSERVACIONES";
        }else if(estatus=="3"){
            value="RECHAZADO";
        }else if(estatus=="4"){
            value="CDR INVALIDO";
        }else{
            value="SIN EMITIR";
        }
        return value;
    }
    function loadData(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                /* @slot('ws_name','order-get') */
                @slot('ws_name','order-get-all-billed')
                @slot('parameters', "  ")
                @slot('result_success');
                /* console.log(response); */
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                    $("#tbResults tbody").html("");
                    let anulado="";
                    let query="";
                        for(let row of response){
                        /* console.log(row.electronic_billing_sale_serie); */
                        if(row.electronic_billing_sale_serie!=null){
                            anulado=row.electronic_billing_sale_serie.substring(0,2)=="RC" ? true: false;
                        }else{
                            anulado="document";
                        }
                        /* console.log(anulado+"-"+row.electronic_billing_sale_correlative); */
                            query=query+`<tr>
                                            <td scope="row">${row.id}</td>
                                            <td>${row.user_first_name + " " + row.user_last_name}</td>
                                            <td>${row.currency_name}</td>
                                            <td>${row.sub_total}</td>
                                            <td>${row.total}</td>
                                            <td>${row.ordered_at}</td>
                                            <td>${validastatus(row.electronic_billing_sale_status)}</td>
                                            <td>${(row.col_payment_status==null) ? "" : row.col_payment_status }</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                                        <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                            <a class='dropdown-item' href='#' onclick='generateDoc(${row.id}, ${row.electronic_billing_sale_status}, ${anulado}, ${row.electronic_billing_sale_is_voided})'>
                                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                                                {!! trans($lang.'result_table.options.generate') !!}</a>
                                                            <a class='dropdown-item' href='#' onclick='responseSunat(${row.id})'>
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                                {!! trans($lang.'result_table.options.cdr') !!}</a>
                                                            <a class='dropdown-item' href='#' onclick='sendEmail(${row.id}, ${row.electronic_billing_sale_status})'>
                                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                {!! trans($lang.'result_table.options.send-email') !!} </a>
                                                        </div>
                                                    </button>    
                                                </div>
                                            </td>
                                        </tr>`;
                        }
                        $("#tbResults tbody").append(query);
                        $("#tbResults").DataTable({
                        responsive: true,
                        language: {
                        processing:     "Recopilando informacion...",
                        search:         "Buscador",
                        lengthMenu:    "Ver _MENU_ Elementos",
                        info:           "desde elemento _START_ ; _END_ de _TOTAL_ elementos",
                        infoEmpty:      "Mostrando 0 a 0 de 0 entradas (filtrado de 1 entradas totales)",
                        infoPostFix:    "",
                        loadingRecords: "Chargement en cours...",
                        zeroRecords:    "No hay datos",
                        emptyTable:     "No se encontraron datos",
                        paginate: {
                            first:      "Primero",
                            previous:   "Anterior",
                            next:       "Siguiente",
                            last:       "Ultimo"
                            },
                    }});
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function sendEmail(id, value){
        if(value=="null" || value==null || value==""){
            ShowErrorMessage("No generado", "Antes de notificar al cliente, emita su documento electronico");
        }else{
            $("#form-send-email").modal("show");
            getEmail(id);
        }
    }
    function responseSunat(ide, value){        
        @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','electronic-billing-sale-get')
                @slot('parameters', "  'order_id':ide ")
                @slot('result_success')                   
                    $("#tbSunatResponse tbody").html("");
                    console.log(response);
                    let query="";
                    let ruc="{{$ruc}}";
                    if(response.length>0){
                        for(let item of response){
                        let estado=validastatus(item.status);
                        let serie=item.serie;
                        let zipname=((serie.substring(0,2)=="RC") ? `R-${ruc}-${item.serie}-${item.correlative}.zip`: `R-${ruc}-03-${item.serie}-${item.correlative}.zip`);
                        let xmlname=((serie.substring(0,2)=="RC") ? `${ruc}-${item.serie}-${item.correlative}.xml`: `${ruc}-03-${item.serie}-${item.correlative}.xml`);
                        let pdfname=((serie.substring(0,2)=="RC") ? `${ruc}-${item.serie}-${item.correlative}.pdf`: `${ruc}-03-${item.serie}-${item.correlative}.pdf`);
                        query=query+`<tr>
                                        <td>${item.id}</td>
                                        <td>${item.serie}-${item.correlative}</td>
                                        <td>${estado}</td>
                                        <td>
                                        <div class="row">
                                            <a type="button" class="btn btn-success col-sm-4" title="Descargar CDR" href="{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/FE/cdr/${zipname}" download="${zipname}">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            <a type="button" class="btn btn-warning col-sm-4" title="DESCARGAR XML" href="{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/FE/xml/${xmlname}" download="${xmlname}.xml">
                                                <i class="fa fa-file-code" aria-hidden="true"></i>
                                            </a>
                                            <a type="button" class="btn btn-danger col-sm-4" title="DESCARGAR PDF" href="{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/FE/pdf/${pdfname}" target="_blank" rel="noopener">
                                                <i class="fa fa-file-pdf" aria-hidden="true"></i>
                                            </a>
                                        </div></td>
                                    </tr>`;
                        }
                    }else{
                        ShowErrorMessage("ERROR", "COMPROBANTE ELECTRONICO NO EXISTE");
                    }
                    $("#tbSunatResponse tbody").append(query);
                    $("#form-response-sunat").modal("show");
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent 
    }
    function generateDoc(id, status, flag, voided){
        $("#form-generate-sunat-title span").html("")
        $("#form-generate-sunat-title span").remove();
        if(status==null || status=="null" || status==""){
            //habilitamos el boton
            $("#btn-cancel-document").attr("hidden", true);
            $("#btn-cancel-document").attr("disabled", true);
            $("#btn-save-document").attr("hidden", false);
            $("#btn-save-document").attr("disabled", false);
        }else{
            $("#btn-cancel-document").attr("hidden", false);
            $("#btn-cancel-document").attr("disabled", false);
            $("#btn-save-document").attr("hidden", true);
            $("#btn-save-document").attr("disabled", true);
            if(flag==false && voided==0){
                $("#form-generate-sunat-title b").append("<span class='text-warning'> (DOCUMENTO YA EMITIDO)</span>");
            }else if(flag==true && voided==0){
                $("#form-generate-sunat-title b").append("<span class='text-danger'> (DOCUMENTO DE BAJA)</span>");
                $("#btn-cancel-document").attr("hidden", true);
            }else if(flag=="document" && voided==0){
                $("#form-generate-sunat-title b").append("<span class='text-warning'> (DOCUMENTO YA EMITIDO)</span>");
            }else if(flag==false && voided==1){
                $("#form-generate-sunat-title b").append("<span class='text-warning'> (DOCUMENTO YA EMITIDO Y ANULADO)</span>");
                $("#btn-cancel-document").attr("hidden", true);
                $("#btn-cancel-document").attr("disabled", true);
            }
        }
        loadHeader(id);
        $("#form-generate-sunat").modal("show");
        LoadCurrency($("#currency_form"));
    }
    function generateBilling(){
        var order_id = $('#order_id').val();
        @component(config($group.'.ui.component.engine.ajax-internal.view'))
            @slot('app_group',$group)
            @slot('route','send-electronic-billing')
            @slot('parameters', "'order_id':order_id")
            @slot('result_success')
                var contenido = `<p>${response['resultado']}</p>`;
                if (response['obs'] != '') {
                    contenido += response['obs'];
                }
                ShowSuccessMessage(message,contenido);
                $("#form-generate-sunat").modal("hide");
                loadData("");
            @endslot
            @slot('result_error')
                if (response['error'] == null || response['error'].length == 0) {
                    ShowErrorMessage('Ocurrio un error','');
                }
                ShowErrorMessage(message,response['error']['error_code']+' '+response['error']['error_message']);
            @endslot
        @endcomponent
    }
    function invoidedBilling(){
        var order_id = $('#order_id').val();
        @component(config($group.'.ui.component.engine.ajax-internal.view'))
            @slot('app_group',$group)
            @slot('route','send-invoided-billing')
            @slot('parameters', "'order_id':order_id")
            @slot('result_success')
                var contenido = `<p>${response['resultado']}</p>`;
                if (response['obs'] != '') {
                    contenido += response['obs'];
                }
                ShowSuccessMessage(message,contenido);
                $("#form-generate-sunat").modal("hide");
                loadData("");
            @endslot
            @slot('result_error')
                ShowErrorMessage(message,response['error']['error_code']+' '+response['error']['error_message']);
            @endslot
        @endcomponent
    }
    function loadHeader(ide){
        @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','order-get')
            @slot('parameters', " 'order_id': ide ")
            @slot('result_success')
                //damos los valores
                $('#order_id').val(ide);
                $("#name_customer").val(response.user_first_name+" "+response.user_last_name);
                
                let data=JSON.parse(response.receiver_info);
                $("#num_doc").val(data["receiver_dni"]);
                
                $("#email_customer").val(response.user_email);
                $("#phone_customer").val(data["receiver_phone"]);
                $("#currency_form").val(response.currency_id);
                $("#currency_form").change();
                var fecha=new Date(response.ordered_at);
                let dia=fecha.getDate();
                let mes=(fecha.getMonth()+1);
                let año=fecha.getFullYear();

                if(dia>9){}else{dia="0"+dia;}
                if(mes>9){}else{mes="0"+mes;}

                let stringDate=`${año}-${mes}-${dia}`;
                $("#fec-date-emi").val(stringDate);
                $("#cost_envio").val(response.shipping_cost);
                $("#sub_total").val(parseFloat(response.sub_total).toFixed(2));
                $("#total").val(parseFloat(response.total).toFixed(2));
                getOrderDetail(response.id);
                readonlyInputs();
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
                HideFullLoading();
            @endslot
        @endcomponent
    }
    function readonlyInputs(){
        $("#fec-date-emi").attr("readonly", true);
        $("#sub_total").attr("readonly", true);
        $("#total").attr("readonly", true);
        $("#name_customer").attr("readonly", true);
        /* $("#last_name_customer").attr("readonly", true); */
        $("#num_doc").attr("readonly", true);
        $("#email_customer").attr("readonly", true);
        $("#phone_customer").attr("readonly", true);
        $("#currency_form").attr("disabled", true);
        $("#cost_envio").attr("readonly", true);
    }
    function limpiarForm(){
        $('#order_id').val(null);
        $("#fec-date-emi").val(null);
        $("#sub_total").val(null);
        $("#total").val(null);
        $("#name_customer").val(null)
        /* $("#last_name_customer").val(null); */
        $("#num_doc").val(null);
        $("#email_customer").val(null);
        $("#phone_customer").val(null);
        $("#currency_form").val(-1);
        $("#currency_form").change();
        $("#cost_envio").val(null);
    }
    function getEmail(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-get')
                @slot('parameters', " 'order_id': id ")
                @slot('result_success')
                    //damos los valores
                    $("#id_user_email").val(response.user_id);
                    let data=JSON.parse(response.receiver_info);
                    /* console.log(response); */
                    $("#email").val(data["receiver_email"]);
                    $("#id_order_email").val(response.id)
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function sendEmailDocument(email, iduser, idorder){
        @component(config($group.'.ui.component.engine.ajax-internal.view'))
                @slot('app_group',$group)
               /*  @slot('ws_group','entity') */
                @slot('route','send-email-document')
                @slot('parameters', " 'email':email, 'id':iduser , 'id_order':idorder ")
                @slot('result_success')
                   $("#form-send-email").modal("hide");
                   ShowSuccessMessage("Correo enviado", "Enviamos el correo solicitado");
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function getOrderDetail(id){
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-detail-get')
                @slot('parameters', " 'order_id':id ")
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable('#form-detail-doc table') ) {
                        let table = $('#form-detail-doc table').DataTable();
                        table.destroy();
                    }
                    $("#form-detail-doc table tbody").html("");                        
                    let query="";                        
                    for(let item of response){
                    query=query+`
                    <tr> 
                        <td scope="row">${item.id}</td>
                        <td>${item.product_sku}</td> 
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${parseFloat(item.price).toFixed(2)}</td>
                    </tr>`;
                    }
                    $("#form-detail-doc table tbody").append(query);                        
                    /* $('#form-detail-doc table').DataTable(); */
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
        }

    function Refrescar(){
        location.reload();
    }
</script>
<!--scrits-->
@endsection