<?php
    use App\Http\Common\Services\ApiService;
    use Illuminate\Support\Facades\Session;
    use \App\Http\Common\Services\ParameterService;

    $group = config('env.app_group_admin');
    $lang = config($group.'.ui.page.categories.list.lang');

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
                            
                            <div id="select">
                            </div>
                             
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12" style="text-align: right!important;">
                          
                          <button class="btn btn-success col-md-2" style="margin: 5px!important;" onclick="OpenForm(<?php echo $default_id; ?>);"><?php echo trans($lang.'btn_register'); ?></button> 
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
                    <tr>
                        <th scope="col"><?php echo trans($lang.'result_table.col_id'); ?></th>
                        <th scope="col"><?php echo trans($lang.'result_table.col_code'); ?></th>
                        <th scope="col"><?php echo trans($lang.'result_table.col_name'); ?></th>
                        <th scope="col"><?php echo trans($lang.'result_table.col_code_localized'); ?></th>
                        <th scope="col"><?php echo trans($lang.'result_table.col_options'); ?></th>
                    </tr>
                </thead>
                  <tbody id="tablebody">
                  
                  </tbody>
              </table>
          </div>
          <div class="card-footer"><?php echo trans($lang.'lbl_results_footer'); ?></div>
      </div>
  </div>
</div>
<!--Modales-->




<?php $__env->startComponent(config($group.'.ui.component.engine.modal.view')); ?>
<?php $__env->slot('modal_id', 'form_register_categories'); ?>
<?php $__env->slot('modal_title', ''); ?>;
<?php $__env->slot('modal_class_02','-'); ?>
<?php $__env->slot('modal_class_04', 'bg-dark'); ?>
<?php $__env->slot('modal_body'); ?>
        <div class="form-group">
            <div class="row col-md-12">
                <div id="view" class="row col-md-12">     
                </div>
                
                <input type="text" name="defaultid" hidden id="defaultid">
                <input type="text" name="defaultroot" hidden id="defaultroot">
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","namecategoryroot",$lang.'form.register.lbl_root_categories',true,"col-md-12","fas fa-envelope"); ?>

                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","code",$lang.'form.register.lbl_code_categories',true,"col-md-8","fas fa-envelope"); ?>

                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_checkbox_spinner","show_menu",$lang.'form.register.lbl_show_menu',true,"mt-2 mb-2 pt-4 col-md-4"); ?>

                
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","url_code",$lang.'form.register.lbl_urlcode_cotegorie',true,"col-md-12"); ?>

                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","name",$lang.'form.register.lbl_name_categorie',true,"col-md-12"); ?>

                <form id="form-img" class="col-md-12" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_image","img",$lang.'form.register.lbl_name_image',true,"col-md-12"); ?>

                        <div class="text-center">
                            <input type="text" hidden name="status-image" id="status-image">
                            <img id="img-preview" class="img-thumbnail">
                        </div>
                        <div id="text-delete">

                        </div>
                    </form>
            </div>
        </div>
                    <div class="col-sm-12" id="secBtn" style="text-align: right!important;">
                        <button id="btn_save" style="margin: 5px!important;" class="btn btn-success form-control"><?php echo trans($lang.'form.register.btn_save'); ?></button>
                    </div>
                </div>
<?php $__env->endSlot(); ?>
    
<?php echo $__env->renderComponent(); ?>
<!--Modales-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom_scripts'); ?>
<script>

    var date=new Date();
    var diff="";
        window.onload=function(){
            console.log("<?php echo e($group); ?>");
            $("#inp-btn-load-img").attr("hidden", true);
            loadData("<?php echo e($default_id); ?>");
            loadDataSelect("<?php echo e($default_id); ?>");
            $("#status-image").val("false");
            $("#file-image").on("change", function(file){
                let image=document.getElementById("file-image");
                console.log(image.files);
                validarImg(image.files);
            });
            $("#btn_save").on("click", function(){
                SaveData();
            });
            $("#file-img").on("change", function(){
                let img=document.getElementById("file-img");
                renamevalidate(img, $("#img"), $("#inp-btn-load-img"));
                if(img.files.length = 0){
    
                }else{
                    previewImage(img.files[0]);
                }
            });
            $("#file-img").on('change', function(){
                upImageAjax();
            });
            $("#inp-btn-delete-img").click(function (e){
                e.preventDefault();
                $("#status-image").val("false");
                $("#img-preview").attr("src", "");
                InsertDel();
            });
            $("#inp-btn-search-img").click(function (e) { 
                e.preventDefault();
            });
            $("#inpValue_name").on("focus", function(){
                let urlcode=$("#inpValue_url_code").val();
                let code=$("#code").val();
                $("#inpValue_url_code").val("");
                let string=`${urlcode}-${code}`;
                $("#inpValue_url_code").val(string);
            });
        }
        function previewImage(files){
            let urlpreview= URL.createObjectURL(files);
            $("#img-preview").attr("src", urlpreview);
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax-internal.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('route','delete-image-categories'); ?>
                <?php $__env->slot('parameters', " 'name-delete':name "); ?>
                <?php $__env->slot('result_success'); ?>
                    ShowSuccessMessage("Imagen Eliminada", "<?php echo e(trans($lang.'form.delete.msg_description_success')); ?>")
                    $("#img").val(null);
                    $("#status-image").val("true");
                    $("#file-img").val(null);
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function InsertDel(){
            let input="";
            let name=$("#img").val();
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax-internal_formdata.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('route','upload-image-categories'); ?>
                <?php $__env->slot('parameters', " formulario "); ?>
                <?php $__env->slot('result_success'); ?>
                    ShowSuccessMessage("Imagen Guardada", "<?php echo e(trans($lang.'form.register.msg_description_success')); ?>")
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function upImageAjax(){
            let formulario=new FormData(document.getElementById("form-img"));
            console.log("<?php echo e($group); ?>");
            
        }
    //open form
    function OpenForm(id){
        //mostrar
        nivel=0;
        $("#view").html("");
        $("#status-image").val("false");
        LoadDataForm("<?php echo e($default_id); ?>", "<?php echo e($default_id); ?>");
        $("#form_register_categories-title").html("<?php echo e(strtoupper(trans($lang.'form.register.title'))); ?>");
        $("#namecategoryroot").attr("readonly", "readonly");
        $("#defaultroot").val("<?php echo e($default_id); ?>");
        $("#defaultid").val("<?php echo e($default_id); ?>");
        $("#namecategoryroot").attr("readonly", "readonly");
        $("#form_register_categories").modal("show");
        $("#img-preview").attr("src", "");
        $("#img").val(null)
        limpiarForm();
    }
    //contadoras
    var nivel=0;
        //select form
        function LoadDataForm(id){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','category-root-get'); ?>
                    <?php $__env->slot('parameters', " 'root_category_id': id "); ?>
                    <?php $__env->slot('result_success'); ?>
                        let query="";
                        if(response.length>0){
                            nivel++;
                            query=query+'<div id="nivel-'+nivel+'" style="padding-bottom: 10px!important;padding-right: 0px;padding-left: 0px" class="col-md-12">';
                            query=query+'<label>NIVEL '+nivel+'</label>';
                            query=query+'<select class="form-control" id=row-'+nivel+' onchange="changeSelectForm(\'' + nivel + '\')">';
                            query=query+'<option value="-1"> -- Seleccione -- </option>';
                        for(let item of response){
                                    query+=`<option value="${item.id}">${item.name_localized}</option>`;
                            }
                            query=query+'</select></div>';
                        }else{
                        }
                        $("#view").append(query);
                        $("#row-"+nivel).select2();
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('result_error'); ?>
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function changeSelectForm(id){
            deleteUbicationForm(id);
            nivel=id;
            if($("#row-"+id).val()<0){
                $("#defaultroot").val(-1);
            }else{
                LoadDataForm($("#row-"+id).val());
                $("#defaultroot").val($("#row-"+id).val());
                $("#namecategoryroot").val($("#row-"+id+" option:selected").text());
                
            }
        }
        function deleteUbicationForm(id)
        {
            if(id==null){
                nivel=0;
                
            }else{
                var level=$("#row-"+id).parent().closest("div").attr("id");
                level=parseInt(level.replace("nivel-", ""));
                for(let i=level+1; i<=nivel; i++){
                    $("#nivel-"+i).remove();
                }
                //level=parseInt(level.);
            }
        }
        //funcion para obtener los registros en total
        function loadData(id){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','category-root-get'); ?>
                    <?php $__env->slot('parameters', " 'root_category_id':id  "); ?>
                    <?php $__env->slot('result_success'); ?>
                        if ( $.fn.dataTable.isDataTable('#tbResults') ) {
                            let table = $('#tbResults').DataTable();
                            table.destroy();
                        }
                        /* console.log(response); */
                        let query="";
                        for(let item of response){
                            query+=`<tr>
                                        <td>${item.id}</td>
                                        <td>${item.code}</td>
                                        <td>${item.name_localized}</td>
                                        <td>${item.url_code_localized}</td>
                                        <td><div>
                                            <button class="btn btn-sm btn-danger dropdown-toggle dropdown-icon tb-btn-group" onclick="" data-toggle='dropdown' style='z-index: 100!important;'> <?php echo trans($lang.'result_table.options.title'); ?><span class='sr-only'></span>
                                                <div class='dropdown-menu' role='menu' x-placement='bottom-start'>
                                                    <a class='dropdown-item' href='#' onclick='LoadDataId(${item.id})'><?php echo trans($lang.'result_table.options.edit'); ?></a>
                                                    <a class='dropdown-item' href='#' onclick='DeleteData(${item.id}, ${item.root_category_id})'><?php echo trans($lang.'result_table.options.delete'); ?></a>
                                                </div>
                                            </button>    
                                            </div>
                                        </td>
                                    </tr>`;
                        }
                        $("#tablebody").html(query);
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
        //save data
        function SaveData(){
            let name=$("#name").val();
            let code=$("#code").val();
            let droot=$("#defaultroot").val();
            let did=$("#defaultid").val();
            let durlcode=$("#url_code").val();
            let banner=$("#img").val();
            let show_menu=($("#estatus-show_menu").is(":checked") == true) ? 1 : 0;
            console.log(show_menu);
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','category-register'); ?>
                    <?php $__env->slot('parameters', " 'id': did,  'code':code ,'root_category_id':droot, 'name':name, 'url_code': durlcode, 'banner':banner, 'show_menu': show_menu "); ?>
                    <?php $__env->slot('result_success'); ?>
                        ShowSuccessMessage("<?php echo e(trans($lang.'form.register.msg_title_success')); ?>","<?php echo e(trans($lang.'form.register.msg_description_success')); ?>");
                        $("#form_register_categories").modal('hide');
                        loadData(droot);
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('result_error'); ?>
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function loadFather(id){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','category-get'); ?>
                    <?php $__env->slot('parameters', " 'category_id': id "); ?>
                    <?php $__env->slot('result_success'); ?>
                        $("#namecategoryroot").val(response.name_localized);
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('result_error'); ?>
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        //funcion para obtener los registros por id
        function LoadDataId(id){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
            <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','category-get'); ?>
                    <?php $__env->slot('parameters', " 'category_id': id "); ?>
                    <?php $__env->slot('result_success'); ?>
                        console.log(response);
                        limpiarForm();
                        nivel=0;
                        $("#view").html("");
                        $("#defaultid").val(response.id);
                        $("#defaultroot").val( (response.root_category_id===null) ? '-1': response.root_category_id);
                        let route="<?php echo e(App\Http\Common\Services\RouteService::GetSiteURL('landing')); ?>/storage/app/loaded/img/categories/"+response.banner;
                        $("#img-preview").attr("src", route);
                        $("#img").val(response.banner);
                        $("#status-image").val("true");
                        /* $("#defaultroot").val(-1); */
                        $("#namecategoryroot").attr("readonly", "readonly");
                        $("#code").val(response.code);
                        $("#inpValue_url_code").val(response.url_code_localized);
                        $("#url_code").val(response.url_code);
                        $("#inpValue_name").val(response.name_localized);
                        $("#name").val(response.name);
                        $("#form_register_categories-title").html("<?php echo e(strtoupper(trans($lang.'form.edit.title'))); ?>");
                        if(response.show_menu == 1){
                            $("#estatus-show_menu").prop("checked", true)
                        }else{
                            $("#estatus-show_menu").prop("checked", false)
                        }
                        loadFather(response.root_category_id);
                        LoadDataForm("<?php echo e($default_id); ?>");
                        $("#form_register_categories").modal("show");
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('result_error'); ?>
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
    
        var level=0;
        //funcion para obtener los registros para el select
        function loadDataSelect(id){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','category-root-get'); ?>
                    <?php $__env->slot('parameters', " 'root_category_id':id "); ?>
                    <?php $__env->slot('result_success'); ?>
                    let query="";
                    if(response.length>0){
                                level++;
                                query=query+'<div id="level-'+level+'" style="padding-bottom: 10px!important;padding-right: 0px;padding-left: 0px" class="col-md-12">';
                                query=query+'<label>NIVEL-'+level+'</label>';
                                query=query+'<select class="form-control" id='+level+' onchange="changeSelectView(\'' + level + '\')">';
                                query=query+'<option value="-1">-- Seleccione -- </option>';
                            for(let item of response){
                                query+=`<option value="${item.id}">${item.name_localized}</option>`;
                                }
                                query=query+'</select></div>';
                            }else{
                            }
                            $(query).insertBefore("#select");
                            $("#"+level).select2();
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('result_error'); ?>
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function limpiarForm(){
            $("#code").val(null);
            $("#inpValue_name").val(null);
            $("#inpValue_url_code").val(null);
            $("#namecategoryroot").val(null);
        }
            //funcion cuando se modifique algun select de la vista principal
        function changeSelectView(id){
                deleteSelectView(id);
                level=id;
                loadData($("#"+id).val());
                let value=$("#"+id).val();
                if(value==-1){
                }else{
                    loadDataSelect(value);
                }
            }
            function deleteSelectView(id){
                if(id==null){
                    level=0;
                }else{
                    let row=$("#"+id).parent().closest("div").attr("id");
                    row=parseInt(row.replace("level-",""));
                    for(let i=row+1; i<=level; i++){
                        $("#level-"+i).remove();
                    }
                }
            }
            //funcion cuando se elimine algun select de la vista principal
        function DeleteData(id, root)
            {
                <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','category-delete'); ?>
                    <?php $__env->slot('parameters', " 'id':id "); ?>
                    <?php $__env->slot('result_success'); ?>
                       ShowSuccessMessage("<?php echo e(trans($lang.'form.register.msg_title_success')); ?>","<?php echo e(trans($lang.'form.register.msg_description_success')); ?>");
                        $("#form_register_categories").modal('hide');
                        if(root==null || root=="" || root=="null"){
                            root="<?php echo e($default_id); ?>";
                            console.log(root);
                        }
                        loadData(root);
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

       



    
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <!--scrits-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config($group.'.ui.template.main.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/admin/page/categories/list.blade.php ENDPATH**/ ?>