<?php
namespace App\Http\Modules\Admin\Services;

use App\Http\Common\Helpers\DateHelper;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class HtmlService{
    public static function GetMenuOptions($lang){

        $group = config('env.app_group_admin');
        $parent = '
        <li class="nav-item has-treeview <OPEN>">
            <a href="<URL>" class="nav-link <ACTIVE>">
                <i class="nav-icon <ICON>"></i><p><LABEL></i><i class="right <ARROW>"></i></p>
            </a>
            <!-- CHILDS -->
        </li>';
        $child = '<li class="nav-item"><a href="<URL>" class="nav-link <ACTIVE>"><i class="<ICON> nav-icon"></i><p><LABEL></p></a></li>';

        $result = "";
        $menu = config($group.'.menu');

        $keys = array_keys($menu);


        for($i=0;$i<count($keys);$i++){
            $subresult = '';
            $option = $menu[$keys[$i]];
            $is_active = 0;

            $subresult = $parent;
            $subresult = str_replace("<LABEL>",trans($lang.$keys[$i].'.label'),$subresult);
            $subresult = str_replace("<ICON>",trans($lang.$keys[$i].'.icon'),$subresult);
            if(array_key_exists("url",$option)){
                $url = RouteService::GetAdminURL($option["url"]);
                $is_active = $is_active + (url()->full() == $url)?1:0;
                $subresult = str_replace("<URL>",$url,$subresult);
                $subresult = str_replace("<ARROW>","",$subresult);


            }else{

                $childs = '<ul class="nav nav-treeview">';
                $submenu = config($group.'.menu.'.$keys[$i]);

                $SMkeys = array_keys($submenu);

                for($j=0;$j<count($SMkeys);$j++){
                    $suboption = $submenu[$SMkeys[$j]];
                    $url = RouteService::GetAdminURL($suboption["url"]);

                    $is_active = $is_active + (url()->full() == $url)?1:0;

                    $sbChild = $child;
                    $sbChild = str_replace("<URL>",$url,$sbChild);
                    $sbChild = str_replace("<LABEL>",trans($lang.$keys[$i].'.'.$SMkeys[$j].'.label'),$sbChild);
                    $sbChild = str_replace("<ICON>",trans($lang.$keys[$i].'.'.$SMkeys[$j].'.icon'),$sbChild);
                    $sbChild = str_replace("<ACTIVE>",((url()->full() == $url)?"active":""),$sbChild);

                    $childs = $childs . $sbChild;


                }

                $childs = $childs.'</ul>';
                $subresult = str_replace("<!-- CHILDS -->",$childs,$subresult);
                $subresult = str_replace("<URL>","#",$subresult);
                $subresult = str_replace("<ARROW>","fas fa-angle-left",$subresult);
            }
            $subresult = str_replace("<OPEN>",($is_active>0?"menu-open":""),$subresult);
            $subresult = str_replace("<ACTIVE>",($is_active>0?"active":""),$subresult);
            $result = $result . $subresult;
        }
        return $result;
    }
    public static function ParseImage($image,$folder=null){
        if($folder==null){
            $folder = config(config('env.app_group_admin').".value.image.folder.assets");
        }
        if(strpos($image,"http") === false){
            return asset(config('env.app_image_folder')."/".$folder."/".$image);
        }else{
            return $image;
        }
    }
    public static function ShowInput($type,$id,$label,$with_title=false,$content_class=null,$aditional_params=array()){
        switch ($type){
            case "checkbox":
                return '
                <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                <br/>
                    <div class="inp-error-display">
                        <input type="checkbox" id="'.$id.'" name="'.$id.'" class="inp-error-display">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                    </div>
                    <div><label class="error-text" style="display:none!important;"></label></div>
                </div>';
            case "input_radio_price":
                return '
                    <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
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
                        <div><label class="error-text" style="display:none!important;"></label></div>
                    </div>';
            case "input_group":
                $type_input = "text";
                if(strpos(strtolower($id), 'email')!==false) $type_input = "email";
                if(strpos(strtolower($id), 'password')!==false) $type_input = "password";
                return '
                    <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <input class="form-control inp-error-display" id="'.$id.'"  name="'.$id.'" type="'.$type_input.'" placeholder="'.trans($label.'.placeholder').'">
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text inp-error-display"><span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span></div>
                            </div>
                        </div>
                        <div><label class="error-text" style="display:none!important;"></label></div>
                    </div>';

            case "input_date":
                return '
                    <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <div class="input-group-prepend" style="width:100%!important;">
                                <input class="form-control datetimepicker-input inp-error-display" id="'.$id.'"  name="'.$id.'"  data-target="#'.$id.'" type="text" placeholder="'.trans($label.'.placeholder').'" data-target-input="nearest">
                                <div class="input-group-append inp-error-display" data-target="#'.$id.'" data-toggle="datetimepicker">
                                    <div class="input-group-text inp-error-display"><span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span></div>
                                </div>
                            </div>
                        </div>
                        <div><label class="error-text" style="display:none!important;"></label></div>
                    </div>';

            case "input_daterange":
                return '
                    <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <div class="input-group-prepend" style="width:100%!important;">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                <input class="form-control inp-error-display float-right" id="'.$id.'"  name="'.$id.'" type="text" placeholder="'.trans($label.'.placeholder').'">
                                <div class="input-group-append inp-error-display">
                                    <div class="input-group-text inp-error-display"><span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span></div>
                                </div>
                            </div>
                        </div>
                        <div><label class="error-text" style="display:none!important;"></label></div>
                    </div>';

            case "input_price":
                $lstCurrency = ApiService::Request(config('env.app_group_admin'), 'entity', 'currency-get', array())->response;
                $html_data =  '
                    <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="btn_currency_'.$id.'">'.$lstCurrency[0]["name_localized"].'</button>
                                <ul class="dropdown-menu">';
                for($i=0;$i<count($lstCurrency);$i++){
                    $html_data = $html_data.'<li class="dropdown-item" id="li_currency_'.$lstCurrency[$i]["id"].'_'.$id.'" onclick="ChangeInputPrice(\''.$id.'\',\''.trim($lstCurrency[$i]["id"]).'\')">'.$lstCurrency[$i]["name_localized"].'</li>';
                }
                $html_data = $html_data.'
                                </ul>
                            </div>
                            <input type="text" class="form-control inp-error-display" id="'.$id.'" name="'.$id.'" type="text" placeholder="'.trans($label.'.placeholder').'">
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text inp-error-display"><span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span></div>
                            </div>
                        </div>
                        <div><label class="error-text" style="display:none!important;"></label></div>
                        <div><input type="hidden" id="currency_id_'.$id.'" value="'.trim($lstCurrency[0]["id"]).'"></div>
                        <div><input type="hidden" id="default_currency_id_'.$id.'" value="'.trim($lstCurrency[0]["id"]).'"></div>
                    </div>';
                return $html_data;

            case "input_localized":
                $type_input = "text";
                if(strpos(strtolower($id), 'email')!==false) $type_input = "email";
                if(strpos(strtolower($id), 'password')!==false) $type_input = "password";

                $langs = array();
                $languages = config('laravellocalization.supportedLocales');
                $languages_codes = array_keys($languages);
                $html_data =  '
                    <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                        '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                        <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="btn_language_'.$id.'">'.$languages[$languages_codes[0]]["name"].'</button>
                                <ul class="dropdown-menu">';
                for($i=0;$i<count($languages_codes);$i++){
                    $langs[] = trim($languages_codes[$i]);
                    $html_data = $html_data.'<li class="dropdown-item" id="li_language_'.trim($languages_codes[$i]).'_'.$id.'" onclick="ChangeInputLanguage(\''.$id.'\',\''.trim($languages_codes[$i]).'\')">'.$languages[$languages_codes[$i]]["name"].'</li>';
                }
                $html_data = $html_data.'
                                </ul>
                            </div>
                            <input type="text" class="form-control inp-error-display" id="inpValue_'.$id.'"  onkeyup="UpdateInputLanguageValue(\''.$id.'\')" name="'.$id.'" type="'.$type_input.'" placeholder="'.trans($label.'.placeholder').'">
                            <div class="input-group-append inp-error-display">
                                <div class="input-group-text inp-error-display"><span id="inp-icon-'.$id.'" class="'.trans($label.'.icon').'"></span></div>
                            </div>
                        </div>
                        <div><label class="error-text" style="display:none!important;"></label></div>
                        <div><input type="hidden" id="'.$id.'"></div>
                        <div><input type="hidden" id="languages_'.$id.'" value=\''.json_encode($langs,true).'\'></div>
                        <div><input type="hidden" id="sel_current_language_'.$id.'" value="'.trim($languages_codes[0]).'"></div>
                    </div>';
                return $html_data;
            case "select":
                return '
                <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                    '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                    <div class="inp-error-display">
                        <select id="'.$id.'" name="'.$id.'" class="form-control select2 inp-error-display" style="width: 100%;"></select>
                    </div>
                    <div><label class="error-text" style="display:none!important;"></label></div>
                </div>';
            case "select_multiple":
                return '
                <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                    '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                    <div class="inp-error-display">
                        <select id="'.$id.'" name="'.$id.'" style="width: 100%;" class="form-control inp-error-display" multiple="multiple"></select>
                    </div>
                    <div><label class="error-text" style="display:none!important;"></label></div>
                </div>';
            case "input_image_localized":
                    $type_input = "text";
                    if(strpos(strtolower($id), 'email')!==false) $type_input = "email";
                    if(strpos(strtolower($id), 'password')!==false) $type_input = "password";
    
                    $langs = array();
                    $languages = config('laravellocalization.supportedLocales');
                    $languages_codes = array_keys($languages);
                    $html_data =  '
                        <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                            '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                            <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="btn_language_'.$id.'">'.$languages[$languages_codes[0]]["name"].'</button>
                                    <ul class="dropdown-menu">';
                    for($i=0;$i<count($languages_codes);$i++){
                        $langs[] = trim($languages_codes[$i]);
                        $html_data = $html_data.'<li class="dropdown-item" id="li_language_'.trim($languages_codes[$i]).'_'.$id.'" onclick="ChangeInputLanguage(\''.$id.'\',\''.trim($languages_codes[$i]).'\')">'.$languages[$languages_codes[$i]]["name"].'</li>';
                    }
                    $input=" $('#file-".$id."').click() ";
                    $html_data = $html_data.'
                                    </ul>
                                </div>
                                <div class="custom-file">
                                    <input type="text" class="form-control custom-file-input inp-error-display" id="inpValue_'.$id.'"  onkeyup="UpdateInputLanguageValue(\''.$id.'\')" name="'.$id.'" readonly type="'.$type_input.'" placeholder="'.trans($label.'.placeholder').'">
                                    <label class="custom-file-label" for="inpValue_'.$id.'"></label>
                                </div>
                                <div class="input-group-append inp-error-display" id="section-btn">
                                    <button onclick="'.$input.'" class="btn btn-outline-secondary search">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-outline-primary Load">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-outline-success add">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div><label class="error-text" style="display:none!important;"></label></div>
                            <div id="section-image"></div>
                            <div><input type="file" hidden name="file-'.$id.'" id="file-'.$id.'"><div>
                            <div><input type="hidden" id="languages_'.$id.'" value=\''.json_encode($langs,true).'\'></div>
                            <div><input type="hidden" id="sel_current_language_'.$id.'" value="'.trim($languages_codes[0]).'"></div>
                        </div>';
                return $html_data;
            break;
            case "input_image":
                $type_input = "text";
                    if(strpos(strtolower($id), 'email')!==false) $type_input = "email";
                    if(strpos(strtolower($id), 'password')!==false) $type_input = "password";
                    $html_data =  '
                        <div id="inp-container-'.$id.'" style="margin-top:0px!important;" class="inp-container '.($content_class==null?'':$content_class).'">
                            '.($with_title?'<label>'.trans($label.'.title').'</label>':'').'
                            <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">';
                    $input=" $('#file-".$id."').click() ";
                    $html_data = $html_data.'
                                </div>
                                <div class="custom-file">
                                    <input type="text" class="form-control custom-file-input inp-error-display" id="'.$id.'"  name="'.$id.'" readonly type="'.$type_input.'" placeholder="'.trans($label.'.placeholder').'">
                                    <label class="custom-file-label" for="'.$id.'"></label>
                                </div>
                                <div class="input-group-append inp-error-display">
                                        <button type="button" onclick="'.$input.'" id="inp-btn-search-'.$id.'" class="btn btn-outline-primary">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" title="Cargar Imagen" id="inp-btn-load-'.$id.'" class="btn btn-outline-success">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" title="Cargar Imagen" id="inp-btn-delete-'.$id.'" class="btn btn-outline-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                </div>
                            </div>
                            <div><label class="error-text" style="display:none!important;"></label></div>
                            <div><input type="file" hidden name="file-'.$id.'" id="file-'.$id.'"><div>
                        </div>';
                return $html_data;
            break;
            case "input_checkbox_spinner":
                $type_input="checkbox";
                    $html_data='<div class="'.($content_class==null?'':$content_class).'">
                                    <div class="custom-control custom-switch">
                                        <input type="'.$type_input.'" class="custom-control-input" id="estatus-'.$id.'">
                                        <label class="custom-control-label" for="estatus-'.$id.'">'.trans($label.'.title').'</label>
                                    </div>
                                </div>';
                return $html_data;
            break;
        }
        return "";
    }
    
}
