<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.products.list.lang');

$default_id = ParameterService::GetParameter("default_id");
$code = isset($code)?$code:null;
$format_image=ApiService::Request(config('env.app_group_admin'), 'entity','parameter-get-codes',array('code'=>'available-image-formats'))->response;
$fomart_image=json_decode($format_image);
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
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/fileupload/css/jquery.fileupload.css")}}">
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/fileupload/css/jquery.fileupload-ui.css")}}">
    <noscript><link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/fileupload/css/jquery.fileupload-ui-noscript.css")}}"/></noscript>
    <noscript><link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/fileupload/css/jquery.fileupload-noscript.css")}}"/></noscript>
    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <style>
        .class-remove{
            display: none;
        }
    </style>
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
                      {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","productGroup",$lang.'form.filters.lbl_products',true,"col-md-12","fas fa-envelope") !!}
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12 container" style="text-align: right!important;">
                        <button class="btn btn-primary col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form-register-subs" id="btnopenform" >
                            {!! trans($lang.'btn_register') !!}
                        </button>
                        <button class="btn btn-success col-md-2" style="margin: 5px!important;" type="button" id="btnExportExcel">
                            <i class="fa fa-file-excel" aria-hidden="true"></i>
                            Exportar Plantilla de carga
                        </button>
                        <button class="btn btn-danger col-md-2" type="button" style="margin: 5px!important;" id="btnImportExcel">
                            <i class="fa fa-upload" aria-hidden="true"></i>
                            Importar Productos
                        </button>
                        <button class="btn btn-warning col-md-2" style="margin: 5px!important;" type="button" id="btnUploadPhotos" onclick="SopImageMassive()">
                            <i class="far fa-images" aria-hidden="true"></i>
                            Carga de Fotos Masiva
                        </button>
                        <button id="btn-validate-info" style="margin: 5px!important;" class="btn btn-secondary col-md-2" type="button">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Validar informacion
                        </button>
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
                    <th>{!! trans($lang.'result_table.col_name') !!}</th>
                    <th class="text-center">{!! trans($lang.'result_table.col_status') !!}</th>
                    <th>{!! trans($lang.'result_table.col_group') !!}</th>
                    <th>{!! trans($lang.'result_table.col_sku') !!}</th>
                    <th>{!! trans($lang.'result_table.col_stock') !!}</th>
                    <th>{!! trans($lang.'result_table.col_shipping') !!}</th>
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
@component(config($group.'.ui.component.engine.modal.view'))
    @slot('modal_id', 'excel-import')
    @slot('modal_title', strtoupper(trans($lang.'form.register.title')));
    @slot('modal_class_02','modal-xl')
    @slot('modal_class_04', 'bg-dark')
    @slot('modal_body')
            <form method="post" id="form-template" hidden enctype="multipart/form-data">
                @csrf
                <input type="file" name="FileExcel" id="file-excel">
            </form>
            <ul class="nav nav-tabs" id="myTab" role="tablist">

            </ul>
            <div class="tab-content" id="myTabContent">
            
            </div>
    @endslot
@endcomponent
<!--Modales-->
@component(config($group.'.ui.component.engine.modal.view'))
    @slot('modal_id', 'form-register-subs')
    @slot('modal_title', strtoupper(trans($lang.'form.register.title')));
    @slot('modal_class_02','-')
    @slot('modal_class_04', 'bg-dark')
    @slot('modal_body')
            <div class="form-group">
                <div class="row col-md-12" id="content">
                    {{-- select para el tipo de grupo --}}
                    <input type="text" name="defaultid" hidden id="defaultid">
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","groupProduct",$lang.'form.register.lbl_product_Group',true,"col-md-12","fas fa-envelope") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","sku",$lang.'form.register.lbl_product_sku',true,"col-md-12") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","urlcode",$lang.'form.register.lbl_url_code',true,"col-md-12","fas fa-envelope") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name_product',true,"col-md-12", "fas fa-envelope") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","description",$lang.'form.register.lbl_description_product',true,"col-md-12","fas fa-envelope") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","stock",$lang.'form.register.lbl_product_stock',true,"col-md-12","fas fa-envelope") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","iscatalogo",$lang.'form.register.lbl_catalogo_product',true,"col-md-12","fas fa-envelope") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","shippingsize",$lang.'form.register.lbl_shipping_product',true,"col-md-12 mb-2","fas fa-envelope") !!}
                    <div class="row mb-2">
                        <div class="custom-control custom-switch col-md-12 ml-4 my-auto">
                            <input type="checkbox" class="custom-control-input" id="estatus">
                            <label class="custom-control-label" for="estatus">Estado del producto</label>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                    <button id="btn_save" style="margin: 5px!important;" class="btn btn-success form-control">{!! trans($lang.'form.register.btn_save') !!}</button>
                </div>
            </div>
    @endslot
@endcomponent
{{-- ---- --}}
{{--Modales--}}
@component(config($group.'.ui.component.engine.modal.view'))
    @slot('modal_id', 'Soport-Image')
    @slot('modal_title', strtoupper(trans($lang.'form.image.title')));
    @slot('modal_class_02','-')
    @slot('modal_class_04', 'bg-dark')
    @slot('modal_body')
            <div class="form-group">
                <div class="row col-md-12" id="content">
                    <br>
                    <div class="row col-md-12 ">
                        <form id="form-img" method="POST" class="col-sm-12" enctype="multipart/form-data">
                            @csrf
                            <button type="button" id="loadImage" class="btn btn-success">Agregar Imagenes</button>
                            {{-- <button id="id-upload" class="btn btn-primary">Guardar Cambios</button> --}}
                            <button id="btn-cancer-form" type="button" class="btn btn-danger">Cancelar</button>
                            <div id="preview-image">

                            </div>
                            <div id="section-deletes">
                        
                            </div>
                            <input type="file" id="id-images-prod" hidden name="Multiple_imagenes[]" multiple>
                        </form>
                        <input type="text" id="text-imagen" class="form-control">
                    </div>
                </div>
            </div>
                    <div class="row">
                        <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                            <button id="btn-save-image" style="margin: 5px!important;" class="btn btn-success form-control">Guardar Imagenes</button>
                        </div>
                    </div>
    @endslot
@endcomponent
{{--Carga de Fotos Masiva--}}
@component(config($group.'.ui.component.engine.modal.view'))
    @slot('modal_id', 'modal_upload_massive_image')
    @slot('modal_title', strtoupper(trans($lang.'form.image.title')));
    @slot('modal_class_02','-')
    @slot('modal_class_04', 'bg-dark')
    @slot('modal_body')
            <div class="form-group">
                <div class="row col-md-12" id="content">
                    <br>
                    <div class="row col-md-12 ">
                        <form id="form-img_massive" method="POST" class="col-sm-12" enctype="multipart/form-data">
                            @csrf
                            <button id="loadImage_massive" class="btn btn-success">Agregar Imagenes</button>
                            <button id="donwload-text" disabled type="button" class="btn btn-warning">
                                <i class="fa fa-file" aria-hidden="true"></i>
                                Descargar TXT
                            </button>
                            <button id="donwload-image-excel" disabled type="button" class="btn btn-secondary">
                                <i class="fa fa-file-excel" aria-hidden="true"></i>
                                Descargar Excel</button>                            
                            <div id="preview-image_massive" class="">
                                
                            </div>
                            <div id="section-deletes_massive">
                                
                            </div>
                            <input type="file" hidden id="Multiple_imagenes" name="Multiple_imagenes[]" multiple>
                            <input type="text" id="text-imagen_massive" class="form-control">
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" style="text-align: right!important;">
                    <button type="button" id="id-upload_massive" form="form-img_massive" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
    @endslot
@endcomponent

@component(config($group.'.ui.component.engine.modal.view'))
    @slot('modal_id', 'form-specification')
    @slot('modal_title', '');
    @slot('modal_class_02','modal-lg')
    @slot('modal_class_04', 'bg-dark')
    @slot('modal_body')
        <div class="content">
        <div class="container-fluid">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title" id="title-header">{!! trans($lang.'lbl_create') !!}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div id="form" class="container my-auto">
                                        <input type="text" hidden name="specification_id" id="specification_id">
                                        <input type="text" hidden name="product_id" id="product_id">
                                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","specification",$lang.'form.register.lbl_product_sku',true,"col-md-12") !!}
                                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","value",$lang.'form.register.lbl_value_specification',true,"col-md-12") !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <div class="container">
                                    <button class="btn btn-dark col-md-2" id="btnload" style="margin: 5px!important;">{!! trans($lang.'btn_clean_up') !!}</button>
                                    <button id="btnsavespecification" class="btn btn-success col-md-2" style="margin: 5px!important;">{!! trans($lang.'btn_register') !!}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">{!! trans($lang.'lbl_results_header') !!}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="result-specification" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                                <tr>
                                    <th>{!! trans($lang.'result_specification.col_id') !!}</th>
                                    <th>{!! trans($lang.'result_specification.col_name') !!}</th>
                                    <th>{!! trans($lang.'result_specification.col_value') !!}</th>
                                    <th>{!! trans($lang.'result_specification.col_options.title') !!}</th>
                                </tr>
                        </thead>
                        <tbody id="tablebody"></tbody>
                    </table>
                </div>
                <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
            </div>
        </div>
        </div>
    @endslot
@endcomponent
<!--Modales-->
{{-- ---- --}}
@component(config($group.'.ui.component.engine.modal.view'))
    @slot('modal_id', 'form-price')
    @slot('modal_title', '');
    @slot('modal_class_02','modal-lg')
    @slot('modal_class_04', 'bg-dark')
    @slot('modal_body')
        <div class="content">
        <div class="container-fluid">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title" id="title-header">{!! trans($lang.'lbl_create_price') !!}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div id="form" class="container my-auto">
                                        <input type="text" hidden name="price_id" id="price_id">
                                        <input type="text" hidden name="product_id_price" id="product_id_price">
                                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","currency",$lang.'form.register.lbl_value_specification',true,"col-md-12") !!}
                                        <div class="row">
                                            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","price_regular",$lang.'form.register.lbl_price_regular',true,"col-md-6") !!}
                                            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","price_online",$lang.'form.register.lbl_price_online',true,"col-md-6") !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <div class="container">
                                    <button class="btn btn-dark col-md-2" id="btnclearPrice" style="margin: 5px!important;">{!! trans($lang.'btn_clean_up') !!}</button>
                                    <button id="btnSavePriceProd" class="btn btn-success col-md-2" style="margin: 5px!important;">{!! trans($lang.'btn_register') !!}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">{!! trans($lang.'lbl_results_header') !!}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="result-price-prod" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                                <tr>
                                    <th>{!! trans($lang.'result-price-prod.col_id') !!}</th>
                                    <th>{!! trans($lang.'result-price-prod.col_currency_name') !!}</th>
                                    <th>{!! trans($lang.'result-price-prod.col_regular_price') !!}</th>
                                    <th>{!! trans($lang.'result-price-prod.col_online_price') !!}</th>
                                    <th>{!! trans($lang.'result-price-prod.options.title') !!}</th>
                                </tr>
                        </thead>
                        <tbody id="tablebody"></tbody>
                    </table>
                </div>
                <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
            </div>
        </div>
        </div>
    @endslot
@endcomponent
<!--Modales-->

{{--Modal para la carga de datos--}}
@component(config($group.'.ui.component.engine.modal.view'))
    @slot('modal_id', 'Load_data_info')
    @slot('modal_title', "Datos Pre-Guardados-Excel" );
    @slot('modal_class_02','modal-lg')
    @slot('modal_class_04', 'bg-dark')
    @slot('modal_body')

    <div class="content">
        <div class="container-fluid">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Datos Pre-Guardados-Excel</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row d-flex justify-content-around">
                                <button type="button" id="btn-validation-data" class="btn btn-success col-md-3 my-2">Validar Datos</button>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <div class="container">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
                <div class="content">
                    <div class="container-fluid">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">Datos Pre-Guardados-Excel</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: right!important;">
                                        <div class="container">
                                            <div>
                                                <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                      <a class="nav-link active" id="Productos-tab" data-toggle="tab" href="#Productos-view" role="tab" aria-controls="Productos" aria-selected="true">Productos</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                      <a class="nav-link" id="categoria-tab" data-toggle="tab" href="#categoria" role="tab" aria-controls="profile" aria-selected="false">Categoria</a>
                                                    </li>
                                                  </ul>
                                                  <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active py-2" id="Productos-view" role="tabpanel" aria-labelledby="Productos-tab">
                                                        <table id="table-products-tab" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Categoria</th>
                                                                    <th>Codigo de grupo</th>
                                                                    <th>Grupo de productos</th>
                                                                    <th>Productos</th>
                                                                    <th>Descripcion</th>
                                                                    <th>Precio online</th>
                                                                    <th>Precio Regular</th>
                                                                    <th>sku</th>
                                                                    <th>Fotos</th>
                                                                    <th>Especificaiones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="categoria" role="tabpanel" aria-labelledby="categoria-tab">
                                                        <table id="table-categories-tab" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>CODE</th>
                                                                    <th>ROOT CODE</th>
                                                                    <th>NAME</th>
                                                                    <th>URL CODE</th>
                                                                    <th>BANNER</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                  </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
    @endslot
@endcomponent

@component(config($group.'.ui.component.engine.modal.view'))
    @slot('modal_id', 'form-preview-image')
    @slot('modal_title', '');
    @slot('modal_class_02','modal-lg')
    @slot('modal_class_04', 'bg-dark')
    @slot('modal_body')
        <div class="content-image">

        </div>
        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-danger" type="button" id="btn-exit-form-preview">Salir</button>
            </div>
        </div>
    @endslot
@endcomponent
<!--scrits-->
<script>
    var format_array=formatArrayString("{{$format_image}}");
    window.onload=function(){
        console.log(new Date().getMinutes());
            loadProductGroup();
            let code=parseInt("{{$code}}");
        $("#btn-exit-form-preview").on("click", function(e){
            $("#form-preview-image").modal("hide");
        });
        $("#btn-validate-info").on('click', function(e){
            $("#Load_data_info").modal("show");
            loadDataLdProducts();
            loadDataCategories();
            e.preventDefault();
        });
        $("#btn-validation-data").on("click", function(){
            sendStoreProcedure();
        });
        $('.checbox_status').on('change',function(e){
            valueCheck();
        });
        $("#btnImportExcel").on("click", function(){
            $("#file-excel").click();
        });
        $("#file-excel").on("change", function(){
            readTemplate();
        });
        if(code>0){
            GroupId(code);
        }else{
            loadData("{{$default_id}}");
        }
        $("#id-upload_massive").on("click", function(e){
            loadRenameMassive();
            saveText($("#text-imagen_massive").val());
            DonwloadImageExcel();
            /* setTimeout(Refrescar, 3000); */
            e.preventDefault();
        });
        $("#btn-save-image").on("click", function(e){
            e.preventDefault();
            SaveData();
        });
        $("#loadImage").on("click", function(e){
            e.preventDefault();
            $("#id-images-prod").click();
        });
        $("#id-images-prod").on("change", function(){
            let imagen=document.getElementById("id-images-prod").files;
            for(let item = 0; item<imagen.length; item++){
                console.log(imagen[item]);
                AppendPreview($("#preview-image"), previewImage(imagen[item]), renamevalidateMassive(imagen[item]), null, null, imagen[item].name)
            }
            loadRename();
            uploadMassiveImage('form-img', "sop-image");
        });
        $("#loadImage_massive").on("click", function(e){
            e.preventDefault();
            $("#status-change_massive").val("false");
            $("#Multiple_imagenes").click();
        })
        $("#productGroup").change(function () { 
            if($("#productGroup").val()==-1){
                loadData();
            }else{
                GroupId($("#productGroup").val());
            }
        });
        $("#btnsavespecification").on("click", function(){
            saveSpecification();
        });
        $("#btnload").on("click", function(){
            limpiarSpecification();
        });
        $("#btnSavePriceProd").on("click", function(){
            savePriceProd();
        });
        $("#btnclearPrice").on("click", function(){
            clearPrice();
        });
        $("#btnExportExcel").on("click", function(){
            getTemplate();
        });
        $("#donwload-text").on("click", function(){
            saveText($("#text-imagen_massive").val());
        });
        $("#donwload-image-excel").on("click", function(){
            DonwloadImageExcel();
        });
        $("#btnUploadPhotos").on("click", function () {
            $("#donwload-text").attr("disabled", true);
            $("#donwload-image-excel").attr("disabled", true);
        });
        $("#Multiple_imagenes").on("change", function(){
            AddMassiveImage();
            loadRenameMassive();
            uploadMassiveImage('form-img_massive');
            $("#donwload-text").attr("disabled", false);
            $("#donwload-image-excel").attr("disabled", false);
        });
    }
    document.getElementById("btnopenform").addEventListener("click", function(){
        $("#defaultid").val("{{$default_id}}");
        $("#form-register-subs-title").html("{{trans($lang.'form.register.title')}}")
        $("#btn_save").html("{{trans($lang.'form.register.btn_save')}}");
        $("#groupProduct").html("");
        $("#sku").val(null);
        $("#shippingsize").val(null);
        $("#inpValue_urlcode").val(null);
        $("#inpValue_name").val(null);
        $("#inpValue_description").val(null);
        $("#stock").val(null);
        $("#iscatalogo").val(null);
        $("#estatus").attr("checked", false);
        ProductGroup();
    });
    document.getElementById("btn_save").addEventListener("click", function () {
        SaveData();
    });
    function valueCheck(){
        $('.checbox_status').val(1)
    }
    function AddMassiveImage(){
        let array=document.getElementById("Multiple_imagenes").files; 
        for(let i = 0 ; i<array.length; i++){
            AppendPreview($("#preview-image_massive"), previewImage(array[i]), renamevalidateMassive(array[i]), 'uploadMassive', 'removeCardMassive', array[i].name);
        }
    }
    var cont=0;
    function AppendPreview(contenedor, src=null, text=null,typeUpload=null,typeRemove=null, text_old=null){
        let input_old_name=`<div class="content-name-old"><label>Nombre Original</label>
                                <input type="text" name="file-first-name[]" readonly="readonly" value="${text_old}" class="form-control my-2">
                            </div>`;
        cont++;
        let image="";
        image=`<div class="my-2 row d-flex no-gutters border rounded" id="card-${cont}">
                    <div class="col-sm-4 text-center">
                        <img src="${(src==null) ? '' : src }" id="img-${cont}" class="my-2 mx-1 img-thumbnail img-fluid">
                        <input hidden type="file" class="my-auto" name="file-img[]" id="file-${cont}">
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group my-2 mx-auto text-center container">
                            ${text_old==null ? '': input_old_name}
                            <div class="form-group">
                                <label>Nombre nuevo en el server</label>
                                <input type="text" readonly="readonly" value="${(text==null) ? '' : text }" class="form-control" name="rename[]" id="text-img-${cont}">
                            </div>
                            <button type="button" onclick="${(typeUpload==null) ? 'upload' : typeUpload }(${cont})" id="btn-add-${cont}" class="btn btn-primary">
                                <i class="fa fa-spinner" aria-hidden="true"></i>
                            </button>
                            <button type="button" onclick="${(typeRemove==null) ? 'removeCard' : typeRemove }(${cont})" class="btn btn-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                <div>`;
        contenedor.append(image);
    }
    var arrayname=new Array();
    function upload(id){
            $("#file-"+id).click();
            $("#file-"+id).on("change", function(){
                loadImage(id);
                loadRename();
            })
    }
    function loadImage(ide){
        let img=document.getElementById("file-"+ide).files;
        let status_image=true;
        for(let i = 0; i<img.length; i++){
            renamevalidate(document.getElementById("file-"+ide), $("#text-img-"+ide), null);
            $("#img-"+ide).attr("src", previewImage(img[i]));
        }
    }
    function loadRename(){
        //obtener a los hijos
        arrayname=new Array();
        let cards=$("#preview-image").children();
        for(let aa=0; aa<cards.length; aa++){
            if($("#card-"+(aa+1)).hasClass("class-remove")){
                console.log("tiene esa clase");
            }else{
                arrayname.push($("#preview-image #text-img-"+(aa+1)).val())
            }
        }
        $("#text-imagen").val(JSON.stringify(arrayname));
    }
    function uploadMassive(id){
        $("#file-"+id).click();
        $("#file-"+id).on("change", function(){
            let img_type=document.getElementById("file-"+id).files;
            img_type=img_type[0].type;
            let type=validateFormatImage(img_type, format_array);
            if (type==true) {
                loadRenameMassive(id);
                console.log("Formato valido");
            }else{
                ShowErrorMessage("Error", "Formato de imagen invalido");
            }
        })
    }
    var arraynamemassive=new Array();
    function loadRenameMassive(){
        //obtener a los hijos
        arraynamemassive=new Array();
        let cards=$("#preview-image_massive").children();
        for(let aa=1; aa<=cards.length; aa++){
            if($("#card-"+(aa)).hasClass("class-remove")){
                console.log("tiene esa clase");
            }else{
                arraynamemassive.push($("#preview-image_massive #text-img-"+(aa)).val());
            }
        }
        $("#text-imagen_massive").val(JSON.stringify(arraynamemassive));
    }
    function removeCard(id){
        let input="";
        let val=$("#text-img-"+id).val();
        input=`<input type="text" name="text-delete[]" hidden value="${val}">`;
        $("#status-change").val("false");
        $("#card-"+id).removeClass("d-flex");
        $("#card-"+id).addClass("class-remove");
        $("#section-deletes").append(input);
        deleteImage($(`#text-img-${id}`).val());
        $("#card-"+id+" #text-img-"+id).remove();
        loadRename();
        /* loadRenameMassive(); */
    }
    function removeCardMassive(id){
        let input="";
        let val=$("#text-img-"+id).val();
        input=`<input type="text" name="text-delete[]" hidden value="${val}">`;
        $("#status-change_massive").val("false");
        $("#card-"+id).removeClass("d-flex");
        $("#card-"+id).addClass("class-remove");
        $("#section-deletes_massive").append(input);
        //METODO AJAX PARA ELIMINAR
        deleteImage($(`#text-img-${id}`).val());
        $("#card-"+id+" #text-img-"+id).remove();
        loadRenameMassive();
        /* $("#card-"+id).remove(); */
    }
    function deleteImage(name){
        /* console.log(name); */
        /* let formulario=new FormData(document.getElementById("form-template")); */
        @component(config($group.'.ui.component.engine.ajax-internal.view'))
                @slot('app_group',$group)
                @slot('route','delete-image-product')
                @slot('parameters', " 'name_file': name ")
                @slot('result_success')
                    ShowSuccessMessage(null, response);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function uploadMassiveImage(form, option="massive"){
        let formulario=new FormData(document.getElementById(`${form}`));
        console.log(formulario);
        @component(config($group.'.ui.component.engine.ajax-internal_formdata.view'))
                @slot('app_group',$group)
                @slot('route','upload-image-massive')
                @slot('parameters', " formulario ")
                @slot('result_success')
                    if(option=="massive"){
                        ShowSuccessMessage("Imagen Guardada", "Se guardo la imagen satisfactoriamente");
                    }else{
                        ShowSuccessMessage("Imagen Guardada", "Imagen Cargada con exito, procedermos a guardar los cambios");
                        SaveData();
                        setTimeout(Refrescar, 3000);
                    }
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function previewImage(files){
        let urlpreview= URL.createObjectURL(files);
        return urlpreview;
    }
    function changeImageUrl(list){
        let card=$("#preview-image").children();
        for(let b=0; b<card.length; b++){
            $("#preview-image #img-"+(b+1)).attr("src", list[b]);
        }
    }
    //funcion para obtener el ajax
    function descargarArchivo(contenidoEnBlob, nombreArchivo) {
        var reader = new FileReader();
        reader.onload = function (event) {
            var save = document.createElement('a');
            save.href = event.target.result;
            save.target = '_blank';
            save.download = nombreArchivo || 'archivo.dat';
            var clicEvent = new MouseEvent('click', {
            'view': window,
            'bubbles': true,
            'cancelable': true
            });
            save.dispatchEvent(clicEvent);
            (window.URL || window.webkitURL).revokeObjectURL(save.href);
        };
        reader.readAsDataURL(contenidoEnBlob);
    };

    function saveText(listname=null){
        let i=0;
        let list=new Array();
        let names=JSON.parse(listname);
        for(let item of names){
            i++;
            list.push(`IMAGEN-${i} : ${item} \n`);
        }
        var blob = new Blob(list, {type: "text/plain;charset=utf-8"});
        descargarArchivo(blob, "nameProductos.txt");
    }
    function SaveData(){
        let id=$("#defaultid").val();
        let select=$("#groupProduct").val();
        let sku=$("#sku").val();
        let urlcode=$("#urlcode").val();
        let name=$("#name").val();
        let description=$("#description").val();
        let stock=$("#stock").val();
        let iscatalogo=$("#iscatalogo").val();
        let shippingsize=$("#shippingsize").val();
        let estado;
        let photos=$("#text-imagen").val();
        if($("#estatus").prop("checked")){
            estado=1;
        }else{
            estado=0;
        }
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Product-Register')
                @slot('parameters'," 'id': id, 'product_group_id': select, 'sku': sku, 'url_code':urlcode, 'name':name, 'description':description, 'is_for_catalogue':iscatalogo, 'is_active':estado, 'stock':stock, 'shipping_size':shippingsize, 'photos': photos " )
                @slot('result_success')
                ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                $("#form-register-subs").modal('hide');
                GroupId(select);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    let check=0;
    function GroupId(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Product-Get')
                @slot('parameters', " 'product_group_id':id ")
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                    let query="";
                    $("#tablebody").html("");
                    for(let item of response){
                        check++;
                        query=query+`<tr> 
                                    <td>${item.id}</td> 
                                    <td>${item.name_localized}</td>`;
                                        query=query+`<td>
                                                            <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input checbox_status" onchange="valueCheck()" id="estatus-${check}" checked="checked">
                                                            <label class="custom-control-label" for="estatus-${check}"></label>
                                                            </div>
                                                        </td>`; 
                        query=query+`<td>${item.product_group_name}</td> <td>${item.sku}</td> <td>${item.stock}</td> <td>${parseFloat(item.shipping_size).toFixed(2)}</td>`;
                        query=query+`<td><div>
                                <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                    <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                    <a class='dropdown-item' href='#' onclick='LoadDataId(${item.id}, "show")'>{!! trans($lang.'result_table.options.edit') !!}</a>
                                    <a class='dropdown-item' href='#' onclick='statusChange(${item.id}, ${item.product_group_id})'>{!! trans($lang.'result_table.options.to_disable') !!}</a>
                                    <a class='dropdown-item' href='#' onclick='load(${item.id})'>{!! trans($lang.'result_table.options.show-specification') !!}</a>
                                    <a class='dropdown-item' href='#' onclick='loadPrices(${item.id})'>{!! trans($lang.'result_table.options.show-price') !!}</a>
                                    <a class='dropdown-item' href='#' onclick='SopImage(${item.id}, "hide")'>{!! trans($lang.'result_table.options.sop-imagen') !!}</a>
                                    </div>
                                </button>    
                            </div></td></tr>`;
                    }
                    $("#tablebody").append(query);
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
    function SopImage(id){
        $("#Soport-Image").modal("show");
        $("#btn_save").html("Guardar Imagenes");
        LoadDataId(id, "hidden");
    }
    function SopImageMassive(){
        $("#preview-image_massive").html("");
        $("#section-deletes_massive").html("");
        $("#text-imagen_massive").val(null);
        $("#modal_upload_massive_image").modal("show");
        cont=0;
    }
    var val=0;
    function loadData(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Product-Get')
                @slot('parameters', "  ")
                @slot('result_success');
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                        let query="";
                        $("#tablebody").html("");
                        for(let item of response){
                            val++;
                        query=query+`<tr> 
                        <td>${item.id}</td> 
                        <td>${item.name_localized}</td>
                        <td class="text-center">
                            <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input checbox_status" checked="checked">
                            <label class="custom-control-label" for="estatus-${val}"></label>
                            </div>
                        </td>`; 
                        
                        query=query+`<td>${item.product_group_name}</td> <td>${item.sku}</td> <td>${item.stock}</td> <td>${parseFloat(item.shipping_size).toFixed(2)}</td>`;
                        query=query+`<td><div>
                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                <a class='dropdown-item' href='#' onclick='LoadDataId(${item.id}, "show")'>{!! trans($lang.'result_table.options.edit') !!}</a>
                                <a class='dropdown-item' href='#' onclick='statusChange(${item.id}, ${item.product_group_id})'>{!! trans($lang.'result_table.options.to_disable') !!}</a>
                                <a class='dropdown-item' href='#' onclick='load(${item.id})'>{!! trans($lang.'result_table.options.show-specification') !!}</a>
                                <a class='dropdown-item' href='#' onclick='loadPrices(${item.id})'>{!! trans($lang.'result_table.options.show-price') !!}</a>
                                <a class='dropdown-item' href='#' onclick='SopImage(${item.id}), "hide"'>{!! trans($lang.'result_table.options.sop-imagen') !!}</a>
                                </div>
                            </button>    
                        </div></td></tr>`;
                        }
                        $("#tablebody").append(query);
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
    function ShowProduct(id){
        LoadDataId(id);
        $("#btn_save").attr("disabled", true);
        $("#form-register-subs-title").html("{{trans($lang.'form.show.title')}}");
        readonly(true);
    }
    function readonly(estatus) {
        if(estatus==true || estatus==false){
            $("#groupProduct").attr("readonly", estatus);
            $("#sku").attr("readonly", estatus);
            $("#inpValue_urlcode").attr("readonly",estatus);
            $("#shippingsize").attr("readonly", estatus);
            $("#inpValue_name").attr("readonly", estatus);
            $("#inpValue_description").attr("readonly", estatus);
            $("#estatus").attr("readonly", estatus);
            $("#stock").attr("readonly", estatus);
            $("#iscatalogo").attr("readonly", estatus);
        }
    }
    function LoadDataId(id, param){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Product-Get')
                @slot('parameters', " 'product_id':id ")
                @slot('result_success')
                    $("#form-register-subs-title").html("{{trans($lang.'form.edit.title')}}");
                    $("#btn_save").attr("disabled", false);
                    $("#btn_save").html("{{trans($lang.'form.edit.btn')}}");
                    $("#groupProduct").html("");
                    readonly(false);
                    let group=response.product_group_id;
                    let listImg=JSON.parse(response.photos);
                    $("#preview-image").html("");
                    cont=0;
                        for(let i=0 ;i<listImg.length; i++){
                            AppendPreview($("#preview-image"), "{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/loaded/img/products/"+listImg[i], listImg[i]);
                        }
                    $("#text-imagen").val(response.photos);
                    $("#status-change").val("true");
                    ProductGroup(group);
                    $("#defaultid").val(response.id);
                    $("#sku").val(response.sku);
                    $("#shippingsize").val(response.shipping_size);
                    $("#inpValue_urlcode").val(response.url_code_localized);
                    $("#urlcode").val(response.url_code);
                    $("#description").val(response.description)
                    $("#name").val(response.name);
                    $("#inpValue_name").val(response.name_localized);
                    $("#inpValue_description").val(response.description_localized);
                    loadRename();
                    if(response.is_active==1){
                        $("#estatus").attr("checked", true);
                    }else{
                        $("#estatus").attr("checked", false);
                    }
                    $("#stock").val(response.stock);
                    $("#iscatalogo").val(response.is_for_catalogue);
                    if(param=="show"){
                        $("#form-register-subs").modal("show")
                    }else{
                        
                    }
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function statusChange(id, param){
        Swal
        .fire({
            title: "DesHabilitar Producto",
            text: "Si deshabilita el producto, este no aparecera en la lista",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Deshabilitar",
            cancelButtonText: "Cancelar",
        })
        .then(resultado => {
            if (resultado.value) {
                updatedata(id, param);
            } else {
                AlertCancel();
            }
        })
    }
    function ProductGroup(val){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductGroup-Get')
                @slot('parameters',"  ")
                @slot('result_success')
                let query="";
                query=query+`<option value="-1"> {{trans($lang.'lbl_default_select')}} </option>`;
                for(let item of response){
                    if(item.id==val){
                        query=query+`<option value="${item.id}" selected>${item.name_localized}</option>`;
                    }else{
                        query=query+`<option value="${item.id}">${item.name_localized}</option>`;
                    }
                }
                $("#groupProduct").append(query);
                $("#groupProduct").select2();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function load(id){
        $("#product_id").val(id);
        $("#specification_id").val("{{$default_id}}");
        LoadSepecification();
        limpiarSpecification();
        getSpecification(id);
        $("#form-specification").modal("show");
    }
    function getSpecification(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','product-specification-get')
                @slot('parameters'," 'product_id':id ")
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable('#result-specification') ) {
                        let table = $('#result-specification').DataTable();
                        table.destroy();
                    }
                    let query="";
                    $("#result-specification tbody").html("");
                    for(let item of response){
                        query=query+`<tr>
                                    <td>${item.id}</td>
                                    <td>${item.specification_name_localized}</td>
                                    <td>${item.value_localized}</td>
                                    <td>
                                    <div>
                                        <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                            <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                            <a class='dropdown-item' href='#' onclick='loadSpecificationid(${item.id})'>{!! trans($lang.'result_table.options.edit') !!}</a>
                                            <a class='dropdown-item' href='#' onclick='DeleteSpecification(${item.id})'>{!! trans($lang.'result_table.options.to_disable') !!}</a>
                                            </div>
                                        </button>    
                                    </div>
                                    </td>
                                </tr>`;
                    }
                    $("#result-specification tbody").append(query);
                    $("#result-specification").DataTable({
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
                @endslot
        @endcomponent
    }
    function updatedata(iddata, param){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Product-change-status')
                @slot('parameters'," 'id': iddata ")
                @slot('result_success')
                ShowSuccessMessage("{{trans($lang.'form.delete.success.msg_title_success')}}","{{trans($lang.'form.delete.success.msg_title_success')}}");
                GroupId(param);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function AlertCancel(){
        Swal.fire(
        'Proceso cancelado',
        'El proceso de eliminar un producto fue cancelado',
        'error'
        )
    }
    function Refrescar(){
        location.reload();
    }
    function loadProductGroup(){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductGroup-Get')
                @slot('parameters',"  ")
                @slot('result_success')
                let query="";
                query=query+`<option value="-1"> {{trans($lang.'lbl_default_select')}} </option>`;
                for(let item of response){
                    query=query+`<option value="${item.id}">${item.name_localized}</option>`;
                }
                $("#productGroup").append(query);
                $("#productGroup").select2();
                @endslot
                @slot('result_error')
                
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    //especificaciones
    function loadSpecificationid(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','product-specification-get')
                @slot('parameters'," 'product_specification_id': id ")
                @slot('result_success')
                $("#inpValue_value").val(response.value_localized)
                $("#value").val(response.value);
                $("#specification_id").val(response.id);
                $("#specification").val(response.specification_id);
                $("#specification").change();
                //estilos
                $("#btnsavespecification").html("{!! trans($lang.'btn_edit') !!}");
                $("#btnsavespecification").removeClass("btn-success");
                $("#btnsavespecification").addClass("btn-primary");
                $("#title-header").html("");
                $("#title-header").html("{!! trans($lang.'lbl_edit') !!}");
                @endslot
                @slot('result_error')
                
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function DeleteSpecification(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductSpecification-Delete')
                @slot('parameters'," 'id':id ")
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.delete.success.msg_title_success')}}","{{trans($lang.'form.delete.success.msg_title_success')}}");
                    getSpecification($("#product_id").val());
                @endslot
                @slot('result_error')
                
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    function saveSpecification()
    {
        //variables
        let id=$("#specification_id").val();
        let value=$("#value").val();
        let specification_id=$("#specification").val();
        let product_id=$("#product_id").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductSpecification-Register')
                @slot('parameters', " 'id':id, 'specification_id':specification_id , 'value':value , 'product_id':product_id ")
                @slot('result_success');
                ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                getSpecification(product_id);
                limpiarSpecification();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function LoadSepecification(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Specification-Get')
                @slot('parameters', "  ")
                @slot('result_success');
                   let query="";
                   query=query+`<option val="-1">{{trans($lang.'lbl_default_select')}}</option>`;
                   for(let item of response){
                        query=query+`<option value="${item.id}">${item.name_localized}</option>`;
                   }
                   $("#specification").select2();
                    $("#specification").append(query);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function limpiarSpecification(){
        $("#code").val(null);
        $("#value").val(null);
        $("#specification").val(-1);
        $("#specification").change();
        $("#inpValue_value").val(null);
        $("#specification_id").val("{{$default_id}}");
        //estilos
        $("#btnsavespecification").html("{!! trans($lang.'btn_register') !!}");
        $("#btnsavespecification").removeClass("btn-primary");
        $("#btnsavespecification").addClass("btn-success");
        $("#title-header").html("");
        $("#title-header").html("{!! trans($lang.'lbl_create') !!}");
    }
    //precios
    function loadPrices(id){
        $("#form-price").modal("show");
        $("#currency").html("");
        $("#product_id_price").val(id);
        $("#price_id").val("{{$default_id}}")
        loadCurrency();
        getPricesProd(id);
        clearPrice();
    }
    //get
    function getPricesProd(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductPrice-Get')
                @slot('parameters', " 'product_id': id ")
                @slot('result_success');
                if ( $.fn.dataTable.isDataTable('#result-price-prod') ) {
                        let table = $('#result-price-prod').DataTable();
                        table.destroy();
                    }
                   if(response.length>0){
                        let query="";
                        $("#result-price-prod tbody").html("")
                        for(let item of response){
                            query=query+`<tr>
                                            <td>${item.id}</td>
                                            <td>${item.currency_name}</td>
                                            <td>${(item.regular_price==null)? '00.00': item.regular_price }</td>
                                            <td>${item.online_price}</td>
                                            <td>
                                                <div>
                                                <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                                    <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                        <a class='dropdown-item' href='#' onclick='editPrice(${item.id})'>{!! trans($lang.'result_table.options.edit') !!}</a>
                                                        <a class='dropdown-item' href='#' onclick='deletePriceProd(${item.id})'>{!! trans($lang.'result_table.options.delete') !!}</a>
                                                    </div>
                                                </button>    
                                            </div>
                                            </td>
                                        </tr>`;
                        }
                        $("#result-price-prod tbody").append(query);
                        $("#result-price-prod").dataTable({
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
                   }
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function clearPrice(){
        $("#price_id").val("{{$default_id}}");
        $("#currency").val(-1);
        $("#currency").change();
        $("#price_regular").val(null);
        $("#price_online").val(null);
        $("#btnSavePriceProd").removeClass("btn-primary");
        $("#btnSavePriceProd").html("{!! trans($lang.'btn_register') !!}");
        $("#btnSavePriceProd").addClass("btn-success");
    }
    function savePriceProd(){
        let idprice = $("#price_id").val();
        let product_id = $("#product_id_price").val();
        let currency_id = $("#currency").val();
        let regular_price = $("#price_regular").val();
        let online_price = $("#price_online").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductPrice-Register')
                @slot('parameters', " 'id':idprice, 'product_id':product_id, 'currency_id':currency_id, 'regular_price':regular_price, 'online_price':online_price ")
                @slot('result_success');
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                    getPricesProd(product_id);
                    clearPrice();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function editPrice(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductPrice-Get')
                @slot('parameters', " 'product_price_id':id ")
                @slot('result_success');
                    $("#price_id").val(response.id);
                    $("#currency").val(response.currency_id);
                    $("#currency").change();
                    $("#price_regular").val(response.regular_price);
                    $("#btnSavePriceProd").removeClass("btn-success");
                    $("#btnSavePriceProd").html("Editar Precio");
                    $("#btnSavePriceProd").addClass("btn-primary");
                    $("#price_online").val(response.online_price);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function loadCurrency(){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','currency-get')
                @slot('parameters', "  ")
                @slot('result_success')
                    let option="<option value='-1'>Seleccione</option>";
                   for(let item of response){
                        option=option+`<option value="${item.id}">${item.name_localized}</option>`;
                   }
                   $("#currency").html("");
                   $("#currency").append(option);
                   $("#currency").select2();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function deletePriceProd(idprice){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ProductPrice-Delete')
                @slot('parameters', " 'id':idprice ")
                @slot('result_success');
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                    getPricesProd($("#product_id_price").val());
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function getTemplate(){
        @component(config($group.'.ui.component.engine.ajax-internal.view'))
                @slot('app_group',$group)
                @slot('route','dowload-template-product')
                @slot('parameters', "  ")
                @slot('result_success')
                    window.open(`{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/${response.name_document}`);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    var array_data;
    var array_categories;
    var sheets;
    function readTemplate(){
        let formulario=new FormData(document.getElementById("form-template"));
        @component(config($group.'.ui.component.engine.ajax-internal_formdata.view'))
                @slot('app_group',$group)
                @slot('route','import-template-product')
                @slot('parameters', " formulario ")
                @slot('result_success')
                    console.log(response);
                    array_categories=new Array();
                    array_data=new Array();
                    sheets=new Array();
                    sheets.push(response[0]);
                    array_categories.push(response[0][1]);
                    array_data.push(response[0][0]);
                    construcSheets(sheets[0], response);
                    LoadTableCategories(response[0].Categoria, response[0].keys_categories);
                    LoadResponseExcelBody(response, "Productos", response[0].preview);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    var llaves=new Array();
    function LoadResponseExcelBody(array, table, leng=null){
        if ( $.fn.dataTable.isDataTable('#excel-import #Productos') ) {
                let table = $('#excel-import #Productos').DataTable();
                table.destroy();
            }
            //construir la cabezera
            $('#excel-import #table-Productos thead tr').html("");
            let heding=array[0].key_productos;
            html_header="";
            for(let b=0; b<heding.length; b++){
                html_header=html_header+`<th>${heding[b]}</th>`;
            }
            $('#excel-import #table-Productos thead tr').append(html_header);
            ///
            $("#excel-import #myTabContent #Productos tbody").html("");
            if (array[0][0].length > 0) {
                //obtenemos las llaves
                let llaves=getKeys(array[0].Productos[0]);
                let datos = array[0].Productos;
                let stringrow="<tr> <|[rowdata]|> </tr>";
                let valor="";
                let longitud= (leng==null) ? datos.length : leng;
                if (longitud<datos.length) {
                    for(let i=0; i<longitud; i++){
                        for(let a=0; a<llaves.length; a++){
                            valor=`${valor}<td> ${array[0].Productos[i][llaves[a]]} </td>`;
                        }
                        $("#excel-import #myTabContent #table-Productos tbody").append(stringrow.replace('<|[rowdata]|>', valor));
                        stringrow="<tr> <|[rowdata]|> </tr>";
                        valor="";
                    }
                }else if(longitud>datos.length){
                    for(let i=0; i<datos.length; i++){
                    for(let a=0; a<llaves.length; a++){
                        valor=`${valor}<td> ${array[0].Productos[i][llaves[a]]} </td>`;
                    }
                    $("#excel-import #myTabContent #table-Productos tbody").append(stringrow.replace('<|[rowdata]|>', valor));
                    stringrow="<tr> <|[rowdata]|> </tr>";
                    valor="";
                    }
                }
                $("#excel-import").modal("show");
                $("#excel-import #table-Productos").DataTable({
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
        }
    }
    function getKeys(valor){
            var keys=[];
            for (var key in valor) {
                keys.push(key);
            }
            return keys;
    }
    function fromAjax(){
        loadProgress();
        let parse=JSON.stringify(array_data);
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('ws_group','entity')
        @slot('ws_name','ld-product-register')
        @slot('parameters', " 'data':parse ")
        @slot('result_success')
        loadProgress(100);
                    array_data=new Array();
                    ShowSuccessMessage("Datos guardados","Se guardaron correctamente los datos");
                @endslot
                @slot('result_error')
                $(".section-contents-bar .progress .progress-bar").removeClass("bg-danger");
                $(".section-contents-bar .progress .progress-bar").addClass("bg-danger");
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function TableContent(content) {
        let table="";
        switch (content){
            case "Productos":
               table=`<div class="text-center my-3">
                    <h3 class="font-weight-bold h3">Carga de productos 
                        <i class="fa fa-file-excel" aria-hidden="true"></i>
                    </h3>
                </div>
                <div class="container">
                    <table id="table-${content}" style="width: 100%;" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                            <tr>

                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-6 d-flex justify-content-center my-3">
                            <button type="button" class="btn btn-primary" onclick="ShowLoadData('${content}')">
                                <i class="fa fa-cloud-upload-alt" aria-hidden="true"></i>
                                Guardar Productos
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="FormClearModal()">
                                <i class="fa fa-sign-out-alt" aria-hidden="true"></i>
                                Cerrar
                            </button>
                        </div>
                        <div class="section-contents-bar col-sm-6 mx-auto my-3">

                        </div>
                    </div>
                </div>`;
            break;
            case "Categoria":
                table=`<div class="text-center my-3">
                    <h3 class="font-weight-bold h3">Carga de Categorias 
                        <i class="fa fa-file-excel" aria-hidden="true"></i>
                    </h3>
                </div>
                <div class="container">
                    <table id="table-${content}" style="width: 100%;" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                            <tr>

                            </tr>
                        </thead>
                        <tbody>
                            
                            </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-6 d-flex justify-content-center my-3">
                            <button class="btn btn-danger" onclick="ShowLoadData('${content}')">
                                <i class="fa fa-cloud-upload-alt" aria-hidden="true"></i>
                                Guardar Categorias
                            </button>
                            <button class="btn btn-warning" data-dismiss="modal" onlick="FormClearModal()">
                                <i class="fa fa-sign-out-alt" aria-hidden="true"></i>
                                Cerrar
                            </button>
                        </div>
                        <div class="section-contents-bar col-sm-6 mx-auto my-3">

                        </div>
                    </div>
                </div>`;
            break;
        }
        $("#myTabContent #"+content).html(table);
    }
    function construcSheets(array, response){
        let keysheets=getKeys(array);
        $("#excel-import ul").html("");
        $("#excel-import #myTabContent").html("");
        let li="";
        let div="";
        for(let i = 0; i<keysheets.length; i++){
            if(keysheets[i] == "Productos" || keysheets[i]=="Categoria" ){
                if(i==0){
                    li=`<li class="nav-item">
                            <a class="nav-link active" id="${keysheets[i]}-tab" data-toggle="tab" href="#${keysheets[i]}" role="tab" aria-controls="${keysheets[i]}" aria-selected="true">${keysheets[i]}</a>
                        </li>`;
                    div=`<div class="tab-pane fade show active" id="${keysheets[i]}" role="tabpanel" aria-labelledby="${keysheets[i]}-tab"></div>`;
                }else{
                    li=li+`<li class="nav-item">
                                <a class="nav-link" id="${keysheets[i]}-tab" data-toggle="tab" href="#${keysheets[i]}" role="tab" aria-controls="${keysheets[i]}" aria-selected="true">${keysheets[i]}</a>
                            </li>`;
                    div=div+`<div class="tab-pane fade" id="${keysheets[i]}" role="tabpanel" aria-labelledby="${keysheets[i]}-tab"></div>`;
                }
            }
        }
        
        $("#excel-import ul").append(li);
        $("#excel-import #myTabContent").append(div);

        for(let a=0; a<keysheets.length; a++){
            if(keysheets[a]=="Productos"){
                TableContent("Productos");
                $("#Productos").addClass("show active");
            }else{
                TableContent("Categoria");
            }
        }
    }
    function LoadTableCategories(array, header){
        if ( $.fn.dataTable.isDataTable('#excel-import #table-Categoria') ) {
            let table = $('#excel-import #table-Categoria').DataTable();
            table.destroy();
        }
        let header_table="";
        if (array.length>0) {
            let llaves=getKeys(array[0]);
            for(let b=0; b<llaves.length; b++){
                if (llaves[b] != "") {
                    header_table=header_table+`<th>${llaves[b]}</th>`;
                }
            }
            //cargaremos la informacion a la cabecera de la tabla
            $("#table-Categoria thead tr").html("");    
            $("#table-Categoria thead tr").append(header_table);
            $("#table-Categoria tbody").html("");
            //cargar la informacion del body
            let body_table="";
            for(let c=0; c<array.length; c++){
                body_table=body_table+`<tr><td>${array[c]["code"]}</td><td>${array[c]["root_code"]}</td><td>${array[c]["name_categorie"]}</td></tr>`;
            }
            $("#table-Categoria tbody").append(body_table);
            /* console.log("FIN DE AGREGAR DATOS");   */ 
        }else{
            /* console.log("datos vacios"); */
            //si los datos estan vacios
            for(let a=0; a<header.length; a++){
                header_table=header_table+`<th>${header[a]}</th>`;
            }
            $("#table-Categoria thead tr").append(header_table);
        }
        $("#table-Categoria").DataTable({
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
       /*  console.log("acaba aqui la funcion"); */
    }
    function ajaxApiCategories(){
        loadProgress();
        let parse=JSON.stringify(array_categories);
        @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('ws_group','entity')
                @slot('ws_name','ld-category-register')
                @slot('parameters', " 'data':parse ")
                @slot('result_success')
                    loadProgress(100);
                    array_categories=new Array();
                    ShowSuccessMessage("Datos guardados","Se guardaron correctamente los datos");
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function DonwloadImageExcel(){
        var array_name_really=new Array();
        let hijos_preview_massive=$("#preview-image_massive").children();
        //obtiene los cards que solo no estan removidos
        for(let a=0; a<hijos_preview_massive.length; a++){
            if ($(hijos_preview_massive[a]).hasClass("class-remove")){
                console.log("Tiene la clase removida");
            }else{
                array_name_really.push(hijos_preview_massive[a]);
            }
        }
        let array_content=new Array();
        for(let c=0; c<array_name_really.length; c++){
            array_content.push($(array_name_really[c]).children("div.col-sm-8"));
        }
        hijos_preview_massive=null;
        hijos_preview_massive=new Array();
        if (array_content.length>0) {
            for(let a=0; a<array_content.length; a++){
                hijos_preview_massive.push($($(array_content[a]).children("div.form-group.my-2.mx-auto.text-center.container")).children("div.content-name-old"));
            }
        }
        array_name_really=null;
        array_name_really=new Array();
        if (hijos_preview_massive.length>0) {
            for(let c=0; c<hijos_preview_massive.length; c++){
                array_name_really.push($($(hijos_preview_massive[c]).children("input.form-control.my-2")).val());
            }
        }
        sendArrayApi(JSON.parse($("#text-imagen_massive").val()), array_name_really);
    }
    function sendArrayApi(array_name_new, array_name_old){
        @component(config($group.'.ui.component.engine.ajax-internal.view'))
                @slot('app_group',$group)
                @slot('route','dowload-excel-product-name')
                @slot('parameters', " 'array_name_new': array_name_new, 'array_name_old':array_name_old ")
                @slot('result_success')
                    window.open(`{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/${response.name_document}`);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function ShowLoadData(table){
        insertProgress();
        if(table == "Productos"){
            fromAjax();
            
        }else if (table == "Categoria") {
            ajaxApiCategories();
        }
    }
    function insertProgress(){
        let bar=`<div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>`;
        $(".section-contents-bar").html("");
        $(".section-contents-bar").html(bar);
    }
    function loadProgress(process=null){
        if (process!=null) {
            $(".section-contents-bar .progress .progress-bar").css("width", `${process}%`);
            clearInterval(time);
        }else{
            let a=0;
            time=setInterval(function(){
            a +=10;
                $(".section-contents-bar .progress .progress-bar").css("width", `${a}%`);
                if (a==100) {
                    clearInterval(time);
                }
            }, 1000);
        }
    }
    var array_pre_data=new Array();
    function loadDataLdProducts(){
        @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ld-product-get')
                @slot('parameters', "  ")
                @slot('result_success')
                    array_pre_data.push(response);
                    if ( $.fn.dataTable.isDataTable('#table-products-tab') ) {
                        let table = $('#table-products-tab').DataTable();
                        table.destroy();
                    }
                    let query="";
                    for(let item of response){
                        query=query+`<tr>
                            <td>${item.CATEGORY_CODE}</td>
                            <td>${item.GROUP_ID}</td>
                            <td>${item.product_group_localized}</td>
                            <td>${item.product_localized}</td>
                            <td>${item.description_localized}</td>
                            <td>${item.ONLINE_PRICE}</td>
                            <td>${item.REGULAR_PRICE}</td>
                            <td>${item.SKU}</td>
                            <td>
                                <div class="dropdown btn-group">
                                    <button class="btn btn-secondary dropdown-toggle" id="btn-dropdown-${item.ID}" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="" class="btn btn-warning">Fotos</button>
                                    <div id="id${item.ID}dropdown" aria-labelledby="btn-dropdown-${item.ID}" class="dropdown-menu-right">
                                    `;
                                    let query_img="";
                                    let productos_img=PreviewPhotos(item.ID);
                                    query_img=`<ul class="dropdown-menu">`
                                    for(let img of productos_img){
                                        query_img=query_img+`<li class="dropdown-item"><img class="img-thumbnail img-fluid mx-2" style="width:100px; height:100px" src="${img}"></li>`;
                                    }
                                    query_img=query_img+`</ul>`;
                                    query=query+ query_img +`
                                    </div>
                                <div>
                            </td>
                            <td>
                                <div class="dropdown btn-group">
                                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-primary">Especificaciones</button>
                                    <div aria-labelledby="btn-dropdown-${item.ID}" class="dropdown-menu-right">`
                                        let query_specifications="";
                                        let product_especifications=PreviewEspecificaciones(item.ID);
                                        query_specifications="";
                                        query_specifications="<ul class='dropdown-menu'>";
                                        for(let img of product_especifications){
                                            query_specifications=query_specifications+`<li class="dropdown-item">${img[0]} = ${loadParseJson(img[1])}</li>`;
                                        }
                                        query_specifications=query_specifications+"<ul>";
                                    
                                    query=query+query_specifications+`</div>
                                <div>
                            </td>
                        </tr>`;
                    }
                    $("#table-products-tab tbody").html("");
                    $("#table-products-tab tbody").append(query);
                    $("#table-products-tab").DataTable({
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
    function loadDataCategories(){
        @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ld-category-get')
                @slot('parameters', "  ")
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable('#table-categories-tab') ) {
                        let table = $('#table-categories-tab').DataTable();
                        table.destroy();
                    }
                    let query="";
                    for(let item of response){
                        query=query+`<tr>
                            <td>${item.CODE}</td>
                            <td>${item.ROOT_CODE}</td>
                            <td>${item.name_localized}</td>
                            <td>${item.url_code_localized}</td>
                            <td>${item.BANER}</td>
                        </tr>`;
                    }
                    $("#table-categories-tab tbody").html("");
                    $("#table-categories-tab tbody").append(query);
                    $("#table-categories-tab").DataTable({
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
    function PreviewPhotos(id){
        //Buscamos el registro
        let array_name_prod_preload=new Array();
        /* $(`#id-${id}-dropdown`).dropdown(); */
        for(let a=0; a<array_pre_data[0].length; a++){
            if (array_pre_data[0][a].ID==id) {
                list_photos=array_pre_data[0][a].PHOTOS;
            }
        }
        if (list_photos!="") {
            list_photos=JSON.parse(list_photos);
            let input_image="";
            for(let item of list_photos){
                src=`{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/loaded/img/prod/${item}`;
                array_name_prod_preload.push(src);
            }
        }
        return array_name_prod_preload;
    }
    function PreviewEspecificaciones(id){
        /* let array_specification_prod_preload=new Array(); */
        let array_specification="";
        for(let a=0; a<array_pre_data[0].length; a++){
            if(array_pre_data[0][a].ID==id){
                array_specification=array_pre_data[0][a].ESPECIFICATIONS;
            }
        }
        array_specification=array_specification.split("|");
        //obtener los nombre de categoria
        var headers=new Array();
        for(let head of array_specification){
            headers.push(head.split("="));
        }
        /* let jason=JSON.parse(headers[0][1]); */
        /* loadParseJson(headers[0][1]); */
        return headers;
    }
    function loadParseJson(string_array){
        string_array=JSON.parse(string_array);
        /* llaves=getKeys(string_array); */
        return string_array[0].es;
    }
    function sendStoreProcedure(){
        @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('ws_group','entity')
                @slot('ws_name','ld-product-procedure')
                @slot('parameters', "  ")
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function FormClearModal(){
        $("#excel-import").modal("hide");
        $("#excel-import #myTab").html("");
        $("#excel-import #myTabContent").html("");
        $("#file-excel").val(null);
    }
    function formatArrayString(string=null){
        if(string != ""){
            string=string.replace(/&#039;/g,"");
            let stringv2
            string = string.replace("[", "");
            string = string.replace("]", "");
            string = string.split(", ");
            return string;
        }else{
            return null;
        }
    }
    function validateFormatImage(img_type, format=Array()){
        let status="";
        for(let item of format){
            if(item == img_type){
                return true;
            }else{
                status=false;
            }
        }
        return status;
    }
</script>
@endsection
