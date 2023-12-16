function ShowMessage(title,message,type){
    Swal.fire({
        title: title,
        html: message,
        icon: type
    });
}
function ShowSuccessMessage(title,message){
    ShowMessage(title,message,'success');
}
function ShowErrorMessage(title,message){
    ShowMessage(title,message,'error');
}
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
function isInt(value) {
    return !isNaN(value) &&
        parseInt(Number(value)) == value &&
        !isNaN(parseInt(value, 10));
}
function AddQtyPreview(qty_id){
    var qty = $("#"+qty_id).val();
    console.log(qty);
    if(isInt(qty)){
        qty = parseInt(qty)+1;
    }else{
        qty = 1;
    }
    $("#qtyPreview").val(qty);
}
function RemoveQtyPreview(qty_id){
    var qty = $("#"+qty_id).val();
    if(isInt(qty)){
        if(parseInt(qty)>1){
            qty = parseInt(qty)-1;
        }else{
            qty = 1;
        }
    }else{
        qty = 1;
    }
    $("#"+qty_id).val(qty);
}
function InitForms(){
    $('.error-text').hide();
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

function justNumbers(item){

}
function justLetters(item){

}