<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Responses\ApiResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CategoriesController extends BaseAdminController{
    public function index(Request $request){
        return view(config($this->group.'.ui.page.categories.list.view'));
    }
    public static function formatArrayCategories($arrays, $len){
        $array=array();
        //obtener las llaves
        if (count($arrays)>0) {
            $key=self::getKeys($arrays[0]);
            $keylen=self::getKeys($len);
            $string="";
            $urlcode="";
            //aqui manipularemos el array para la importacion
            for ($i=0; $i <count($arrays) ; $i++) {
                for($a=0; $a<count($key); $a++){
                    if ($key[$a]=="name_categorie") {
                        for ($b=0; $b < count($keylen); $b++) { 
                            if ($b==0) {
                                $stringname='{"'.$keylen[$b].'": "'.$arrays[$i][$key[$a]].'"}';
                                $urlcode='{"'.$keylen[$b].'": "'.$arrays[$i][$key[$a]]."_".$arrays[$i][$key[$a-2]].'"}';
                            }else{
                                $stringname=$stringname.','.'{"'.$keylen[$b].'": ""}';
                                $urlcode=$urlcode.','.'{"'.$keylen[$b].'": ""}';
                            }
                        }
                    }
                    if ($key[$a]=="code") {
                        $stringbanner=$arrays[$i][$key[$a]].".png";
                    }
                }
                $array[$i]["name"]="[".$stringname."]";
                $array[$i]["url_code"]="[".$urlcode."]";
                $array[$i]["root_code"]=$arrays[$i]["root_code"];
                $array[$i]["banner"]=$stringbanner;
                $array[$i]["code"]=$arrays[$i]["code"];
                $stringname="";
                $urlcode="";
            }
            return $array;
        }else{
            return array();
        }
        
    }
    public static function getKeys($arrays){
        $llaves=array_keys($arrays);
        return $llaves;
    }
    public function uploadImage(Request $request){
        $request->file("file-img")->storePubliclyAs('/categories//', $request["img"],'images');
        return ApiResponse::SendSuccessResponse(null, $request->file());
    }
    public function deteleImageCategories(Request $request){
        Storage::disk('images')->delete('/categories//'.$request["name-delete"]);
        return ApiResponse::SendSuccessResponse(null, $request);
    }
    public function getDataCategories($date_start=null, $date_end=null){
        return ApiService::Request($this->group, 'entity', 'categories-get-data-billing-date', ['date_start'=>$date_start, "date_end"=>$date_end])->response;
    }
}