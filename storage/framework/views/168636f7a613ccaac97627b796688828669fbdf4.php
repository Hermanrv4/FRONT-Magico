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

<?php $__env->startSection('page_title',trans($lang.'page_title')); ?>
<?php $__env->startSection('metas',''); ?>
<?php $__env->startSection('top_scripts'); ?>
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/datatable/datatables.min.css")); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/datatable/Buttons-1.6.1/css/buttons.dataTables.min.css")); ?>"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")); ?>">
    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<div class="content-header">
  <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?php echo trans($lang.'page_title'); ?></h1>
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
                          <div id="selects" class="row col-md-12">
                            <!-- <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","root_ubication",$lang.'form.filters.lbl_currency',true,"col-md-12","fas fa-envelope"); ?> -->
                            <div id="view">
                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12" style="text-align: right!important;">
                          <!-- <button class="btn btn-dark col-md-2" id="btnsearch" style="margin: 5px!important;"><?php echo trans($lang.'btn_search'); ?></button> -->
                          <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form_register_currency" id="btnSaveUbication" ><?php echo trans($lang.'btn_register'); ?></button>  
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
          <div class="card-body">
              <table id="tbResults" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                  <thead>
                    <th><?php echo trans($lang.'result_table.col_id'); ?></th>
                    <th><?php echo trans($lang.'result_table.col_name'); ?></th>
                    <th><?php echo trans($lang.'result_table.col_code'); ?></th>
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
<?php $__env->slot('modal_id', 'form_register_currency'); ?>
<?php $__env->slot('modal_title', strtoupper(trans($lang.'form.register.title'))); ?>;
<?php $__env->slot('modal_class_02','-'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
        <div class="form-group">
            <div class="row col-md-12" id="content">
                
                <div id="divUbication" class="col-md-12">

                </div>
                <input type="text" name="defaultid" hidden id="defaultid">
                <input type="text" name="defaultroot" hidden id="defaultroot">
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","nameroot",$lang.'form.register.lbl_name_root',true,"col-md-12","fas fa-envelope"); ?>

                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code_ubication',true,"col-md-12","fas fa-envelope"); ?>

                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name_ubication',true,"col-md-12"); ?>

            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save" style="margin: 5px!important;" class="btn btn-success form-control"></button>
                    </div>
                </div>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<!--Modales-->
<!--Modales-->
<?php $__env->startComponent(config($group.'.ui.component.engine.modal.view')); ?>
<?php $__env->slot('modal_id', 'form-shipping-price'); ?>
<?php $__env->slot('modal_title', strtoupper(trans($lang.'form.register.title'))); ?>;
<?php $__env->slot('modal_class_02','modal-lg'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
<div class="content">
  <div class="container-fluid">
          <div class="card card-dark">
              <div class="card-header">
                  <h3 class="card-title"><?php echo trans($lang.'lbl_header_currency.create'); ?></h3>
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
                                    <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("checkbox","idBtnSaveAll",$lang.'form.register.lbl_ubication_all',true,"col-md-5","fas fa-envelope"); ?>

                                    <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("checkbox","is_static",$lang.'form.register.lbl_static_price',true,"col-md-5","fas fa-envelope"); ?>

                                </div>
                                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_price","price",$lang.'form.register.lbl_price',true,"col-md-12","fas fa-envelope"); ?>

                                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","min_days",$lang.'form.register.lbl_min_days',true,"col-md-12","fas fa-envelope"); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: right!important;">
                                <button class="btn btn-success col-md-2" id="btn_save_prices" style="margin: 5px!important;"><?php echo trans($lang.'btn_save_price'); ?></button>
                                <button class="btn btn-dark col-md-2" id="btn_clear_prices" style="margin: 5px!important;"><?php echo trans($lang.'btn_clear'); ?></button>
                            </div>
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
          <div class="card-body">
              <table id="table-prices" width="100%" class="table table-bordered table-hover display nowrap" cellspacing="0">
                  <thead>
                    <th><?php echo trans($lang.'result_table_prices.col_id'); ?></th>
                    <th><?php echo trans($lang.'result_table_prices.col_currency'); ?></th>
                    <th><?php echo trans($lang.'result_table_prices.col_code'); ?></th>
                    <th><?php echo trans($lang.'result_table_prices.col_price'); ?></th>
                    <th><?php echo trans($lang.'result_table_prices.col_options.title'); ?></th>
                  </thead>
                  <tbody id=""></tbody>
              </table>
          </div>
          <div class="card-footer"><?php echo trans($lang.'lbl_results_footer'); ?></div>
      </div>
  </div>
</div>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<!--Modales-->
<!--scrits-->
<script>
    
    window.onload=function(){
        $("#is_static").addClass("form-control");
        $("#inp-container-is_static div.inp-error-display").addClass("text-center");
        $("#idBtnSaveAll").addClass("form-control");
        $("#inp-container-idBtnSaveAll div.inp-error-display").addClass("text-center")
        LoadUbication("<?php echo e($default_id); ?>");
        LoadUbicationView("<?php echo e($default_id); ?>");
        $("#defaultid").val("<?php echo e($default_id); ?>");
        $("#defaultroot").val("<?php echo e($default_id); ?>");
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
                messageWarning("<?php echo e(trans($lang.'lbl_default_info_message')); ?>", "<?php echo e(trans($lang.'lbl_default_info')); ?>");
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
        $("#defaultid").val("<?php echo e($default_id); ?>");
        $("#defaultroot").val("<?php echo e($default_id); ?>");
        $("#form_register_currency-title b").html("<?php echo e(strtoupper(trans($lang.'form.register.title'))); ?>");
        $("#btn_save").html("<?php echo e(trans($lang.'form.register.btn_save')); ?>");
        $("#btn_save").removeClass("btn-primary");
        $("#btn_save").addClass("btn-success");
        $("#divUbication").html("");
        loadUbicationForm("<?php echo e($default_id); ?>");
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
                LoadUbication("<?php echo e($default_id); ?>");
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
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ubication-root-get'); ?>
                <?php $__env->slot('parameters'," 'root_ubication_id': id_root "); ?>
                <?php $__env->slot('result_success'); ?>
                
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
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
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
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ubication-register'); ?>
                <?php $__env->slot('parameters'," 'id': idubication, 'root_ubication_id': root, 'name': name, 'code': code"); ?>
                <?php $__env->slot('result_success'); ?>
                ShowSuccessMessage("<?php echo e(trans($lang.'form.register.msg_title_success')); ?>","<?php echo e(trans($lang.'form.register.msg_description_success')); ?>");
                $("#form_register_types").modal('hide');
                LoadUbication(root);
                /* setTimeout(Refrescar, 2000); */
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function LoadUbicationId(id){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ubication-get'); ?>
                <?php $__env->slot('parameters', " 'ubication_id': id "); ?>
                <?php $__env->slot('result_success'); ?>
                    $("#form_register_currency").modal("show");
                    nivel=0;
                    $("#divUbication").html("");
                    loadUbicationForm("<?php echo e($default_id); ?>");

                    //editar formularios
                    if(response.root_ubication_id==null){
                        $("#defaultroot").val("<?php echo e($default_id); ?>")
                    }else{
                        $("#defaultroot").val(response.root_ubication_id)
                    }
                    $("#form_register_currency-title").html("<b><?php echo e(trans($lang.'form.edit.title')); ?><b>");
                    $("#btn_save").html("<?php echo e(trans($lang.'form.register.btn_update')); ?>");
                    ubicationroot(response.root_ubication_id, $("#nameroot"));
                    //remover clases
                    $("#btn_save").removeClass("btn-success");
                    $("#btn_save").addClass("btn-primary");
                    $("#defaultid").val(response.id);
                    $("#code").val(response.code);
                    $("#inpValue_name").val(response.name_localized);
                    $("#name").val(response.name);
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function ubicationroot(id, input){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ubication-get'); ?>
                <?php $__env->slot('parameters', " 'ubication_id': id "); ?>
                <?php $__env->slot('result_success'); ?>
                    
                    input.val(response.name_localized);
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function LoadUbicationView(id){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ubication-root-get'); ?>
                <?php $__env->slot('parameters'," 'root_ubication_id': id "); ?>
                <?php $__env->slot('result_success'); ?>
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
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function LoadUbication(root_id){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ubication-root-get'); ?>
                <?php $__env->slot('parameters', " 'root_ubication_id': root_id"); ?>
                <?php $__env->slot('result_success'); ?>
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
                                <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> <?php echo trans($lang.'result_table.options.title'); ?><span class='sr-only'></span>
                                    <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                    <a class='dropdown-item' href='#' onclick='LoadUbicationId(${item.id})'><?php echo trans($lang.'result_table.options.edit'); ?></a>
                                    <a class='dropdown-item' href='#' onclick='modalshipping(${item.id})'><?php echo trans($lang.'result_table.options.price'); ?></a>
                                    <a class='dropdown-item' href='#' onclick='DeleteUbication(${item.id}, ${item.root_ubication_id})'><?php echo trans($lang.'result_table.options.delete'); ?></a>
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
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function DeleteUbication(iddata, root){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ubication-delete'); ?>
                <?php $__env->slot('parameters'," 'id': iddata "); ?>
                <?php $__env->slot('result_success'); ?>
                ShowSuccessMessage("<?php echo e(trans($lang.'form.delete.msg_title_success')); ?>","<?php echo e(trans($lang.'form.delete.msg_title_success')); ?>");
                if(root==null || root=="" || root == "null"){
                    root="<?php echo e($default_id); ?>";
                }
                LoadUbication(root);
                /* setTimeout(Refrescar, 2000); */
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
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
        $("#defaultshipping").val("<?php echo e($default_id); ?>");
        $("#form-shipping-price").modal("show");
    }
    function addPrices(idubication, idshipping, moneda, estatico, dias, precio){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ShippingPrice-Register'); ?>
                <?php $__env->slot('parameters'," 'id':idshipping, 'ubication_id':idubication, 'currency_id':moneda, 'price':precio, 'min_days':dias, 'is_static':estatico "); ?>
                <?php $__env->slot('result_success'); ?>
                    ShowSuccessMessage("<?php echo e(trans($lang.'form.register.msg_title_success')); ?>","<?php echo e(trans($lang.'form.register.msg_description_success')); ?>");
                    clearPrices();
                    loadShipingPrice(idubication);
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function addPricesList(idubication, moneda, estatico, dias, precio){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','shipping-price-update'); ?>
                <?php $__env->slot('parameters',"  'ubication_id':idubication, 'currency_id':moneda, 'price':precio, 'min_days':dias, 'is_static':estatico "); ?>
                <?php $__env->slot('result_success'); ?>
                    ShowSuccessMessage("<?php echo e(trans($lang.'form.register.msg_title_success')); ?>","<?php echo e(trans($lang.'form.register.msg_description_success')); ?>");
                    loadShipingPrice(idubication)
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                console.log(data);
                    ShowFormErrors(null,null,response,[]);
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function clearPrices(){
        $("#defaultshipping").val("<?php echo e($default_id); ?>");
        $("#is_static").prop("checked", false);
        $("#min_days").val(null);
        $("#price").val(null);
        $("#idBtnSaveAll").prop("checked", false);
    }
    function loadpricesid(id){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ShippingPrice-Get'); ?>
                <?php $__env->slot('parameters'," 'shipping_price_id': id "); ?>
                <?php $__env->slot('result_success'); ?>
                console.log(response);
                    $("#defaultubication").val(response.ubication_id);
                    $("#defaultshipping").val(response.id);
                    $("#currency_id_price").val(response.currency_id);
                    ChangeInputPrice('price', response.currency_id);
                    (response.is_static===0)? $("#is_static").prop("checked", false) : $("#is_static").prop("checked", true);
                    $("#min_days").val(response.min_days);
                    $("#price").val(response.price);
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function loadShipingPrice(id){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ShippingPrice-Get'); ?>
                <?php $__env->slot('parameters'," 'ubication_id': id "); ?>
                <?php $__env->slot('result_success'); ?>
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
                                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> <?php echo trans($lang.'result_table.options.title'); ?><span class='sr-only'></span>
                                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                <a class='dropdown-item' href='#' onclick='loadpricesid(${item.id})'><?php echo trans($lang.'result_table_prices.col_options.edit'); ?></a>
                                                <a class='dropdown-item' href='#' onclick='deletePrices(${item.id})'><?php echo trans($lang.'result_table_prices.col_options.delete'); ?></a>
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
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function deletePrices(id){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ShippingPrice-Delete'); ?>
                <?php $__env->slot('parameters'," 'id': id "); ?>
                <?php $__env->slot('result_success'); ?>
                    console.log(response);
                    ShowSuccessMessage("<?php echo e(trans($lang.'form.delete.msg_title_success')); ?>","<?php echo e(trans($lang.'form.delete.msg_description_success')); ?>");
                    loadShipingPrice($("#defaultubication").val());
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
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
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','ubication-root-get'); ?>
                <?php $__env->slot('parameters'," 'root_ubication_id': id_root "); ?>
                <?php $__env->slot('result_success'); ?>
                /* console.log(response); */
                let query="";
                    query=query+`<option value="-1">Seleccione</option>`;
                    for(let item of response[0]){
                        query=query+`<option value="${item.id}">${item.name_localized}</option>`;
                    }
                    $("#ubicaciones").append(query);
                    $("#ubicaciones").select2();
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
</script>
<!--scrits-->
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config($group.'.ui.template.main.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/admin/page/ubication/list.blade.php ENDPATH**/ ?>