<?php
namespace App\Http\Modules\Admin\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class AppHelper{
    public static function GetAdminData(){
        return json_decode(Session::get(config('env.app_auth_admin_session_id'))[config('env.app_group_admin')],true);
    }
    public static function GeneraSKU($auto){
        $string="SKU-PRD";
       /*  $nameprod=strtoupper($nameprod); */
        for($i=0; $i<5; $i++){
            $len=strlen($auto);
            if($len<6){
                $auto='0'.$auto;
            }
        }
        return $string."-".$auto;
    }
    public static function quitar_tildes($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
        }
}
