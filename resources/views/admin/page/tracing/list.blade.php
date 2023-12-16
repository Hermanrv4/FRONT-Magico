<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.tracing.list.lang');

$default_id = ParameterService::GetParameter("default_id");
$show_list=ApiService::Request($group, 'entity', 'parameter-get-codes', ["code"=>"show_list"])->response;
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
                <i class="fa fa-user-secret mr-2" aria-hidden="true"></i>  
                {!! trans($lang.'page_title') !!} {{ $user==null ? '' : " de ".$user["first_name"]." ".$user["last_name"] }}</h1>
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
                        <div class="text-center">
                            <h1 id="title-text-charts" class="h4 font-weight-bold">
                                {{ strtoupper(trans($lang.'query.section_visit.title')) }}        
                            </h1>
                        </div>
                      <div class="row">
                          <div id="selects" class="col-md-9 p-3 border">
                                <canvas id="bar-chart" width="800" height="450"></canvas>
                          </div>
                          <div class="col-3 p-4 my-auto">
                            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","show_list",$lang.'form.register.lbl_show_list',true,"col-md-12","fas fa-envelope") !!}
                            <br>    
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
                                    <a class="nav-link active" onclick="loadChart(1,'{{ strtoupper(trans($lang.'query.section_visit.title')) }}')" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ strtoupper(trans($lang.'query.section_visit.title')) }}</a>
                                    <a class="nav-link" onclick="loadChart(2,'{{ strtoupper(trans($lang.'query.product_preview.title')) }}')" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ strtoupper(trans($lang.'query.product_preview.title')) }}</a>
                                    <a class="nav-link" onclick="loadChart(3,'{{ strtoupper(trans($lang.'query.product_addcard.title')) }}')" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ strtoupper(trans($lang.'query.product_addcard.title')) }}</a>
                                    <a class="nav-link" onclick="loadChart(5, '{{ strtoupper(trans($lang.'query.category_visit_page.title')) }}')" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">{{ strtoupper(trans($lang.'query.category_visit_page.title')) }}</a>
                                    @if (isset($user))
                                        
                                    @else
                                        <a class="nav-link" onclick="loadChart(4,'{{strtoupper(trans($lang.'query.user_not_register_visit_page.title'))}}')" id="v-pills-for-tab" data-toggle="pill" href="#v-pills-for" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                            {{strtoupper(trans($lang.'query.user_not_register_visit_page.title'))}}
                                        </a>
                                        <a class="nav-link" onclick="loadResultOfDate(6,'{{strtoupper(trans($lang.'query.category_visit_page_user_null.title'))}}')" id="v-pills-for-tab" data-toggle="pill" href="#v-pills-for" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                            {{strtoupper(trans($lang.'query.category_visit_page_user_null.title'))}}
                                        </a>
                                    @endif
                                </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12" style="text-align: right!important;">
                        
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
            <div class="text-center mx-auto">
                <h3 class="h3 font-weight-bold">
                    {{ strtoupper(trans($lang.'query.title')) }}
                </h3>
                <div class="row">
                    <div class="my-auto mx-auto">
                        <button type="button" onclick="loadResult('bar', 'chart')" class="btn btn-primary font-weight-bold text-uppercase mx-2">
                            <i class="{{trans($lang.'query.button.btn-chart-bar.icon')}}"></i>
                            {{ trans($lang.'query.button.btn-chart-bar.title') }}
                        </button>
                        <button type="button" onclick="loadResult('pie', 'chart')" class="btn btn-danger font-weight-bold text-uppercase mx-2">
                            <i class="{{trans($lang.'query.button.btn-chart-pie.icon')}}"></i>
                            {{ trans($lang.'query.button.btn-chart-pie.title') }}
                        </button>
                        <button hidden type="button" onclick="loadResult('radar', 'chart')" class="btn btn-warning font-weight-bold text-uppercase mx-2">
                            <i class="{{trans($lang.'query.button.btn-chart-radar.icon')}}"></i>
                            {{ trans($lang.'query.button.btn-chart-radar.title') }}
                        </button>
                        <button type="button" onclick="loadResult('excel', 'report')" class="btn btn-success font-weight-bold text-uppercase mx-2">
                            <i class="{{trans($lang.'query.button.btn-excel.icon')}}"></i>
                            {{ trans($lang.'query.button.btn-excel.title') }}
                        </button>
                    </div>
                </div>
                <div class="row mt-3 justify-content-center">
                    <div class="form-group">
                        <input type="date" class="form-control" id="date_start">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="date_end">
                    </div>
                </div>
            </div>
            <div class="text-center mx-auto">
                <div class="row">
                    <div class="col-sm-9 py-3">
                        <div id="section_id" class="m-2 border p-2">
                            <canvas id="radar-chart" width="800" height="600"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-3 my-auto">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
                            <a class="nav-link active" onclick="loadResultOfDate(1,'{{ strtoupper(trans($lang.'query.section_visit_of_date.title')) }}')" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                {{ strtoupper(trans($lang.'query.section_visit_of_date.title')) }}</a>
                            <a class="nav-link" onclick="loadResultOfDate(2,'{{ strtoupper(trans($lang.'query.product_preview_of_date.title')) }}')" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                {{ strtoupper(trans($lang.'query.product_preview_of_date.title')) }}</a>
                            <a class="nav-link" onclick="loadResultOfDate(3,'{{ strtoupper(trans($lang.'query.product_addcard_of_date.title')) }}')" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                {{ strtoupper(trans($lang.'query.product_addcard_of_date.title')) }}</a>
                            <a class="nav-link" onclick="loadResultOfDate(5, '{{ strtoupper(trans($lang.'query.category_visit_page_of_date.title')) }}')" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                {{ strtoupper(trans($lang.'query.category_visit_page_of_date.title')) }}</a>
                            @if (isset($user))
                            @else
                                <a class="nav-link" onclick="loadResultOfDate(4,'{{strtoupper(trans($lang.'query.user_not_register_visit_page_of_date.title'))}}')" id="v-pills-for-tab" data-toggle="pill" href="#v-pills-for" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                    {{strtoupper(trans($lang.'query.user_not_register_visit_page_of_date.title'))}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="card-footer">{!! trans($lang.'lbl_results_footer') !!}</div>
      </div>
  </div>
</div>
{{-- segunda tarjeta --}}
<!--Modales-->
@endsection
@section('bottom_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
        var id_user="{{ $user==null ? null : $user['id'] }}";
        var show_list="{{ $show_list==null ? 5 : $show_list }}";
        var report=1;
        var option=null;
        var type_chart="bar";
        $(document).ready(function (){
            loadChart(1, "{{ strtoupper(trans($lang.'query.section_visit.title')) }}");
            loadResultOfDate(report);
            $("#date_start").on("change", function(){
                loadResultOfDate(report);
            });
            $("#date_end").on("change", function(){
                loadResultOfDate(report);
            });
            loadShowList(parseInt(show_list));
            // detectar evento del combo box
            $("#show_list").on("change", function(){
                show_list=$("#show_list").val();
                loadChart(report);
            });
        });
        function loadChart(charts, title=null){
            report=charts;
            setTitlePage(title);
            switch(charts){
                case 1:
                    if(id_user==''){
                        getQueryVisitPage();
                    }else{
                        getQueryVisitPageOfUser();
                    }
                break;
                case 2:
                    if(id_user==''){
                        getQueryPreviewProduc();
                    }else{
                        getQueryPreviewProducOfUser();
                    }
                break;
                case 3:
                    if(id_user==''){
                        getQueryAddCardProduct();
                    }else{
                        getQueryAddCardProductOfUser();
                    }
                break;
                case 4:
                    getQueryVisitUserPage();
                break;
                case 5:
                    if(id_user==''){
                        getQueryCategorieVisit();
                    }else{
                        getQueryCategorieVisitOfUser();
                    }
                break;
            }
        }
        function loadResultOfDate(typeChart, title=null){
            report=typeChart;
            if(id_user==''){
                    switch (typeChart){
                        case 1:
                            getQueryVisitPageOfDate();
                        break;
                        case 2:
                            getQueryPreviewProducOfDate();
                        break;
                        case 3:
                            getQueryAddCardProductOfDate();
                        break;
                        case 4:
                            getQueryVisitUserPageOfDate();
                        break;
                        case 5:
                            getQueryCategorieVisitOfDate();
                        break;
                        case 6:
                            getQueryCategorieVisitUserNull();
                        break;
                }
            }else{
                switch (typeChart){
                    case 1:
                        getQueryVisitPageOfDateUser();
                    break;
                    case 2:
                        getQueryPreviewProducOfDateForUser();
                    break;
                    case 3:
                        getQueryAddCardProductOfUserForDate();
                    break;
                    case 4:
                        getQueryVisitUserPageOfDate();
                    break;
                    case 5:
                        getQueryCategorieVisitOfUserForDate();
                    break;
                }
            }
        }
        //radar
        new Chart(document.getElementById("radar-chart"), {
        type: 'radar',
        data: {
            labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
            datasets: [
                {
                label: "1950",
                fill: true,
                backgroundColor: "rgba(179,181,198,0.2)",
                borderColor: "rgba(179,181,198,1)",
                pointBorderColor: "#fff",
                pointBackgroundColor: "rgba(179,181,198,1)",
                data: [8.77,55.61,21.69,6.62,6.82]
                }, {
                label: "2050",
                fill: true,
                backgroundColor: "rgba(255,99,132,0.2)",
                borderColor: "rgba(255,99,132,1)",
                pointBorderColor: "#fff",
                pointBackgroundColor: "rgba(255,99,132,1)",
                pointBorderColor: "#fff",
                data: [25.48,54.16,7.61,8.06,4.45]
                }
            ]
        },
            options: {
            title: {
                display: true,
                text: 'Distribution in % of world population'
                }
            }
        });
        //end radar
        function loadResult(type=null, text=null){
            if(text=="chart"){
                type_chart=type;
            }
            loadResultOfDate(report);
        }
        function loadShowList(int){
            let query=``;
            let string=null;
            let number=0;
            let list_number=new Array();
            for(let i=0; i<int; i++){
                number=number+int;
                list_number.push(number);
            }
            for(let a=0; a<list_number.length; a++){
                query=`${query}<option value="${list_number[a]}">${list_number[a]}</option>`;
            }
            query=`${query}<option value="all">Mostrar Todo</option>`;
            $("#show_list").append(query);
        }
        function getQueryVisitPage(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
                    @slot('ws_group','entity')
                    @slot('ws_name','tracing-get-data-or-date')
                    @slot('parameters', " 'show_list': show_list ")
                    @slot('result_success')
                        let tracing_chart= (response.length>6 ? 'pie' : 'bar');
                        let label=new Array();
                        let data_count=new Array();
                        let color=new Array();
                        for(item of response){
                            label.push(item.section);
                            data_count.push(item.count_section);
                            color.push(colorRGB());
                        }
                        clearCanvas($("#selects"));
                        new Chart(document.getElementById("bar-chart"), {
                        type: tracing_chart,
                        data: {
                        labels: label,
                            datasets: [
                                {
                                label: "Population (millions)",
                                backgroundColor: color,
                                data: data_count,
                                }
                            ]
                        },
                            options: optionsConstruc(tracing_chart)
                        });
                    @endslot
                    @slot('result_error')
                        ShowFormErrors(null,null,response,[]);
                    @endslot
            @endcomponent
        }
        function getQueryPreviewProduc(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-preview-or-date')
            @slot('parameters', " 'show_list':show_list ")
            @slot('result_success')
                let tracing_chart=(response.length>6 ? 'pie' : 'bar');
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.name_product);
                    data_count.push(item.count_preview);
                    color.push(colorRGB());
                }
                clearCanvas($("#selects"));
                new Chart(document.getElementById("bar-chart"), {
                type: tracing_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(tracing_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryAddCardProduct(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-addCard-or-date')
            @slot('parameters', " 'show_list':show_list ")
            @slot('result_success')
                let tracing_chart=(response.length>6 ? 'pie' : 'bar');
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.name_product);
                    data_count.push(item.count_addcard);
                    color.push(colorRGB());
                }
                clearCanvas($("#selects"));
                new Chart(document.getElementById("bar-chart"), {
                type: tracing_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(tracing_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryVisitUserPage(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-visit-page-usernull')
            @slot('parameters', " 'show_list':show_list ")
            @slot('result_success')
                let tracing_chart= (response.length>6 ? 'pie' : 'bar');
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.section);
                    data_count.push(item.count_vist);
                    color.push(colorRGB());
                }
                clearCanvas($("#selects"));
                new Chart(document.getElementById("bar-chart"), {
                type: tracing_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(tracing_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent 
        }
        function getQueryCategorieVisit(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-visit-category')
            @slot('parameters', " 'show_list':show_list ")
            @slot('result_success')
                let tracing_chart= (response.length>6 ? 'pie' : 'bar');
                //labels
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.category_name);
                    data_count.push(item.count_category);
                    color.push(colorRGB());
                }
                //limpiamos
                clearCanvas($("#selects"));
                new Chart(document.getElementById("bar-chart"), {
                type: tracing_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(tracing_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent 
        }
        function getQueryCategorieVisitUserNull(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-category-visit-usernull')
            @slot('parameters', " 'show_list':show_list ")
            @slot('result_success')
                let tracing_chart= (response.length>6 ? 'pie' : 'bar');
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.category_name);
                    data_count.push(item.count_vist);
                    color.push(colorRGB());
                }
                clearCanvas($("#selects"));
                new Chart(document.getElementById("bar-chart"), {
                type: tracing_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(tracing_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent 
        }
        function clearCanvas(obj, title_canva=null){
            obj.html("");
            let canvas=`<canvas id="${title_canva==null ? 'bar-chart' : title_canva}" width="800" height="450"></canvas>`;
            obj.html(canvas);
        }
        function generarNumero(numero){
	        return (Math.random()*numero).toFixed(0);
        }
        function colorRGB(){
            var coolor = "("+generarNumero(255)+"," + generarNumero(255) + "," + generarNumero(255) +")";
            return "rgb" + coolor;
        }
        function setTitlePage(title){
            $("#title-text-charts").html('');
            $("#title-text-charts").html(title)
        }
        //consultas por fechas
        function getQueryVisitPageOfDate(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-data-or-date')
            @slot('parameters', " 'date_start':date_start, 'date_end':date_end ")
            @slot('result_success')
                console.log(response);
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.section);
                    data_count.push(item.count_section);
                    color.push(colorRGB());
                }
                //limpiamos
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryPreviewProducOfDate(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-preview-or-date')
            @slot('parameters', " 'date_start': date_start, 'date_end':date_end ")
            @slot('result_success')
                console.log(response);
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.sku);
                    data_count.push(item.count_preview);
                    color.push(colorRGB());
                }
                //limpiamos
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryAddCardProductOfDate(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-addCard-or-date')
            @slot('parameters', " 'date_start':date_start, 'date_end':date_end ")
            @slot('result_success')
                //labels
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.sku);
                    data_count.push(item.count_addcard);
                    color.push(colorRGB());
                }
                //limpiamos
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryCategorieVisitOfDate(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-visit-category')
            @slot('parameters', " 'date_start':date_start, 'date_end':date_end ")
            @slot('result_success')
                console.log(response);
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.category_name);
                    data_count.push(item.count_category);
                    color.push(colorRGB());
                }
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent 
        }
        function getQueryVisitUserPageOfDate(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-visit-page-usernull')
            @slot('parameters', " 'date_start':date_start , 'date_end':date_end ")
            @slot('result_success')
                /* console.log(response); */
                //labels
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.section);
                    data_count.push(item.count_vist);
                    color.push(colorRGB());
                }
                //limpiamos
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent 
        }
        function optionsConstruc(type){
            if(type=='bar'){
                return option={scales:{
                        yAxes:[{
                            ticks:{
                                beginAtZero:true
                            }
                        }]
                    },
                    legend: { display: false },
                    title: {
                        display: false,
                        text: 'Predicted world population (millions) in 2050'
                        }};
            }else{
                return null;
            }
        }
        //funciones por user
        function getQueryVisitPageOfUser(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
                    @slot('ws_group','entity')
                    @slot('ws_name','tracings-get-visit-page-for-user')
                    @slot('parameters', " 'id_user':id_user ")
                    @slot('result_success')
                        console.log(response);
                        //labels
                        let label=new Array();
                        let data_count=new Array();
                        let color=new Array();
                        for(item of response){
                            label.push(item.section);
                            data_count.push(item.count_section);
                            color.push(colorRGB());
                        }
                        /* console.log(label);
                        console.log(data_count); */
                        //limpiamos
                        clearCanvas($("#selects"));
                        new Chart(document.getElementById("bar-chart"), {
                        type: 'bar',
                        data: {
                        labels: label,
                            datasets: [
                                {
                                label: "Population (millions)",
                                backgroundColor: color,
                                data: data_count,
                                }
                            ]
                        },
                            options: {
                            scales:{
                                yAxes:[{
                                    ticks:{
                                        beginAtZero:true
                                    }
                                }]
                            },
                            legend: { display: false },
                            title: {
                                display: false,
                                text: 'Predicted world population (millions) in 2050'
                                },
                            }
                        });
                    @endslot
                    @slot('result_error')
                        ShowFormErrors(null,null,response,[]);
                    @endslot
            @endcomponent
        }
        function getQueryPreviewProducOfUser(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-preview-for-user')
            @slot('parameters', " 'id_user':id_user ")
            @slot('result_success')
                console.log(response);
                //labels
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.sku);
                    data_count.push(item.count_prod);
                    color.push(colorRGB());
                }
                /* console.log(label);
                console.log(data_count); */
                //limpiamos
                clearCanvas($("#selects"));
                new Chart(document.getElementById("bar-chart"), {
                type: 'bar',
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: {
                    scales:{
                        yAxes:[{
                            ticks:{
                                beginAtZero:true
                            }
                        }]
                    },
                    legend: { display: false },
                    title: {
                        display: false,
                        text: 'Predicted world population (millions) in 2050'
                        },
                    }
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryAddCardProductOfUser(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-addcard-for-user')
            @slot('parameters', " 'id_user':id_user ")
            @slot('result_success')
                /* console.log(response); */
                //labels
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.sku);
                    data_count.push(item.count_prod);
                    color.push(colorRGB());
                }
                /* console.log(label);
                console.log(data_count); */
                //limpiamos
                clearCanvas($("#selects"));
                new Chart(document.getElementById("bar-chart"), {
                type: 'bar',
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: {
                    scales:{
                        yAxes:[{
                            ticks:{
                                beginAtZero:true
                            }
                        }]
                    },
                    legend: { display: false },
                    title: {
                        display: false,
                        text: 'Predicted world population (millions) in 2050'
                        },
                    }
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryCategorieVisitOfUser(){
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-category-visit-for-user')
            @slot('parameters', " 'id_user':id_user ")
            @slot('result_success')
                console.log(response);
                //labels
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.category_name);
                    data_count.push(item.count_value);
                    color.push(colorRGB());
                }
                /* console.log(label);
                console.log(data_count); */
                //limpiamos
                clearCanvas($("#selects"));
                new Chart(document.getElementById("bar-chart"), {
                type: 'bar',
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: {
                    scales:{
                        yAxes:[{
                            ticks:{
                                beginAtZero:true
                            }
                        }]
                    },
                    legend: { display: false },
                    title: {
                        display: false,
                        text: 'Predicted world population (millions) in 2050'
                        },
                    }
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent 
        }
        // funciones por usurios y fechas
        function getQueryVisitPageOfDateUser(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracings-get-visit-page-for-user')
            @slot('parameters', " 'id_user':id_user, 'date_start':date_start, 'date_end':date_end ")
            @slot('result_success')
                console.log(response);
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.section);
                    data_count.push(item.count_section);
                    color.push(colorRGB());
                }
                //limpiamos
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryPreviewProducOfDateForUser(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-preview-for-user')
            @slot('parameters', " 'id_user':id_user,'date_start': date_start, 'date_end':date_end ")
            @slot('result_success')
                console.log(response);
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.sku);
                    data_count.push(item.count_prod);
                    color.push(colorRGB());
                }
                //limpiamos
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryAddCardProductOfUserForDate(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-addcard-for-user')
            @slot('parameters', " 'id_user':id_user, 'date_start':date_start, 'date_end':date_end ")
            @slot('result_success')
                /* console.log(response); */
                //labels
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.sku);
                    data_count.push(item.count_prod);
                    color.push(colorRGB());
                }
                /* console.log(label);
                console.log(data_count); */
                //limpiamos
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent
        }
        function getQueryCategorieVisitOfUserForDate(){
            let date_start=$("#date_start").val();
            let date_end=$("#date_end").val();
            @component(config($group.'.ui.component.engine.ajax.view'))
            @slot('app_group',$group)
            @slot('ws_group','entity')
            @slot('ws_name','tracing-get-category-visit-for-user')
            @slot('parameters', " 'id_user':id_user, 'date_start':date_start, 'date_end':date_end ")
            @slot('result_success')
                //labels
                let label=new Array();
                let data_count=new Array();
                let color=new Array();
                for(item of response){
                    label.push(item.category_name);
                    data_count.push(item.count_value);
                    color.push(colorRGB());
                }
                clearCanvas($("#section_id"), 'chart-of-date');
                new Chart(document.getElementById("chart-of-date"), {
                type: type_chart,
                data: {
                labels: label,
                    datasets: [
                        {
                        label: "Population (millions)",
                        backgroundColor: color,
                        data: data_count,
                        }
                    ]
                },
                    options: optionsConstruc(type_chart)
                });
            @endslot
            @slot('result_error')
                ShowFormErrors(null,null,response,[]);
            @endslot
            @endcomponent 
        }
    </script>
@endsection