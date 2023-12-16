<?php
namespace App\Http\Modules\Admin\Controllers;
use App\Http\Common\Controllers\BaseAdminController;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Services\ApiService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ParameterController extends BaseAdminController{
    public function index(Request $request){
        return view(config($this->group.'.ui.page.parameter.list.view'));
    }
    public function UpdateDeleteCardOrBanner(Request $request)
    {
        //validamos si vamos a copiar un banner o un card
        if($request["dato"]=="banners"){
            if($request["action"]=="create"){
                $request->file("file-img")->storePubliclyAs("/banners//", $request["rename"], 'images');
                return ApiResponse::SendSuccessResponse(null, []);
            }elseif($request["action"]=='delete'){
                Storage::disk('images')->delete('/banners//'.$request["rename"]);
                return ApiResponse::SendSuccessResponse(null, []);
            }
        }elseif($request["dato"=="cards"]){
            if ($request['action']=='create') {
                $request->file("file-img")->storePubliclyAs('/cards//', $request["rename"],'images');
                return ApiResponse::SendSuccessResponse(null, []);
            }elseif ($request['action']=='delete') {
                Storage::disk('images')->delete('/cards//'.$request["rename"]);
                return ApiResponse::SendSuccessResponse(null, []);
            }
        }
    }
}