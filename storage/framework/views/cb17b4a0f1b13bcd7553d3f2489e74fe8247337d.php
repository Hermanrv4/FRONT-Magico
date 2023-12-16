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

<?php $__env->startSection('page_title',trans($lang.'page_title')); ?>
<?php $__env->startSection('metas',''); ?>
<?php $__env->startSection('top_scripts'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/datatable/datatables.min.css")); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/datatable/Buttons-1.6.1/css/buttons.dataTables.min.css")); ?>"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")); ?>">
    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<div class="content-header">
  <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 text-dark">
                <i class="fa fa-leaf" aria-hidden="true"></i>  
                <?php echo trans($lang.'page_title'); ?></h1>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#"><?php echo trans($lang.'page_title'); ?></a></li>
              </ol>
          </div>
      </div>
  </div>
</div>


<div class="content">
  <div class="container-fluid">
      
          <div class="card card-dark">
              <div class="card-header">
                  <h3 class="card-title"><?php echo trans($lang.'lbl_filters_header'); ?></h3>
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
                                        <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","currency",$lang.'form.register.lbl_currency_fe',true,""); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: right!important;">
                            
                        </div>
                    </div>
                </div>
              </div>
              <div class="card-footer"><?php echo trans($lang.'lbl_filters_footer'); ?></div>
          </div>
      <div class="card card-dark">
          <div class="card-header">
              <h3 class="card-title"><?php echo trans($lang.'lbl_results_header'); ?></h3>
              <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
          </div>
          <div class="card-body table-responsive">
              <table id="tbResults" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                  <thead>
                    <th><?php echo trans($lang.'result_table.col_id'); ?></th>
                    
                    
                    <th><?php echo trans($lang.'result_table.col_customer'); ?></th>
                    <th><?php echo trans($lang.'result_table.col_currency'); ?></th>
                    <th><?php echo trans($lang.'result_table.col_base_imponible'); ?></th>
                    <th><?php echo trans($lang.'result_table.col_monto_tot'); ?></th>
                    <th><?php echo trans($lang.'result_table.col_fec_emi'); ?></th>
                    <th><?php echo trans($lang.'result_table.col_status_doc'); ?></th>
                    <th>ESTADO DE PAGO</th>
                    
                    <th><?php echo trans($lang.'result_table.col_options'); ?></th>
                  </thead>
                  <tbody id="tablebody"></tbody>
              </table>
          </div>
          <div class="card-footer"><?php echo trans($lang.'lbl_results_footer'); ?></div>
      </div>
  </div>
</div>

<!--Modales-->
<?php $__env->startComponent(config($group.'.ui.component.engine.modal.view')); ?>
<?php $__env->slot('modal_id', 'form-register-subs'); ?>
<?php $__env->slot('modal_title', strtoupper(trans($lang.'page_title'))); ?>
<?php $__env->slot('modal_class_02','-'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
        <div class="form-group">
            <div class="row col-md-12" id="content">
                
                <input type="text" name="defaultid" hidden id="defaultid">
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code',true,"col-md-12"); ?>

                
                <div class="row container">
                    <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name',true,"col-md-12"); ?>

                </div>
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save" style="margin: 5px!important;" id="btnRegister" class="btn btn-success form-control"> </button>
                    </div>
                </div>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<!--Modales-->


<!--Modal para el correo electronico-->
<?php $__env->startComponent(config($group.'.ui.component.engine.modal.view')); ?>
<?php $__env->slot('modal_id', 'form-send-email'); ?>
<?php $__env->slot('modal_title', strtoupper(trans($lang.'lbl_send_msg'))); ?>;
<?php $__env->slot('modal_class_02','modal-md'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
        <div class="form-group">
            <div class="row">
                <input type="text" hidden id="id_user_email">
                <input type="text" hidden id="id_order_email">
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","email",$lang.'form.register.lbl_email',true,"col-md-12"); ?>

            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button style="margin: 5px!important;" id="btn-send" class="btn btn-success form-control">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            <?php echo trans($lang.'btn_send_email'); ?>

                        </button>
                    </div>
                </div>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<!--Modales-->
<!--Modal para la respuesta de sunat-->
<?php $__env->startComponent(config($group.'.ui.component.engine.modal.view')); ?>
<?php $__env->slot('modal_id', 'form-response-sunat'); ?>
<?php $__env->slot('modal_title', strtoupper(trans($lang.'lbl_response_sunat'))); ?>;
<?php $__env->slot('modal_class_02','modal-lg'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
        <div class="form-group">
            <div class="card card-dark container">
                <div class="card-header">
                    <h3 class="card-title"><?php echo trans($lang.'lbl_results_header'); ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="tbSunatResponse" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                          <th><?php echo trans($lang.'result_table.col_id'); ?></th>
                          <th><?php echo trans($lang.'result_table.col-num-doc'); ?></th>
                          
                          <th><?php echo trans($lang.'result_table.col_status_doc'); ?></th>
                         
                          <th><?php echo trans($lang.'result_table.col_options'); ?></th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer"><?php echo trans($lang.'lbl_results_footer'); ?></div>
            </div>
        </div>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<!--Modales-->

<!--Modales-->
<!--Modal para generar un documento-->
<?php $__env->startComponent(config($group.'.ui.component.engine.modal.view')); ?>
<?php $__env->slot('modal_id', 'form-generate-sunat'); ?>
<?php $__env->slot('modal_title', strtoupper(trans($lang.'lbl_generate_doc'))); ?>;
<?php $__env->slot('modal_class_02','modal-lg'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
        <div class="container">
            <form action="" method="post" id="form-generate-doc">
                <div class="form-group" id="form-header-doc">
                    
                    <div class="form-group border container my-3 p-3">
                        <div class="row">
                            <input type="text" hidden id="order_id">
                            <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","name_customer",$lang.'form.register.lbl_full_name',true,"col-md-8"); ?>

                            
                            <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","num_doc",$lang.'form.register.lbl_doc_customer',true,"col-md-4"); ?>

                            
                            
                            
                        </div>
                        <div class="row  my-3 d-flex justify-content-around">
                            <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","currency_form",$lang.'form.register.lbl_currency_fe',true,"col-md-4"); ?>

                            <div class="form-group col-sm-4">
                                <label for="#fec-date-emi"><?php echo e(trans($lang.'form.register.lbl_fec_emi.title')); ?></label>
                                <input type="date" class="form-control" id="fec-date-emi">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","phone_customer",$lang.'form.register.lbl_phone_customer',true,"col-md-5"); ?>

                            <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","email_customer",$lang.'form.register.lbl_email',true,"col-md-7"); ?>

                        </div>

                    </div>
                    <div class="row border container my-3 p-3 d-flex justify-content-around">
                        
                        
                    </div>
                </div>
                <div class="form-group" id="form-detail-doc">
                    <table width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col"><?php echo e(trans($lang.'result_detail.col_id')); ?></th>
                                <th><?php echo e(trans($lang.'result_detail.col_codigo')); ?></th>
                                <th><?php echo e(trans($lang.'result_detail.col_name_prod')); ?></th>
                                <th><?php echo e(trans($lang.'result_detail.col_precio')); ?></th>
                                <th><?php echo e(trans($lang.'result_detail.col_cant')); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="row border container my-3 p-3 d-flex justify-content-around">
                    <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","sub_total",$lang.'form.register.lbl_sub_tot',true,"col-md-3"); ?>

                    <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","cost_envio",$lang.'form.register.lbl_cost_envio',true,"col-md-3"); ?>

                    <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","total",$lang.'form.register.lbl_tot',true,"col-md-3"); ?>

                </div>
            </form>
        </div>
<?php $__env->endSlot(); ?>
<?php $__env->slot('modal_footer'); ?>
    <div class="row container my-3 d-flex justify-content-around">
        <button id="btn-save-document" type="button" class="btn btn-success" onclick="generateBilling()" >
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
            <?php echo e(trans($lang.'btn_send_doc')); ?>

        </button>
        <button id="btn-cancel-document" type="button" class="btn btn-danger" onclick="invoidedBilling()" >
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
            <?php echo e(trans($lang.'btn_cance_doc')); ?>

        </button>
        <button type="button" class="btn btn-warning" onclick="closeModal()">
            <i class="fa fa-ban" aria-hidden="true"></i>
            <?php echo e(trans($lang.'btn_cancel_doc')); ?> 
        </button>
    </div>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<!--Modales-->
<!--scrits-->
<script>
    

    window.onload=function(){
        loadData("<?php echo e($default_id); ?>");
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
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','currency-get'); ?>
                <?php $__env->slot('parameters', ""); ?>
                <?php $__env->slot('result_success'); ?>
                    obj.html("");
                    let query="";
                    query=`<option value="-1"><?php echo e(trans($lang.'lbl_default_select')); ?></option>`;
                    for(let item of response){
                        query=query+`<option value="${item.id}">${item.name_localized + " - " + item.symbol}</option>`;
                    }
                    obj.append(query);
                    obj.select2();
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function closeModal(){
        $("#form-generate-sunat").modal("hide");
    }
    function loadFilter(date=null, currency=null){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','order-billed-get-filter'); ?>
                <?php $__env->slot('parameters', " 'fec_emision': date, 'currency': currency"); ?>
                <?php $__env->slot('result_success'); ?>
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
                                                    <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> <?php echo trans($lang.'result_table.options.title'); ?><span class='sr-only'></span>
                                                        <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                            <a class='dropdown-item' href='#' onclick='generateDoc(${row.id}, ${row.electronic_billing_sale_status})'>
                                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                                                <?php echo trans($lang.'result_table.options.generate'); ?></a>
                                                            <a class='dropdown-item' href='#' onclick='responseSunat(${row.id})'>
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                                <?php echo trans($lang.'result_table.options.cdr'); ?></a>
                                                            <a class='dropdown-item' href='#' onclick='sendEmail(${row.id}, ${row.electronic_billing_sale_status})'>
                                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                <?php echo trans($lang.'result_table.options.send-email'); ?> </a>
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
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
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
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                /* <?php $__env->slot('ws_name','order-get'); ?> */
                <?php $__env->slot('ws_name','order-get-all-billed'); ?>
                <?php $__env->slot('parameters', "  "); ?>
                <?php $__env->slot('result_success'); ?>;
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
                                                    <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> <?php echo trans($lang.'result_table.options.title'); ?><span class='sr-only'></span>
                                                        <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                            <a class='dropdown-item' href='#' onclick='generateDoc(${row.id}, ${row.electronic_billing_sale_status}, ${anulado}, ${row.electronic_billing_sale_is_voided})'>
                                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                                                <?php echo trans($lang.'result_table.options.generate'); ?></a>
                                                            <a class='dropdown-item' href='#' onclick='responseSunat(${row.id})'>
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                                <?php echo trans($lang.'result_table.options.cdr'); ?></a>
                                                            <a class='dropdown-item' href='#' onclick='sendEmail(${row.id}, ${row.electronic_billing_sale_status})'>
                                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                <?php echo trans($lang.'result_table.options.send-email'); ?> </a>
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
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
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
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','electronic-billing-sale-get'); ?>
                <?php $__env->slot('parameters', "  'order_id':ide "); ?>
                <?php $__env->slot('result_success'); ?>                   
                    $("#tbSunatResponse tbody").html("");
                    console.log(response);
                    let query="";
                    let ruc="<?php echo e($ruc); ?>";
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
                                            <a type="button" class="btn btn-success col-sm-4" title="Descargar CDR" href="<?php echo e(App\Http\Common\Services\RouteService::GetSiteURL('landing')); ?>/storage/app/FE/cdr/${zipname}" download="${zipname}">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            <a type="button" class="btn btn-warning col-sm-4" title="DESCARGAR XML" href="<?php echo e(App\Http\Common\Services\RouteService::GetSiteURL('landing')); ?>/storage/app/FE/xml/${xmlname}" download="${xmlname}.xml">
                                                <i class="fa fa-file-code" aria-hidden="true"></i>
                                            </a>
                                            <a type="button" class="btn btn-danger col-sm-4" title="DESCARGAR PDF" href="<?php echo e(App\Http\Common\Services\RouteService::GetSiteURL('landing')); ?>/storage/app/FE/pdf/${pdfname}" target="_blank" rel="noopener">
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
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?> 
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
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax-internal.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
            <?php $__env->slot('route','send-electronic-billing'); ?>
            <?php $__env->slot('parameters', "'order_id':order_id"); ?>
            <?php $__env->slot('result_success'); ?>
                var contenido = `<p>${response['resultado']}</p>`;
                if (response['obs'] != '') {
                    contenido += response['obs'];
                }
                ShowSuccessMessage(message,contenido);
                $("#form-generate-sunat").modal("hide");
                loadData("");
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('result_error'); ?>
                if (response['error'] == null || response['error'].length == 0) {
                    ShowErrorMessage('Ocurrio un error','');
                }
                ShowErrorMessage(message,response['error']['error_code']+' '+response['error']['error_message']);
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function invoidedBilling(){
        var order_id = $('#order_id').val();
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax-internal.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
            <?php $__env->slot('route','send-invoided-billing'); ?>
            <?php $__env->slot('parameters', "'order_id':order_id"); ?>
            <?php $__env->slot('result_success'); ?>
                var contenido = `<p>${response['resultado']}</p>`;
                if (response['obs'] != '') {
                    contenido += response['obs'];
                }
                ShowSuccessMessage(message,contenido);
                $("#form-generate-sunat").modal("hide");
                loadData("");
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('result_error'); ?>
                ShowErrorMessage(message,response['error']['error_code']+' '+response['error']['error_message']);
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function loadHeader(ide){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
            <?php $__env->slot('ws_group','entity'); ?>
            <?php $__env->slot('ws_name','order-get'); ?>
            <?php $__env->slot('parameters', " 'order_id': ide "); ?>
            <?php $__env->slot('result_success'); ?>
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
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('result_error'); ?>
                ShowFormErrors(null,null,response,[]);
                HideFullLoading();
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
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
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','order-get'); ?>
                <?php $__env->slot('parameters', " 'order_id': id "); ?>
                <?php $__env->slot('result_success'); ?>
                    //damos los valores
                    $("#id_user_email").val(response.user_id);
                    let data=JSON.parse(response.receiver_info);
                    /* console.log(response); */
                    $("#email").val(data["receiver_email"]);
                    $("#id_order_email").val(response.id)
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function sendEmailDocument(email, iduser, idorder){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax-internal.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
               /*  <?php $__env->slot('ws_group','entity'); ?> */
                <?php $__env->slot('route','send-email-document'); ?>
                <?php $__env->slot('parameters', " 'email':email, 'id':iduser , 'id_order':idorder "); ?>
                <?php $__env->slot('result_success'); ?>
                   $("#form-send-email").modal("hide");
                   ShowSuccessMessage("Correo enviado", "Enviamos el correo solicitado");
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function getOrderDetail(id){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','order-detail-get'); ?>
                <?php $__env->slot('parameters', " 'order_id':id "); ?>
                <?php $__env->slot('result_success'); ?>
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
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }

    function Refrescar(){
        location.reload();
    }
</script>
<!--scrits-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config($group.'.ui.template.main.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/admin/page/generate-fe/list.blade.php ENDPATH**/ ?>