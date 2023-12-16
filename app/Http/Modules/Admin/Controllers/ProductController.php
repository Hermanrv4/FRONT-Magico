<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Http\Common\Responses\ApiResponse;
use App\Imports\ProductsImport;
use App\Exports\GeneralExport;
use App\Exports\NameImagesExport;
use App\Http\Modules\Admin\Helpers\AppHelper;
use App\Http\Common\Services\ApiService;
use App\Http\Modules\Admin\Controllers\CategoriesController;
use App\Http\Modules\Admin\Controllers\SpecificationController;
use App\Exports\CategoriesExport;
use Exception;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends BaseAdminController{
    
    public function index($code=null, $id=null){
        if($code == null) $code = ParameterService::GetParameter("default_id");
        return view(config($this->group.'.ui.page.products.list.view'), ["code"=>$code]);
    }
    public function ExcelNameProducts(Request $request){
        $excelName=NameImagesExport::convertArray( $request["array_name_old"] ,$request["array_name_new"]);
        $images=new NameImagesExport();
        $images->setData($excelName);
        try{
            Excel::store($images, 'Nombre_de_imagenes.xlsx');
            $res=array("data_new"=>$images->getData(), "name_document"=>"Nombre_de_imagenes.xlsx");
            return ApiResponse::SendSuccessResponse(null, $res);
        }catch(Exception $e){
            return $e;
        }
    }
    public function downloadtemplate(){
        try{
            Excel::store(new GeneralExport, 'Plantilla-de-Carga.xlsx');
            $array=array("name_document"=>"Plantilla-de-Carga.xlsx");
            return ApiResponse::SendSuccessResponse(null,$array);
        }catch(Exception $e){
            return $e;
        }
    }
    public function ImportTemplate(Request $request){
        $array=array();
        try{
            $array=Excel::toArray(new ProductsImport, request()->file('FileExcel'));
            //manipular el array de productos 
            $key=(count($array[1])>0) ? self::keys($array[1][0]) : array();
            $prod=ApiService::Request($this->group, 'entity', 'Product-Get', [])->response;
            $len=config('laravellocalization.supportedLocales');
            $arrayCategories=CategoriesController::formatArrayCategories($array[0], $len);
            //OBTENEMOS LA LONGITUD A MOSTRAR INFO
            
            $data=self::formatArray($array[1], $key, $prod, $len);
            $listresponse=array();
            $listresponse["Productos"]=$array[1];
            $listresponse["Categoria"]=$array[0];
            $keyscategories=new CategoriesExport();
            $keyproductos=new ProductExport();
            $listresponse["keys_categories"]=$keyscategories->headings();
            $listresponse["key_productos"]=$keyproductos->headings();
            $listresponse[]=$data;
            $listresponse[]=$arrayCategories;
            $listresponse["preview"]=ApiService::Request(config('env.app_group_admin'), 'entity','parameter-get-codes',array('code'=>'preview_excel'))->response;
            return ApiResponse::SendSuccessResponse(null, array($listresponse));
        }catch(Exception $e){
            return $e;
        }
    }
    public static function formatArray($collection, $llaves, $prod, $len){
        //productos
        $array=array();
        if (count($collection)>0) {
                $specification = ApiService::Request(config('env.app_group_admin'), 'entity', 'Specification-Get', array('specification_code'=>-1))->response;
                $lenprod=count($prod);
                $lenkey=self::keys($len); 
                $stringspecificacion="";
                $urlcode="";
                $sku="";
                $namegroup="";
                $nameprodjson="";
                $string="";
                for($i=0; $i<count($collection); $i++){
                    $lenprod++;
                    for($a=0; $a<count($llaves); $a++){
                        //obtener el nombre del grupo
                        if($llaves[$a]==="nombre_del_grupo" && $a==2){
                            for($aa=0; $aa<count($lenkey); $aa++){
                                if($aa==0){
                                    $namegroup='{"'.$lenkey[$aa].'": "' . $collection[$i][$llaves[$a]] . '" }';
                                }else{
                                    $namegroup=$namegroup.', {"'.$lenkey[$aa].'" : ""}';
                                }
                            }
                        }
                        if ( $llaves[$a]=="is_update" && $a==20 && $collection[$i][$llaves[$a]] != "" && $collection[$i][$llaves[$a]] != "SI") {
                            $sku=$collection[$i][$llaves[$a]];
                        }else{
                            $sku=AppHelper::GeneraSKU($lenprod);
                        }
                        //obtener el producto variante, SKU, PRODUCTO URL
                        if($llaves[$a]==="nombre_del_producto" && $a==3){
                            for($bb=0; $bb<count($lenkey); $bb++){
                                if($bb==0){
                                    $nameprodjson='{"'.$lenkey[$bb].'": "'.$collection[$i][$llaves[$a]].'"}';
                                    $urlcode='{"'.$lenkey[$bb].'":"'.strtoupper($collection[$i][$llaves[$a]]).'_'.$sku.'"}';
                                }else{
                                    $nameprodjson=$nameprodjson.',{"'.$lenkey[$bb].'": ""}';
                                    $urlcode=$urlcode.',{"'.$lenkey[$bb].'":""}';
                                }
                            }
                        }
                        //obtener la descripcion
                        if($llaves[$a]==="descripcion_del_producto" && $a==4){
                            for($aaa=0; $aaa<count($lenkey); $aaa++){
                                if($aaa==0){
                                    $descripcion='{"'.$lenkey[$aaa].'" : "'.$collection[$i][$llaves[$a]].'"}';
                                }else{
                                    $descripcion=$descripcion.',{"'.$lenkey[$aaa].'" : ""}';
                                }
                            }
                        }
                        //obtener fotos
                        if(preg_match("/foto/", $llaves[$a])){
                                if ($collection[$i][$llaves[$a]]=="") {
                                    $string=$string."";
                                }else{
                                    if ($string=="") {
                                        $string='"'.$collection[$i][$llaves[$a]].'"';
                                    }else{
                                        $string=$string.',"'.$collection[$i][$llaves[$a]].'"';
                                    }
                                }
                        }
                        //obtener las especificaciones
                        for($b=0; $b<count($specification); $b++){
                            $val=$specification[$b]["code"];
                            $val=str_replace('Ñ', 'N', AppHelper::quitar_tildes($val));
                            for ($chp=0; $chp < count($lenkey); $chp++) { 
                                if($chp==0){
                                    if(strtoupper($val)==strtoupper($llaves[$a])){
                                        if($stringspecificacion==""){
                                            $stringspecificacion=$specification[$b]["code"].'=[{"'.$lenkey[$chp].'":"'.$collection[$i][$llaves[$a]].'"}]'.$stringspecificacion;
                                        }else{
                                            $stringspecificacion=$stringspecificacion.'|'.$specification[$b]["code"].'=[{"'.$lenkey[$chp].'":"'.$collection[$i][$llaves[$a]].'"}]';
                                        }
                                    }
                                }
                            }
                        }
        
                    }
                    $array[$i]["photo"]="[".$string."]";
                    $array[$i]["product_group"]="[".$namegroup."]" ?? "";
                    $array[$i]["product"]="[".$nameprodjson."]" ?? "";
                    $array[$i]["url_code"]="[".$urlcode."]" ?? "";
                    $array[$i]["description"]="[".$descripcion."]" ?? "";
                    $array[$i]["sku"]=$sku ?? "";
                    $array[$i]["category_code"]=$collection[$i]["categoria"] ?? "";
                    $array[$i]["group_id"]=$collection[$i]["grupo"] ?? "";
                    $array[$i]["especifications"]=$stringspecificacion ?? "";
                    $array[$i]["precio_online"]=$collection[$i]["precio_online"] ?? "0.00";
                    $array[$i]["precio_regular"]=$collection[$i]["precio_regular"] ?? "0.00";
                    $array[$i]["stock"]=$collection[$i]["stock"] ?? "0";
                    $array[$i]["catalogo"]=$collection[$i]["catalogo"];
                    $urlcode="";
                    $stringspecificacion="";
                    $string="";
                    $sku="";
                    $nameprodjson="";
                    $namegroup="";
                }
            return $array;
        }else{
            return array();
        }
    }
    public static function keys($arrays){
        $llaves=array_keys($arrays);
        return $llaves;
    }
    public function getHeader(){
        $header=new ProductExport();
        return ApiResponse::SendSuccessResponse([], $header->headings());
    }
    public function DeleteImage(Request $request){
        //eliminar archivos con ajax
        Storage::disk('images')->delete('/prod//'.$request["name_file"]);
        return ApiResponse::SendSuccessResponse(null, "Archivo eliminado satisfactoriamente");
    }
    public function UploadImageProducts(Request $request){
        $arraylist=array();
        $filesarray=$request->file("Multiple_imagenes");
        $renameFile=$request["rename"];
        $rename=array();
        for($a=0; $a<count($renameFile); $a++){
            $exist=Storage::disk("images")->exists('/prod//'.$renameFile[$a]);
            if($exist == [] || $exist == null || $exist == false){
                $rename[]=$renameFile[$a];
            }else{
                $rename[]="encontrado".$renameFile[$a];
            }
        }
        for($i=0; $i<count($filesarray); $i++){
            try{
                $filesarray[$i]->storePubliclyAs("/prod//", $rename[$i], "images");
            }catch(Exception $e){
                return $e;
            }
        }
        return ApiResponse::SendSuccessResponse(null, array("rename"=>$rename, "file"=>$filesarray, "count"=>[count($rename), count($filesarray)]));
    }
    public function GetDataProductBillingSaleOfDate($date_start, $date_end){
        return ApiService::Request($this->group, 'entity', 'product-get-data-billing-of-date', ['date_start'=>$date_start, "date_end"=>$date_end])->response;
    }
}