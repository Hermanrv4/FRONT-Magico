
function ShowFullLoading(message){
    if(message==null) {
        $("#spLoadingMessage").html("");
    }else{
        $("#spLoadingMessage").html(message);
    }
    $("#dvLoadingFull").show();
}
function HideFullLoading(){
    $("#spLoadingMessage").html('');
    $("#dvLoadingFull").hide();
}

function ShowMessage(title,message,type){
    Swal.fire({
        title: title,
        html: message,
        type: type
    });
}
function ShowSuccessMessage(title,message){
    ShowMessage(title,message,'success');
}
function ShowErrorMessage(title,message){
    ShowMessage(title,message,'error');
}
function PutFront(e,class_name){
    $("."+class_name).css("z-index", "100");
    $(e).css("z-index", "101");
}
function InitForms(){
    $('.error-text').text("");
    $('.inp-container').removeClass("error-field");
    $('.inp-error-display').removeClass("error-field");
}
function ShowFormErrors(container_id,message,data,equivalence=[]){
    InitForms();
    var errors = "";
    for(var item in data) {
        var back = item;
        var front = item;
        if(equivalence[back]!=null) front = equivalence[back];
        for(var subitem in data[back]) {
            console.log(front);
            if ($('#' + front)) {
                $('#' + item).addClass("error-field");
                $('#inp-container-' + front + ' .inp-error-display').addClass("error-field");
                $('#inp-container-' + front + ' .error-text').text(data[back][0]);
                $('#inp-container-' + front + ' .error-text').show();
            }
            if (container_id == null) {
                errors = errors + (errors == "" ? "" : "<br/>") + data[back][subitem];
            } else {
                errors = errors + "<li>" + data[back][subitem] + "</li>";
            }
        }
    }
    if(container_id==null){
        ShowErrorMessage(message,""+errors+"");
    }else{
        var html = "" +
            "<div id='dvErrors' class='col-md-12 nopadding'></div>" +
            "<div class='alert alert-danger'>" +
            "<p style='color:white;'><b>"+message+"</b></p>" +
            "<ul>" +
            "<li>"+errors+"</li>" +
            "</ul>" +
            "</div>" +
            "</div><hr/>";
        $("#"+container_id).html(html);
    }
}


// Restricts input for the set of matched elements to the given inputFilter function.
(function($) {
    $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    };
}(jQuery));

function justNumbers(value) {
    return /^\d*$/.test(value);
}
function justDecimals(value) {
    return /^\d*[.]?(\d{1,2})?$/.test(value);
}
function justDate(value){
    return /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/.test(value);
}
/*****************************************************************************************************************/
/*****************************************************************************************************************/
function InitPriceInput(id,currency_id=null,price=null){
    if(currency_id===null || currency_id==="") currency_id = $("#default_currency_id_"+id).val();
    if(price===null || price==="") $("#"+id).val("");
    else $("#"+id).val(parseFloat(price).toFixed(2));
    ChangeInputPrice(id,currency_id);
}
function ChangeInputPrice(id,currency_id){
    var btn = $("#btn_currency_"+id);
    btn.attr('disabled', true);
    $("#currency_id_"+id).val(currency_id);
    btn.text($("#li_currency_"+currency_id+"_"+id).text());
    btn.attr('disabled', false);
}
/*****************************************************************************************************************/
function InitLocalizedInput(id,value){
    if(value===null || value==="" || !isJson(value)){
        $("#"+id).val(LocalizedGetDefault(id));
    }else{
        $("#"+id).val(value);
    }
    var languages = JSON.parse($("#languages_"+id).val());
    ChangeInputLanguage(id,languages[0],true);
}
function ChangeInputLanguage(id,language_code,is_init=false){
    var btn = $("#btn_language_"+id);
    btn.attr('disabled', true);
    if(!is_init) UpdateInputLanguageValue(id);//Me aseguro que jale lo ultimo escrito y lo coloque en el current_language
    LocalizedLoadValueForLanguage(id,language_code);
    $("#sel_current_language_"+id).val(language_code);
    btn.text($("#li_language_"+language_code+"_"+id).text());
    btn.attr('disabled', false);
}
function LocalizedLoadValueForLanguage(id,language_code){
    var lstValues = LocalizedGetValues(id);
    $("#inpValue_"+id).val(lstValues[language_code]);
}
function UpdateInputLanguageValue(id){
    var current_lang = $("#sel_current_language_"+id).val();
    var inputValue = $("#inpValue_"+id).val();
    var lstValues = LocalizedGetValues(id);
    lstValues[current_lang] = inputValue;
    $("#"+id).val(LocalizedGetJSONValue(id,lstValues));
}
function LocalizedGetJSONValue(id,lstValues){
    var languages = JSON.parse($("#languages_"+id).val());
    var values = [];
    for(i=0;i<languages.length;i++){
        let tmp = {};
        if(languages[i] in lstValues){
            tmp[languages[i]]=lstValues[languages[i]];
        }else{
            tmp[languages[i]]="";
        }
        values.push(tmp);
    }
    return JSON.stringify(values);
}
function LocalizedGetDefault(id){
    var languages = JSON.parse($("#languages_"+id).val());
    var default_value = [];
    for(i=0;i<languages.length;i++){
        let value = {};
        value[languages[i]]="";
        default_value.push(value);
    }
    return JSON.stringify(default_value);
}
function LocalizedGetValues(id){
    var value = $("#"+id).val();
    if(!isJson(value)){
        value = LocalizedGetDefault(id)
        $("#"+id).val(value);
    }
    var arrValues = [];
    var lstValues = JSON.parse(value);
    for(var i in lstValues){
        var arr_keys = Object.keys(lstValues[i]);
        for(var j in arr_keys){
            arrValues[arr_keys[j]]=lstValues[i][arr_keys[j]];
        }
    }
    return arrValues;
}
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
/*****************************************************************************************************************/
function LocalizedInputValidate(id,ValidateFunction,message){
    var lstValues = LocalizedGetValues(id);
    var return_messages = "";
    for(var key in lstValues){
        if(!ValidateFunction(lstValues[key])) return return_messages = return_messages+(return_messages===""?"":"<br/>")+message.replace(":language", "<b>"+$("#li_language_"+key+"_"+id).text().toLowerCase()+"</b>");
    }
    return return_messages;
}
/*****************************************************************************************************************/
var myAttachedData = [];
var urlFilesToDelete = [];
function GetDataFromFUTable(table_id){
    myAttachedData = [];
    $("#"+table_id+" > tbody > tr").each( function(index,element){
        var name = $( this ).find("td > .hidName").val();
        var size =  $( this ).find("td > .hidSize").val();
        var is_loaded = $( this ).find("td > .hidLoaded").val();
        if(is_loaded==1){
            let tmp = {};
            tmp["name"] = name;
            tmp["size"] = size;
            myAttachedData.push(tmp);
        }
    });
}
function DeleteFileUploadedTemporary(id,url_delete){
    $("#"+id).remove();
    urlFilesToDelete.push(url_delete);
}
function DeleteFileUploadedCompletely(){
    for(var i=0;i<urlFilesToDelete.length;i++){
        $.ajax({
            'url' : urlFilesToDelete[i],
            'type' : 'POST',
            'success' : function(data) {console.log(data);},
            'error' : function(request,error){console.log(request);console.log(error);}
        });
    }
    urlFilesToDelete=[];
}
/*****************************************************************************************************************/
/*****************************************************************************************************************/
/*****************************************************************************************************************/