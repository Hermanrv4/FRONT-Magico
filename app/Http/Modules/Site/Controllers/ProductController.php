<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CategoryService;
use App\Http\Modules\Site\Services\SiteService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends BaseSiteController {
    public function ProductDetail($url_code){
        $parameters = Array(
            "currency_code" => ParameterService::GetParameter("default_currency_code")
            ,"url_code" => $url_code
        );
        $dataSpecifications = ApiService::Request(config('env.app_group_site'), 'entity', 'specification-get', array());
        $dataProduct = ApiService::Request(config('env.app_group_site'), 'entity', 'product-by-urlcode', $parameters);
        if($dataProduct->status == config('app.value.result.status.value.success')){
            if( count($dataProduct->response) > 0){
                return view(config($this->group.'.ui.ecommerce.product.view'))
                ->with("product_data", $dataProduct->response)
                ->with("specifications", $dataSpecifications->response)
                ->render();
            }else{
                return redirect(RouteService::GetSiteURL('landing'));
            }
            
        }else{
            return redirect(RouteService::GetSiteURL('landing'));
        }
    }
    public function GetPreview(Request $request){
        $parameters = Array(
            "currency_code" => ParameterService::GetParameter("default_currency_code")
            ,"url_code" => $request->url_code
        );
        $dataSpecifications = ApiService::Request(config('env.app_group_site'), 'entity', 'specification-get', array());
        $dataProduct = ApiService::Request(config('env.app_group_site'), 'entity', 'product-by-urlcode', $parameters);
      
        if($dataProduct->status == config('app.value.result.status.value.success')){
            $html_preview = "";
            try {
                $html_preview = view(config($this->group.'.ui.component.product.preview.view'))
                    ->with("product_data", $dataProduct->response)
                    ->with("specifications", $dataSpecifications->response)
                    ->render();
            } catch (\Throwable $e) {dd($e);}
            return ApiResponse::SendSuccessResponse(null,$html_preview);
        }else{
            return ApiResponse::SendSuccessResponse(null,array());
        }
    }
    public function GetAllProduct(Request $request){
        $dataProduct = ApiService::Request(config('env.app_group_site'), 'entity', 'product-all', array());
    }
    public function GetCatalogue(Request $request){
        $categories = array();
        $union=ParameterService::GetParameter('db_query_union');
        $int_limiter = ParameterService::GetParameter('db_query_limiter');
        $request->filters = str_replace($int_limiter.$int_limiter,"",$request->filters);
        $request->categories_filter = str_replace($union.$union,"",$request->categories_filter);

        if($request->filters==""){
            $request->filters = null;
        }

        if($request->search==''){
            $request->search = null;
        }
        $request->categories = str_replace($union,",",$request->categories);
        
        $cat_unq= explode($union,$request->categories);

        //$lstCategories = $request->categories_filter;
        if($request->categories_filter==""){
            $lstCategories =$request->categories; 
        }
        
        $parameters = array(
            "currency_code" => SiteService::GetCurrencyCode()
            ,"page_qty" => ParameterService::GetParameter('product_catalogue_quantity')
            ,"categories" => $request->categories
            ,"page_num" => $request->page_num
            ,"filters" => $request->filters
            ,"order_by" => (int)$request->order
        );
        
        if($request->search!=null){
            $parameters["search"] = $request->search;
        } 
        if($request->min_price!="" && $request->min_price!=null){
            $parameters["min_price"] =   $request->min_price;
        }
        if($request->max_price!="" && $request->max_price!=null){
            $parameters["max_price"] =   $request->min_price;
        }
        $dataSpecifications = ApiService::Request(config('env.app_group_site'), 'entity', 'specification-get', array());
        $lstProducts = array();

        $categories = implode(ParameterService::GetParameter('db_query_union'), $categories);
        //$parameters = array("order_by"=>$request->order_by,"currency_code" => ParameterService::GetParameter('default_currency_code'),"page_qty" => ParameterService::GetParameter('product_catalogue_quantity'),"categories" => $categories,"page_num" => $request->page_num);

        if($request->search!=null){
            $parameters["search"] =   $request->search;
        }
        if($request->sale!="0" && $request->sale!=0){
            $parameters["sale"] =   $request->sale;
        }
        
        $dataProducts = ApiService::Request(config('env.app_group_site'), 'entity', 'product-catalogue', $parameters);
        $html = "";
        if($dataProducts->status == config('app.value.result.status.value.success')){
            $LstProducts = $dataProducts->response;
            $items = array();
            $html = "";
            for($i=0;$i<count($LstProducts);$i++){
                try {
                    $items[] = view(config($this->group.'.ui.component.product.box.view'))
                        ->with("type", config($this->group.'.value.product.box-type.catalogue'))
                        ->with("product_data", $LstProducts[$i])
                        ->with("specifications", $dataSpecifications->response)
                        ->render();
                        $html = $html . $items[$i];
                } catch (\Throwable $e) {
                    dd($e);
                }
            }
            return ApiResponse::SendSuccessResponse(null,array($html,$items));
        }else{
            return ApiResponse::SendSuccessResponse(null,array($html,array()));
        }
    }
}