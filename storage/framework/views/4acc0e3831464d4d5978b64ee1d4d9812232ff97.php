<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.types.list.lang');

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
                          <div class="row col-md-12">
                              <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","seleTypeGroup",$lang.'form.filters.lbl_company',true,"col-md-12","fas fa-envelope"); ?>

                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12" style="text-align: right!important;">
                          <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form_register_types" id="btnTypenew" ><?php echo trans($lang.'btn_register'); ?></button>
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
                  <thead></thead>
                  <tbody id="tablebody"></tbody>
              </table>
          </div>
          <div class="card-footer"><?php echo trans($lang.'lbl_results_footer'); ?></div>
      </div>
  </div>
</div>

<!--Modales-->
<?php $__env->startComponent(config($group.'.ui.component.engine.modal.view')); ?>
<?php $__env->slot('modal_id', 'form_register_types'); ?>
<?php $__env->slot('modal_title', strtoupper(trans($lang.'form.register.title'))); ?>;
<?php $__env->slot('modal_class_02','-'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
        <div class="form-group">
            <div class="row col-md-12">
                
                <input type="text" name="idtype" hidden id="idtype">
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","type_group_id",$lang.'form.filters.lbl_company',true,"col-md-12","fas fa-envelope"); ?>

                
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_type_code',true,"col-sm-6"); ?>

                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_type_name',true,"col-md-12"); ?>

            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save_type" style="margin: 5px!important;" id="btnRegister" class="btn btn-success form-control"></button>
                    </div>
                </div>
<?php $__env->endSlot(); ?>
    
<?php echo $__env->renderComponent(); ?>
<!--Modales-->

<!--scrits-->
<!--scrits-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom_scripts'); ?>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script>
    function limpiarForm(){
        $("#idtype").val("<?php echo e($default_id); ?>");
        $("#code").val(null);
        $("#inpValue_name").val(null);
    }
    window.onload=function(){
        LoadTypes();
        LoadTypeGroup();
        //
        $("#seleTypeGroup").on("change", function () {
            let group=$("#seleTypeGroup").val();
            
            if(group.length===0){
                LoadTypes();
            }else{
                LoadTypexGroup(group);
            }
        });
        
    }
    document.getElementById("btnTypenew").addEventListener("click", ()=>{
        limpiarForm();
        $("#form_register_types b").html("<?php echo e(strtoupper(trans($lang.'form.register.title'))); ?>");
        $("#btn_save_type").html("<?php echo e(trans($lang.'form.register.btn_save_Type')); ?>");
        $("#btn_save_type").removeClass("btn-primary");
        $("#btn_save_type").addClass("btn-success");
        $("#idtype").val("<?php echo e($default_id); ?>");
        LoadDataForm(null);
    });
    document.getElementById("btn_save_type").addEventListener("click", ()=>{
        SaveType();
    });
    
    function SaveType(){
        let idtype=$("#idtype").val();
        let tip_group=$("#type_group_id").val();
        let code=$("#code").val();
        let name=$("#name").val();
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','type-register'); ?>
                <?php $__env->slot('parameters'," 'id':idtype, 'type_group_id': tip_group, 'name': name, 'code': code"); ?>
                <?php $__env->slot('result_success'); ?>

                ShowSuccessMessage("<?php echo e(trans($lang.'form.register.msg_title_success')); ?>","<?php echo e(trans($lang.'form.register.msg_description_success')); ?>");
                $("#form_register_types").modal('hide');
                LoadTypes();
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    //cargar tipo grupos
    function LoadTypeGroup(){
        $("#seleTypeGroup").html("");
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','type-group'); ?>
                <?php $__env->slot('parameters', ''); ?>
                <?php $__env->slot('result_success'); ?>
                document.getElementById("seleTypeGroup").innerHTML += `<option value="">Seleccione...</option>`;
                
                    for(let item of response){
                        
                        document.getElementById("seleTypeGroup").innerHTML += `<option value="${item.id}">${item.name_localized}</option>`;
                    }
                $("#seleTypeGroup").select2();
                <?php $__env->endSlot(); ?>
                
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }

    function LoadDataForm(val){
        $("#type_group_id").html("");
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','type-group'); ?>
                <?php $__env->slot('parameters', ''); ?>
                <?php $__env->slot('result_success'); ?>
                
                document.getElementById("type_group_id").innerHTML += `<option value="">Seleccione...</option>`;
                    for(let item of response){
                        if(val == item.id){
                            document.getElementById("type_group_id").innerHTML += `<option value="${item.id}" selected>${item.name_localized}</option>`;
                        }else{
                            document.getElementById("type_group_id").innerHTML += `<option value="${item.id}">${item.name_localized}</option>`;
                        }
                    }
                $("#type_group_id").select2();
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function loadTypeId(id_type){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','type-get'); ?>
                <?php $__env->slot('parameters', " 'type_id': id_type "); ?>
                <?php $__env->slot('result_success'); ?>
                    $("#form_register_types").modal("show");
                    //editar formularios
                    $("#type_group_id").html("");
                    LoadDataForm(response.type_group_id);
                    $("#form_register_types-title").html("<b><?php echo e(trans($lang.'form.edit.title')); ?><b>");
                    $("#btn_save_type").html("<?php echo e(trans($lang.'form.register.btn_update_Type')); ?>");
                    
                    //remover clases
                    $("#btn_save_type").removeClass("btn-success");
                    $("#btn_save_type").addClass("btn-primary");
                    
                    let idtype=response.id;
                    grupo=response.type_group_id;
                    $("#idtype").val("");
                    $("#idtype").val(idtype);
                    $("#name").val(response.name);
                    $('#type_group_id > option[value="'+grupo+'"]').attr('selected', 'selected');
                    $("#code").val(response.code);
                    $("#inpValue_name").val(response.name_localized);
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function LoadTypes(){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','type-get'); ?>
                <?php $__env->slot('parameters', ""); ?>
                <?php $__env->slot('result_success'); ?>
                if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }

                    $("#tbResults >thead").html("");
                    $("#tbResults >tbody").html("");
                        var headers = [];
                        var table_body = "";

                    if(response.legth===0){
                        $("#tbResults >thead").html("<tr><th><?php echo trans($lang.'lbl_default_noresult_title'); ?></th></tr>");
                        $("#tbResults >tbody").html("<tr><td><?php echo trans($lang.'lbl_default_noresult_message'); ?></td></tr>");
                    }else{
                        $("#tbResults >thead").html("<tr>" +
                            "<th><?php echo trans($lang.'result_table.col_type_id'); ?></th>"+
                            "<th><?php echo trans($lang.'result_table.col_type_code'); ?></th>"+
                            "<th><?php echo trans($lang.'result_table.col_type_group'); ?></th>"+
                            "<th><?php echo trans($lang.'result_table.col_type_name'); ?></th>"+
                            "<th><?php echo trans($lang.'result_table.col_options.title'); ?></th>"+
                        "</tr>");
                        for(let item of response){
                        document.getElementById("tablebody").innerHTML += `<tr> <td>${item.id}</td> <td>${item.code}</td> <td>${item.type_group_name_localized}</td> <td>${item.name_localized}</td> <td><div>
                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> <?php echo trans($lang.'result_table.col_options.title'); ?><span class='sr-only'></span>
                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'><a class='dropdown-item' href='#' onclick='loadTypeId(${item.id})'><?php echo trans($lang.'result_table.col_options.edit'); ?></a><a class='dropdown-item' href='#' onclick='DeleteType(${item.id})'><?php echo trans($lang.'result_table.col_options.delete'); ?></a></div>
                            </button>    
                        </div></td></tr>`;
                        }
                    }
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
    function LoadTypexGroup(group){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','type-get'); ?>
                <?php $__env->slot('parameters', " 'type_group_id': group "); ?>
                <?php $__env->slot('result_success'); ?>
                if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                    $("#tbResults >thead").html("");
                        $("#tbResults >tbody").html("");
                        var headers = [];
                        var table_body = "";
                    if(response.legth===0){
                        $("#tbResults >thead").html("<tr><th><?php echo trans($lang.'lbl_default_noresult_title'); ?></th></tr>");
                        $("#tbResults >tbody").html("<tr><td><?php echo trans($lang.'lbl_default_noresult_message'); ?></td></tr>");
                    }else{
                        $("#tbResults >thead").html("<tr>" +
                            "<th><?php echo trans($lang.'result_table.col_type_id'); ?></th>"+
                            "<th><?php echo trans($lang.'result_table.col_type_code'); ?></th>"+
                            "<th><?php echo trans($lang.'result_table.col_type_group'); ?></th>"+
                            "<th><?php echo trans($lang.'result_table.col_type_name'); ?></th>"+
                            "<th><?php echo trans($lang.'result_table.col_options.title'); ?></th>"+
                        "</tr>");
                       
                        for(let item of response){
                        document.getElementById("tablebody").innerHTML += `<tr> <td>${item.id}</td> <td>${item.code}</td> <td>${item.type_group_name_localized}</td> <td>${item.name_localized}</td> <td><div>
                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> <?php echo trans($lang.'result_table.col_options.title'); ?><span class='sr-only'></span>
                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'><a class='dropdown-item' href='#' onclick='loadTypeId(${item.id})'><?php echo trans($lang.'result_table.col_options.edit'); ?></a><a class='dropdown-item' href='#' onclick='DeleteType(${item.id})'><?php echo trans($lang.'result_table.col_options.delete'); ?></a></div>
                            </button>    
                        </div></td></tr>`;
                        }
                    }
                    
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
    function DeleteType(id_type){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','type-delete'); ?>
                <?php $__env->slot('parameters'," 'id': id_type "); ?>
                <?php $__env->slot('result_success'); ?>
                
                ShowSuccessMessage("<?php echo e(trans($lang.'form.delete.msg_title_success')); ?>","<?php echo e(trans($lang.'form.delete.msg_title_success')); ?>");
                $("#form_register_types").modal('hide');
                LoadTypes();
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make(config($group.'.ui.template.main.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/admin/page/types/list.blade.php ENDPATH**/ ?>