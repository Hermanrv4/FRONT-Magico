<?php
use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.electronics.list.lang');
$ruc = config('greenter.ruc');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Facturacion Electronica</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('resources/assets/'.$group.'/main/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/extra/sweetalert2/css/sweetalert2.min.css")}}">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <link rel="stylesheet" href="{{asset("resources/assets/".$group."/own/css/cover.css")}}">
  </head>
  <body class="text-center">
    
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="masthead mb-auto">
    <div class="inner">
    </div>
  </header>

  <main role="main" class="inner cover">
    <div class="text-group my-3">
      <span class="font-weight-bold h2 text-dark">BITZ</span>
    </div>
    <form method="post" class="border px-4 py-3 bg-dark border-dark rounded">
      <h1 class="cover-heading h4">{{ trans($lang.'lbl_header_title') }}</h1>
        <div class="for-group">
          <span id="msg"></span>
            {{-- {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","num_docu",$lang.'form.register.lbl_num_docu',true,"col-sm-5 mx-auto my-4") !!} --}}
            <div class="row mt-3">
                <div class="col-sm-4 container text-center">
                  <label for="">{{ trans($lang.'form.register.lbl_num_docu.title') }}</label>
                </div>
                <div class="col-sm-7 container input-group mb-3">
                  <input type="text" id="num_docu" placeholder="{{trans($lang.'form.register.lbl_num_docu.placeholder')}}" class="form-control">
                  <div class="input-group-append text-center">
                    <i class="input-group-text text-center font-weight-bold">#</i>
                  </div>
                </div>
            </div>
          </div>
          <span id="msg-num-docu"></span>
        <div class="form-group data-document">
         {{--  <div class="row d-flex justify-content-center"> --}}
           {{--  {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","serie_doc",$lang.'form.register.lbl_serie',true,"col-sm-3") !!}
            {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","correla_doc",$lang.'form.register.lbl_correlativo',true,"col-sm-5") !!} --}}
            <div class="row mt-3">
              <div class="col-sm-4 text-center">
                <label for="">Serie y correlativo</label>
              </div>
              <div class="d-flex col-sm-7 justify-content-center container">
                <div class="col-sm-5 input-group container">
                  <input type="text" id="serie_doc" placeholder="{{trans($lang.'form.register.lbl_serie.placeholder')}}" class="form-control">
                  {{-- <div class="input-group-append text-center">
                    <i class="input-group-text text-center font-weight-bold">0</i>
                  </div> --}}
              </div>
              <div class="col-sm-7 container input-group">
                <input type="text" id="correla_doc" placeholder="{{trans($lang.'form.register.lbl_correlativo.placeholder')}}" class="form-control">
                  {{-- <div class="input-group-append text-center">
                    <i class="input-group-text text-center font-weight-bold">12</i>
                  </div> --}}
              </div>
              </div>
            </div>

      {{--     </div> --}}
        </div>
        <span id="msg-date-docu"></span>
        <div class="form-group date-document">
          <div class="row d-flex justify-content-center mt-4">
            <div class="col-sm-4 mr-auto">
              <label for="fec-emi-doc">{{ trans($lang.'form.register.lbl_date_input.title') }}</label>
            </div>
              <div class="col-sm-7 container">
                <input type="date" id="fec-emi-doc" class="form-control" required>
              </div>
          </div>
        </div>
        <span id="msg-tot-docu"></span>
        <div class="form-group tot-document">
          <div class="row d-flex justify-content-center mt-4">
           {{--  {!! \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","tot-document",$lang.'form.register.lbl_tot',true,"col-sm-5") !!} --}}
            <div class="col-sm-4">
              <label for="">{{ trans($lang.'form.register.lbl_tot.title') }}</label>
            </div>
            <div class="col-sm-7 container input-group mb-4">
              <input type="text" id="tot-document" class="form-control" placeholder="{{ trans($lang.'form.register.lbl_tot.placeholder') }}">
              <div class="input-group-append text-center">
                <i class="input-group-text text-center font-weight-bold">12</i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group data-botton">
            <p class="lead">
              <button type="button" class="btn btn-lg btn-secondary button_insert" id="btn-enter">Buscar</button>
            </p>
        </div>
    </form>
  </main>
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
                <div class="card-header bg-dark d-flex">
                    <h3 class="card-title">{!! trans($lang.'lbl_results_header') !!}</h3>
                    <div class="card-tools ml-auto ">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="tbSunatResponse" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                          <th>{!! trans($lang.'result_table.col-num-doc') !!}</th>
                          <th>{!! trans($lang.'result_table.col_tip_doc') !!}</th>
                          <th>{!! trans($lang.'result_table.col_status_doc') !!}</th>
                          {{-- <th>{!! trans($lang.'result_table.col_obs') !!}</th> --}}
                          <th>{!! trans($lang.'result_table.col_options') !!}</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-dark">{!! trans($lang.'lbl_results_footer') !!}</div>
            </div>
        </div>
@endslot
@endcomponent
<!--Modales-->
  <footer class="mastfoot mt-auto">
    <div class="inner">
    </div>
  </footer>
  <script src="{{asset("resources/assets/".$group."/main/plugins/jquery/jquery.min.js")}}"></script>
  <script src="{{asset('resources/assets/'.$group.'/main/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <script src="{{asset("resources/assets/".$group."/main/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
  <script src="{{asset("resources/assets/".$group."/extra/sweetalert2/js/sweetalert2.all.min.js")}}"></script>
  <script src="{{asset("resources/assets/".$group."/own/js/app.js")}}"></script>
  <script>
    $(document).ready(function(){
      $(".data-botton").hide();
      $(".data-document").hide();
      $(".date-document").hide();
      $(".tot-document").hide();
      $(".card-result").hide();
      $(".button_insert").on("click", function(){
        getValue($("#serie_doc").val(), $("#correla_doc").val(), $("#num_docu").val(), $("#tot-document").val(), $("#fec-emi-doc").val());
      }); 
     
      $("#correla_doc").on("keyup", function(){
        let value;
        if(value=onlyNumber($("#correla_doc").val())){
          if($("#serie_doc").val()=="" || $("#serie_doc").val()==null && $("#correla_doc").val()==null || $("#correla_doc").val()==""){
            $(".date-document").hide("slow");
            $("#msg-num-docu").html("<p class='font-weight-bold text-danger'>El correlativo debe estar lleno</p>");
          }else{
            let len=$("#correla_doc").val();
            if(len.length>8){
              $("#msg-num-docu").html("<p class='font-weight-bold text-warning'>El correlativo como maximo son 8 digitos</p>");
              $(".date-document").hide("slow");
            }else{
              $("#msg-num-docu").html("<p class='font-weight-bold text-success'>La serie y correlativos son validas</p>");
              $(".date-document").show("slow");
            }
          }
        }else{
          $("#msg-num-docu").html("<p class='font-weight-bold text-success'>El correlativo solo acepta numeros</p>");
          $(".date-document").hide("slow");
        }
      });
      $("#serie_doc").on("keyup", function(){
        let valor=$("#serie_doc").val();
        if($("#serie_doc").val()=="" || $("#serie_doc").val()==null ){
          $("#msg-num-docu").html("<p class='font-weight-bold text-danger'>Este campo debe de estar lleno</p>");
        }else if(valor.length>4) {
          $("#msg-num-docu").html("<p class='font-weight-bold text-warning'>La serie como maximo son 4 digitos</p>");
        }else{
          $("#msg-num-docu").html("<p class='font-weight-bold text-success'>La serie valida</p>");
        }
      });

      $("#fec-emi-doc").on("change", function(){
        if($("#fec-emi-doc").val()==null || $("#fec-emi-doc").val()==""){
          $("#msg-date-docu").html("<p class='font-weight-bold text-danger'>Debe igresar una fecha</p>");
          $(".tot-document").hide("slow");
        }else{
          let correlativo=$("#correla_doc").val();
          /* let ceros=AddCeros(correlativo, 8); */
          $("#correla_doc").val(AddCeros(correlativo, 8));
          $("#msg-date-docu").html("<p class='font-weight-bold text-success'>correcto</p>");
          $(".tot-document").show("slow");
        }
      });
      
      $("#tot-document").on("keyup", function(){
        if($("#tot-document").val()==null || $("#tot-document").val()==""){
          $("#msg-tot-docu").html("<p class='font-weight-bold text-danger'>El campo no puede estar vacio</p>");
          $(".data-botton").hide("slow");
        }else{
          console.log($("#correla_doc").val());
          if(onlyNumberDecimal($("#tot-document").val())){
            $("#msg-tot-docu").html("<p class='font-weight-bold text-success'>Valor valido</p>")
            $(".data-botton").show("slow");
          }else{
            $("#msg-tot-docu").html("<p class='font-weight-bold text-danger'>Solo acepta numeros, enteros o decimales</p>")
            $(".data-botton").hide("slow");
          }

        }
      });

      $("#num_docu").on("keyup", function(){
        let value=$("#num_docu").val();
        if(value=parseInt(value)){
          //validamos la longitud
          let name=$("#num_docu").val();
          if(name.length<8){

            $("#msg").html("<p class='font-weight-bold text-danger'>Ingrese un valor no menor de 8 digitos</p>");
            $("#btn-enter").attr("disabled", true);
            $(".data-document").hide("slow");
          }else if(name.length>8){
            $("#msg").html("");
            $("#btn-enter").attr("disabled", true);
            $("#msg").html("<p class='font-weight-bold text-warning'>El valor ingresado supera los digitos permitidos</p>");
            $(".data-document").hide("slow");
          }else if(name.length==8){
            $("#msg").html("");
            $("#btn-enter").attr("disabled", false);
            $("#msg").html("<p class='font-weight-bold text-success'>Longitud permitida</p>");
            $(".data-document").show("slow");
          }
        }else{
          alert("solo escriba numeros");
          $("#num_docu").val(null);
        }
      });
    });
    function showResult(param){
        $("#tbSunatResponse tbody").html("");
        let estado=validastatus(param.electronic_billing_sale_status)
        let ruc="{{$ruc}}";
        let query="";
        query=`
              <tr>
                <td>${param.electronic_billing_sale_serie}</td>
                <td>${param.electronic_billing_sale_correlative}</td>  
                <td>${estado}</td>
                <td>
                  <div class="row">
                        <a type="button" class="btn btn-success col-sm-4" title="Descargar CDR" href="{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/FE/cdr/R-${ruc}-03-${param.electronic_billing_sale_serie}-${param.electronic_billing_sale_correlative}.zip" download="R-${ruc}-03-${param.electronic_billing_sale_serie}-${param.electronic_billing_sale_correlative}.zip">
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </a>
                        <a type="button" class="btn btn-warning col-sm-4" title="DESCARGAR XML" href="{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/FE/xml/${ruc}-03-${param.electronic_billing_sale_serie}-${param.electronic_billing_sale_correlative}.xml" download="${ruc}-03-${param.electronic_billing_sale_serie}-${param.electronic_billing_sale_correlative}.xml">
                            <i class="fa fa-code" aria-hidden="true"></i>
                        </a>
                        <a type="button" class="btn btn-danger col-sm-4" title="DESCARGAR PDF" href="{{App\Http\Common\Services\RouteService::GetSiteURL('landing')}}/storage/app/FE/pdf/${ruc}-03-${param.electronic_billing_sale_serie}-${param.electronic_billing_sale_correlative}.pdf" target="_blank" rel="noopener">
                            <i class="fa fa-file-pdf" aria-hidden="true"></i>
                        </a>
                      </div>  
                </td>
              </tr>`;
          $("#tbSunatResponse tbody").append(query);
          /* $("#tbSunatResponse").d */
          $("#form-response-sunat").modal("show");
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
    function AddCeros(value, cant){
      ceros="";
      if(value.length<cant){
        let resta=cant-value.length;
       /*  console.log(value.length); */
        for(let i=0; i<resta; i++){
          ceros=ceros+"0";
          /* console.log(ceros); */
        }
      }
      return `${ceros}${value}`;
    }
    function getValue(serie, correlativo, dni, total, fecha){
      @component(config($group.'.ui.component.engine.ajax.view'))
        @slot('app_group',$group)
        @slot('ws_group','entity')
        @slot('ws_name','order-get-all-billed')
        @slot('parameters', " 'serie': serie, 'correlative': correlativo, 'dni':dni, 'total': total, 'fec_emision':fecha ")
        @slot('result_success')                   
            if(response.electronic_billing_sale_serie==serie && response.electronic_billing_sale_correlative==correlativo){
              showResult(response);
            }else{
              ShowErrorMessage("Boleta no registrada", "La boleta que se encuentra buscando no se encuentra");
            }
        @endslot
        @slot('result_error')
            ShowFormErrors(null,null,response,[]);
            HideFullLoading();
        @endslot
      @endcomponent 
    }
    let patter=/^([0-9])*$/;
    let twoPatterm=/^[0-9]+([.])?([0-9]+)?$/;
    function onlyNumber(val){
      if(patter.test(val)){
        return true;
      }else{
        return false;
      }
    }
    function onlyNumberDecimal(val){
      if(twoPatterm.test(val)){
        return true;
      }else{
        return false;
      }
    }
  </script>
</div>
  </body>
</html>