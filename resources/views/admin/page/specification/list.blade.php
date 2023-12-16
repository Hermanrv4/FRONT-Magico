<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.specification.list.lang');

$default_id = ParameterService::GetParameter("default_id");

/* $objAdmin = \App\Http\Modules\Admin\Helpers\AppHelper::GetAdminData();
$is_internal_user = $objAdmin["company_id"]==null; */
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
                            
                            <div id="view">
                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12" style="text-align: right!important;">
                          <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form-register-subs" id="btnopenform" >{!! trans($lang.'btn_register') !!}</button>
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
                    <th>{!! trans($lang.'result_table.col_code') !!}</th>
                    <th>{!! trans($lang.'result_table.col_name') !!}</th>
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
@slot('modal_title', '');
@slot('modal_class_02','-')
@slot('modal_class_04', 'bg-dark')
@slot('modal_body')
        <div class="form-group">
            <div class="row col-md-12" id="content">
                {{-- select para el tipo de grupo --}}
                <input type="text" name="defaultid" hidden id="defaultid">
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code',true,"col-md-12") !!}
                <div class="section-check d-flex row col-md-12 justify-content-around">
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","is_color",$lang.'form.register.lbl_color',true," my-auto mx-auto d-inline") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","is_html",$lang.'form.register.lbl_html',true," my-auto mx-auto d-inline") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","is_image",$lang.'form.register.lbl_image',true," my-auto mx-auto d-inline") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","is_preview",$lang.'form.register.is_preview',true,"my-auto mx-auto d-inline") !!}
                </div>
                <div class="row container">
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name',true,"col-md-12") !!}
                </div>
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save" style="margin: 5px!important;" class="btn btn-success form-control"> </button>
                    </div>
                </div>
@endslot
@endcomponent
<!--Modales-->

<!--scrits-->
<script>
    

    window.onload=function(){
        loadData("{{$default_id}}");

        $("#estatus-is_color").on("click", function(){
            if($("#estatus-is_color").prop("checked")){
                $("#estatus-is_html").attr("disabled", true);
                $("#estatus-is_image").attr("disabled", true);
                $("#estatus-is_preview").attr("disabled", true);
                
            }else{
                $("#estatus-is_html").attr("disabled", false);
                $("#estatus-is_image").attr("disabled", false);
                $("#estatus-is_preview").attr("disabled", false);
            }
        });

        $("#estatus-is_html").on("click", function(){
            if($("#estatus-is_html").prop("checked")){
                $("#estatus-is_color").attr("disabled", true);
                $("#estatus-is_image").attr("disabled", true);
                $("#estatus-is_preview").attr("disabled", true);

            }else{
                $("#estatus-is_color").attr("disabled", false);
                $("#estatus-is_image").attr("disabled", false);
                $("#estatus-is_preview").attr("disabled", false);
            }
        });

        $("#estatus-is_image").on("click", function(){
            if($("#estatus-is_image").prop("checked")){
                $("#estatus-is_color").attr("disabled", true);
                $("#estatus-is_html").attr("disabled", true);
                $("#estatus-is_preview").attr("disabled", true);

            }else{
                $("#estatus-is_color").attr("disabled", false);
                $("#estatus-is_html").attr("disabled", false);
                $("#estatus-is_preview").attr("disabled", false);
            }
        });

        $("#estatus-is_preview").on("click", function(){
            if($("#estatus-is_preview").prop("checked")){
                
                $("#estatus-is_color").attr("disabled", true);
                $("#estatus-is_image").attr("disabled", true);
                $("#estatus-is_html").attr("disabled", true);

            }else{
                $("#estatus-is_color").attr("disabled", false);
                $("#estatus-is_image").attr("disabled", false);
                $("#estatus-is_html").attr("disabled", false);
            }
        });
    }
    document.getElementById("btnopenform").addEventListener("click", function(){
        $("#defaultid").val("{{$default_id}}");
        $(".modal-title").html("{{ strtoupper(trans($lang.'form.register.title')) }}")
        $("#btn_save").html(" {!! trans($lang.'form.register.btn_save') !!} ")
        $("#code").val(null);
        $("#estatus-code").prop("checked", false);
        $("#estatus-is_color").prop("checked", false);
        $("#estatus-is_html").prop("checked", false);
        $("#estatus-is_image").prop("checked", false);
        $("#estatus-is_preview").prop("checked", false);
        $("#needs_user_info").val(null);
        $("#inpValue_name").val(null);
        $("#name").val(null);
    });
    document.getElementById("btn_save").addEventListener("click", function () {
        SaveData();
    });


    function SaveData(){
        let id=$("#defaultid").val();
        let name=$("#name").val();
        let code=$("#code").val();
        let color=($("#estatus-is_color").prop("checked")==true) ? 1: 0;
        let preview=($("#estatus-is_preview").prop("checked")==true) ? 1 : 0;
        let html=($("#estatus-is_html").prop("checked")==true) ? 1 : 0;
        let image=($("#estatus-is_image").prop("checked")==true) ? 1 : 0;
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Specification-Register')
                @slot('parameters'," 'id': id, 'code': code, 'name': name, 'is_preview':preview, 'is_color': color, 'is_html': html, 'is_image': image, 'is_global_filter': 0, 'needs_user_info':0 " )
                @slot('result_success')
                ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                $("#form-register-subs").modal('hide');
                loadData();
                /* setTimeout(Refrescar, 2000); */
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function loadData(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Specification-Get')
                @slot('parameters', "  ")
                @slot('result_success');
                
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                        let query="";
                        $("#tablebody").html("");
                        for(let item of response){
                        query=query+`<tr> 
                        <td>${item.id}</td> 
                        <td>${item.code}</td> <td>${item.name_localized}</td>`;
                        query=query+`<td><div>
                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                <a class='dropdown-item' href='#' onclick='LoadDataId(${item.id})'>{!! trans($lang.'result_table.options.edit') !!}</a>
                                <a class='dropdown-item' href='#' onclick='deletedata(${item.id})'>{!! trans($lang.'result_table.options.delete') !!}</a>
                                </div>
                            </button>    
                        </div></td></tr>`;
                        }
                        $("#tablebody").append(query);
                    $('#root_ubication').select2();
                    $('#tbResults').DataTable({
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
    function LoadDataId(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Specification-Get')
                @slot('parameters', " 'specification_id':id ")
                @slot('result_success')
                    
                    $("#form-register-subs-title").html("{{trans($lang.'form.edit.title')}}")
                    $("#btn_save").html("{{trans($lang.'form.edit.btn')}}");
                    //
                    console.log(response);
                    if(response.is_preview==1){
                        $("#estatus-is_preview").prop("checked", true);
                        $("#status-is_preview").trigger("click");
                    }else if(response.is_image==1){
                        $("#estatus-is_image").prop("checked", true);
                        $("#estatus-is_preview").trigger("click");
                    }else if(response.is_color==1){
                        $("#estatus-is_color").prop("checked", true);
                        $("#estatus-is_preview").trigger("click");
                    }else if(response.is_html==1){
                        $("#estatus-is_html").prop("checked", true);
                        $("#estatus-is_html").trigger("click");
                    }

                    $("#defaultid").val(response.id);
                    $("#inpValue_name").val(response.name_localized);
                    $("#name").val(response.name);
                    $("#code").val(response.code);
                    $("#is_color").val(response.is_color);
                    $("#is_preview").val(response.is_preview);
                    $("#is_html").val(response.is_html);
                    $("#is_image").val(response.is_image);
                    $("#needs_user_info").val(response.needs_user_info);                    
                    $("#form-register-subs").modal("show")
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function deletedata(iddata){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Specification-Delete')
                @slot('parameters'," 'id': iddata ")
                @slot('result_success')
                ShowSuccessMessage("{{trans($lang.'form.delete.msg_title_success')}}","{{trans($lang.'form.delete.msg_title_success')}}");
                loadData();
                @endslot
                @slot('result_error')
                
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function Refrescar(){
        location.reload();
    }
</script>
<!--scrits-->
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
@endsection