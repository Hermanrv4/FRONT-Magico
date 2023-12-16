<?php
    use App\Http\Common\Services\ApiService;
    use Illuminate\Support\Facades\Session;
    use \App\Http\Common\Services\ParameterService;

    $group = config('env.app_group_admin');
    $lang = config($group.'.ui.page.sale.list.lang');
    $default_id = ParameterService::GetParameter("default_id");
    $code = isset($code)?$code:null;
    $status_change="Rechazado";
    $is_gen=ApiService::Request(config('env.app_group_admin'), 'entity', 'parameter-get-codes', array('code'=>"is_gen"))->response;
?>
@extends(config($group.'.ui.template.main.view'))
@section('page_title',trans($lang.'page_title'))
@section('metas','')
@section('top_scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/datatable/DataTables-1.10.20/css/dataTables.bootstrap4.css")}}"/>
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/datatable/Responsive-2.2.3/css/responsive.bootstrap4.css")}}"/>
  {{--   <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/datatable/datatables.min.css")}}"/> --}}
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/main/datatable/Buttons-1.6.1/css/buttons.bootstrap4.min.css")}}"/>
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
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <!-- <button class="btn btn-dark col-md-2" disabled id="btnsearch" style="margin: 5px!important;">{!! trans($lang.'btn_search') !!}</button> -->
                                <!-- <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form_register_customer" id="btnopenform" >{!! trans($lang.'btn_register') !!}</button> -->
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
                            <th scope="col">{!! trans($lang.'result_table.col_customer') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_currency') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_sub_total') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_shipping_cost') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_total') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_status') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_status_pay') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_options') !!}</th>
                        </thead>
                        <tbody id="tablebody"></tbody>
                    </table>
                </div>
                <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
            </div>
        </div>
    </div>
    {{--Modal order Detail--}}
    @component(config($group.'.ui.component.engine.modal.view'))
        @slot('modal_id', 'form_view_order_detail')
        @slot('modal_title', strtoupper(trans($lang.'form.order_detail.title')));
        @slot('modal_class_04', 'bg-dark')
        @slot('modal_body')
            <div class="container-fluid">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">{!! trans($lang.'lbl_results_header') !!}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="tbResultsOrderDetail" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                            <thead id="table-head">
                                <th scope="col">{!! trans($lang.'result_table_order_detail.col_id') !!}</th>
                                <th scope="col">{!! trans($lang.'result_table_order_detail.col_product_sku') !!}</th>
                                <th scope="col">{!! trans($lang.'result_table_order_detail.col_product_name') !!}</th>
                                <th scope="col">{!! trans($lang.'result_table_order_detail.col_quantity') !!}</th>
                                <th scope="col">{!! trans($lang.'result_table_order_detail.col_price') !!}</th>
                                <th scope="col">{!! trans($lang.'result_table_order_detail.col_observations') !!}</th>
                                <th scope="col">{!! trans($lang.'result_table_order_detail.col_options') !!}</th>
                            </thead>
                            <tbody id="tablebody_order_detail"></tbody>
                        </table>
                    </div>
                    <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
                </div>            
            </div>        
        @endslot
    @endcomponent

    {{--Modal change state--}}
    @component(config($group.'.ui.component.engine.modal.view'))
        @slot('modal_id', 'form-detail_sale')
        @slot('modal_title', strtoupper(trans($lang.'status_sale.modal.title')));
        @slot('modal_class_02','-')
        @slot('modal_class_04', 'bg-dark')
        @slot('modal_body')
                <div class="form-group">
                    <div class="row col-md-12" id="content">
                        {{-- select para el tipo de grupo --}}
                        <input type="text" name="order_id" hidden id="order_id">
                        <input type="text" hidden id="status_paycode">
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","status",$lang.'form.register.lbl_status_sale',true,"col-md-12","fas fa-envelope") !!}
                    </div>
                    <div class="text-center d-flex justify-content-center my-3">
                        {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","notify_sale",$lang.'form.register.lbl_nofify_sale',true,"col-md-6","fas fa-envelope") !!}
                    </div>
                </div>
                        <div class="row">
                            <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                                <button id="btn_save" style="margin: 5px!important;" class="btn btn-success form-control">{!! trans($lang.'status_sale.btn_save') !!}</button>
                            </div>
                        </div>
        @endslot
    @endcomponent
    <!--Modales-->


    {{--Scripts--}}
    <script>
        window.onload=function(){
            let id=parseInt("{{$code}}");
            let default_id=parseInt("{{$default_id}}")
            if(id==null){
                loadSale(default_id);
            }else{
                loadSale(id);
            }
            $("#btn_save").on("click", function(){
                let status_text=($("#status :selected").text()== "{{$status_change}}") ? $("#status :selected").text() : null;
                if($("#estatus-notify_sale").is(":checked")){
                    saveState("{{$is_gen}}", status_text);
                    notifystatus();
                }else{
                    saveState("{{$is_gen}}", status_text);
                }
            });
            $("#estatus-notify_sale").on("change", function(){
                if($("#estatus-notify_sale").is(":checked")){
                    ShowMessage("Notificacion", "Se le notificara al cliente por el estado de su orden por medio de un correo", "info");
                }else{
                    ShowMessage("Notificacion", "No se le notificara al cliente por dicho estado", "info");
                }
            });
        }
        //ventas
        function loadSale(order){
            if(isNaN(order)){
                order=-1;
            }
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-get')
                @slot('parameters', " 'user_id': order  ")
                @slot('result_success')
                /* console.log(response); */
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                        let query="";
                        $("#tablebody").html("");                        
                        for(let item of response){
                            query=query+`<tr> 
                            <td scope="row">${item.id}</td>
                            <td>${item.user_first_name} ${item.user_last_name}</td> 
                            <td>${item.currency_name}</td> 
                            <td>${parseFloat(item.sub_total).toFixed(2)}</td>
                            <td>${parseFloat(item.shipping_cost).toFixed(2)}</td>
                            <td>${parseFloat(item.total).toFixed(2)}</td>
                            <td>${item.type_name}</td>
                            <td>${(item.payment_status==null)? "": item.payment_status}</td>
                                <td data-priority="1">
                                    <div>
                                        <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                            <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                <a class='dropdown-item' href='#' onclick='loadOrderDetail(${item.id})'>{!! trans($lang.'result_table.options.view_detail') !!}</a>
                                                <a class='dropdown-item' href='#' onclick='changeOrder(${item.id},${item.status_type_id})'>{!! trans($lang.'result_table.options.state') !!}</a>
                                            </div>
                                        </button>    
                                    </div>
                                </td>
                            </tr>`;
                        }
                        $("#tablebody").append(query);
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
                            },
                    }} 
                );               
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
        }
        //Order Detail
        function getOrderDetail(id){
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-detail-get')
                @slot('parameters', " 'order_id':id ")
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable('#tbResultsOrderDetail') ) {
                        let table = $('#tbResultsOrderDetail').DataTable();
                        table.destroy();
                    }
                    $("#tablebody_order_detail").html("");                        
                    let query="";                        
                    for(let item of response){
                    query=query+`
                    <tr> 
                        <td scope="row">${item.id}</td>
                        <td>${item.product_sku}</td> 
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${parseFloat(item.price).toFixed(2)}</td>`
                        if(item.observations==null){
                                query=query+`<td>SIN OBSERVACIONES...</td>`;
                            }else{
                                query=query+`<td>${item.observations}</td>`
                            }
                        query=query+`
                        <td>
                            <div>
                                <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table_order_detail.options.title') !!}<span class='sr-only'></span>
                                    <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                        <a class='dropdown-item' disabled href='#' onclick='EditAddress(${item.id})'>{!! trans($lang.'result_table_order_detail.options.edit') !!}</a>
                                        
                                    </div>
                                </button>    
                            </div>
                        </td>
                    </tr>`;
                    }
                    $("#tablebody_order_detail").append(query);                        
                    $('#tbResultsOrderDetail').DataTable({
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
                        }
                    });
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
        }
        function loadOrderDetail(id){
            getOrderDetail(id)
            $("#form_view_order_detail").modal("show"); 
        }
        function changeOrder(id, type_id){
            getStatusPayCode(id);
            changeState(id, type_id);
        }
        function changeState(id,type_id){
            let order_id = id;
            $("#order_id").val(order_id);
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','type-get')
                @slot('parameters', " 'type_group_id': 1 ")
                @slot('result_success')
                    $("#status").html('');                   
                    let query="";
                    query=query+`<option value="" selected>{{trans($lang.'lbl_default_select')}}</option>`;
                    for(let item of response){
                        if(item.id==type_id){
                            query=query+`<option value="${item.id}" selected>${item.name_localized}</option>`;
                        }else{
                            query=query+`<option value="${item.id}">${item.name_localized}</option>`;
                        }
                    }
                    //abrir modal
                    $("#status").select2();
                    $("#status").append(query);
                    $("#form-detail_sale").modal("show");
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent            
        }
        function saveState(is_gen=null, status_order=null){
            let order_id = $('#order_id').val();
            let status = $('#status').val();
            let status_order_paycode = $("#status_paycode").val();
            /* console.log(status); */
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-change-status')
                @slot('parameters', " 'id': order_id,'status_type_id':status, 'is_gen': is_gen, 'status': status_order_paycode ")
                @slot('result_success')                  
                    ShowSuccessMessage("{{trans($lang.'status_sale.msg_title_success')}}","{{trans($lang.'status_sale.msg_description_success')}}");
                    $("#form-detail_sale").modal('hide');
                    loadSale();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent  
        }
        function notifystatus(id_order,estatus){
            /* @component(config($group.'.ui.component.engine.ajax-internal.view'))
                @slot('app_group',$group)
                @slot('route','send-notify-email-sale')
                @slot('parameters', " 'id':id_order, 'status': estatus ")
                @slot('result_success')
                    ShowSuccessMessage("Correo enviado", "Notificacion al cliente enviado");
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent */
        }
        function getStatusPayCode(id_order){
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-get')
                @slot('parameters', " 'order_id': id_order ")
                @slot('result_success')
                    $("#status_paycode").val((response.payment_status==null)? 'null' : response.payment_status);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
        }
    </script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
@endsection