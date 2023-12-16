<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use Illuminate\Http\Request;

class SpecificationController extends BaseAdminController{
    public function index(Request $request){
        return view(config($this->group.'.ui.page.specification.list.view'));
    }
    public static function ArraySpecifications($arraylist, $lang){
        $key=self::getKeys($arraylist[0]);
        $keylang=self::getKeys($lang);
        for ($i=0; $i < count($arraylist); $i++) { 
            for($a=0; $a < count($key); $a++){
                if ($key[$a]=="name_specificacion") {
                    for ($b=0; $b < count($keylang); $b++) { 
                        if ($b==0) {
                            $arrayname='{"'.$keylang[$b].'":"'.$arraylist[$i][$key[$a]].'" }';
                        }else{
                            $arrayname=$arrayname.',{"'.$keylang[$b].'" : ""}';
                        }
                    }
                }
            }
            $array[$i]["name"]="[".$arrayname."]";
            $array[$i]["code"]=$arraylist[$i]["sp_code"];
            $array[$i]["color"]=$arraylist[$i]["color"];
            $array[$i]["html"]=$arraylist[$i]["html"];
            $array[$i]["preview"]=$arraylist[$i]["preview"];
            $array[$i]["image"]=$arraylist[$i]["image"];
            $array[$i]["gb_filter"]=$arraylist[$i]["gb_filter"];
        }
        return $array;
    }
    public static function getKeys($arrays){
        $llaves=array_keys($arrays);
        return $llaves;
    }
}