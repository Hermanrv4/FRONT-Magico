<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.ubication.list.lang');

$default_id = ParameterService::GetParameter("default_id");

/* $objAdmin = \App\Http\Modules\Admin\Helpers\AppHelper::GetAdminData();
$is_internal_user = $objAdmin["company_id"]==null; */
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
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
@endsection
@section('body')
{{-- tarjeta --}}
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
                          <div id="selects" class="row col-md-12">
                            <!-- {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","root_ubication",$lang.'form.filters.lbl_currency',true,"col-md-12","fas fa-envelope") !!} -->
                            <div id="view">
                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12" style="text-align: right!important;">
                          <!-- <button class="btn btn-dark col-md-2" id="btnsearch" style="margin: 5px!important;">{!! trans($lang.'btn_search') !!}</button> -->
                          <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form_register_currency" id="btnSaveUbication" >{!! trans($lang.'btn_register') !!}</button>{{-- 
                          <button class="btn btn-success col-md-2" style="margin: 5px!important;" onclick="">{!! trans($lang.'btn_register') !!}</button> --}}  
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
              <table id="tbResults" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                  <thead>
                    <th>{!! trans($lang.'result_table.col_id') !!}</th>
                    <th>{!! trans($lang.'result_table.col_name') !!}</th>
                    <th>{!! trans($lang.'result_table.col_code') !!}</th>
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
@slot('modal_id', 'form_register_currency')
@slot('modal_title', strtoupper(trans($lang.'form.register.title')));
@slot('modal_class_02','-')
@slot('modal_class_04', 'bg-dark')
@slot('modal_body')
        <div class="form-group">
            <div class="row col-md-12" id="content">
                {{-- select para el tipo de grupo --}}
                <div id="divUbication" class="col-md-12">

                </div>
                <input type="text" name="defaultid" hidden id="defaultid">
                <input type="text" name="defaultroot" hidden id="defaultroot">
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","nameroot",$lang.'form.register.lbl_name_root',true,"col-md-12","fas fa-envelope") !!}
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code_ubication',true,"col-md-12","fas fa-envelope") !!}
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name_ubication',true,"col-md-12") !!}
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save" style="margin: 5px!important;" class="btn btn-success form-control"></button>
                    </div>
                </div>
@endslot
@endcomponent
<!--Modales-->
<!--Modales-->
@component(config($group.'.ui.component.engine.modal.view'))
@slot('modal_id', 'form-shipping-price')
@slot('modal_title', strtoupper(trans($lang.'form.register.title')));
@slot('modal_class_02','modal-lg')
@slot('modal_class_04', 'bg-dark')
@slot('modal_body')
<div class="content">
  <div class="container-fluid">
          <div class="card card-dark">
              <div class="card-header">
                  <h3 class="card-title">{!! trans($lang.'lbl_header_currency.create') !!}</h3>
                  <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
              </div>
              <div class="card-body">
                  <div class="form-group">
                      <div class="row">
                                <input type="text" name="defaultubication" id="defaultubication" hidden>
                                <input type="text" name="defaultshipping" id="defaultshipping" hidden>
                                <div class="container row mx-auto col-md-12">
                                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("checkbox","idBtnSaveAll",$lang.'form.register.lbl_ubication_all',true,"col-md-5","fas fa-envelope") !!}
                                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("checkbox","is_static",$lang.'form.register.lbl_static_price',true,"col-md-5","fas fa-envelope") !!}
                                </div>
                                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_price","price",$lang.'form.register.lbl_price',true,"col-md-12","fas fa-envelope") !!}
                                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","min_days",$lang.'form.register.lbl_min_days',true,"col-md-12","fas fa-envelope") !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <button class="btn btn-success col-md-2" id="btn_save_prices" style="margin: 5px!important;">{!! trans($lang.'btn_save_price') !!}</button>
                                <button class="btn btn-dark col-md-2" id="btn_clear_prices" style="margin: 5px!important;">{!! trans($lang.'btn_clear') !!}</button>
                            </div>
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
          <div class="card-body">
              <table id="table-prices" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                  <thead>
                    <th>{!! trans($lang.'result_table_prices.col_id') !!}</th>
                    <th>{!! trans($lang.'result_table_prices.col_currency') !!}</th>
                    <th>{!! trans($lang.'result_table_prices.col_code') !!}</th>
                    <th>{!! trans($lang.'result_table_prices.col_price') !!}</th>
                    <th>{!! trans($lang.'result_table_prices.col_options.title') !!}</th>
                  </thead>
                  <tbody id=""></tbody>
              </table>
          </div>
          <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
      </div>
  </div>
</div>
@endslot
@endcomponent
<!--Modales-->
<!--scrits-->
<script>
    
    window.onload=function(){
        $("#is_static").addClass("form-control");
        $("#inp-container-is_static div.inp-error-display").addClass("text-center");
        $("#idBtnSaveAll").addClass("form-control");
        $("#inp-container-idBtnSaveAll div.inp-error-display").addClass("text-center")
        LoadUbication("{{$default_id}}");
        LoadUbicationView("{{$default_id}}");
        $("#defaultid").val("{{$default_id}}");
        $("#defaultroot").val("{{$default_id}}");
        $("#nameroot").attr("readonly", "readonly");

        $("#btn_save_prices").on("click", function(){
            let idshipping=$("#defaultshipping").val();
            let moneda=$("#currency_id_price").val();
            let estatico=($("#is_static").is(":checked")===true)? 1 : 0;
            let dias=$("#min_days").val();
            let precio=$("#price").val();
            let status=($("#idBtnSaveAll").is(":checked")==true)? true : false;
            console.log(status);
            let idubication=$("#defaultubication").val();
            if(status==true){
                addPricesList(idubication, moneda, estatico, dias, precio);
            }else{
                addPrices(idubication, idshipping, moneda, estatico, dias, precio);
            }
        });
        $("#btn_clear_prices").on("click", function(){
            clearPrices();
        });
        $("#idBtnSaveAll").on("click", function () {
            if($("#idBtnSaveAll").is(":checked")){
                console.log("hola");
                messageWarning("{{trans($lang.'lbl_default_info_message')}}", "{{trans($lang.'lbl_default_info')}}");
            }
        });
    }
    function messageWarning(message, title){
        Swal.fire(
        message,
        title,
        'warning'
        )
    }
    document.getElementById("btnSaveUbication").addEventListener("click", function(){
        nivel=0;
        limpiarIn();
        $("#defaultid").val("{{$default_id}}");
        $("#defaultroot").val("{{$default_id}}");
        $("#form_register_currency-title b").html("{{strtoupper(trans($lang.'form.register.title'))}}");
        $("#btn_save").html("{{trans($lang.'form.register.btn_save')}}");
        $("#btn_save").removeClass("btn-primary");
        $("#btn_save").addClass("btn-success");
        $("#divUbication").html("");
        loadUbicationForm("{{$default_id}}");
    });
    document.getElementById("btn_save").addEventListener("click", function(){
        SaveUbication();
    })
    function ChangeUbication(id){
        DeleteUbicationSelects(id);
        $("#defaultroot").val($("#row-"+id).val());
        let hh=$("#row-"+id).val();
        if(hh==-1){
            
        }else{
            loadUbicationForm($("#row-"+id).val());
            $("#nameroot").val($("#row-"+id+" option:selected").text());
        }

    }
    function ChangeUbicationView(id){
        DeleteUbicationViews(id);
            if($("#"+id).val()==-1){
                LoadUbication("{{$default_id}}");
            }else{
                LoadUbicationView($("#"+id).val());
                LoadUbication($("#"+id).val());
            }
    }
    
    //variable de contar
    var nivel=0;
    var niveles=0;
    function loadUbicationForm(id_root)
    {
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-root-get')
                @slot('parameters'," 'root_ubication_id': id_root ")
                @slot('result_success')
                
                let query="";
                if(response[0].length>0){
                    nivel++;
                    query=query+'<div id="nivel-'+nivel+'" style="padding-bottom: 10px!important;padding-right: 0px;padding-left: 0px" class="col-md-12">';
                    query=query+'<label>Nivel-'+nivel+'</label>';
                    query=query+'<select id=row-'+nivel+' class="form-control col-md-12" onchange="ChangeUbication(\'' + nivel + '\')">';
                    query=query+'<option value="-1"> =--SELECCIONE--= </option>';
                        for(let item of response[0])
                        {
                            query=query+'<option value="'+item.id+'">'+item.name_localized+'</option>';
                        }
                    query=query+'</select></div>';
                    $("#divUbication").append(query);
                    $("#row-"+nivel).select2();
                }else{
                    
                }
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function DeleteUbicationSelects(id)
    {
        if(id==null)
        {
            nivel=0;
           
        }else{
            let level=$("#row-"+id).parent().closest('div').attr('id')
            level=parseInt(level.replace("nivel-",""));
            for(let i=level+1; i<=nivel; i++){
                $("#nivel-"+i).remove();
            }
            nivel=level;
        }
    }
    function DeleteUbicationViews(id)
    {
        if(id==null)
        {
            niveles=0;
            console.log("esta vacio");
        }else{
            let level=$("#"+id).parent().closest('div').attr('id');
            
            level=parseInt(level.replace("level-",""));
            
            for(let i=level+1; i<=niveles; i++){
                $("#level-"+i).remove();
            }
            niveles=level;
        }
    }
    function SaveUbication(){
        let idubication=$("#defaultid").val();
        let root=$("#defaultroot").val();
        let code=$("#code").val();
        let name=$("#name").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-register')
                @slot('parameters'," 'id': idubication, 'root_ubication_id': root, 'name': name, 'code': code")
                @slot('result_success')
                ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                $("#form_register_types").modal('hide');
                LoadUbication(root);
                /* setTimeout(Refrescar, 2000); */
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function LoadUbicationId(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-get')
                @slot('parameters', " 'ubication_id': id ")
                @slot('result_success')
                    $("#form_register_currency").modal("show");
                    nivel=0;
                    $("#divUbication").html("");
                    loadUbicationForm("{{$default_id}}");

                    //editar formularios
                    if(response.root_ubication_id==null){
                        $("#defaultroot").val("{{$default_id}}")
                    }else{
                        $("#defaultroot").val(response.root_ubication_id)
                    }
                    $("#form_register_currency-title").html("<b>{{trans($lang.'form.edit.title')}}<b>");
                    $("#btn_save").html("{{trans($lang.'form.register.btn_update')}}");
                    ubicationroot(response.root_ubication_id, $("#nameroot"));
                    //remover clases
                    $("#btn_save").removeClass("btn-success");
                    $("#btn_save").addClass("btn-primary");
                    $("#defaultid").val(response.id);
                    $("#code").val(response.code);
                    $("#inpValue_name").val(response.name_localized);
                    $("#name").val(response.name);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    
                @endslot
        @endcomponent
    }
    function ubicationroot(id, input){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-get')
                @slot('parameters', " 'ubication_id': id ")
                @slot('result_success')
                    
                    input.val(response.name_localized);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    
                @endslot
        @endcomponent
    }
    function LoadUbicationView(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-root-get')
                @slot('parameters'," 'root_ubication_id': id ")
                @slot('result_success')
                let query="";
                console.log(response);
                if(response[0].length>0){
                    niveles++;
                    query=query+'<div id="level-'+niveles+'" style="padding-bottom: 10px!important;padding-right: 0px;padding-left: 0px" class="col-md-12">';
                    query=query+'<label>Nivel-'+niveles+'</label>';
                    query=query+'<select id='+niveles+' class="form-control col-md-12" onchange="ChangeUbicationView(\'' + niveles + '\')">';
                    query=query+"<option value='-1'>--SELECCIONE--</option>";
                        for(let item of response[0])
                        {
                            query=query+'<option value="'+item.id+'">'+item.name_localized+'</option>';
                        }
                    query=query+'</select></div>';
                    $(query).insertBefore("#view");
                    $("#"+niveles).select2();
                }else{
                    
                }
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function LoadUbication(root_id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-root-get')
                @slot('parameters', " 'root_ubication_id': root_id")
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                    console.log(response);
                        $("#tablebody").html("");
                        /* console.log(response); */
                        for(let item of response[0]){
                        document.getElementById("tablebody").innerHTML += `<tr> 
                                                                            <td>${item.id}</td> 
                                                                            <td>${item.name_localized}</td> 
                                                                            <td>${item.code}</td>
                                                                            <td><div>
                                <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                    <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                    <a class='dropdown-item' href='#' onclick='LoadUbicationId(${item.id})'>{!! trans($lang.'result_table.options.edit') !!}</a>
                                    <a class='dropdown-item' href='#' onclick='modalshipping(${item.id})'>{!! trans($lang.'result_table.options.price') !!}</a>
                                    <a class='dropdown-item' href='#' onclick='DeleteUbication(${item.id}, ${item.root_ubication_id})'>{!! trans($lang.'result_table.options.delete') !!}</a>
                                </div>
                            </button>    
                        </div>
                        </td>
                        </tr>`;
                        }
                    $('#root_ubication').select2();
                    $('#tbResults').DataTable({
                        responsive:true,
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
                            }
                    }
                    });
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function DeleteUbication(iddata, root){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-delete')
                @slot('parameters'," 'id': iddata ")
                @slot('result_success')
                ShowSuccessMessage("{{trans($lang.'form.delete.msg_title_success')}}","{{trans($lang.'form.delete.msg_title_success')}}");
                if(root==null || root=="" || root == "null"){
                    root="{{$default_id}}";
                }
                LoadUbication(root);
                /* setTimeout(Refrescar, 2000); */
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function limpiarIn(){
        $("#code").val(null);
        $("#nameroot").val(null);
        $("#inpValue_name").val(null);
    }
    function modalshipping(id){
        $("#ubicaciones").html("")
        /* ubicationget(id); */
        loadShipingPrice(id);
        ubicationload(id);
        $("#defaultubication").val(id);
        $("#defaultshipping").val("{{$default_id}}");
        $("#form-shipping-price").modal("show");
    }
    function addPrices(idubication, idshipping, moneda, estatico, dias, precio){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ShippingPrice-Register')
                @slot('parameters'," 'id':idshipping, 'ubication_id':idubication, 'currency_id':moneda, 'price':precio, 'min_days':dias, 'is_static':estatico ")
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                    clearPrices();
                    loadShipingPrice(idubication);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function addPricesList(idubication, moneda, estatico, dias, precio){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','shipping-price-update')
                @slot('parameters',"  'ubication_id':idubication, 'currency_id':moneda, 'price':precio, 'min_days':dias, 'is_static':estatico ")
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                    loadShipingPrice(idubication)
                @endslot
                @slot('result_error')
                console.log(data);
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function clearPrices(){
        $("#defaultshipping").val("{{$default_id}}");
        $("#is_static").prop("checked", false);
        $("#min_days").val(null);
        $("#price").val(null);
        $("#idBtnSaveAll").prop("checked", false);
    }
    function loadpricesid(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ShippingPrice-Get')
                @slot('parameters'," 'shipping_price_id': id ")
                @slot('result_success')
                console.log(response);
                    $("#defaultubication").val(response.ubication_id);
                    $("#defaultshipping").val(response.id);
                    $("#currency_id_price").val(response.currency_id);
                    ChangeInputPrice('price', response.currency_id);
                    (response.is_static===0)? $("#is_static").prop("checked", false) : $("#is_static").prop("checked", true);
                    $("#min_days").val(response.min_days);
                    $("#price").val(response.price);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function loadShipingPrice(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ShippingPrice-Get')
                @slot('parameters'," 'ubication_id': id ")
                @slot('result_success')
                if ( $.fn.dataTable.isDataTable('#table-prices') ) {
                        let table = $('#table-prices').DataTable();
                        table.destroy();
                    }
                    $("#table-prices tbody").html("");
                    let query="";
                    for(let item of response){
                        query=query+`<tr>
                                        <td>${item.id}</td>
                                        <td>${item.currency_name}</td>
                                        <td>${item.currency_code}</td>
                                        <td>${item.price}</td>
                                        <td>
                                        <div>
                                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                <a class='dropdown-item' href='#' onclick='loadpricesid(${item.id})'>{!! trans($lang.'result_table_prices.col_options.edit') !!}</a>
                                                <a class='dropdown-item' href='#' onclick='deletePrices(${item.id})'>{!! trans($lang.'result_table_prices.col_options.delete') !!}</a>
                                            </div>
                                        </button>
                                    </div>
                                        </td>
                                    </tr>`;
                    }
                    $("#table-prices tbody").append(query);
                    $("#table-prices").DataTable({
                        responsive:true,
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
                            }
                    }
                    });
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function deletePrices(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ShippingPrice-Delete')
                @slot('parameters'," 'id': id ")
                @slot('result_success')
                    console.log(response);
                    ShowSuccessMessage("{{trans($lang.'form.delete.msg_title_success')}}","{{trans($lang.'form.delete.msg_description_success')}}");
                    loadShipingPrice($("#defaultubication").val());
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function isFather(value){
        if(value==null){
            return true;
        }else{
            return false;
        }
    }
    function getValues(obj)
    {
        var array=new Array();
        for(let i = 0 ; i<obj.length; i++){
            array[i]=$(obj[i]).val();
        }
        return array;
    }
    function ubicationload(id_root){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-root-get')
                @slot('parameters'," 'root_ubication_id': id_root ")
                @slot('result_success')
                /* console.log(response); */
                let query="";
                    query=query+`<option value="-1">Seleccione</option>`;
                    for(let item of response[0]){
                        query=query+`<option value="${item.id}">${item.name_localized}</option>`;
                    }
                    $("#ubicaciones").append(query);
                    $("#ubicaciones").select2();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
</script>
<!--scrits-->
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
@endsection