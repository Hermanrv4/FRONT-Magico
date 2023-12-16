<?php
namespace App\Http\Modules\Site\Helpers;

use App\Http\Common\Helpers\StringHelper;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\HtmlService;
use App\Http\Modules\Site\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer;

class MailHelper
{
    public static function SendMail($subject, $message, $toMail, $toName){
        try {
            $mailserver = json_decode(ParameterService::GetParameter('int_mailserver'),true);

            $mail = new PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->CharSet = 'Utf-8';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = false;
            $mail->Host = $mailserver["servidor"];
            $mail->Username = $mailserver["usuario"];
            $mail->Password = $mailserver["clave"];
            $mail->From = ParameterService::GetParameter('business_email');
            $mail->FromName = ParameterService::GetParameter('business_name');
            $mail->Port = $mailserver["puerto"];
            $message = MailHelper::ConfigureMailInformation($message);
            $mail->addAddress($toMail, $toName);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->WordWrap = 50;
            $mail->isHTML(true);
            if (!$mail->send()) {
                //dd('Mailer Error: ' . $mail->ErrorInfo);
                return false;
            }else{
                //dd("OK");
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
    public static function ConfigureMailInformation($message){
        date_default_timezone_set(config('env.app_timezone'));
        $message = str_replace("[<|MAIL_SOPORTE|>]", ParameterService::GetParameter('business_email'), $message);
        $message = str_replace("[<|FACEBOOK|>]",  ParameterService::GetParameter('sn_facebook_url'), $message);
        $message = str_replace("[<|INSTAGRAM|>]",  ParameterService::GetParameter('sn_instagram_url'), $message);
        $message = str_replace("[<|FACEBOOK_IMAGE|>]", asset("storage/app/mail/img/facebook2x.png"), $message);
        $message = str_replace("[<|INSTAGRAM_IMAGE|>]",  asset("storage/app/mail/img/instagram2x.png"), $message);
        $message = str_replace("[<|WEB|>]", config('env.app_url'), $message);
        $message = str_replace("[<|AÑO|>]", date("Y"), $message);
        $message = str_replace("[<|EMPRESA|>]", ParameterService::GetParameter('business_name'), $message);
        return $message;
    }
    public static function GetHTMLContain($path){
        $url = $path;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $contents = curl_exec($ch);
        curl_close($ch);
        return $contents;
    }
    /*----------------------------------------------------------------------------------------------------------------------------*/
    public static function SendMail_Wellcome_Customer($objUser,$email=null){
        try{
            $subject = "Bienvenido a Mágico";
            $name = null;
            $mail = null;
            if($email!=null){
                $name = $email;
                $mail = $email;
            }else{
                $name = $objUser["email"];
                $mail = $objUser["first_name"];
            }
            $message = MailHelper::GetHTMLContain(asset('storage/app/mail/wellcome_customer.html'));
            MailHelper::SendMail($subject,$message,$mail,$name);
        }Catch(\Exception $ex){}
    }
    /*----------------------------------------------------------------------------------------------------------------------------*/
    public static function SendMail_Contact_Customer($parameters){
        $bussines_mail = ParameterService::GetParameter("business_email");
        $bussines_name = ParameterService::GetParameter("business_name");
        if($parameters["is_company"]==1){
            $subject = "Nuevo Pedido Corporativo";
            $message = "Felicicades, se ha ralizado un pedido corporativo con los siguientes datos:<br><br>";
            $message = $message."Nombre: ".$parameters["name"]."<br>";
            $message = $message."Apellidos: ".$parameters["last_name"]."<br>";
            $message = $message."Correo: ".$parameters["mail"]."<br>";
            $message = $message."Nombre de la empresa: ".$parameters["name_company"]."<br>";
            $message = $message."Telefono: ". $parameters["phone"]."<br>";
            $message = $message."Mensaje: ".$parameters["message"]."<br>";
            
            MailHelper::SendMail($subject,$message,$bussines_mail,$bussines_name);
        }else{
            try{
            $subject = "Formulario de contacto";
            $message = MailHelper::GetHTMLContain(asset('storage/app/mail/contact_form.html'));
            $message = str_replace("[<|CONTACT_NAMES|>]", $parameters["name"], $message);
            $message = str_replace("[<|CONTACT_MAIL|>]", $parameters["mail"], $message);
            $message = str_replace("[<|CONTACT_PHONE|>]", $parameters["phone"], $message);
            $message = str_replace("[<|CONTACT_MESSAGE|>]", $parameters["message"], $message);
            $message = str_replace("[<|URL_IMG_WELLCOME_CLIENT|>]", asset('/storage/app/mail/img/wellcome.jpeg'), $message);
            MailHelper::SendMail($subject,$message,$bussines_mail,$bussines_name);

            $message = "Hemos recibido sus solicitud, nos comunicaremos en breve.<br><br>";
            MailHelper::SendMail($subject,$message,$parameters["mail"],$parameters["name"]);
            }Catch(\Exception $ex){

            }
        }
        
    }
    
    /*----------------------------------------------------------------------------------------------------------------------------*/
    public static function SendMail_Notify_Order_Status($order_id,$status,$for_admin=0){
        try{
            $data = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get-mail-data', array("order_id" => $order_id))->response;

            $specifications = ApiService::Request(config('env.app_group_site'), 'entity', 'specification-get', array())->response;
            $lstPreviews = ProductService::GetPreviewsAndNeedUserInfo($specifications,$objSpColor,$objSpNeedUserInfo);

            $lang = config('site.ui.mail.lang')."notify_order_status.";

            $item_header = MailHelper::GetHTMLContain(asset('storage/app/mail/components/notify_order_status/item_order_header.html'));
            $item_detail = MailHelper::GetHTMLContain(asset('storage/app/mail/components/notify_order_status/item_order_detail.html'));

            if($for_admin){
                $subject = trans($lang.'admin.subject_'.$status);
                $message = MailHelper::GetHTMLContain(asset('storage/app/mail/notify_order_status_admin.html'));

                $message = str_replace("[<|TITLE|>]", trans($lang.'admin.title_'.$status), $message);
                $message = str_replace("[<|STATUS_IMAGE|>]", asset('storage/app/mail/img/img_status_'.$status.'.jpg'), $message);
                $message = str_replace("[<|MESSAGE|>]", trans($lang.'admin.message_'.$status), $message);
            }else{
                $subject = trans($lang.'subject_'.$status);
                $message = MailHelper::GetHTMLContain(asset('storage/app/mail/notify_order_status.html'));

                $message = str_replace("[<|TITLE|>]", trans($lang.'title_'.$status), $message);
                $message = str_replace("[<|STATUS_IMAGE|>]", asset('storage/app/mail/img/img_status_'.$status.'.jpg'), $message);
                $message = str_replace("[<|MESSAGE|>]", trans($lang.'message_'.$status), $message);
            }

            //<editor-fold des="REPORT HEADER">
            /*--- SE INGRESA LA INFORMACIÓN DE LA CABECERA ---*/
            $message = str_replace("[<|TITLE_ORDER_HEADER|>]", trans($lang.'title_order_header'), $message);
            $header_html = "";
            /*-------------------------------*/
            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_section_buyer'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]","",$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_buyer_first_name'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["user"]["first_name"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_buyer_last_name'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["user"]["last_name"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_buyer_email'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["user"]["email"],$item);
            $header_html = $header_html . $item;
            /*-------------------------------*/
            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]","&nbsp;",$item);
            $item = str_replace("[<|ITEM_VALUE|>]","&nbsp;",$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_section_delivery'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]","",$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_delivery_country'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["ubication"]["cities"][3]["name_localized"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_delivery_department'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["ubication"]["cities"][2]["name_localized"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_delivery_province'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["ubication"]["cities"][1]["name_localized"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_delivery_district'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["ubication"]["cities"][0]["name_localized"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_delivery_address'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["ubication"]["address"]["address"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_delivery_phone'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["ubication"]["address"]["phone"],$item);
            $header_html = $header_html . $item;
            /*-------------------------------*/
            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]","&nbsp;",$item);
            $item = str_replace("[<|ITEM_VALUE|>]","&nbsp;",$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_section_receive'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]","",$item);
            $header_html = $header_html . $item;

            $receiver_info = json_decode($data["order"]["receiver_info"],true);
            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_receive_first_name'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$receiver_info["receiver_first_name"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_receive_last_name'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$receiver_info["receiver_last_name"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_receive_phone'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$receiver_info["receiver_phone"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_receive_email'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$receiver_info["receiver_email"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_receive_dni'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$receiver_info["receiver_dni"],$item);
            $header_html = $header_html . $item;
            /*-------------------------------*/
            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]","&nbsp;",$item);
            $item = str_replace("[<|ITEM_VALUE|>]","&nbsp;",$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_section_billing'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]","",$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_order_at'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["order"]["ordered_at"],$item);
            $header_html = $header_html . $item;

            if(isset($data["order"]["event_at"])){
                $item = $item_header;
                $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_event_at'),$item);
                $item = str_replace("[<|ITEM_VALUE|>]",$data["order"]["event_at"],$item);
                $header_html = $header_html . $item;  
            }
            
            if(isset($data["order"]["hour_range"])){
            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_hour_at'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["order"]["hour_range"],$item);
            $header_html = $header_html . $item;
            }

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_cod_authorization'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["order"]["transaction_pay_code"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_cod_operation'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["order"]["token"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_currency'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["currency"]["name_localized"],$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_subtotal'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["currency"]["symbol"]." ".number_format($data["order"]["sub_total"],2),$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_delivery'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["currency"]["symbol"]." ".number_format($data["order"]["shipping_cost"],2),$item);
            $header_html = $header_html . $item;

            $item = $item_header;
            $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_total'),$item);
            $item = str_replace("[<|ITEM_VALUE|>]",$data["currency"]["symbol"]." ".number_format($data["order"]["total"],2),$item);
            $header_html = $header_html . $item;
            /*-------------------------------*/
            $message = str_replace("[<|ITEM_ORDER_HEADER|>]", $header_html, $message);
            //</editor-fold>

            /*--- SE INGRESA LA INFORMACIÓN DE PRODUCTOS ---*/
            $message = str_replace("[<|TITLE_ORDER_DETAIL|>]", trans($lang.'title_order_detail'), $message);
            $detail_html = "";
            for($i=0;$i<count($data["order_detail"]);$i++){
                $prd_data = $data["order_detail"][$i]["product"];
                $qty = floatval($data["order_detail"][$i]["cart"]["quantity"]);
                $price = floatval($prd_data["ONLINE_PRICE"]);
                $item = $item_detail;
                $lstFontBackPhotos = ProductService::GetFrontBackPhotos($prd_data);

                $str_specifications = "<ul>";
                $lstMySpecifications = ProductService::GetMySpecifications($prd_data);
                foreach ($lstMySpecifications as $key => $value)
                {
                    $specificationName = "";
                    $specificationValue = "";

                        for ($x = 0; $x < count($specifications); $x++) {
                            if ($specifications[$x]["code"] == $key) {
                                $specificationName = StringHelper::IsNull($specifications[$x]["name_localized"],"-");
                                break;
                            }
                        }
                        $specificationValue = StringHelper::IsNull($value,"-");

                    $str_specifications = $str_specifications."<li/><u>".ucwords(strtolower($specificationName))."</u>: ".ucwords(strtolower($specificationValue))."</li>";
                }
                $str_specifications = $str_specifications."</ul>";

                $item = str_replace("[<|PRODUCT_IMAGE|>]",$lstFontBackPhotos["front"],$item);
                $item = str_replace("[<|PRODUCT_SKU|>]",trans($lang.'lbl_title_product_sku')." ".$prd_data["PRODUCT_SKU"],$item);
                $item = str_replace("[<|PRODUCT_NAME|>]",trans($lang.'lbl_title_product_name')." ".$prd_data["PRODUCT_NAME"],$item);
                $item = str_replace("[<|PRODUCT_SPECIFICATIONS|>]",trans($lang.'lbl_title_product_specifications')." ".$str_specifications,$item);

                if(isset($prd_data["PROVIDER_COMMERCIAL_NAME"])){
                   $item = str_replace("[<|PRODUCT_PROVIDER|>]",trans($lang.'lbl_title_product_provider')." ".$prd_data["PROVIDER_COMMERCIAL_NAME"],$item);
                }else{
                    $item = str_replace("[<|PRODUCT_PROVIDER|>]","",$item);
                }

                $item = str_replace("[<|PRODUCT_PRICE|>]",trans($lang.'lbl_title_product_price')." ".$data["currency"]["symbol"]." ".number_format($price,2),$item);
                $item = str_replace("[<|PRODUCT_QUANTITY|>]",trans($lang.'lbl_title_product_quantity')." ".intval($qty),$item);
                $item = str_replace("[<|PRODUCT_TOTAL|>]",trans($lang.'lbl_title_product_total')." ".$data["currency"]["symbol"]." ".number_format($price*$qty,2),$item);
                $detail_html = $detail_html . $item;
            }
            $message = str_replace("[<|ITEM_ORDER_DETAIL|>]", $detail_html, $message);

            /*--- SE INGRESA INFORMACIÓN ADICIONAL DEL CORREO ---*/
            $message = str_replace("[<|COMPANY_IMAGE|>]", HtmlService::ParseImage(ParameterService::GetParameter('logo_img')), $message);
            $message = str_replace("[<|URL_CONTINUE_BUYING|>]", RouteService::GetSiteURL('catalogue-all'), $message);
            $message = str_replace("[<|BUTTON_CONTINUE_BUYING|>]",trans($lang.'btn_continue_buying'), $message);
            $message = str_replace("[<|COMPANY_COLOR|>]", ParameterService::GetParameter('principal_color'), $message);

            /*--- SE ENVÍA EL CORREO AL CLIENTE ---*/
            if($for_admin){
                MailHelper::SendMail($subject,$message,"jpellegrin@merlishop.com","Administrador");
                MailHelper::SendMail($subject,$message,"crossi@merlishop.com","Administrador");
                MailHelper::SendMail($subject,$message,"jcaceres@tecincience.com","Administrador");
                /*MailHelper::SendMail($subject,$message,"francisco.caceres.993@gmail.com","Administrador");*/
            }else{
                /*MailHelper::SendMail($subject,$message,"francisco.caceres.993@gmail.com",$data["user"]["first_name"]);*/
                MailHelper::SendMail($subject,$message,$data["user"]["email"],$data["user"]["first_name"]);
            }

            if($status==config('site.value.order.payment-status.approved')&&!$for_admin){
                MailHelper::SendMail_Notify_Order_Status($order_id,$status,1);
            }
        }Catch(\Exception $ex){dd($ex);}
    }
    public static function SendMail_Order_Success($order_id,$status,$for_admin=0,$fortesting=0,$resend=null){

        try{
            $data = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get-mail-data', array("order_id" => $order_id))->response;
            $specifications = ApiService::Request(config('env.app_group_site'), 'entity', 'specification-get', array())->response;
            $lstPreviews = ProductService::GetPreviewsAndNeedUserInfo($specifications,$objSpColor,$objSpNeedUserInfo);
            
            /********************************************************** */
            $user = $data["user"];
            $order = $data["order"];
            $order_detail = $data["order_detail"];
            $currency = $data["currency"];
            $ubication = $data["ubication"];
            $aditional_info = (array)json_decode($order["aditional_info"]);
            /********************************************************** */
            $lang = config('site.ui.mail.lang')."notify_order_status.";
            $tax_percent = ParameterService::GetParameter('tax');
            $symbol = $data["currency"]["symbol"];

            $item_header = MailHelper::GetHTMLContain(asset('storage/app/mail/components/notify_order_status/item_order_header.html'));
            $item_detail = MailHelper::GetHTMLContain(asset('storage/app/mail/components/notify_order_status/item_order_detail.html'));
            $detail_html = "";
            $articulos_comprados = "";

            $total = 0;

            for($i=0;$i<count($data["order_detail"]);$i++) {
                $prd_data = $data["order_detail"][$i]["product"];
                $qty = intval($data["order_detail"][$i]["cart"]["quantity"]);
                $price = floatval($prd_data["online_price"]);
                $item = $item_detail;
                $lstFontBackPhotos = ProductService::GetFrontBackPhotos($prd_data);

                $articulos_comprados = $articulos_comprados . "<tr>";
                if(count($lstFontBackPhotos)>0){
                    $articulos_comprados = $articulos_comprados . " <td class='vertical-middle center '><img class='imagen' src='".$lstFontBackPhotos["front"]."' style='width:35px;height:35px;'></td>";
                }else{
                    $articulos_comprados = $articulos_comprados . " <td class='vertical-middle center'> - </td>";
                }
                
                $articulos_comprados = $articulos_comprados . " <td class='vertical-middle' style='padding-left: 5%;padding-right: 5%'>".$prd_data["product_name"]."</td>";
            
                $subtotal = floatval($qty)*$price;
                $impuesto = $subtotal*($tax_percent/100.0);
                $total = $total + $subtotal;
                
                $articulos_comprados = $articulos_comprados . " <td class='vertical-middle center' style='text-align:center;min-width: 70px'>".$qty."</td>";
                $articulos_comprados = $articulos_comprados . " <td class='vertical-middle center' style='text-align:center;min-width: 70px'>".$symbol." ".number_format(($subtotal),2)."</td>";
                //$articulos_comprados = $articulos_comprados . " <td class='vertical-middle center'>".$symbol." ".number_format($subtotal,2)."</td>";
                //$articulos_comprados = $articulos_comprados . " <td class='vertical-middle center'>".$symbol." ".number_format($impuesto,2)."</td>";
                //$articulos_comprados = $articulos_comprados . " <td class='vertical-middle center'>".$symbol." ".number_format($total,2)."</td>";
                $articulos_comprados = $articulos_comprados . "</tr>";
            }

            $datos_generales = "";
            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle text-danger' colspan='2'><b>COMPRADOR:</b></td>";
            $datos_generales = $datos_generales . "</tr>";
            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Nombres:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$user["first_name"]."</td>";
            $datos_generales = $datos_generales . "</tr>";
            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Apellidos:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$user["last_name"]."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $doc_type = "DNI";
            $type_sell = "Boleta de venta";
            if(strlen($user["dni"]) == 11){
                $doc_type = "RUC";
                $type_sell = "Factura";
            }
            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>".$doc_type.":</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$user["dni"]."</td>";
            $datos_generales = $datos_generales . "</tr>";

            if($user["phone"]!=null){
                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Teléfono:</b></td>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$user["phone"]."</td>";
                $datos_generales = $datos_generales . "</tr>";
            }

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Correo:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$user["email"]."</td>";
            $datos_generales = $datos_generales . "</tr>";
            $datos_generales = $datos_generales . "<br/>";

            $env_section = "";

            $datos_generales = $datos_generales.$env_section;

            $env_direc = "";

            
            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle text-danger' colspan='2'><b>ENVÍO:</b></td>";
            $datos_generales = $datos_generales . "</tr>";
            $id_shop = ParameterService::GetParameter('SHOP_ID');
            if($order["type_store"]!=null && $order["type_store"]==$id_shop){
                
                $shop = ApiService::Request(config('env.app_group_site'), 'entity', 'shops-get', array("id" => $order["id_shop"]))->response;
                $ubication_shop = ApiService::Request(config('env.app_group_site'), 'entity', 'ubication-get-by-id', array("ubication_id" => $shop["ubication_id"]))->response;

                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Metodo de envío:</b></td>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'> Recojo en tienda </td>";
                $datos_generales = $datos_generales . "</tr>";

                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Tienda de recojo:</b></td>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$shop["name_localized"]."</td>";
                $datos_generales = $datos_generales . "</tr>";
            }else{

                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Metodo de envío:</b></td>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'> Delivery </td>";
                $datos_generales = $datos_generales . "</tr>";

                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Dirección de envío:</b></td>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$ubication["address"]["address"]."</td>";
                $datos_generales = $datos_generales . "</tr>";
            }

            if(isset($aditional_info["city_id"])!=false){
                $id_city = $aditional_info["city_id"];
                $ubication_city = ApiService::Request(config('env.app_group_site'), 'entity', 'ubication-get-by-id', array("ubication_id" => $id_city))->response;
                $env_direc = $env_direc . "<tr>";
                $env_direc = $env_direc . "   <td class='vertical-middle'><b>Ciudad de recojo:</b></td>";

                $env_direc = $env_direc . "   <td class='vertical-middle'>".ucwords(strtolower($ubication_city["name_localized"]))."</td>";
                $env_direc = $env_direc . "</tr>";
            }

            $datos_generales = $datos_generales . "<br/>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle text-danger' colspan='2'><b>FACTURACIÓN:</b></td>";
            $datos_generales = $datos_generales . "</tr>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Fecha de compra:</b></td>";
            $fecha_str = date_create($order["ordered_at"]);
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".date_format($fecha_str,"d-m-Y H:i:s")."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Tipo de pago:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'> Mercado Pago </td>";
            $datos_generales = $datos_generales . "</tr>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Código de transacción:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$order["transaction_pay_code"]."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Tipo de documento:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$type_sell."</td>";
            $datos_generales = $datos_generales . "</tr>";

            if($order["type_store"]!=null && $order["type_store"]==$id_shop){
                
                $shop = ApiService::Request(config('env.app_group_site'), 'entity', 'shops-get', array("id" => $order["id_shop"]))->response;
                $ubication_shop = ApiService::Request(config('env.app_group_site'), 'entity', 'ubication-get-by-id', array("ubication_id" => $shop["ubication_id"]))->response;
                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Dirección de tienda:</b></td>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$shop["address"].", ".$shop["ubication_name"]."</td>";
                $datos_generales = $datos_generales . "</tr>";
            }else{
                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Dirección de envío:</b></td>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$ubication["address"]["address"]."</td>";
                $datos_generales = $datos_generales . "</tr>";

                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Dirección de facturación:</b></td>";
                $UbicationTotal = $ubication["cities"];
                $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$ubication["address"]["address"]." - ".
                $UbicationTotal[0]["name_localized"].", ".$UbicationTotal[1]["name_localized"].", ".$UbicationTotal[2]["name_localized"]."</td>";
                $datos_generales = $datos_generales . "</tr>";

            }

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Moneda:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$currency["name_localized"]."</td>";
            $datos_generales = $datos_generales . "</tr>";
 
            $tax_amount = 0;
            $tax_amount = number_format($order["tax_amount"],2);

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>IGV (%):</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$tax_percent."%</td>";
            $datos_generales = $datos_generales . "</tr>";

            $tot_product = $order["total"] - $order["shipping_cost"];

            if($order["id_discount"]!=null){
                $tot_product = $tot_product + $order["value_discount"];
            }

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Productos:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$symbol." ".number_format($tot_product,2)."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Costo de envío:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$symbol." ".number_format($order["shipping_cost"],2)."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Sub Total:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$symbol." ".number_format($order["sub_total"],2)."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Monto IGV:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$symbol." ".$tax_amount."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $discount_info = null;
            if($order["id_discount"]!=null){
                $discount_info = ApiService::Request(config('env.app_group_site'), 'entity', 'discount-validate', array("id" => $order["id_discount"]))->response;
                $datos_generales = $datos_generales . "<tr>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Cupón usado:</b></td>";
                $datos_generales = $datos_generales . "   <td class='vertical-middle'> ".$discount_info["code"]." </td>";
                $datos_generales = $datos_generales . "</tr>";
            }

            if($order["value_discount"]==null){
                $order["value_discount"] = 0.0;
            }

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Descuentos:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$symbol." ".$order["value_discount"]."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $datos_generales = $datos_generales . "<tr>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'><b>Total:</b></td>";
            $datos_generales = $datos_generales . "   <td class='vertical-middle'>".$symbol." ".number_format($order["total"],2)."</td>";
            $datos_generales = $datos_generales . "</tr>";

            $subject = "Gracias por comprar en Mágico";
            $message = MailHelper::GetHTMLContain(asset('storage/app/mail/successful_payment.html'));

            $message = str_replace("[<|DATOS_GENERALES|>]", $datos_generales, $message);

            $message = str_replace("[<|ARTICULOS_DESCRIPTION|>]", "Los artículos comprados son los siguientes:", $message);
            $message = str_replace("[<|ARTICULOS_COMPRADOS|>]", $articulos_comprados, $message);
            $business_mail = ParameterService::GetParameter('business_email');
            $business_name = ParameterService::GetParameter('business_name');

            if($for_admin==true){
				if($fortesting==0){
					MailHelper::SendMail($subject,$message,$business_mail,$business_name);
					if($resend!=null){
						MailHelper::SendMail($subject,$message,$resend,$business_mail);
					}
				}else{
					MailHelper::SendMail($subject,$message,$resend,$business_name);
				}
            }else{
                MailHelper::SendMail($subject,$message,$business_mail,$business_name);
                
                $message = str_replace("Estimado administrador,", "Hola ".$user["first_name"].",", $message);

                $message = str_replace('<img src="https://magico.pe/resources/Cilindrosm/assets/custom/img/loaded/banners/logo.png" style="max-width: 200px" alt="">', '', $message);
                $message = str_replace("¡En hora buena!, un cliente ha realizado una compra y requiere su inmediata atención",
                    "Muchas gracias por preferir a <i style='position:relative;top:3px'><img style='position: relative;max-width: 80px;top: 3px;' src='https://magico.pe/resources/Cilindrosm/assets/custom/img/loaded/banners/logo.png'></i>", $message);

                $message = str_replace("max-width: 80px;","position: relative;max-width: 80px;top: 3px;",$message);
                $message = str_replace($env_section,"",$message);
                $message = str_replace($env_direc,"",$message);

                $message = str_replace("Los datos generales de la compra son: ", "Los datos de tu compra son: ", $message);
                $message = str_replace("Los artículos comprados son los siguientes:", "El detalle de tu pedido es el siguiente: ", $message);

                $message = str_replace("<p></p>", "<p>¡Tu pedido ya está registrado!</p>", $message);
                MailHelper::SendMail("¡Gracias, hemos recibido tu pedido Mágico con éxito!",$message,$user["email"],$user["first_name"]);
            }

        }catch(\Exception $ex){
            dd($ex);
        }
    }
    public static function SendMail_Order_Pending($order_id){
        $data = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get-mail-data', array("order_id" => $order_id))->response;
        $objUser = $data["user"];
        $subject = "Pago pendiente";
        $message = MailHelper::GetHTMLContain(asset('storage/app/mail/rejected_payment.html'));
        MailHelper::SendMail($subject,$message,$objUser["email"],$objUser["first_name"]);
    }
    public static function SendMail_Order_Failed(){

    }
    /*----------------------------------------------------------------------------------------------------------------------------*/
    public static function SendMail_New_Suscriber($email,$event=false){
        $subject = "Nuevo registro cliente Mágico";
        $message = "¡Felicidades, el cliente ".$email." se ha suscrito !";
        $mail_bussines = ParameterService::GetParameter("business_email");
        $phone_bussines = ParameterService::GetParameter("business_phone");
        $name_bussines = ParameterService::GetParameter("business_name");
        try {

            if($event==true){
                $subject = "Se ha registrado un nuevo participante";
                $message = "¡Felicidades, ".$email." quiere participar en el sorteo !";
            }
            MailHelper::SendMail($subject,$message,$mail_bussines,$phone_bussines);
        }catch (\Exception $e){
            MailHelper::SendMail($subject,"Ha ocurrido un problema con ".$email,ParameterService::GetParameter("email_support"),$name_bussines);
        }

    }
}