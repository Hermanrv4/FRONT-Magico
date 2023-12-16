/* const { functions } = require("lodash"); */

$(document).ready(function(){
    $("#section-btn .search").on("click", function(e){
        e.preventDefault();
    });
    $("#section-btn .Load").on("click", function(e){
        e.preventDefault();
    });
    $("#section-btn .add").on("click", function(e){
        e.preventDefault();
    });
});
function eventsearch(obj){
    $("#file"+obj).click();
}
var date=new Date();
var diff="";
    //funcion para cambiar el nombre de la imagen
    function renamevalidate(obj, input, btn=null){
        let format=["jpeg", "png", "jpg", "jfif", "PNG"];
        let valido=false;
        //nombre de por si
        let name=obj.files[0].name;
        /* console.log(obj.files[0]); */
        //obtenemos el formato
        let type=obj.files[0].type;
        /* console.log(type); */

        if(type=="image/jpeg" || type=="image/png" || type=="image/jpg"){
            valido=true;
        }
        let formatsave=new Array();
        let name_new="";
        for(let iii=0; iii<format.length; iii++)
        {
            let string="."+format[iii];
            rename=name.split(string);
            if(rename.length>1){
                formatsave.push(format[iii]);
                iii=format.length+1;
            }
        }
        diff=date.getDate()+"-"+(date.getMonth()+1)+"-"+date.getFullYear()+"-"+date.getHours()+"-"+date.getMinutes()+"-"+date.getMilliseconds();
        for(let ii=0; ii<rename.length; ii++){
            name_new=name_new+rename[ii];
        }
        name_new=name_new+"-"+diff;
        for(let a=0; a<formatsave.length; a++){
            name_new=name_new+"."+formatsave[a];
        }
        if(valido==true){
            if(!btn==null){
                btn.attr("disabled", false);
            }
            input.val(name_new);
        }else{
            input.val(null);
            obj.value = null;
            if(btn==null){
                ShowErrorMessage("Formato de imagen no recomentado", "El formato de la imagen no es el correcto");
            }else{
                btn.attr("disabled", true);
                ShowErrorMessage("Formato de imagen no recomentado", "El formato de la imagen no es el correcto");console.log("swss");
            }
        }
    }
    function renamevalidateMassive(obj=null, input=null, btn=null){
        let msg="Parametros en nullo";
        let format=["jpeg", "png", "jpg", "jfif", "PNG"];
        let valido=false;
        //validamos el envio de parametros nullos
        if(obj!=null){
            //comprobacion de la longitud
            let name=obj.name;
            //obtenemos el formato
            let type=obj.type;
            // validacion de formatos
            if(type=="image/jpeg" || type=="image/png" || type=="image/jpg"){
                valido=true;
            }
            let formatsave=new Array();
            let name_new="";
            for(let iii=0; iii<format.length; iii++)
            {
                let string="."+format[iii];
                rename=name.split(string);
                if(rename.length>1){
                    formatsave.push(format[iii]);
                    iii=format.length+1;
                }
            }
            diff=date.getDate()+"-"+(date.getMonth()+1)+"-"+date.getFullYear()+"-"+date.getHours()+"-"+(new Date().getMinutes())+"-"+date.getMilliseconds();
            for(let ii=0; ii<rename.length; ii++){
                name_new=name_new+rename[ii];
            }
            name_new=name_new+"-"+diff;
            for(let a=0; a<formatsave.length; a++){
                name_new=name_new+"."+formatsave[a];
            }
            if(valido==true){
                if(!btn==null){
                    btn.attr("disabled", false);
                }
                if(input != null){
                    input.val(name_new);
                }else{
                    return name_new;
                }
            }else{
                input.val(null);
                obj.value = null;
                if(btn==null){
                    ShowErrorMessage("Formato de imagen no recomentado", "El formato de la imagen no es el correcto");
                }else{
                    btn.attr("disabled", true);
                    ShowErrorMessage("Formato de imagen no recomentado", "El formato de la imagen no es el correcto");
                }
            }

        }else{
            return msg;
        }
    }