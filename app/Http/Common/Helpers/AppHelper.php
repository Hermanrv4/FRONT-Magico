<?php
namespace App\Http\Common\Helpers;

use Carbon\Carbon;

class AppHelper{

    public static function GetToken(){
        return DateHelper::GetNow()->timestamp . "-" . rand(1000000, 9999999);
    }
	
	public static function EncodeUrl($url) {
		$reserved = array(
		":" => '!%3A!ui',
		"/" => '!%2F!ui',
		"?" => '!%3F!ui',
		"#" => '!%23!ui',
		"[" => '!%5B!ui',
		"]" => '!%5D!ui',
		"@" => '!%40!ui',
		"!" => '!%21!ui',
		"$" => '!%24!ui',
		"&" => '!%26!ui',
		"'" => '!%27!ui',
		"(" => '!%28!ui',
		")" => '!%29!ui',
		"*" => '!%2A!ui',
		"+" => '!%2B!ui',
		"," => '!%2C!ui',
		";" => '!%3B!ui',
		"=" => '!%3D!ui',
		"%" => '!%25!ui',
		);

		$url = rawurlencode($url);
		$url = preg_replace(array_values($reserved), array_keys($reserved), $url);
		return $url;
	}
	public static function getB64Image($base64_image){
		$image_service_str = substr($base64_image, strpos($base64_image, ",")+1);    
     	$image = base64_decode($image_service_str);   
     	return $image; 
	}
	public static function getB64Extension($base64_image, $full=null){
		preg_match("/^data:image\/(.*);base64/i",$base64_image, $img_extension);
    	return ($full) ?  $img_extension[0] : $img_extension[1];
	}
	public static function Getkeys($arrays){
        $llaves=array_keys($arrays);
        return $llaves;
    }
}
