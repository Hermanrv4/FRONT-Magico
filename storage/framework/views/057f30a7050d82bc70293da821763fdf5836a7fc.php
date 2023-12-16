<?php
    use App\Http\Common\Services\ApiService;
    use Illuminate\Support\Facades\Session;
    use \App\Http\Common\Services\ParameterService;

    $group = config('env.app_group_admin');
    $lang = config($group.'.ui.page.parameter.list.lang');
    $default_id = ParameterService::GetParameter("default_id");
    //obtener lenguajes
    $languages = json_encode(config('laravellocalization.supportedLocales'));
?>

<?php $__env->startSection('page_title',trans($lang.'page_title')); ?>
<?php $__env->startSection('metas',''); ?>
<?php $__env->startSection('top_scripts'); ?>
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/datatable/DataTables-1.10.20/css/dataTables.bootstrap4.css")); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/datatable/Responsive-2.2.3/css/responsive.bootstrap4.css")); ?>"/>
  
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/datatable/Buttons-1.6.1/css/buttons.bootstrap4.min.css")); ?>"/>
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
                                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("select","code",$lang.'form.filters.lbl_parameter',true,"col-md-12","fas fa-envelope"); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: right!important;">
                            <button class="btn btn-info col-md-2" style="margin: 5px!important;" id="btn_search" onclick='resetResults()'><?php echo trans($lang.'btn_reset'); ?></button>     
                            <button class="btn btn-success col-md-2" style="margin: 5px!important;" id="btn_search" onclick='loadDataById()'><?php echo trans($lang.'btn_search'); ?></button>     
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
                    <div class="row">
                        <div class="row col-md-12">
                            <input type="text" name="id_result" hidden id="id_result">
                            <div class="row col-md-12" id="result">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: right!important;" id="div_btn">
                            
                        </div>
                    </div>
                </div>
                <div class="card-footer"><?php echo trans($lang.'lbl_results_footer'); ?></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom_scripts'); ?>
    <script>
        window.onload=function(){
            loadData();
            saludar();            
        }
        function loadData(){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','parameter-get-codes'); ?>
                <?php $__env->slot('parameters', ""); ?>
                <?php $__env->slot('result_success'); ?>;                         
                    $('#code').html('');
                    let query="";
                    query = query+`<option value="" selected><?php echo e(trans($lang.'lbl_default_select')); ?></option>`;
                    for(let item of response){
                        var code = item.code.replace('_',' ').toUpperCase();
                        query=query+`<option value="${item.id}">${code}</option>`;                           
                    }
                    $('#code').append(query);
                    $('#code').select2();
                <?php $__env->endSlot(); ?>                       
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function loadDataById(){
            let parameter_id = $('#code').val();
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','parameter-get'); ?>
                <?php $__env->slot('parameters', " 'parameter_id':parameter_id "); ?>
                <?php $__env->slot('result_success'); ?>
                    let is_localized = response.is_localized;
                    let is_json = response.is_json;
                    var query = '';
                    resetResults();
                    $('#id_result').val(parameter_id);
                    if (!is_localized && !is_json) {                        
                        query= chooseInput(response.code,'value');
                        $('#result').html(query);
                        $('#value').val(response.value);
                        addSaveButton();
                    }
                    if (is_localized && !is_json) {

                        var valor = response.code;
                        if(valor.includes('image')){
                            query = chooseInput('image_parameter','value');
                        }else{
                            query = `<?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_localized","value",$lang.'form.edit.lbl_value',true,"col-md-12"); ?>`;
                        }
                        $('#result').html(query);
                        $('#inpValue_value').val(response.value_localized);
                        $('#value').val(response.value);
                        
                        if(valor.includes('image')){
                            addSaveButton();
                            addLoadFileButton();
                        }
                    }
                    if (is_localized && is_json) {
                        //parsea el valor localizado y valor
                        var parse_value_localized = JSON.parse(response.value_localized);
                        var parse_value = JSON.parse(response.value);
                        var lenguajes_result = getKeys(parse_value[0]);
                        var lenguajes = <?php echo $languages; ?>;
                        var lenguajes_headers = getKeys(lenguajes);
                        var cabezeras = getKeys(parse_value_localized[0]);
                        //creacion del card
                        for (let i = 0; i < parse_value_localized.length; i++) {
                            var card_body=`<div class="card col-sm-5 mx-auto"><div class="card-body" id='${i}'></div>${i!=0?`<div class="card-footer"><button type="button" class="btn btn-danger" onclick="deleteField('${i}_delete')">Eliminar</button></div>`:``}</div>`;
                            $('#result').append(card_body);
                            for (let ii = 0; ii < cabezeras.length; ii++) {
                                if(cabezeras[ii] === 'image'){
                                    var input = chooseInput('image_parameter',i+'_'+cabezeras[ii],cabezeras[ii],lenguajes_headers);                                   
                                }else{
                                    var input = chooseInput('text_parameter',i+'_'+cabezeras[ii],cabezeras[ii],lenguajes_headers);
                                }
                                $('#'+i).append(input);
                                    $('#inpValue_'+i+'_'+cabezeras[ii]).val(parse_value_localized[i][cabezeras[ii]]);
                                    var values = [];
                                    for (let a = 0; a < lenguajes_result.length; a++) {
                                        var value = new Object();
                                        value[lenguajes_result[a]] = parse_value[0][lenguajes_result[a]][i][cabezeras[ii]] == null ?"":parse_value[0][lenguajes_result[a]][i][cabezeras[ii]];
                                        values.push(value);
                                    }
                                $('#'+i+'_'+cabezeras[ii]).val(JSON.stringify(values));
                                $('#'+i+'_'+cabezeras[ii]+'_old').val(JSON.stringify(values));
                                UpdateInputLanguageValue(i+'_'+cabezeras[ii]);
                            }
                            var delete_input=`<input type="text" class="form-control ${i}_delete" hidden value="false">`;
                            $('#'+i).append(delete_input);
                        }                        
                        addSaveButton();
                        addLoadFileButton();
                        addAddButton();
                    }
                    if(!is_localized && is_json){
                        //parsea el valor localizado y valor
                        var parse_value = JSON.parse(response.value);
                        if (Array.isArray(parse_value)) {
                            //agregar inputs
                            for (let i = 0; i < parse_value.length; i++) {
                                var input = `<div class="form-row align-items-center">
                                                <div class="col-auto my-1"> 
                                                    <label for="value_${i}">VALOR ${i}</label>
                                                    <input type="text" class="form-control" id="value_${i}">
                                                    <input type="text" hidden class="${i}_delete" value="false">
                                                </div>
                                                <div class="col-auto my-1">
                                                    ${i!=0?`<button type="button" class="btn btn-danger" onclick="deleteField('${i}_delete')">Eliminar</button>`:``}                                                    
                                                </div>
                                            </div>`;
                                $('#result').append(input);
                                $('#value_'+i).val(parse_value[i]);
                            }
                            addSaveButton();
                            addAddButton();
                        }
                        else{
                            var cabezeras = getKeys(parse_value);
                            if(cabezeras.length>0){
                                for (let i = 0; i < cabezeras.length; i++) {
                                    var input = `<div class="form-row align-items-center">
                                                    <div class="col-auto my-1"> 
                                                        <label for="${cabezeras[i]}">${cabezeras[i].toUpperCase().replace('_',' ')}</label>
                                                        <input type="text" class="form-control" id="${cabezeras[i]}">
                                                    </div>
                                                </div>`;
                                    $('#result').append(input);
                                    $('#'+cabezeras[i]).val(parse_value[cabezeras[i]]);
                                }
                                addSaveButton();
                            }
                        }

                    }
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function getResult(){
            var parameter_id = $('#id_result').val();
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','parameter-get'); ?>
                <?php $__env->slot('parameters', " 'parameter_id':parameter_id "); ?>
                <?php $__env->slot('result_success'); ?>
                    let is_localized = response.is_localized;
                    let is_json = response.is_json;
                    if (!is_localized && !is_json) {
                        var respuesta = $('#value').val();
                        saveResult(parameter_id,respuesta);
                    }
                    if (is_localized && !is_json) {
                        var respuesta = $('#value').val();
                        console.log(respuesta);
                        saveResult(parameter_id,respuesta);
                    }
                    if (is_localized && is_json) {
                        var parse_value_localized = JSON.parse(response.value_localized);
                        var parse_value = JSON.parse(response.value);
                        var lenguajes_result = getKeys(parse_value[0]);
                        var lenguajes = <?php echo $languages; ?>;
                        var lenguajes_headers = getKeys(lenguajes);                        
                        var cabezeras = getKeys(parse_value_localized[0]);
                        var num = $('#result > div').length;
                        var objResultado=new Object();
                        for (let i = 0; i < lenguajes_headers.length; i++) {
                            var arrays=[];
                            for (let ii = 0; ii < num; ii++) {
                                //dentro se hara un recorrido de las cabezeras
                                var obj = new Object();                                
                                var value_delete = $('.'+ii+'_delete').val();
                                if (value_delete=='false' ){
                                    for (let iii = 0; iii < cabezeras.length; iii++) {
                                        var value = $('#'+[ii]+'_'+cabezeras[iii]).val();
                                        obj[cabezeras[iii]] = JSON.parse(value)[i][lenguajes_headers[i]] == undefined ? "" : JSON.parse(value)[i][lenguajes_headers[i]];
                                    }
                                    arrays.push(obj);
                                }
                            }
                            objResultado[lenguajes_headers[i]] = arrays;
                        }
                        saveResult(parameter_id,JSON.stringify([objResultado]));
                    }
                    if(!is_localized && is_json){
                        var parse_value = JSON.parse(response.value);
                        if (Array.isArray(parse_value)) {
                            var num = $('#result div > input').length/2;
                            var resultados = [];
                            for (let i = 0; i < num; i ++) {
                                var value = $('#value_'+i).val();
                                var delete_value = $('.'+i+'_delete').val();;
                                if(delete_value=='false'){
                                    resultados.push(value);
                                }
                            }
                            saveResult(parameter_id,resultados);
                            resetResults();
                        }
                        else{
                            var cabezeras = getKeys(parse_value);
                            var resultado = new Object();
                            for (let i = 0; i < cabezeras.length; i++) {
                                resultado[cabezeras[i]]=$('#'+cabezeras[i]).val();
                            }
                            saveResult(parameter_id,resultado);
                            resetResults();
                        }
                    }                
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function updatePhotos(){
            let parameter_id = $('#code').val();
            
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','parameter-get'); ?>
                <?php $__env->slot('parameters', " 'parameter_id':parameter_id "); ?>
                <?php $__env->slot('result_success'); ?>
                    var parse_value_localized = JSON.parse(response.value_localized);
                    var parse_value = JSON.parse(response.value);
                    var lenguajes_result = getKeys(parse_value[0]);
                    var lenguajes = <?php echo $languages; ?>;
                    var lenguajes_headers = getKeys(lenguajes);
                    var num = $('#result > div').length;
                    var dato = $('#code option:selected').text().toLowerCase();
                    var banners = [];
                    for (let a = 0; a < parse_value_localized.length; a++) {
                        for (let b = 0; b < lenguajes_result.length; b++) {
                            var value = parse_value[0][lenguajes_result[b]][a]['image'];
                            if(value !== ""){
                                banners.push(parse_value[0][lenguajes_result[b]][a]['image']);
                            }
                        }
                    }
                    for (let i = 0; i < num; i++) {
                        var value_delete = $('.'+i+'_delete').val();
                        for (let ii = 0; ii < lenguajes_headers.length; ii++) {
                            var value = $('#'+i+'_image').val();
                            var value_old = $('#'+i+'_image_old').val();
                            if(value !== "" ){
                                var value_parse = JSON.parse(value)[ii][lenguajes_headers[ii]];
                                if(value_old !== ""){
                                    var value_parse_old = JSON.parse(value_old)[ii][lenguajes_headers[ii]];
                                    if(value_parse !== value_parse_old){
                                        console.log('eliminar antiguo')
                                        uploadOrDeleteFile('delete',dato,value_parse_old,i,lenguajes_headers[ii]);
                                    }
                                }
                                if(value_parse !== ""){
                                    console.log(value_parse);                                    
                                    if (value_delete=='false' && !banners.includes(value_parse)){
                                        console.log('crear')
                                        console.log(`${dato}, ${value_parse}, ${i}, ${lenguajes_headers[ii]}`);
                                        uploadOrDeleteFile('create',dato,value_parse,i,lenguajes_headers[ii]);
                                    }else if(value_delete=='true' && banners.includes(value_parse)){
                                        console.log('eliminar')
                                        uploadOrDeleteFile('delete',dato,value_parse,i,lenguajes_headers[ii]);
                                    }
                                }
                            }
                            
                        }
                    }
                    $('#btnsave').attr("disabled", false);
                    ShowSuccessMessage("<?php echo e(trans($lang.'form.msg_title_success')); ?>","<?php echo e(trans($lang.'form.msg_description_success')); ?>");
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function uploadOrDeleteFile(action,dato,rename,num,lenguajes_headers){
            var formulario = new FormData(document.getElementById('frm_img_'+num+'_image_'+lenguajes_headers));                        
            formulario.append("action", action);                
            formulario.append("dato", dato);                
            formulario.append("rename", rename);
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax-internal_formdata.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('route','parameter-create-delete-card'); ?>
                <?php $__env->slot('parameters', " formulario "); ?>
                <?php $__env->slot('result_success'); ?>
                    /* resetResults(); */
                    ShowSuccessMessage("<?php echo e(trans($lang.'form.msg_title_success')); ?>","<?php echo e(trans($lang.'form.msg_description_success')); ?>");
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function addField(){
            //obtenemos id del parametro
            var parameter_id = $('#id_result').val();
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','parameter-get'); ?>
                <?php $__env->slot('parameters', " 'parameter_id':parameter_id "); ?>
                <?php $__env->slot('result_success'); ?>
                //obtener datos para poder conocer como leer la respuesta
                let is_localized = response.is_localized;
                let is_json = response.is_json;
                if (is_localized && is_json) {
                    //parsea el valor localizado y valor
                    var parse_value_localized = JSON.parse(response.value_localized);
                    var parse_value = JSON.parse(response.value);                        
                    //obtener de lenguajes y cabezeras de campos del resultado
                    var lenguajes_result = getKeys(parse_value[0]);
                    var lenguajes = <?php echo $languages; ?>;
                    var lenguajes_headers = getKeys(lenguajes);
                    var cabezeras = getKeys(parse_value_localized[0]);
                    //obtener el numero de
                    var i = $('#result > div').length;
                    //agregamos nuevo card
                    var card_body=`<div class="card col-sm-5"><div class="card-body" id='${i}'></div>${i!=0?`<div class="card-footer"><button type="button" class="btn btn-danger" onclick="deleteField('${i}_delete')">Eliminar</button></div>`:``}</div>`;
                    $('#result').append(card_body);
                    //llenado de cada card
                    for (let ii = 0; ii < cabezeras.length; ii++) {
                        if(cabezeras[ii]=== 'image'){
                            var input = chooseInput('image_parameter',i+'_'+cabezeras[ii],cabezeras[ii],lenguajes_headers);
                        }
                        else{
                            var input = chooseInput('text_parameter',i+'_'+cabezeras[ii],cabezeras[ii],lenguajes_headers);
                        }                       
                        $('#'+i).append(input);
                    }
                    var delete_input=`<input type="text" class="form-control ${i}_delete" hidden value="false">`;
                    $('#'+i).append(delete_input);
                }
                if (!is_localized && is_json) {
                    var parse_value = JSON.parse(response.value);
                    if (Array.isArray(parse_value)) {
                        var num = $('#result div > input').length;
                        var input = `<div class="form-row align-items-center">
                                        <div class="col-auto my-1"> 
                                            <label for="value_${num/2}">VALOR ${num/2}</label>
                                            <input type="text" class="form-control" id="value_${num/2}">
                                            <input type="text" class="${num/2}_delete" hidden value="false">
                                        </div>
                                        <div class="col-auto my-1">
                                            <button type="button" class="btn btn-danger" onclick="deleteField('${num/2}_delete')">Eliminar</button>
                                        </div>
                                    </div>`;
                        $('#result').append(input);
                    }
                    else{
                        var cabezeras = getKeys(parse_value);
                    }
                }
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function deleteField(card_id){
            $('.'+card_id).val("true");
            var id_paren = $('.'+card_id).parent().parent().hide();
        }
        function saveResult(id,resultado){
            var value= resultado;
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                <?php $__env->slot('ws_group','entity'); ?>
                <?php $__env->slot('ws_name','parameter-register'); ?>
                <?php $__env->slot('parameters', " 'id':id, 'value':value "); ?>
                <?php $__env->slot('result_success'); ?>
                    resetResults();
                    ShowSuccessMessage("<?php echo e(trans($lang.'form.msg_title_success')); ?>","<?php echo e(trans($lang.'form.msg_description_success')); ?>");
                <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function getKeys(valor){
            var keys=[];
            for (var key in valor) {
                keys.push(key);
            }
            return keys;
        }
        function addSaveButton(){
            var query = `<button class="btn btn-success col-md-2" style="margin: 5px!important;" id="btnsave" onclick='getResult()'><?php echo trans($lang.'btn_save'); ?></button>`;
            $('#div_btn').append(query);
        }
        function addAddButton(){
            var query = `<button class="btn btn-primary col-md-2" style="margin: 5px!important;" id="btnadd" onclick='addField()'><?php echo trans($lang.'btn_add'); ?></button>`;
            $('#div_btn').prepend(query);
        }
        function addLoadFileButton(){
            var query = `<button class="btn btn-secondary col-md-2" style="margin: 5px!important;" id="btnLoadFiles" onclick='updatePhotos()'><?php echo trans($lang.'btn_loadFiles'); ?></button>`;
            $('#div_btn').prepend(query);
            $('#btnsave').attr("disabled", true);
        }
        function resetResults(){
            $('#id_result').val('');
            $('#result').html('');
            $('#div_btn').html('');
        }
        function chooseInput(name,id_value,cabezeras=null){
            if(name.includes('_color')){
                return `<input type="color" class="form-control" id="value" placeholder="<?php echo e(trans($lang.'form.edit.lbl_value.placeholder')); ?>">`;
            }
            if(name.includes('text_parameter')){
                var lenguajes = <?php echo $languages; ?>;
                var lenguajes_headers = getKeys(lenguajes);
                var langs=[];
                var input = `
                    <div id="inp-container-${id_value}" style="margin-top:0px!important;" class="inp-container col-md-12">
                        <label>${cabezeras.toUpperCase().replace('_',' ')}</label>
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="btn_language_${id_value}">${lenguajes[lenguajes_headers[0]]['name']}</button>
                                <ul class="dropdown-menu">`;
                for (let a = 0; a < lenguajes_headers.length; a++) {
                    langs.push(lenguajes_headers[a]);
                    input = input+`<li class="dropdown-item" id="li_language_${lenguajes_headers[a]}_${id_value}" onclick="ChangeInputLanguage('${id_value}','${lenguajes_headers[a]}')">${lenguajes[lenguajes_headers[a]]['name']}</li>`;
                }
                input=input+`   </ul>
                            </div>
                            <input type="text" class="form-control inp-error-display" id="inpValue_${id_value}" onkeyup="UpdateInputLanguageValue('${id_value}')" name="${id_value}" placeholder="${cabezeras.toUpperCase().replace('_',' ')}">
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text inp-error-display"><span id="inp-icon-${id_value}" class=""></span></div>
                            </div>
                        </div>
                        <div><label class="error-text" style="display:none!important;"></label></div>
                        <div><input type="hidden" id="${id_value}"></div>
                        <div><input type="hidden" id="languages_${id_value}" value=${JSON.stringify(langs)}></div>
                        <div><input type="hidden" id="sel_current_language_${id_value}" value="${lenguajes_headers[0]}"></div>
                    </div>`;
                return input;
            }
            if(name.includes('image_parameter')){
                var lenguajes = <?php echo $languages; ?>;
                var lenguajes_headers = getKeys(lenguajes);
                var langs=[];
                var input = `
                    <div id="inp-container-${id_value}" style="margin-top:0px!important;" class="inp-container col-md-12">
                        <label>${ cabezeras==null?'VALUE':cabezeras.toUpperCase().replace('_',' ')}</label>
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="btn_language_${id_value}">${lenguajes[lenguajes_headers[0]]['name']}</button>
                                <ul class="dropdown-menu">`;
                for (let a = 0; a < lenguajes_headers.length; a++) {
                    langs.push(lenguajes_headers[a]);
                    input = input+`<li class="dropdown-item" id="li_language_${lenguajes_headers[a]}_${id_value}" onclick="ChangeInputLanguage('${id_value}','${lenguajes_headers[a]}')">${lenguajes[lenguajes_headers[a]]['name']}</li>`;
                }
                input=input+`   </ul>
                            </div>
                            <input type="text" class="form-control inp-error-display" id="inpValue_${id_value}" name="${id_value}" disabled aria-describedby="inp-btn-search-img-${id_value}">
                            <div class="input-group-append inp-error-display">
                                <button onclick="clicInputFile('${id_value}')" id="inp-btn-search-img-${id_value}" class="btn btn-outline-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div><label class="error-text" style="display:none!important;"></label></div>`;
                        
                for (let b = 0; b < lenguajes_headers.length; b++) {
                    input = input+`
                    <form id="frm_img_${id_value}_${lenguajes_headers[b]}" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div><input type="file" hidden id="file_${id_value}_${lenguajes_headers[b]}" name="file-img" onchange="putFileName('inpValue_${id_value}','file_${id_value}_${lenguajes_headers[b]}','${id_value}')"></div>
                    </form>`;
                }                            
                input=input+`
                        <div><input type="hidden" id="${id_value}_old"></div>
                        <div><input type="hidden" id="${id_value}"></div>
                        <div><input type="hidden" id="languages_${id_value}" value=${JSON.stringify(langs)}></div>
                        <div><input type="hidden" id="sel_current_language_${id_value}" value="${lenguajes_headers[0]}"></div>
                    </div>`;
                return input;
            }
            else{
                return `<?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","value",$lang.'form.edit.lbl_value',true,"col-md-12"); ?>`;
            }
        }
        function clicInputFile(id){
            var sel_current_language = $('#sel_current_language_'+id).val();
            $('#file_'+id+'_'+sel_current_language).click();
        }
        function putFileName(inputId,Fileid,id){
            let img = document.getElementById(Fileid);
            renamevalidate(img, $("#"+inputId));
            UpdateInputLanguageValue(id)
        }
        //clases
        function changeAdd(param){
            let array=Array();
            let child=$("#result").children();
            for(let i=0; i<child.length; i++){
                array[i]="#"+$(child[i]).attr("id");
            }
            for(let a=0; a<child.length; a++){
                $(array[a]).removeClass("row d-flex justify-content-around active");
            }
            $(param).addClass("row d-flex justify-content-around");
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config($group.'.ui.template.main.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/admin/page/parameter/list.blade.php ENDPATH**/ ?>