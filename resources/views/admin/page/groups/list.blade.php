<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.groups.list.lang');

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
    {{-- responsive --}}
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

                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12" style="text-align: right!important;">
                          
                          <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form-register-groups" id="btnopenform" >{!! trans($lang.'btn_register') !!}</button>
                         
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
                  <th scope="col">{!! trans($lang.'result_table.col_id') !!}</th>
                        <th scope="col">{!! trans($lang.'result_table.col_code_category') !!}</th>
                        <th scope="col">{!! trans($lang.'result_table.col_name_category') !!}</th>
                        <th scope="col">{!! trans($lang.'result_table.col_name') !!}</th>
                        <th scope="col">{!! trans($lang.'result_table.col_description') !!}</th>
                        <th scope="col">{!! trans($lang.'result_table.col_options') !!}</th>
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
@slot('modal_id', 'form-register-groups')
@slot('modal_title', strtoupper(trans($lang.'form.register.title')));
@slot('modal_class_02','-')
@slot('modal_class_04', 'bg-dark')
@slot('modal_body')
        <div class="form-group">
            <div class="row col-md-12" id="content">
                {{-- select para el tipo de grupo --}}
                <input type="text" name="defaultid" hidden id="defaultid">
                <input type="text" name="category_id" hidden id="category_id">
                <div id="category_root" class="col-md-12 row">

                </div>
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","category_padre",$lang.'form.register.lbl_category_father',true,"col-md-12","fas fa-envelope") !!}
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code_group',true,"col-md-12","fas fa-envelope") !!}
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name_group',true,"col-md-12","fas fa-envelope") !!}
                {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","description",$lang.'form.register.lbl_description_group',true,"col-md-12") !!}
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save" style="margin: 5px!important;" class="btn btn-success form-control">{!! trans($lang.'form.register.btn_save') !!}</button>
                    </div>
                </div>
@endslot
@endcomponent
<!--Modales-->

<!--scrits-->
<script>
    

    window.onload=function(){
        loadData("{{$default_id}}");
        loadDataSelect("{{$default_id}}");
        $("#category_padre").attr("readonly", "readonly");

        $("#btnopenform").on("click", function(){
            $("#category_root").html("");
            $("#defaultid").val("{{$default_id}}");
            loadCategoryForm("{{$default_id}}");
        });
    }
    document.getElementById("btn_save").addEventListener("click", function () {
        SaveData();
    });
    //selets de categoria en el formulario
    var nivel=0;
    function loadCategoryForm(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','category-root-get')
                @slot('parameters', " 'root_category_id':id ")
                @slot('result_success')
                let query="";
                    if(response.length>0){
                            nivel++;
                            query=query+'<div id="nivel-'+nivel+'" style="padding-bottom: 10px!important;padding-right: 0px;padding-left: 0px" class="col-md-12">';
                            query=query+'<label>NIVEL-'+nivel+'</label>';
                            query=query+'<select class="form-control" id=form-'+nivel+' onchange="changeSelectForm(\'' + nivel + '\')">';
                            query=query+'<option value="-1">-- Seleccione -- </option>';
                        for(let item of response){
                            query+=`<option value="${item.id}">${item.name_localized}</option>`;
                            }
                            query=query+'</select></div>';
                        $("#category_root").append(query);
                    }else{
                            
                    }
                        $("#form-"+nivel).select2();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }

    function changeSelectForm(id){
            deleteSelectForm(id);
            nivel=id;
            $("#category_id").val($("#form-"+id).val());
            //obtener texto
            $("#category_padre").val($("#form-"+id+" option:selected").text());
            let value=$("#form-"+id).val();
            if(value==-1){
            }else{
                loadCategoryForm(value);
            }
        }
        function deleteSelectForm(id){
            if(id==null){
                nivel=0;
            }else{
                let row=$("#form-"+id).parent().closest("div").attr("id");
                row=parseInt(row.replace("nivel-",""));
                for(let i=row+1; i<=nivel; i++){
                    $("#nivel-"+i).remove();
                }
            }
        }

    function SaveData(){
        let id=$("#defaultid").val();
        let category_id=$("#category_id").val();
        let code=$("#code").val();
        let name=$("#name").val();
        let description=$("#description").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductGroup-Register')
                @slot('parameters'," 'id': id, 'category_id': category_id, 'code': code, 'name':name, 'description':description " )
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                    $("#form-register-groups").modal('hide');
                    loadData(($("#category_id").val()=="")?"-1" : $("#category_id").val());
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    let level=0;
    //Categorias
    function loadDataSelect(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','category-root-get')
                @slot('parameters', " 'root_category_id':id ")
                @slot('result_success')
                let query="";
                    if(response.length>0){
                            level++;
                            query=query+'<div id="level-'+level+'" style="padding-bottom: 10px!important;padding-right: 0px;padding-left: 0px" class="col-md-12">';
                            query=query+'<label>NIVEL-'+level+'</label>';
                            query=query+'<select class="form-control" id='+level+' onchange="changeSelectView(\'' + level + '\')">';
                            query=query+'<option value="-1">-- Seleccione -- </option>';
                        for(let item of response){
                            query+=`<option value="${item.id}">${item.name_localized}</option>`;
                            }
                            query=query+'</select></div>';
                        $("#selects").append(query);
                        $("#"+level).select2();
                    }else{
                            
                    }
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function changeSelectView(id){
            deleteSelectView(id);
            level=id;
            /* loadData($("#"+id).val()); */
            let value=$("#"+id).val();
            if(value==-1){
            }else{
                loadData(value);
                loadDataSelect(value);
            }
        }
    function deleteSelectView(id){
            if(id==null){
                level=0;
            }else{
                let row=$("#"+id).parent().closest("div").attr("id");
                row=parseInt(row.replace("level-",""));
                for(let i=row+1; i<=level; i++){
                    $("#level-"+i).remove();
                }
            }
        }
    function loadData(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductGroup-Get')
                @slot('parameters', " 'category_id': id ")
                @slot('result_success');
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                    console.log(response);
                        let query="";
                        $("#tablebody").html("");
                        for(let item of response){
                        query=query+`<tr> 
                        <td>${item.id}</td> 
                        <td>${item.category_code}</td>
                        <td>${item.category_name}</td>`;
                        query=query+`<td>${item.name_localized}</td>`
                        if(item.description==null){
                            query=query+`<td> Sin descripcion ... </td>`;
                        }else{
                            query=query+`<td>${item.description}</td>`;
                        }
                        query=query+`<td><div>
                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                    <a class='dropdown-item' href='#' onclick='openProducts(${item.id})'>{!! trans($lang.'result_table.options.detail') !!}</a>
                                    <a class='dropdown-item' href='#' onclick='LoadDataId(${item.id})'>{!! trans($lang.'result_table.options.edit') !!}</a>
                                    <a class='dropdown-item' href='#' onclick='deletedata(${item.id}, ${item.category_id})'>{!! trans($lang.'result_table.options.delete') !!}</a>
                                </div>
                            </button>    
                        </div></td></tr>`;
                        }
                        $("#tablebody").append(query);
                   
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
                        emptyTable:     "Use el filtro de busqueda",
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
                @slot('ws_name','ProductGroup-Get')
                @slot('parameters', " 'product_group_id':id ")
                @slot('result_success')
                    console.log(response);
                    $("#category_root").html("");
                    nivel=0;
                    loadCategoryForm("{{$default_id}}");
                    $("#defaultid").val(response.id);
                    $("#category_id").val(response.category_id);
                    $("#code").val(response.code);
                    $("#name").val(response.name);
                    $("#description").val(response.description);
                    $("#inpValue_name").val(response.name_localized);
                    $("#category_padre").val(response.category_name);
                    $("#form-register-groups").modal("show")
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function deletedata(iddata, category){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductGroup-Delete')
                @slot('parameters'," 'id': iddata ")
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.delete.msg_title_success')}}","{{trans($lang.'form.delete.msg_title_success')}}");
                    $("#form-register-groups").modal("hide");
                    loadData(category);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function Refrescar(){
        location.reload();
    }

    //funcion especial para abrir una nueva ventana
    function openProducts(code){
        let url="{!! \App\Http\Common\Services\RouteService::GetAdminURL("products-list",["code"=>"route_parameter"]) !!}";
        window.open(url.replace("route_parameter",code));
    }
</script>
<!--scrits-->
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
@endsection