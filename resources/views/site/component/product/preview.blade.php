<?php
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\SiteService;
use App\Http\Modules\Site\Services\HtmlService;
use \App\Http\Modules\Site\Services\ProductService;
use \App\Http\Common\Helpers\StringHelper;
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_site');
$lang = config('site.ui.component.product.preview.lang');

if(!isset($product_data) || $product_data == null) return ;
if(!isset($specifications) || $specifications == null) return ;

$lstPrices = ProductService::GetPrices($product_data);
$lstPreviews = ProductService::GetPreviews($specifications,$objSpColor,$objSpNeedUserInfo);
$lstMySpecifications = ProductService::GetMySpecifications($product_data);
$lstSimilarSpecifications = ProductService::GetSimilarSpecifications($product_data);

$htmlPhotos = "";
$data_photos = $product_data["product_photos"];
$arrPhotos = json_decode($data_photos,true);
for($i=0;$i<count($arrPhotos);$i++){
    if($arrPhotos[$i]!=""){
     $htmlPhotos=$htmlPhotos.'<li data-thumb="'.HtmlService::ParseImage($arrPhotos[$i],"products").'">
        <img style="width:350px;height:350px;object-fit: contain;object-position: center;" src="'.HtmlService::ParseImage($arrPhotos[$i],"products").'" alt="" /></li>';
    }
}

if(isset($product_data["VISIBLE"])==false){
    $product_data["VISIBLE"] = 1;
}

$spColorCode = null;
if($objSpColor != null) $spColorCode = $objSpColor["code"];
?>
@component(config('site.ui.component.engine.modal.view'))
    @slot('modal_id','quick-view')
    @slot('modal_body')
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">{!! trans($lang.'lbl_close'); !!}</span></button>
        <div class="row" style="margin: 0px!important;">
            <div class="col-md-12">
                <div class="tovar_view_fotos col-md-6" style="margin: 0px!important;padding: 0px!important;">
                    <div id="prevSlider" class="flexslider"><ul class="slides">{!! $htmlPhotos !!}</ul></div>
                </div>
                <div class="tovar_view_description col-md-6">
                    <div class="tovar_view_title">{!! $product_data["product_name"] !!}</div>
                    <div class=" tovar_brend_price">
                        @if(round($lstPrices["other"])!=null)
                        <div class="pull-right tovar_view_price" style="text-decoration:line-through!important;font-size: 16px!important;">{!! $product_data["currency_symbol"]." ".number_format(round($lstPrices["other"],2),2) !!}</div><br/>
                        @endif
                        <div class="pull-right tovar_view_price">{!! $product_data["currency_symbol"]." ".number_format(round($lstPrices["principal"],2),2) !!}</div>
                    </div>
                    <div class="row col-md-12" style="padding: 0px!important;margin: 0px!important;">
                    <?php
                    for($x=0;$x<count($lstPreviews);$x++){
                        if(array_key_exists($lstPreviews[$x]["code"],$lstSimilarSpecifications)){
                            $is_color = ($lstPreviews[$x]["code"] == StringHelper::IsNull($spColorCode,""));

                            $lstSimSpec = $lstSimilarSpecifications[$lstPreviews[$x]["code"]];

                            if(count($lstSimSpec)>1){ 

                            
                                $template_li = "";
                                if($is_color) $template_li = '<a onclick="OpenSimilarUrlCodePreview(\''.$lstPreviews[$x]["code"].'\',\'[VALUE_PREVIEW]\',\'[VALUE_URL_PREVIEW]\')" class="color-variant-item [CLASS]" style="background-color: [VALUE]!important;"></a>';
                                else $template_li = '<a onclick="OpenSimilarUrlCodePreview(\''.$lstPreviews[$x]["code"].'\',\'[VALUE_PREVIEW]\',\'[VALUE_URL_PREVIEW]\')" class="[CLASS]">[VALUE]</a>';

                                echo ($is_color?"<div class='tovar_color_select col-md-6 col-xs-6'>":"<div class='tovar_size_select col-md-6 col-xs-6'>");
                                echo '<p style="margin:0px!important;">'.strtoupper($lstPreviews[$x]["name_localized"]).'</p>';
                                
                            
                                for($i=0;$i<count($lstSimSpec);$i++){
                                    $class = "";
                                    $value = $lstSimSpec[$i]["value"];
                                    $value_preview = $lstSimSpec[$i]["value"];
                                    $url_code = $lstSimSpec[$i]["url_code"];
                                    if($lstSimSpec[$i]["is_my"] || $lstSimSpec[$i]["value"] == $lstMySpecifications[$lstPreviews[$x]["code"]]){
                                        $class = "active";
                                        $value_preview = "NULL"; 
                                    }
                                    echo str_replace("[CLASS]",$class
                                        ,str_replace("[VALUE]",$value,
                                        str_replace("[VALUE_URL_PREVIEW]",$url_code,
                                            str_replace("[VALUE_PREVIEW]",$value,$template_li)
                                        ))
                                    );
                                }
                                echo "</div>";
                                echo '<input type="hidden" id="inpSP'.$lstPreviews[$x]["code"].'" value="'.$lstMySpecifications[$lstPreviews[$x]["code"]].'">';
                                echo '<input type="hidden" id="inpOrigSP'.$lstPreviews[$x]["code"].'" value="'.$lstMySpecifications[$lstPreviews[$x]["code"]].'">';
                            }
                        }else{
                            echo '<input type="hidden" id="inpSP'.$lstPreviews[$x]["code"].'" value="">';
                            echo '<input type="hidden" id="inpOrigSP'.$lstPreviews[$x]["code"].'" value="">';
						}
                    }
                    ?>
                    </div>
                    <input type="hidden" id="qtyPreview" value="1">
                    <div class="tovar_view_btn center">
                        <br/>
                        <a class="add_bag" href="#" onclick="SendAddToCart('{!! $product_data["PRODUCT_ID"] !!}','qtyPreview',false)" ><i class="fa fa-shopping-cart"></i>{!! trans($lang.'lbl_add_to_cart'); !!}</a>
                        <a class="add_bag" href="{!! RouteService::GetSiteURL('product',array($product_data["product_url_code"])) !!}" ><i class="fa fa-eye"></i>{!! trans($lang.'lbl_view_details'); !!}</a>
                    </div>
                </div>
            </div>
        </div>
        <script type="application/javascript">
            function OpenSimilarUrlCodePreview(code,value,url_code) {
                if(value === 'NULL') return false;
                <?php
                $str_params = "''";
                $int_limiter = ParameterService::GetParameter('db_query_limiter');
                $int_union = ParameterService::GetParameter('db_query_union');
                for($x=0;$x<count($lstPreviews);$x++){
                    $code = $lstPreviews[$x]["code"];
                    $str_params = $str_params.($x==0?'':'+"'.$int_limiter.'"').'+"'.$code.'" + "'.$int_union.'" + $("#inpSP'.$code.'").val()';
                    echo '$("#inpSP'.$code.'").val($("#inpOrigSP'.$code.'").val());'; //INICIALIZAMOS TODOS LOS HIDDEN PARA LUEGO MODIFICAR EL QUE SE DIO CLICK.
                }
				$product_url = RouteService::GetSiteURL('product', ['PROD_URL_CODE']);
                ?>
                $("#inpSP"+code).val(value);
                $('#quick-view').modal("hide");
                var product_url = ("{!! $product_url !!}").replace("PROD_URL_CODE", url_code);
                var filters = {!! $str_params !!};
                @component(config($group.'.ui.component.engine.ajax.view'))
                    @slot('internal_request',false)
                    @slot('app_group',$group)
                    @slot('ws_group','entity')
                    @slot('ws_name','product-similars')
                    @slot('parameters','
                        product_group_code: "'.$product_data["PRODUCT_GROUP_CODE"].'",
                        excluded_product_url_code: "'.$product_data["product_url_code"].'",
                        filters: filters,
                        sel_specification: code+"'.$int_union.'"+$("#inpSP"+code).val(),
                        currency_code: "'.SiteService::GetCurrencyCode().'"')
                    @slot('result_success')
                        if(response.length>0){
                            OpenPreview(response[0]["product_url_code"]);
                        }else{
							ShowErrorMessage("{!! trans($lang.'lbl_invalid_similar') !!}");
                        }
                    @endslot
                @endcomponent
            }
        </script>
    @endslot
    @slot('modal_class_01','bd-example-modal-lg')
    @slot('modal_class_03','quick-view-modal')
@endcomponent
