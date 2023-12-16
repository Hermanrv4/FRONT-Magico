<?php
namespace App\Http\Modules\Site\Services;

use App\Http\Common\Helpers\DateHelper;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class HtmlService{
    public static function GetCategoriesHeader($root_category_id,$level=1)
    {
        $result = "";
        $lstCategories = null;
        if ($root_category_id == null) {
            $lstCategories = ApiService::Request(config('env.app_group_site'), 'entity', 'category-root-parents-menu', array())->response;
        } else {
            $lstCategories = ApiService::Request(config('env.app_group_site'), 'entity', 'category-childs-by-root-id', array('root_id' => $root_category_id))->response;
        }
        
        if (count($lstCategories) > 0) {
            for ($i = 0; $i < count($lstCategories); $i++) {
                $color = '#F3E9E9';
                if($lstCategories[$i]["id"]==8){
                    $color = 'red';
                }
                $result = $result . '<li>';
                $result = $result . '<div class="text-center-x menu-normal"><a class="item-menu-'.$lstCategories[$i]["id"].'" style="" href="' . RouteService::GetSiteURL("catalogue-category", [$lstCategories[$i]["url_code_localized"]]) . '"><strong>'.$lstCategories[$i]["name_localized"].'</strong></a></div>';
                $result = $result . '<div class="text-center-x menu-responsive"><a style="color:'.$color.';font-size:16px;width:100%" href="' . RouteService::GetSiteURL("catalogue-category", [$lstCategories[$i]["url_code_localized"]]) . '"><strong>'.$lstCategories[$i]["name_localized"].'</strong></a></div>';
                $result = $result . '</li>';
            }
        }

        return $result;
    }
    public static function GetCategoriesHeaderResponsive($root_category_id)
    {
        $result = "";
        $lstCategories  = null;
        if ($root_category_id == null) {
            $lstCategories = ApiService::Request(config('env.app_group_site'), 'entity', 'category-root-parents', array())->response;
        } else {
            $lstCategories = ApiService::Request(config('env.app_group_site'), 'entity', 'category-childs-by-root-id', array('root_id' => $root_category_id))->response;
        }
        if (count($lstCategories) > 0) {
            $result .='<ul id="myUL">';
            for($i=0;$i<count($lstCategories);$i++){//PRIMER NIVEL
                $link_1 = RouteService::GetSiteURL("catalogue-category", [$lstCategories[$i]["url_code_localized"]]);
                $result .='<li style="font-size: 20px;border-bottom: 1px solid black"><a class="caret" style="display: table-footer-group;"><span onclick="ViewByLink('."'".$link_1."'".')".'.">".$lstCategories[$i]["name_localized"].'</span></a>';
                $itms = ApiService::Request(config('env.app_group_site'), 'entity', 'category-childs-by-root-id', array('root_id' => $lstCategories[$i]["id"]))->response;
                if(count($itms)>0){
                    $result .='<ul class="ul-my">';
                    for($j=0;$j<count($itms);$j++){//SEGUNDO NIVEL
                        $link_2 = RouteService::GetSiteURL("catalogue-category", [$itms[$j]["url_code_localized"]]);
                        $result .='<li class="li-my"><a class="caret" style="display: table-footer-group;"><span onclick="ViewByLink('."'".$link_2."'".')".'.">".$itms[$j]["name_localized"].'</span></a>';
                        $itms2 = ApiService::Request(config('env.app_group_site'), 'entity', 'category-childs-by-root-id', array('root_id' => $itms[$j]["id"]))->response;
                        if(count($itms2)>0){
                            $result .='<ul class="ul-my">';
                            for($k=0;$k<count($itms2);$k++){//TERCER NIVEL
                                $link_3 = RouteService::GetSiteURL("catalogue-category", [$itms2[$k]["url_code_localized"]]);
                                $result .='<li class="li-my"><a class="caret" style="display: table-footer-group;"><span onclick="ViewByLink('."'".$link_3."'".')".'.">".$itms2[$k]["name_localized"].'</span></a>';
                                $itms3 = ApiService::Request(config('env.app_group_site'), 'entity', 'category-childs-by-root-id', array('root_id' => $itms2[$k]["id"]))->response;
                                if(count($itms3)>0){
                                    $result .='<ul class="ul-my">';
                                    for($m=0;$m<count($itms3);$m++){//CUARTO NIVEL
                                        $result .='<li class="li-my"><a href="' . RouteService::GetSiteURL("catalogue-category", [$itms3[$m]["url_code_localized"]]) . '" class="caret" style="display: table-footer-group;">'.$itms3[$m]["name_localized"].'</a>';
                                        $result.="</li>"; 
                                    }
                                    $result.="</ul>"; 
                                }

                                $result.="</li>"; 
                            }
                            $result .="</ul>";
                        }
                        $result.="</li>"; 
                    }
                    $result .="</ul>";
                }
                $result.="</li>"; 

            }
            /*

                        <li style="font-size: 20px;border-bottom: 1px solid black"><a class="caret" style="display: table-footer-group;">Beverages</a>
                          <ul class="ul-my">
                            <li class="li-my"><a>Water</a></li>
                            <li class="li-my"><a>Coffee</a></li>
                            <li class="li-my"><a class="caret"  style="display: table-footer-group;">Tea</a>
                              <ul class="ul-my">
                                <li class="li-my"><a style="">Tea</a></li>
                                <li class="li-my"><a>White Tea</a></li>
                                <li><a class="caret"  style="display: table-footer-group;">Green Tea</a>
                                  <ul class="ul-my">
                                    <li class="li-my"><a>Sencha</a></li>
                                    <li class="li-my"><a>Gyokuro</a></li>
                                    <li class="li-my"><a>Matcha</a></li>
                                    <li class="li-my"><a>Pi Lo Chun</a></li>
                                  </ul>
                                </li>
                              </ul>
                            </li>  
                          </ul>
                        </li>
            */
            $result .='</ul>';
        }
    
        return $result;
    }
    public static function ShowInput($type,$id,$label,$with_title=false,$content_class=null,$aditional_params=array()){
        switch ($type){
            case "input_date":
                return '
                    <div id="inp-container-'.$id.'" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group date inp-error-display" data-provide="datepicker" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <input class="form-control inp-error-display '.$id.'" id="'.$id.'" name="'.$id.'" type="text" placeholder="'.trans($label.'.placeholder').'">
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text input-icon-label inp-error-display">
                                    <span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span>
                                </div>
                            </div>
                        </div>
                        <div><label class="error-text"></label></div>
                    </div>';
            case "checkbox":
                return '
                <div id="inp-container-'.$id.'" class="inp-container '.($content_class==null?'':$content_class).'">
                <br/>
                    <div class="inp-error-display">
                        <input type="checkbox" id="'.$id.'" name="'.$id.'" class="inp-error-display">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                    </div>
                    <div><label class="error-text"></label></div>
                </div>';
            case "input_radio_price":
                return '
                    <div id="inp-container-'.$id.'" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'

                        <div class="input-group inp-error-display">
                            <div class="input-group-prepend inp-error-display">
                                <span class="input-group-text inp-error-display"><input type="radio" id="'.$id.'_radio" value="'.$id.'" name="'.$aditional_params["group_name"].'"'.($aditional_params["checked"]?"checked":"").'></span>
                            </div>
                            <div class="input-group-prepend inp-error-display">
                                <select id="'.$id.'_currency" class="form-control select2 inp-error-display" '.($aditional_params["enabled"]?"":"disabled").'></select>
                            </div>
                            <input type="number" class="form-control inp-error-display" id="'.$id.'_value" name="'.$id.'_value" placeholder="'.trans($label.'.placeholder').'" '.($aditional_params["enabled"]?"":"disabled").'>
                        </div>
                        <div><label class="error-text"></label></div>
                    </div>';
            case "input_group":
                return '
                    <div id="inp-container-'.$id.'" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <input class="form-control inp-error-display" id="'.$id.'" name="'.$id.'" type="'.(strpos($id, 'email')!==false?"email":(strpos($id, 'password')!==false?"password":"text")).'" placeholder="'.trans($label.'.placeholder').'">
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text input-icon-label inp-error-display">
                                    <span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span>
                                </div>
                            </div>
                        </div>
                        <div><label class="error-text"></label></div>
                    </div>';
            case "input_group_worktime":
                return '
                    <div id="inp-container-'.$id.'" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <input class="form-control inp-error-display" id="'.$id.'" name="'.$id.'" type="'.(strpos($id, 'email')!==false?"email":(strpos($id, 'password')!==false?"password":"text")).'" placeholder="'.trans($label.'.placeholder').'" disabled>
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text inp-error-display"><span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span></div>
                            </div>
                        </div>
                        <div><label class="error-text"></label></div>
                    </div>';

            case "input_text":
                return '
                    <div id="inp-container-'.$id.'" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <input class="form-control inp-error-display" id="'.$id.'" onkeypress="return justLetters(event)" name="'.$id.'" type="'.(strpos($id, 'email')!==false?"email":(strpos($id, 'password')!==false?"password":"text")).'" placeholder="'.trans($label.'.placeholder').'">
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text input-icon-label inp-error-display">
                                    <span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span>
                                </div>
                            </div>
                        </div>
                        <div><label class="error-text"></label></div>
                    </div>';
            case "input_number":
                return '
                    <div id="inp-container-'.$id.'" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <input class="form-control inp-error-display" onkeypress="return justNumbers(event)" id="'.$id.'" name="'.$id.'" type="'.(strpos($id, 'email')!==false?"email":(strpos($id, 'password')!==false?"password":"text")).'" placeholder="'.trans($label.'.placeholder').'">
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text input-icon-label inp-error-display">
                                    <span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span>
                                </div>
                            </div>
                        </div>
                        <div><label class="error-text"></label></div>
                    </div>
                    ';
            case "select":

                return '
                <div id="inp-container-'.$id.'" class="inp-container '.($content_class==null?'':$content_class).'">
                    '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                    <div class="inp-error-display">
                        <select id="'.$id.'" name="'.$id.'" class="form-control select2 inp-error-display" style="width: 100%;"></select>
                    </div>
                    <div><label class="error-text"></label></div>
                </div>';
        }
        return "";
    }
    public static function ParseImage($image,$folder=""){
		
		$link = "";
		
        if(strpos($image,"http") === false){
            $link =  asset("/storage/app/loaded/img/".($folder==""?"":$folder."/").$image);
        }else{
            $link = $image;
        }
		
		$link = str_replace("magico.test.bitz.pe/","magico.pe/",$link);
		return $link;
    }
}
