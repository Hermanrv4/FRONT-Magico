<?php
namespace App\Http\Modules\Admin\Helpers;

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
    public static function SendMail_Wellcome_Customer($objUser){
        try{
            $subject = "Bienvenido a Zelebra.pe";
            $message = MailHelper::GetHTMLContain(asset('storage/app/mail/wellcome_customer.html'));
            $message = str_replace("[<|TITULO|>]", $subject, $message);
            $message = str_replace("[<|USER_NAME|>]", $objUser["first_name"], $message);
            $message = str_replace("[<|URL_IMG_WELLCOME_CLIENT|>]", asset('/storage/app/mail/img/wellcome.jpeg'), $message);
            MailHelper::SendMail($subject,$message,$objUser["email"],$objUser["first_name"]);
        }Catch(\Exception $ex){}
    }
    /*----------------------------------------------------------------------------------------------------------------------------*/
    public static function sendEmailSuccessDocument($email, $objOrder){
        try{
            $name=$objOrder["user_first_name"]." ".$objOrder["user_last_name"];
            $num_docu=$objOrder["electronic_billing_sale_serie"]."-".$objOrder["electronic_billing_sale_correlative"];
            $url_portal=RouteService::GetAdminUrl('list-electronics-document-customer');
            $subject="WAWA PIMA";
            $message=MailHelper::GetHTMLContain(asset('storage/app/mail/notify_generate_doc.html'));
            $message=str_replace("[<|TITULO|>]", $subject, $message);
            $message = str_replace("[<|USER_NAME|>]", $name, $message);
            $message = str_replace("[<|NUM_DOCU|>]", $num_docu, $message);
            $message = str_replace("[<|DATE_EMI|>]", $objOrder["ordered_at"], $message);
            $message = str_replace("[<|TOT_DOCU|>]", number_format($objOrder["total"], 2), $message);
            $message = str_replace("[<|WEB_PORTAL|>]", $url_portal, $message);
            $message=str_replace("[<|URL_IMG_WELLCOME_CLIENT|>]", asset('/storage/app/mail/img/emision-facturacion-electronica.png'), $message);
            MailHelper::SendMail($subject,$message,$email,$name);
        }catch(\Exeption $ex){}
    }
    /* --------------------------------------------------------- */
    public static function sendStatusOrder($objOrder, $objStatus){
        try{
            $email=$objOrder["user_email"];
            /* $subject="Estado de orden"; */
            $lang = config('admin.ui.mail.lang')."notify_order_status.";

            switch($objOrder["type_name"]){
                case "Aprobado":
                    $subject=trans($lang.'subject_approved');
                    $text=trans($lang.'title_approved');
                    $message_email=trans($lang.'message_approved');
                break;
                case "Pendiente":
                    $subject=trans($lang.'subject_pending');
                    $text=trans($lang.'title_pending');
                    $message_email=trans($lang.'message_pending');
                break;
                case "Rechazado":
                    $subject=trans($lang.'subject_rejected');
                    $text=trans($lang.'title_rejected');
                    $message_email=trans($lang.'message_rejected');
                break;
                case "Cancelado":
                    $subject=trans($lang.'subject_cancelled');
                    $text=trans($lang.'title_cancelled');
                    $message_email=trans($lang.'message_cancelled');
                break;
            }

            $message = MailHelper::GetHTMLContain(asset('storage/app/mail/notify_order_status_admin.html'));
            $message = MailHelper::GetHTMLContain(asset('storage/app/mail/notify_order_status.html'));
            $message = str_replace("[<|TITLE|>]", $subject, $message);
            $message = str_replace("[<|MESSAGE|>]", $message_email, $message);
           /*  $message = str_replace("[<|TITLE_ORDER_HEADER|>]", $subject, $message); */
            $message = str_replace("[<|TITLE_ORDER_HEADER|>]", trans($lang.'title_order_header'), $message);
            $message = str_replace("[<|ITEM_ORDER_HEADER|>]", $subject, $message);
            $message = str_replace("[<|ITEM_ORDER_DETAIL|>]", $subject,$message);
            $message = str_replace("[<|TITLE_ORDER_DETAIL|>]", "UWU", $message);
            /* $message = str_replace("[<|BUTTON_CONTINUE_BUYING|>]", "UWU", $message); */
            $message=str_replace("[<|STATUS_IMAGE|>]", asset('/storage/app/mail/img/img_status_approved.jpg'), $message);
            MailHelper::SendMail($subject,$message,'felipe188.mendoza@gmail.com',"felipe");
            /* MailHelper::SendMail($subject,$message,$email,$name); */
        }catch(\Exeption $ex){}
    }
    public static function SendMail_Notify_Order_Status($objOrder,$nameStatus,$for_admin=0){
        $lang = config('admin.ui.mail.lang')."notify_order_status.";
        $email=$objOrder["user_email"];
        switch($nameStatus){
            case "Aprobado":
                $status="approved";
                $subject=trans($lang.'subject_approved');
                $text=trans($lang.'title_approved');
                $message_email=trans($lang.'message_approved');
            break;
            case "Pendiente":
                $status="pending";
                $subject=trans($lang.'subject_pending');
                $text=trans($lang.'title_pending');
                $message_email=trans($lang.'message_pending');
            break;
            case "Rechazado":
                $status="rejected";
                $subject=trans($lang.'subject_rejected');
                $text=trans($lang.'title_rejected');
                $message_email=trans($lang.'message_rejected');
            break;
            case "Cancelado":
                $status="cancelled";
                $subject=trans($lang.'subject_cancelled');
                $text=trans($lang.'title_cancelled');
                $message_email=trans($lang.'message_cancelled');
            break;
        }
        try{
            $data = ApiService::Request(config('env.app_group_site'), 'entity', 'order-get-mail-data', array("order_id" => $objOrder["id"]))->response;

            $specifications = ApiService::Request(config('env.app_group_site'), 'entity', 'specification-get', array())->response;
            $lstPreviews = ProductService::GetPreviewsAndNeedUserInfo($specifications,$objSpColor,$objSpNeedUserInfo);
            $lang = config('admin.ui.mail.lang')."notify_order_status.";

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

            if(isset($data["order"]["hour_range"])) {

                $item = $item_header;
                $item = str_replace("[<|ITEM_LABEL|>]", trans($lang . 'lbl_title_billing_hour_at'), $item);
                $item = str_replace("[<|ITEM_VALUE|>]", $data["order"]["hour_range"], $item);
                $header_html = $header_html . $item;
            }

            if(isset($data["order"]["transaction_pay_code"])) {
                if($data["order"]["transaction_pay_code"]!=null){
                    $item = $item_header;
                    $item = str_replace("[<|ITEM_LABEL|>]",trans($lang.'lbl_title_billing_cod_authorization'),$item);
                    $item = str_replace("[<|ITEM_VALUE|>]",$data["order"]["transaction_pay_code"],$item);
                    $header_html = $header_html . $item;
                }
            }


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
                $price = floatval($prd_data["online_price"]);
                $item = $item_detail;
                $lstFontBackPhotos = ProductService::GetFrontBackPhotos($prd_data);

                $str_specifications = "<ul>";
                $lstMySpecifications = ProductService::GetMySpecifications($prd_data);

                foreach ($lstMySpecifications as $key => $value)
                {
                    $specificationName = "";
                    $specificationValue = "";

                    if($objSpNeedUserInfo!=null){
                        if($objSpNeedUserInfo["code"]==$key){
                            $specificationName = StringHelper::IsNull($value,"-");
                            $specificationValue = StringHelper::IsNull($data["order_detail"][$i]["cart"]["observations"],"-");
                        }
                    }else {
                        for ($x = 0; $x < count($specifications); $x++) {
                            if ($specifications[$x]["code"] == $key) {
                                $specificationName = StringHelper::IsNull($specifications[$x]["name_localized"],"-");
                                break;
                            }
                        }
                        $specificationValue = StringHelper::IsNull($value,"-");
                    }
                    $str_specifications = $str_specifications."<li/><u>".ucwords(strtolower($specificationName))."</u>: ".ucwords(strtolower($specificationValue))."</li>";
                }
                $str_specifications = $str_specifications."</ul>";

                $item = str_replace("[<|PRODUCT_IMAGE|>]",$lstFontBackPhotos["front"],$item);
                $item = str_replace("[<|PRODUCT_SKU|>]",trans($lang.'lbl_title_product_sku')." ".$prd_data["PRODUCT_SKU"],$item);
                $item = str_replace("[<|PRODUCT_NAME|>]",trans($lang.'lbl_title_product_name')." ".$prd_data["PRODUCT_NAME"],$item);
                $item = str_replace("[<|PRODUCT_SPECIFICATIONS|>]",trans($lang.'lbl_title_product_specifications')." ".$str_specifications,$item);

                $provider_comercial_name = "";
                if(isset($prd_data["PROVIDER_COMMERCIAL_NAME"])){
                    $provider_comercial_name = $prd_data["PROVIDER_COMMERCIAL_NAME"];
                }
                $item = str_replace("[<|PRODUCT_PROVIDER|>]",trans($lang.'lbl_title_product_provider')." ".$provider_comercial_name,$item);
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

            $mp_mails = json_decode(ParameterService::GetParameter("business_order_notify_emails"),true);
            if($for_admin){
                for($i=0;$i<count($mp_mails);$i++){
                    /* MailHelper::SendMail($subject,$message,$mp_mails[$i],"Administrador"); */
                }
            }else{
                MailHelper::SendMail($subject,$message, $email,$data["user"]["first_name"]);
                /* MailHelper::SendMail($subject,$message,$data["user"]["email"],$data["user"]["first_name"]); */
            }

            /* if($status==config('site.value.order.payment-status.approved')&&!$for_admin){
                MailHelper::SendMail_Notify_Order_Status($order_id,$status,1);
            } */
        }
        Catch(\Exception $ex){
            /* MailHelper::SendMail($subject,json_encode($ex,true),"haxel_33@hotmail.com",$data["user"]["first_name"]);
            MailHelper::SendMail($subject,$ex->getMessage()." ".$order_id,"haxel_33@hotmail.com",$data["user"]["first_name"]);
            MailHelper::SendMail($subject,$ex->getCode()." ".$order_id,"haxel_33@hotmail.com",$data["user"]["first_name"]); */
        }
    }
}