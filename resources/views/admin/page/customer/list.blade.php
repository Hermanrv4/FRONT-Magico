<?php
    use App\Http\Common\Services\ApiService;
    use Illuminate\Support\Facades\Session;
    use \App\Http\Common\Services\ParameterService;

    $group = config('env.app_group_admin');
    $lang = config($group.'.ui.page.customer.list.lang');
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
                                <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form_register_customer" id="btnopenform" >{!! trans($lang.'btn_register') !!}</button>
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
                            <th scope="col">{!! trans($lang.'result_table.col_DNI') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_first_name') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_last_name') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_phone') !!}</th>
                            <th scope="col">{!! trans($lang.'result_table.col_email') !!}</th>
                            <th >{!! trans($lang.'result_table.col_options') !!}</th>
                        </thead>
                        <tbody id="tablebody"></tbody>
                    </table>
                </div>
                <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
            </div>
        </div>
    </div>

    {{--Modal agregar editar--}}
    @component(config($group.'.ui.component.engine.modal.view'))
        @slot('modal_id', 'form_register_customer')
        @slot('modal_title', strtoupper(trans($lang.'form.register.title')));
        @slot('modal_class_02','-')
        @slot('modal_class_04', 'bg-dark')
        @slot('modal_body')
            <div class="form-group">
                <div class="row col-md-12" id="content">
                    <input type="text" name="default_id" hidden id="default_id">
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","dni",$lang.'form.register.lbl_dni_customer',true,"col-md-12","fas fa-envelope") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","first_name",$lang.'form.register.lbl_first_name',true,"col-md-12") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","last_name",$lang.'form.register.lbl_last_name',true,"col-md-12") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","email",$lang.'form.register.lbl_email',true,"col-md-12") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","phone",$lang.'form.register.lbl_phone_customer',true,"col-md-12","fas fa-envelope") !!}
                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","password",$lang.'form.register.lbl_ppassword_customer',true,"col-md-12","fas fa-envelope") !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                    <button id="btn_save" style="margin: 5px!important;" id="btnRegister" class="btn btn-success form-control">{!! trans($lang.'btn_send_email') !!}</button>
                </div>
            </div>
        @endslot
    @endcomponent
    {{--Modal direcciones--}}
    @component(config($group.'.ui.component.engine.modal.view'))
        @slot('modal_id', 'form_edit_address')
        @slot('modal_title', strtoupper(trans($lang.'form.address.title')))
        @slot('modal_class_02','modal-lg')
        @slot('modal_class_04', 'bg-dark')
        @slot('modal_body')
            <div class="container-fluid">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title" id="header_card">{!! trans($lang.'lbl_address_filters_header_create') !!}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="row col-md-12" id="content">
                                    <div id="address_content" class="row col-md-12 d-flex justify-content-around">
                                    </div>
                                    <input type="text" name="default_id" hidden id="default_id">
                                    <input type="text" name="address_user_id" hidden id="address_user_id">
                                    <input type="text" name="id_ubication" id="id_ubication" hidden>
                                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","address_ubication",$lang.'form.address_register.lbl_ubication',true,"col-md-12") !!}
                                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","address_address",$lang.'form.address_register.lbl_address',true,"col-md-12") !!}
                                    {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","address_phone",$lang.'form.address_register.lbl_phone',true,"col-md-12","fas fa-envelope") !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <button class="btn btn-dark col-md-2" style="margin: 5px!important;"  id="btnclean_address" onclick='clearAddress()'>{!! trans($lang.'form.address_register.btn_clean') !!}</button>
                                <button class="btn btn-success col-md-2" style="margin: 5px!important;" id="btnsave_address" onclick='saveAddress()'>{!! trans($lang.'form.address_register.btn_save') !!}</button>
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
                        <table id="tbResultsAddress" width="100%" class="table table-bordered table-hover" cellspacing="0">
                            <thead id="table-head">
                                <tr>
                                    <th scope="col">{!! trans($lang.'result_table_address.col_id') !!}</th>
                                    <th scope="col">{!! trans($lang.'result_table_address.col_ubication') !!}</th>
                                    <th scope="col">{!! trans($lang.'result_table_address.col_address') !!}</th>
                                    <th scope="col">{!! trans($lang.'result_table_address.col_phone') !!}</th>
                                    <th scope="col">{!! trans($lang.'result_table_address.col_options') !!}</th>
                                </tr>
                            </thead>
                            <tbody id="tablebody_address"></tbody>
                        </table>
                    </div>
                    <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
                </div>            
            </div>        
        @endslot
    @endcomponent
    {{--Scripts--}}
    <script>
        window.onload=function(){
            loadData("{{$default_id}}");
        }
        document.getElementById("btnopenform").addEventListener("click", function(){
            $("#default_id").val("{{$default_id}}");
            $("#form_register_customer-title").html("{{trans($lang.'form.register.title')}}");
            $("#dni").val(null)
            $("#first_name").val(null);
            $("#last_name").val(null);
            $("#email").val(null);
            $("#phone").val(null);
            $("#password").val(null);
        });
        document.getElementById("btn_save").addEventListener("click", function () {
            SaveData();
        });
        //CLIENTES
        function loadData(){
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Customer-Get')
                @slot('parameters', "")
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                        let query="";
                        $("#tablebody").html("");
                        
                        for(let item of response){
                        query=query+`<tr scope="row"> 
                        <td>${item.id}</td>`
                        if(item.dni==null){
                            query=query+`<td>SIN DNI</td>`;
                        }else{
                            query=query+`<td>${item.dni}</td>`
                        }                         
                        query=query+`<td>${item.first_name}</td> 
                                    <td>${item.last_name}</td>`
                        if(item.phone==null){
                            query=query+`<td>SIN OBSERVACIONES...</td>`;
                        }else{
                            query=query+`<td>${item.phone}</td>`
                        }
                        query=query+`<td>${item.email}</td>
                            <td data-priority="1">
                                <div>
                                    <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table.options.title') !!}<span class='sr-only'></span>
                                        <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                            <a class='dropdown-item' href='#' onclick='LoadDataId(${item.id})'>{!! trans($lang.'result_table.options.edit') !!}</a>
                                            <a class='dropdown-item' href='#' onclick='loadAddress(${item.id})'>{!! trans($lang.'result_table.options.edit_address') !!}</a>
                                            <a class='dropdown-item' href='#' onclick='openSale(${item.id})' target="_blank">{!! trans($lang.'result_table.options.show_sale') !!}</a>
                                            <a class='dropdown-item' href='#' onclick='deleteData(${item.id})'>{!! trans($lang.'result_table.options.delete') !!}</a>
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
        function SaveData(){
            let id=$("#default_id").val();
            let dni=$("#dni").val();
            let first_name=$("#first_name").val();
            let last_name=$("#last_name").val();
            let email=$("#email").val();
            let phone=$("#phone").val();
            let password=$('#password').val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Customer-Register')
                @slot('parameters'," 'id': id, 'dni': dni, 'first_name': first_name, 'last_name':last_name, 'phone':phone,'email':email, 'password':password" )
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.register.msg_title_success')}}","{{trans($lang.'form.register.msg_description_success')}}");
                    loadData();
                    $("#form_register_customer").modal('hide');
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
                @slot('ws_name','Customer-Get')
                @slot('parameters', " 'user_id':id ")
                @slot('result_success')
                    $("#form_register_customer-title").html("{{trans($lang.'form.edit.title')}}")
                    $("#btn_save").html("{{trans($lang.'form.edit.btn')}}");
                    $("#default_id").val(response.id);
                    $("#dni").val(response.dni);
                    $("#first_name").val(response.first_name);
                    $("#last_name").val(response.last_name);
                    $("#phone").val(response.phone);
                    $("#email").val(response.email);
                    $("#info").val(response.info_suscriber);
                    $("#form_register_customer").modal("show")
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
        function deleteData(id){
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Customer-Delete')
                @slot('parameters'," 'id': id ")
                @slot('result_success')
                loadData();
                ShowSuccessMessage("{{trans($lang.'form.delete.msg_title_success')}}","{{trans($lang.'form.delete.msg_title_success')}}");
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                @endslot
            @endcomponent
        }
        //DIRECCIONES de clientes
        function getAddressData(id){
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Address-Get')
                @slot('parameters', " 'user_id':id ")
                @slot('result_success')
                    if ( $.fn.dataTable.isDataTable('#tbResultsAddress') ) {
                        let table = $('#tbResultsAddress').DataTable();
                        table.destroy();
                    }
                    $("#tablebody_address").html("");                        
                    let query="";                        
                    for(let item of response){
                    query=query+`<tr> 
                    <td scope="row">${item.id}</td>
                    <td>${item.ubication_name}</td> 
                    <td>${item.address}</td>`
                    if(item.phone==null){
                        query=query+`<td>SIN OBSERVACIONES...</td>`;
                    }else{
                        query=query+`<td>${item.phone}</td>`
                    }
                    query=query+`
                        <td>
                            <div>
                                <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> {!! trans($lang.'result_table_address.options.title') !!}<span class='sr-only'></span>
                                    <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                        <a class='dropdown-item' href='#' onclick='EditAddress(${item.id})'>{!! trans($lang.'result_table_address.options.edit') !!}</a>
                                        <a class='dropdown-item' href='#' onclick='DeleteData(${item.id})'>{!! trans($lang.'result_table_address.options.delete') !!}</a>
                                    </div>
                                </button>    
                            </div>
                        </td>
                    </tr>`;
                    }
                    $("#tablebody_address").append(query);                        
                    $('#tbResultsAddress').DataTable({
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
            @endcomponent
            $("#address_user_id").val(id);
            $("#address_address").focus();
        }
        function loadAddress(id){
            /* LoadUbicationView(-1); */
            $("#address_ubication").attr("readonly", true)
            
            clearAddress();            
            getAddressData(id)
            $("#form_edit_address").modal("show");            
        }
        function EditAddress(id){
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Address-Get')
                @slot('parameters', " 'address_id':id")
                @slot('result_success')
                    $("#header_card").html("{{trans($lang.'lbl_address_filters_header_edit')}}");                    
                    $("#default_id").val(response.id);
                    $("#address_user_id").val(response.user_id);
                    $("#address_ubication").val(response.ubication_name);
                    $("#address_address").val(response.address);
                    $("#address_address").focus();
                    $("#address_phone").val(response.phone);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
        }
        function saveAddress(){
            let id=$("#default_id").val();
            let user_id=$("#address_user_id").val();
            /* let ubication_id=$("#address_ubication").val(); */
            let ubication_id=$("#id_ubication").val();
            let address=$("#address_address").val();
            let phone=$("#address_phone").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Address-Register')
                @slot('parameters'," 'id': id,'user_id':user_id ,'ubication_id': ubication_id, 'address': address, 'phone':phone" )
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.address_register.msg_title_success')}}","{{trans($lang.'form.address_register.msg_description_success')}}");
                    loadAddress(user_id);    
                    $("#header_card").html("{{trans($lang.'lbl_address_filters_header_create')}}");    
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
            @endcomponent
            
        }
        function DeleteData(id){
            let user_id = $("#address_user_id").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','Address-Delete')
                @slot('parameters'," 'id': id ")
                @slot('result_success')
                    ShowSuccessMessage("{{trans($lang.'form.delete.msg_title_success')}}","{{trans($lang.'form.delete.msg_title_success')}}");
                    loadAddress(user_id);  
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                @endslot
            @endcomponent
        }
        function clearAddress(){
            $("#address_ubication").val('');
            $("#address_address").val('');
            $("#address_phone").val('');
            $("#default_id").val("{{$default_id}}");
            $("#header_card").html("{{trans($lang.'lbl_address_filters_header_create')}}");
            $("#address_content").html("");
            niveles=0;
            LoadUbicationView("{{$default_id}}");
        }

        //UBICACIONES
        let niveles=0;
        function LoadUbicationView(id){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ubication-root-get')
                @slot('parameters'," 'root_ubication_id': id ")
                @slot('result_success')
                let query="";

                if(response[0].length>0){
                    niveles++;
                    query=query+'<div id="level-'+niveles+'" style="padding-bottom: 10px!important;padding-right: 0px;padding-left: 0px">';
                    query=query+'<label>Nivel-'+niveles+'</label>';
                    query=query+'<select id='+niveles+' class="form-control" onchange="ChangeUbicationView(\'' + niveles + '\')">';
                    query=query+"<option value='-1'>--SELECCIONE--</option>";
                        for(let item of response[0])
                        {
                            query=query+'<option value="'+item.id+'">'+item.name_localized+'</option>';
                        }
                    query=query+'</select></div>';
                    $("#address_content").append(query);
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
    //DETECTAR EL SELECT
    function ChangeUbicationView(id){
        DeleteUbicationViews(id);
            if($("#"+id).val()==-1){
                /** */
                /* LoadUbication("{{$default_id}}"); */
            }else{
                $("#address_ubication").val($("#"+id+" option:selected").text());
                $("#id_ubication").val($("#"+id+" option:selected").val());
                LoadUbicationView($("#"+id).val());
            }
    }
    //ELIMINAR SELECT
    function DeleteUbicationViews(id)
    {
        if(id==null)
        {
            niveles=0;
            
        }else{
            let level=$("#"+id).parent().closest('div').attr('id');
            
            level=parseInt(level.replace("level-",""));
           
            for(let i=level+1; i<=niveles; i++){
                $("#level-"+i).remove();
            }
            niveles=level;
        }
    }
    //ID CLIENTE URL
    function openSale(code){
        let url="{!! \App\Http\Common\Services\RouteService::GetAdminURL("sales-list", ["code"=>"route_parameter"]) !!}";
        /* window.location.href = url.replace("route_parameter",code); */
        window.open(url.replace("route_parameter",code), '');
    }
    </script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
@endsection