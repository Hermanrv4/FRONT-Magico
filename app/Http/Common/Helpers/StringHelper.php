<?php
namespace App\Http\Common\Helpers;

use Carbon\Carbon;

class StringHelper{

    public static function IsNull($obj,$default){
        return ($obj==null?$default:$obj);
    }
    public static function RandomString($len){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $len; $i++) {
            $randstring = $randstring.$characters[rand(0, strlen($characters)-1)];
        }
        return $randstring;
    }
}
