<?php
    use App\Http\Common\Services\ApiService;
    use Illuminate\Support\Facades\Session;
    use \App\Http\Common\Services\ParameterService;

    $group = config('env.app_group_admin');
    $lang = config($group.'.ui.page.statistical-charts-list.list.lang');
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
                                {{-- <div class="card">
                                    <div class="card-body d-flex"> --}}
                                        <div class="row col-12 font-weight-bold mr-auto">
                                            <select id="id-query-option" class="form-control">
                                                <option value="0">{!! trans($lang.'lbl_default_select') !!}</option>
                                                <option value="1">{!! trans($lang.'card-query.query-categories.title') !!}</option>
                                                <option value="2">{!! trans($lang.'card-query.query-group-product.title') !!}</option>
                                                <option value="3">{!! trans($lang.'card-query.query-product.title') !!}</option>
                                                <option value="4">{!! trans($lang.'card-query.query-sale.title') !!}</option>
                                                <option value="5">{!! trans($lang.'card-query.query-order-status.title') !!}</option>
                                                <option value="6">{!! trans($lang.'card-query.query-order-customer.title') !!}</option>
                                            </select>
                                        </div>
                                    {{-- </div>
                                </div> --}}
                            </div>
                            <div class="row container">
                                <div id="btn-checked-filter" class="content-filter container my-3 col-md-4">
                                    <div class="btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-outline-primary active">
                                          <input type="checkbox" id="btn-checked-input-filter"> Filtrar Por Estados
                                        </label>
                                    </div>
                                </div>
                                <div id="select-result-filter" class="container my-3 col-md-6">
                                    
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
                    <div class="row col-sm-12 preload">
                        
                    </div>
                    <div class="section-result py-4 px-4">
                        <div id="title-result" class="text-center">

                        </div>
                        <div id="content-btn" class="d-flex justify-content-center">
                            <button type="button" id="btn-chart-bar" class="btn btn-lg btn-outline-primary">
                                <i class="fa fa-chart-bar mr-2" aria-hidden="true"></i>
                                <b class="font-weight-bold ml-auto ml-2">
                                    {!! trans($lang.'card-query.btn-card-query.btn-bar') !!}
                                </b>
                            </button>
                            <button type="button" id="btn-chart-pie" class="btn btn-lg btn-outline-success">
                                <i class="fa fa-chart-pie mr-2" aria-hidden="true"></i>
                                <b class="font-weight-bold ml-auto ml-2">
                                    {!! trans($lang.'card-query.btn-card-query.btn-pie') !!}
                                </b>
                            </button>
                            <button type="button" hidden class="btn btn-lg btn-outline-danger">
                                <i class="fa fa-file-pdf mr-2" aria-hidden="true"></i>
                                <b class="font-weight-bold ml-auto ml-2">
                                    {!! trans($lang.'card-query.btn-card-query.btn-export-pdf') !!}
                                </b>
                            </button>
                            <button type="button" id="btn-chart-export-excel" class="btn btn-lg btn-outline-warning">
                                <i class="fa fa-file-excel mr-2" aria-hidden="true"></i>
                                <b class="font-weight-bold ml-auto ml-2">
                                    {!! trans($lang.'card-query.btn-card-query.btn-export-excel') !!}
                                </b>
                            </button>
                        </div>
                        <div class="d-flex my-2">
                            <div class="row col-12 justify-content-center">
                                <div class="col-sm-4 form-group">
                                    <input type="date" id="id-fec-start" class="form-control">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <input type="date" id="id-fec-end" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="chart-id" class="px-5 py-4">
                    </div>
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
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
@endsection

@section('bottom_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.1.1/dist/chart.min.js"></script>
<script>
    var array_list=["ninguno", "categorias", "grupo_producto", "producto", "ventas", "order-status", "order-customer"];
    var option = null;
    var config=null;
    var labels=new Array();
    var categories=new Array();
    var data=new Array();
    var type_chart="bar";
    var colors=new Array();
    var canvas="";
    var headerTitleGeneral="";
    var data_all=new Array();
    $(document).ready(function(){
        $("#content-btn").hide();
        $("#btn-checked-filter").hide();
        loadDataCategories();
        $(document).ajaxStart(function() {
            /* $('.preload').html("Cargando"); */
        });
        $(document).ajaxStop(function() {
            /* $('.preload').html("Carga Finalizada") */
        });
        $("#btn-checked-input-filter").on("click", function(){
            if($("#btn-checked-input-filter").is(":checked")){
                console.log($("#btn-checked-input-filter").is(":checked"));
                loadTypes("{{$default_id}}");
                option="order-of-status";
            }else{
                $("#select-result-filter").html("");
            }
        });
        $("#id-query-option").select2();
        loadDataCategories();
        $("#id-query-option").on("change", function(){
            $("#title-result").html("");
            $("#title-result").html(`<h1 class="font-weight-bold">${$("#id-query-option :selected").text()}</h1>`);
            option=array_list[$("#id-query-option :selected").val()];
            /* console.log(option); */
            LoadResult(option);

        });
        $("#id-fec-start").on("change", function () {
            if($("#btn-checked-input-filter").is(":checked")){
                console.log("of date");
                getQueryOrderStatusOfDate($("#STATES-ID-select").val());
            }else{
                LoadResult(option);
            }
        });
        $("#id-fec-end").on("change", function () {
            if($("#btn-checked-input-filter").is(":checked")){
                console.log("of date");
                getQueryOrderStatusOfDate($("#STATES-ID-select").val());
            }else{
                LoadResult(option);
            }
        });
        $("#btn-chart-bar").on("click", function(){
            type_chart="bar";
            LoadResult(option);
            /* getCategoriesLabel(null, type_chart); */
        });
        $("#btn-chart-pie").on("click", function(){
            type_chart="pie";
            LoadResult(option);
        });
        $("#btn-chart-export-excel").on("click", function(){
            if(canvas!=""){
                sendCanvasSave(canvas);
            }else{
                ShowFormErrors("Seleccione un grafico");
            }
        });
    });
    //obtener los tipos
    function loadTypes(id_type){
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','type-get')
                @slot('parameters', " 'type_group_id':1 ")
                @slot('result_success')
                    console.log(response);
                    $("#select-result-filter").html("");
                    let select="";
                    select=select+`<select onchange="changeSelect()" id="${response[0].type_group_code}-ID-select" class="form-control">`
                    for(let item of response){
                        select=select+`<option value="${item.id}">${item.name_localized}</option>`
                    }
                    select=select+`</select>`;
                    $("#select-result-filter").html(select)
                    $(`#${response[0].type_group_code}-ID-select`).select2();
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                @endslot
        @endcomponent
    }
    //obtener las categorias
    function loadDataCategories(id = "{{$default_id}}"){
        id=parseInt(id);
        @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','category-root-get')
                @slot('parameters', " 'root_category_id':id ")
                @slot('result_success')
                categories=new Array();
                    for(let item of response){
                        obj=[item.name_localized, item.id];
                        categories.push(obj);
                    }
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function LoadResult(option){
        switch(option){
            case "ninguno":
                $("#select-result-filter").html("");
                $("#btn-checked-input-filter").prop("checked", false)
                clearCanvas();
                $("#btn-checked-filter").hide();
            break;
            case "categorias":
                $("#select-result-filter").html("");
                $("#btn-checked-input-filter").prop("checked", false)
                $("#btn-checked-filter").hide();
                getCategoriesLabel();
            break;
            case "grupo_producto":
                $("#select-result-filter").html("");
                $("#btn-checked-input-filter").prop("checked", false)
                $("#btn-checked-filter").hide();
                getQueryProductGroupDate();
            break;
            case "producto":
                $("#select-result-filter").html("");
                $("#btn-checked-input-filter").prop("checked", false)
                $("#btn-checked-filter").hide();
                getQueryProductDate();
            break;
            case "ventas":
                $("#select-result-filter").html("");
                $("#btn-checked-input-filter").prop("checked", false)
                $("#btn-checked-filter").hide();
                getQueryBillingCustomerOfDate();
            break;
            case "order-status":
                $("#btn-checked-filter").fadeIn(3000);
                if($("#btn-checked-input-filter").is(":checked")){
                    getQueryOrderStatusOfDate($("#STATES-ID-select").val());
                }else{
                    getQueryOrderStatus();
                }
            break;
            case "order-customer":
                $("#select-result-filter").html("");
                $("#btn-checked-input-filter").prop("checked", false)
                $("#btn-checked-filter").hide();
                getQueryCustomerSate();
            break;
            default:
                console.log("defecto");
            break;
        }
    }
    function getQueryOrderStatusOfDate(id_status){
        let fec_start=$("#id-fec-start").val();
        let fec_end=$("#id-fec-end").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','order-get-status-of-date')
            @slot('parameters', " 'date_start':fec_start , 'date_end':fec_end, 'id_status':id_status ")
            @slot('result_success')
                if(response.length==0){
                    ShowFormErrors(null, "No hay datos, seleccione un rango fechas difente");
                }
                $("#title-result").html("");
                $("#title-result").html(`<h1>Ordenes ${$("#STATES-ID-select :selected").text()} por fechas</h1>`);
                $("#chart-id").html("");
                $("#chart-id").html(`<canvas id="myChartOrder" width="600" height="400"></canvas>`);
                data_all=new Array();
                
                let labels=new Array();
                let colors=new Array();
                let Data=new Array();
                canvas="myChartOrder";
                /* console.log(response); */
                for(let item of response){
                /* labels.push(`${item.orderet_at}-${item.type_name}`); */
                    labels.push(`${item.orderet_at}`);
                    colors.push(colorRGB());
                }
                /* console.log(labels); */
                for(let row of response){
                    Data.push(row.count_status);
                }
                /* console.log(response); */
                data_all.push([labels,Data]);
                data=new Array();
                headerTitleGeneral="";
                headerTitleGeneral=`Ordenes ${$("#STATES-ID-select :selected").text()} por fechas`;
                console.log(headerTitleGeneral);
                data = {
                    labels: labels,
                    datasets: [{
                        label: `Ordenes ${$("#STATES-ID-select :selected").text()} por fechas`,
                        backgroundColor: colors,
                        borderColor: "White",
                        data: Data,
                    }]
                    };
                    config = {
                        type: `${type_chart}`,
                        data,
                        options: {}
                    };
                var myChart = new Chart(
                        document.getElementById('myChartOrder'),
                        config
                    );
                    @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
                HideFullLoading();
            @endslot
        @endcomponent
    }
     //cantidad de ventas por producto entre un rango de fechas
    function getQueryOrderStatus(id="{{$default_id}}"){
        let fec_start=$("#id-fec-start").val();
        let fec_end=$("#id-fec-end").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-get-status-date')
                @slot('parameters', " 'date_start':fec_start , 'date_end':fec_end ")
                @slot('result_success')
                    $("#chart-id").html("");
                    $("#chart-id").html(`<canvas id="myChart" width="600" height="400"></canvas>`);
                    canvas="myChart"
                    labels=new Array();
                    let count_data=new Array();
                    colors=new Array();
                    //contruimos los labels
                    for(let item of response){
                        labels.push(item.type_name);
                        count_data.push(item.count_type);
                        colors.push(colorRGB());
                    }
                    data_all.push([labels, count_data]);
                    headerTitleGeneral=`${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`;
                    console.log(headerTitleGeneral);
                    data=new Array();
                    data = {
                            labels: labels,
                            datasets: [{
                            label: `${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`,
                            backgroundColor: colors,
                            borderColor: "White",
                            data: count_data,
                        }]
                    };
                    config = {
                        type: `${type_chart}`,
                        data,
                        options: {}
                    };
                    var myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function getQueryProductGroupDate(id="{{$default_id}}"){
        id=parseInt(id);
        let fec_start=$("#id-fec-start").val();
        let fec_end=$("#id-fec-end").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','product-group-get-order-sale')
                @slot('parameters', " 'date_start': fec_start, 'date_end':fec_end ")
                @slot('result_success')
                    $("#chart-id").html("");
                    $("#chart-id").html(`<canvas id="myChart" width="600" height="400"></canvas>`);
                    canvas="myChart";
                    let count_data= new Array();
                    labels=new Array();
                    //construimos los labels
                    //construimos la data
                    for(let item of response){
                        labels.push(item.code);
                        count_data.push(item.cantidad_vendida);
                    }
                    //constriumos los colores
                    for(let row of response){
                        colors.push(colorRGB());
                    }
                    data=new Array();
                    headerTitleGeneral=`${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`;
                    data = {
                            labels: labels,
                            datasets: [{
                            label: `${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`,
                            backgroundColor: colors,
                            borderColor: "White",
                            data: count_data,
                        }]
                    };
                    config = {
                        type: `${type_chart}`,
                        data,
                        options: {}
                    };
                    var myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function getQueryProductDate(){
        let fec_start=$("#id-fec-start").val();
        let fec_end=$("#id-fec-end").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
                @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','product-get-order-sale')
                @slot('parameters', " 'date_start': fec_start, 'date_end':fec_end ")
                @slot('result_success')
                    $("#chart-id").html("");
                    $("#chart-id").html(`<canvas id="myChart" width="600" height="400"></canvas>`);
                    canvas="myChart";
                    labels=new Array();
                    //construimos los labels
                    for(let item of response){
                        labels.push(item.sku);
                    }
                    //asignamos los colores
                    colors=new Array();
                    for(let row of response){
                        colors.push(colorRGB());
                    }
                    //asignamos los datos para el diagrama
                    count_data=new Array();
                    for(let data of response){
                        count_data.push(data.count_product);
                    }
                    data=new Array();
                    data = {
                            labels: labels,
                            datasets: [{
                            label: `${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`,
                            backgroundColor: colors,
                            borderColor: "White",
                            data: count_data,
                        }]
                    };
                    config = {
                        type: `${type_chart}`,
                        data,
                        options: {}
                    };
                    var myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function a() { 

    }
    function getCategoriesLabel(id = "{{$default_id}}", type="pie"){
        id=parseInt(id);
        fec_start=$("#id-fec-start").val();
        fec_end=$("#id-fec-end").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','ld-billing-categorie-sale')
                @slot('parameters', " 'fec_date_start': fec_start, 'fec_date_end':fec_end ")
                @slot('result_success')
                    $("#chart-id").html("");
                    $("#chart-id").html(`<canvas id="myChart" width="600" height="400"></canvas>`);
                    canvas="myChart";
                    //construir el label
                    let count_data=new Array();
                    labels=new Array();
                    for(let item of response){
                        for(let i = 0 ; i<categories.length; i++){
                            if(categories[i][1]==item.category_id){
                                labels.push(categories[i][0]);
                            }
                        }
                    }
                    for(let row of response){
                        count_data.push(row.cantidades);
                    }
                    //colores random de nuestros graficos
                    colors=new Array();
                    for(let item of response){
                        colors.push(colorRGB());
                    }
                    data=new Array();
                    headerTitleGeneral=`${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`;
                    data = {
                            labels: labels,
                            datasets: [{
                            label: `${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`,
                            backgroundColor: colors,
                            borderColor: "White",
                            data: count_data,
                        }]
                    };
                    config = {
                        type: `${type_chart}`,
                        data,
                        options: {}
                    };
                    var myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function sendCanvasSave(format){
        var photo_canvas=document.getElementById(format);
        var blob_canvas=photo_canvas.toDataURL('imgen/jpeg');
        var title_pie=(type_chart=='bar') ? 'Grafico de barras' : 'Grafico de circular';
        var id_status=$("#STATES-ID-select").val();
        var header_title=headerTitleGeneral;
        var date_start=$("#id-fec-start").val();
        var date_end=$("#id-fec-end").val();
        //enviar ajax
        @component(config($group.'.ui.component.engine.ajax-internal.view'))
                @slot('app_group',$group)
                @slot('route','chart-grafics-save-data')
                @slot('parameters', " 'photo':blob_canvas, 'date_start':date_start,'date_end':date_end,'title_pie':title_pie, 'header_title':header_title, 'report':option, 'id_status':id_status ")
                @slot('result_success')
                    window.open(`{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/${response.name_document}`);
                    $id_status=null;
                    $("#STATES-ID-select").val(null);
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    //ventas por cliente
    function getQueryCustomerSate(id = "{{$default_id}}", type="pie"){
        id=parseInt(id);
        let fec_start=$("#id-fec-start").val();
        let fec_end=$("#id-fec-end").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','order-get-customer-date')
                @slot('parameters', " 'date_start': fec_start, 'date_end':fec_end ")
                @slot('result_success')
                    $("#chart-id").html("");
                    $("#chart-id").html(`<canvas id="myChart" width="600" height="400"></canvas>`);
                    canvas="myChart"
                    let count_data= new Array();
                    labels=new Array();
                    for(let row of response){
                        labels.push(row.first_name);
                    }
                    /* console.log(labels); */
                    colors=new Array();
                    for(let item of response){
                        colors.push(colorRGB());
                    }
                    /* console.log(colors); */
                    for(let row of response){
                        count_data.push(row.order_times);
                    }
                    /* console.log(count_data); */
                    data=new Array();
                    headerTitleGeneral=`${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`;
                    data = {
                            labels: labels,
                            datasets: [{
                            label: `${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`,
                            backgroundColor: colors,
                            borderColor: "White",
                            data: count_data,
                        }]
                    };
                    config = {
                        type: `${type_chart}`,
                        data,
                        options: {}
                    };
                    var myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
    function generarNumero(numero){
	    return (Math.random()*numero).toFixed(0);
    }
    function colorRGB(){
	    var coolor = "("+generarNumero(255)+"," + generarNumero(255) + "," + generarNumero(255) +")";
	    return "rgb" + coolor;
    }
    function clearCanvas(){
        $("#chart-id").html("");
    }
    function changeSelect(){
        getQueryOrderStatusOfDate($("#STATES-ID-select").val());
    }
    function getQueryBillingCustomerOfDate(){
        let fec_start=$("#id-fec-start").val();
        let fec_end=$("#id-fec-end").val();
        @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
                @slot('ws_group','entity')
                @slot('ws_name','user-get-billing-of-date')
                @slot('parameters', " 'date_start': fec_start, 'date_end':fec_end ")
                @slot('result_success')
                    console.log(response);
                    $("#chart-id").html("");
                    $("#chart-id").html(`<canvas id="myChart" width="600" height="400"></canvas>`);
                    canvas="myChart";
                    let count_data= new Array();
                    labels=new Array();
                    //construimos los labels
                    //construimos la data
                    for(let item of response){
                        labels.push(item.first_name);
                        count_data.push(item.count_data);
                    }
                    //constriumos los colores
                    for(let row of response){
                        colors.push(colorRGB());
                    }
                    data=new Array();
                    headerTitleGeneral=`${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`;
                    data = {
                            labels: labels,
                            datasets: [{
                            label: `${$("#id-query-option :selected").text()} entre las fechas ${$("#id-fec-start").val()} a ${$("#id-fec-end").val()}`,
                            backgroundColor: colors,
                            borderColor: "White",
                            data: count_data,
                        }]
                    };
                    config = {
                        type: `${type_chart}`,
                        data,
                        options: {}
                    };
                    var myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
                @endslot
                @slot('result_error')
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                @endslot
        @endcomponent
    }
</script>
@endsection