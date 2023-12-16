<?php

use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Session;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.suscriber.list.lang');

$default_id = ParameterService::GetParameter("default_id");

/* $objAdmin = \App\Http\Modules\Admin\Helpers\AppHelper::GetAdminData();
$is_internal_user = $objAdmin["company_id"]==null; */
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
                          <button class="btn btn-success col-md-2" style="margin: 5px!important;" data-toggle="modal" data-target="#form-register-subs" id="btnopenform" ><?php echo trans($lang.'btn_register'); ?></button>  
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
                    <th scope="col"><?php echo trans($lang.'result_table.col_id'); ?></th>
                    <th scope="col"><?php echo trans($lang.'result_table.col_email'); ?></th>
                    <th scope="col"><?php echo trans($lang.'result_table.col_info'); ?></th>
                    <th scope="col"><?php echo trans($lang.'result_table.col_options'); ?></th>
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
<?php $__env->slot('modal_title', strtoupper(trans($lang.'form.register.title'))); ?>;
<?php $__env->slot('modal_class_02','-'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
        <div class="form-group">
            <div class="row col-md-12" id="content">
                
                <input type="text" name="defaultid" hidden id="defaultid">
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","email",$lang.'form.register.lbl_email_suscriber',true,"col-md-12","fas fa-envelope"); ?>

                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","info",$lang.'form.register.lbl_info_suscriber',true,"col-md-12"); ?>

            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save" style="margin: 5px!important;" id="btnRegister" class="btn btn-success form-control"><?php echo trans($lang.'form.register.btn_save'); ?></button>
                    </div>
                </div>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<!--Modales-->

<!--scrits-->
<script>
    

    window.onload=function(){
        loadData("<?php echo e($default_id); ?>");
    }
    document.getElementById("btnopenform").addEventListener("click", function(){
        /* $("#defaultid").val("<?php echo e($default_id); ?>"); */
        clearInput();
    });
    document.getElementById("btn_save").addEventListener("click", function () {
        SaveData();
    });
    function SaveData(){
        let id=$("#defaultid").val();
        let email=$("#email").val();
        let info=$("#info").val();
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','suscriber-register'); ?>
                <?php $__env->slot('parameters'," 'id': id, 'email': email, 'info_suscriber': info " ); ?>
                <?php $__env->slot('result_success'); ?>
                ShowSuccessMessage("<?php echo e(trans($lang.'form.register.msg_title_success')); ?>","<?php echo e(trans($lang.'form.register.msg_description_success')); ?>");
                $("#form-register-subs").modal('hide');
                loadData();
                /* setTimeout(Refrescar, 2000); */
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function loadData(id){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','suscriber-get'); ?>
                <?php $__env->slot('parameters', " 'subscriber_id' : id "); ?>
                <?php $__env->slot('result_success'); ?>
                    if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                        let table = $('#tbResults').DataTable();
                        table.destroy();
                    }
                        let query="";
                        $("#tablebody").html("");
                        for(let item of response){
                        query=query+`<tr> 
                        <td>${item.id}</td> 
                        <td>${item.email}</td>`
                        if(item.info_suscriber==null){
                            query=query+`<td>SIN OBSERVACIONES...</td>`;
                        }else{
                            query=query+`<td>${item.info_suscriber}</td>`
                        }
                        query=query+`<td><div>
                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> <?php echo trans($lang.'result_table.options.title'); ?><span class='sr-only'></span>
                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                <a class='dropdown-item' href='#' onclick='LoadDataId(${item.id})'><?php echo trans($lang.'result_table.options.edit'); ?></a>
                                <a class='dropdown-item' href='#' onclick='deletedata(${item.id})'><?php echo trans($lang.'result_table.options.delete'); ?></a>
                                </div>
                            </button>    
                        </div></td></tr>`;
                        }
                        $("#tablebody").append(query);
                    $('#root_ubication').select2();
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
    function LoadDataId(id){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
            <?php $__env->slot('ws_group','entity'); ?>
            <?php $__env->slot('ws_name','suscriber-get'); ?>
            <?php $__env->slot('parameters', " 'suscriber_id':id "); ?>
            <?php $__env->slot('result_success'); ?>
                $("#form-register-subs-title").html("<?php echo e(trans($lang.'form.edit.title')); ?>")
                $("#btn_save").html("<?php echo e(trans($lang.'form.edit.btn')); ?>");
                $("#email").val(response.email);
                $("#defaultid").val(response.id);
                $("#info").val(response.info_suscriber);
                $("#form-register-subs").modal("show")
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('result_error'); ?>
                ShowFormErrors(null,null,response,[]);
                HideFullLoading();
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function deletedata(iddata){
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
            <?php $__env->slot('ws_group','entity'); ?>
            <?php $__env->slot('ws_name','suscriber-delete'); ?>
            <?php $__env->slot('parameters'," 'id': iddata "); ?>
            <?php $__env->slot('result_success'); ?>
            
            ShowSuccessMessage("<?php echo e(trans($lang.'form.delete.msg_title_success')); ?>","<?php echo e(trans($lang.'form.delete.msg_title_success')); ?>");
            /* setTimeout(Refrescar, 2000); */
            loadData();
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('result_error'); ?>

                ShowFormErrors(null,null,response,[]);
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }
    function Refrescar(){
    location.reload();
    }
    function clearInput() {
        $("#email").val(null);
        $("#defaultid").val("<?php echo e($default_id); ?>");
        $("#info").val(null);
        //estilos
        $("#form-register-subs-title").html("<?php echo e(trans($lang.'form.register.title')); ?>")
        $("#btn_save").html("<?php echo e(trans($lang.'btn_register')); ?>");
    }
</script>
<!--scrits-->
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config($group.'.ui.template.main.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/admin/page/suscriber/list.blade.php ENDPATH**/ ?>