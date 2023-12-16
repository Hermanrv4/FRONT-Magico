<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Common\Controllers\BaseAdminController;
use Illuminate\Http\Request;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Helpers\AppHelper;
use Illuminate\Support\Facades\Storage;
use App\Exports\ChartsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataChartExport;
use App\Exports\ChartGeneral;
class StatisticalchartsController extends BaseAdminController {
    public function index(Request $request){
        return view(config($this->group.'.ui.page.statistical-charts-list.list.view'));
    }
    public function saveDataUrl(Request $request){
        $img=AppHelper::getB64Image($request["photo"]);
        $img_extension=AppHelper::getB64Extension($request["photo"]);
        $img_name='grafico_estadistico'. time() . '.' . $img_extension;
        Storage::disk('images')->put("/prod//".$img_name, $img);
        $data=self::selectOption($request["report"], $request["date_start"], $request["date_end"], $request["id_status"]);
        
        $chart=new ChartsExport();
        $chart->SetImgPath($img_name);
        $chart->setTitle($request["title_pie"]);
        $chart->setHeaderTitle($request["header_title"]);
        
        $data_chart=new DataChartExport();
        $data_chart->setDataHeading(AppHelper::GetKeys($data[0]));
        $data_chart->setArrayData(self::formatArrayData($data));
        $datageneral=new ChartGeneral();
        $datageneral->setList(["0"=>$data_chart, "1"=>$chart]);
        Excel::store($datageneral, 'Grafico_data.xlsx');
        Storage::disk('images')->delete('/prod//'.$img_name);
        return ApiResponse::SendSuccessResponse(null,array("name_document"=>'Grafico_data.xlsx'));

    }
    public function selectOption($option, $date_start=null, $date_end=null, $status=null){
        switch ($option){
            case "categorias":
                return (new CategoriesController())->getDataCategories($date_start, $date_end);               
            break;
            case "producto":
                return (new ProductController())->GetDataProductBillingSaleOfDate($date_start, $date_end);   
            break;
            case "grupo_producto":
                return (new ProductGroupController())->GetDataProductGroupBillingOfDate($date_start, $date_end);    
            break;
            case "order-status":
                return (new UserController())->GetOrderForUserOfDate($date_start, $date_end);    
            break;
            case "ventas":
                return (new UserController())->GetBillingForUserOfDate($date_start, $date_end);    
            break;
            case "order-of-status":
                return (new SaleController())->GetOrderForStatusOfDate($date_start, $date_end, $status);
            break;
            case "order-customer":
                return (new SaleController())->GetOrderOfDate($date_start, $date_end);
            break;
        }
    }
    public static function formatArrayData($array){
        $data=array();
        $keys=AppHelper::GetKeys($array[0]);
        for($i=0; $i<count($array); $i++){
            for($a=0; $a<count($keys); $a++){
                $data[$i][]=$array[$i][$keys[$a]];
            }
        }
        return $data;
    }
}
