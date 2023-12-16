<?php
namespace App\Http\Modules\Admin\Controllers;
use Greenter\See;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Responses\ApiResponse;
use App\Http\Common\Controllers\BaseAdminController;

use Greenter\Report\XmlUtils;
use Greenter\Report\PdfReport;
use Greenter\Model\Sale\Legend;
use Greenter\Report\HtmlReport;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Document;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\CdrResponse;
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;

class ElectronicBillingController extends BaseAdminController{

    private $serie;
    private $new_correlativo;
    private $fec_emision;
    public function GetSerie(){
        return $this->serie;
    }
    public function GetNewCorrelative(){
        return $this->new_correlativo;
    }
    public function GetFecEmision(){
        return $this->fec_emision;
    }
    private function CreateConfig(){
        $see = new See();
        $see->setCertificate(file_get_contents(dirname(__DIR__,5).'\storage\app\certificate\certificate.pem'));
        $see->setService(config('greenter.endopoint'));
        $see->setClaveSOL(config('greenter.ruc'),config('greenter.usuario'),config('greenter.passworsd'));
        return $see;
    }
    private function GenerateInvoice($order_id){
        //obtener datos para invoice           
        $cabezera = ApiService::Request(config('env.app_group_admin'),'entity','order-get',array("order_id" => $order_id))->response;            
        $detalle = ApiService::Request(config('env.app_group_admin'),'entity','order-detail-get',array("order_id" => $order_id))->response;
        $billing_data = json_decode(ApiService::Request(config('env.app_group_admin'),'entity','parameter-get-codes',array("code"=>"billing_data"))->response);
        $tax = ApiService::Request(config('env.app_group_admin'),'entity','parameter-get-codes',array("code"=>"tax"))->response;
        $serie = ApiService::Request(config('env.app_group_admin'),'entity','parameter-get-codes',array("code"=>"billing_serie"))->response;
        $old_correlativo = ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-get-correlative',array("serie" => $serie))->response;
        $new_correlativo = sprintf("%08d",intval($old_correlativo["correlative"])+1);
        $this->serie = $serie;
        $this->new_correlativo = $new_correlativo;
        if (is_null($cabezera) || is_null($detalle) || is_null($billing_data) || is_null($tax) || is_null($serie) || is_null($old_correlativo) || is_null($new_correlativo)) {
            throw new Exception('Error al obtener datos');
        }        
        //crear cliente
        $nombre_cliente = $cabezera["user_first_name"].' '.$cabezera["user_last_name"];          
        $client = new Client();
        $client->setTipoDoc('1')
                    ->setNumDoc($cabezera["dni"])
                    ->setRznSocial($nombre_cliente);
        //Emisor
        $address = new Address();
        $address->setUbigueo($billing_data->ubigeo)
            ->setDepartamento($billing_data->departamento)
            ->setProvincia($billing_data->provincia)
            ->setDistrito($billing_data->distrito)
            ->setUrbanizacion('-')
            ->setDireccion($billing_data->direccion);

        $company = new Company();
        $company->setRuc(config('greenter.ruc'))
            ->setRazonSocial($billing_data->razon_social)
            ->setNombreComercial($billing_data->nombre_comercial)
            ->setAddress($address);
        //del documento
        $bi_doc = $cabezera["total"]/((100+$tax)/100);
        $igv_doc =  $bi_doc*($tax/100);
        $total_doc = $cabezera["total"];
        // Venta
        $invoice = (new Invoice())
        ->setUblVersion('2.1')
        ->setTipoOperacion('0101') // Venta - Catalog. 51
        ->setTipoDoc('03') // Factura - Catalog. 01 
        ->setSerie($serie)
        ->setCorrelativo($new_correlativo)
        ->setFechaEmision(new Carbon($cabezera["ordered_at"])) // Zona horaria: Lima
        ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
        ->setTipoMoneda('PEN') // Sol - Catalog. 02
        ->setCompany($company)
        ->setClient($client)
        ->setMtoOperGravadas($bi_doc)
        ->setMtoIGV($igv_doc)
        ->setTotalImpuestos($igv_doc)
        ->setValorVenta(floatval($bi_doc))
        ->setSubTotal($total_doc)
        ->setMtoImpVenta($total_doc);        
        //Detalle
        $items = array();
        //Agregar el costo de envio como producto
        $bi_sc = round($cabezera["shipping_cost"]/((100+$tax)/100), 2);
        $igv_sc = $bi_sc*($tax/100);
        $total_sc = $cabezera["shipping_cost"];
        $item_evio = (new SaleDetail())
            ->setCodProducto('FLETE')
            ->setUnidad('NIU')
            ->setCantidad(1)
            ->setDescripcion('COSTO DE ENVIO')
            ->setMtoBaseIgv($bi_sc)
            ->setPorcentajeIgv($tax) // 18%
            ->setIgv($igv_sc)
            ->setTipAfeIgv('10')
            ->setTotalImpuestos($igv_sc)
            ->setMtoValorVenta($bi_sc)
            ->setMtoValorUnitario($bi_sc)
            ->setMtoPrecioUnitario($bi_sc+$igv_sc);
        array_push($items, $item_evio);
        for ($i=0; $i < count($detalle); $i++) {
            //por producto
            //unitario                
            $bi_prd = round($detalle[$i]['price']/((100+$tax)/100), 2);
            $igv_prd = $bi_prd*($tax/100);
            $total_prd = $detalle[$i]['price'];
            //total
            $bi_prd_t = $bi_prd*$detalle[$i]['quantity'];
            $igv_prd_t = $igv_prd*$detalle[$i]['quantity'];
            $total_prd_t = $total_prd*$detalle[$i]['quantity'];

            $item = (new SaleDetail())
                ->setCodProducto($detalle[$i]['product_sku'])
                ->setUnidad('NIU')
                ->setCantidad($detalle[$i]['quantity'])
                ->setDescripcion($detalle[$i]['product_name'])
                ->setMtoBaseIgv($bi_prd_t)
                ->setPorcentajeIgv($tax) // 18%
                ->setIgv($igv_prd_t)
                ->setTipAfeIgv('10')
                ->setTotalImpuestos($igv_prd_t)
                ->setMtoValorVenta($bi_prd_t)
                ->setMtoValorUnitario($bi_prd)
                ->setMtoPrecioUnitario($bi_prd+$igv_prd);
                
            array_push($items, $item);
        }  
    
        $legendValue = new NumeroALetras();
        $legend = (new Legend())
        ->setCode('1000') // Monto en letras - Catalog. 52
        ->setValue('SON '.$legendValue->toInvoice($total_doc,2,Str::upper($cabezera['currency_name'])));

        $invoice->setDetails($items)
                ->setLegends([$legend]);
        return $invoice;
    }
    private function GenerateRCSumary($order_id){
        $cabezera = ApiService::Request(config('env.app_group_admin'),'entity','order-get-all-billed',array("order_id" => $order_id))->response;            
        $billing_data = json_decode(ApiService::Request(config('env.app_group_admin'),'entity','parameter-get-codes',array("code"=>"billing_data"))->response);
        $old_correlativo = ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-get-correlative',array("serie" => 'summ'))->response;
        $new_correlativo = sprintf("%05d",intval($old_correlativo["correlative"])+1);
        $tax = ApiService::Request(config('env.app_group_admin'),'entity','parameter-get-codes',array("code"=>"tax"))->response;
        $this->serie = 'summ';
        $this->new_correlativo=$new_correlativo;
        if (is_null($cabezera) || is_null($billing_data) || is_null($old_correlativo) || is_null($new_correlativo)) {
            throw new Exception('Error al obtener datos');
        }
        //Emisor
        $address = new Address();
        $address->setUbigueo($billing_data->ubigeo)
            ->setDepartamento($billing_data->departamento)
            ->setProvincia($billing_data->provincia)
            ->setDistrito($billing_data->distrito)
            ->setUrbanizacion('-')
            ->setDireccion($billing_data->direccion);

        $company = new Company();
        $company->setRuc(config('greenter.ruc'))
            ->setRazonSocial($billing_data->razon_social)
            ->setNombreComercial($billing_data->nombre_comercial)
            ->setAddress($address);

        $bi_doc = $cabezera["total"]/((100+$tax)/100);
        $igv_doc =  $bi_doc*($tax/100);
        $total_doc = $cabezera["total"];
        $detail = new SummaryDetail();
        $detail->setTipoDoc('03') // Boleta
            ->setSerieNro($cabezera["electronic_billing_sale_serie"].'-'.$cabezera["electronic_billing_sale_correlative"])
            ->setEstado('3') // Anulación
            ->setClienteTipo('1')
            ->setClienteNro($cabezera["dni"])
            ->setTotal($total_doc)
            ->setMtoOperGravadas($bi_doc)
            ->setMtoOperInafectas(0)
            ->setMtoOperExoneradas(0)
            ->setMtoOtrosCargos(0)
            ->setMtoIGV($igv_doc);
        $resumen = new Summary();
        $resumen->setFecGeneracion(new Carbon($cabezera['ordered_at'])) // Fecha de emisión de las boletas.
            ->setFecResumen($this->GetFecEmision()) // Fecha de envío del resumen diario.
            ->setCorrelativo($new_correlativo) // Correlativo, necesario para diferenciar de otros Resumen diario del mismo día.
            ->setCompany($company)
            ->setDetails([$detail]);
        
        return $resumen;
    }
    public function GenerateBill(Request $request){
        try {
            //antes de obtener verificar 
            $verify = ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-sale-exists-order',array("order_id" => $request['order_id']))->message;
            if ($verify=="true") {
                return ApiResponse::SendErrorResponse('Boleta ya Registrada, para esta venta.');
            }
            //Configuracion
            $invoice = $this->GenerateInvoice($request['order_id']);
            
            $see = $this->CreateConfig();
            $result = $see->send($invoice);

            // Guardar XML firmado digitalmente.
            file_put_contents(dirname(__DIR__,5)."\storage\app\FE\xml\\".$invoice->getName().'.xml',
                                $see->getFactory()->getLastXml());
                    
            // Verificamos que la conexión con SUNAT fue exitosa.
            $error_code="";
            $error_message="";
            if (!$result->isSuccess()) {
                // Mostrar error al conectarse a SUNAT.
                $error_code = 'Codigo Error: '.$result->getError()->getCode();
                $error_message = 'Mensaje Error: '.$result->getError()->getMessage();
                return ApiResponse::SendErrorResponse('Error al intentar conectar al WS SUNAT',array('error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
            }

            // Guardamos el CDR
            file_put_contents(dirname(__DIR__,5).'\storage\app\FE\cdr\R-'.$invoice->getName().'.zip', $result->getCdrZip());
            $cdr = $result->getCdrResponse();

            $code = (int)$cdr->getCode();
            $estado = '';
            $estado_code = 0;
            $obs = array();
            if ($code === 0) {
                $estado= 'ESTADO: ACEPTADA';
                $estado_code = '1';
                if (count($cdr->getNotes()) > 0) {
                    $estado .= ' | OBSERVACIONES:';
                    $estado_code = '2';
                    // Corregir estas observaciones en siguientes emisiones.
                    $obs = $cdr->getNotes();
                }  
            } else if ($code >= 2000 && $code <= 3999) {
                $estado = 'ESTADO: RECHAZADA';
                $estado_code = '3';
            } else {
                /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
                /*code: 0100 a 1999 */
                $estado = 'Excepción';
                $estado_code = '4';
            }

            $resultado =  $cdr->getDescription();
            //GUARDAR EN BD
            $serie = ApiService::Request(config('env.app_group_admin'),'entity','parameter-get-codes',array("code"=>"billing_serie"))->response;
            $old_correlativo = ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-get-correlative',array("serie" => $serie))->response;
            $new_correlativo = sprintf("%08d",intval($old_correlativo["correlative"])+1);
            ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-update',array("serie" => $this->GetSerie(),"correlative"=>$this->GetNewCorrelative()));
            $obj = ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-sale-register',array("serie" => $this->GetSerie(),"correlative"=>$this->GetNewCorrelative(),"order_id"=>$request['order_id'],"status"=>$estado_code));
            $this->ExportReport($request['order_id'],$invoice->getName(),'invoice');
            if ($obj->response!=true) {
                $error_code = 'Codigo Error: Comunicate con un asesor';
                $error_message = 'Mensaje Error: '.$this->GetSerie().'-'.$this->GetNewCorrelative();
                return ApiResponse::SendErrorResponse('Error al intentar guardar el documento.',array('error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
            } 
            $this->resetValues();
            return ApiResponse::SendSuccessResponse($estado,array('resultado'=>$resultado,'obs'=>$obs,'error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
        } catch (\Exception $ex) {
            return ApiResponse::SendErrorResponse($ex->getMessage(),$ex->getMessage());
        }
    }
    public function GenerateSummary(Request $request){
        try {
            $obs='';
            $error_code='';$error_message='';
            $verify_1 = ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-sale-exists-order',array("order_id" => $request['order_id']))->message;
            $verify_2 = ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-sale-get',array("order_id" => $request['order_id']))->response;
            if ($verify_1=="false") {
                $error_code='Error Sistema:';
                $error_message='No se puede dar de baja a una venta que no se emitió Boleta.';
                return ApiResponse::SendErrorResponse('No se puede anular',array('error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
            }
            for ($i=0; $i < count($verify_2); $i++) { 
                if ( $verify_2[$i]['is_voided']==1) {
                    $error_code='Error Sistema:';
                    $error_message='La Boleta ya se encuentra anulada.';
                    return ApiResponse::SendErrorResponse('No se puede anular',array('error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
                }    
            }
            
            //obtner fecha hora de emision
            $this->fec_emision = Carbon::now();

            $resumen = $this->GenerateRCSumary($request['order_id']);
            $see = $this->CreateConfig();
            $result = $see->send($resumen);
            file_put_contents(dirname(__DIR__,5)."\storage\app\FE\xml\\".$resumen->getName().'.xml', $see->getFactory()->getLastXml());
            $error_code="";
            $error_message="";
            if (!$result->isSuccess()) {
                // Mostrar error al conectarse a SUNAT.
                $error_code = 'Codigo Error: '.$result->getError()->getCode();
                $error_message = 'Mensaje Error: '.$result->getError()->getMessage();
                return ApiResponse::SendErrorResponse('Error al intentar conectar al WS SUNAT',array('error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
            }
            $ticket = $result->getTicket();
            $statusResult = $see->getStatus($ticket);
            if (!$statusResult->isSuccess()) {
                // Si hubo error al conectarse al servicio de SUNAT.
                $error_code = 'Codigo Error: '.$result->getError()->getCode();
                $error_message = 'Mensaje Error: '.$result->getError()->getMessage();
                return ApiResponse::SendErrorResponse('Error al intentar conectar al WS SUNAT',array('error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
            }
            $resultado = $statusResult->getCdrResponse()->getDescription();
            // Guardar CDR
            file_put_contents(dirname(__DIR__,5)."\storage\app\FE\cdr\\".'R-'.$resumen->getName().'.zip', $statusResult->getCdrZip());
            
            ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-update',array("serie" => $this->GetSerie(),"correlative"=>$this->GetNewCorrelative()));
            ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-sale-voided',array("order_id"=>$request['order_id']));
            $obj = ApiService::Request(config('env.app_group_admin'),'entity','electronic-billing-sale-register',array("serie" => Str::substr($resumen->getName(),12,11),"correlative"=>$this->GetNewCorrelative(),"order_id"=>$request['order_id'],"status"=>1));
            $this->ExportReport($request['order_id'],$resumen->getName(),'summary');
            if ($obj->response!=true) {
                $error_code = 'Codigo Error: Comunicate con un asesor';
                $error_message = 'Mensaje Error: '.$this->GetSerie().'-'.$this->GetNewCorrelative();
                return ApiResponse::SendErrorResponse('Error al intentar guardar el comunicado de baja.',array('error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
            }            
            $this->resetValues();
            return ApiResponse::SendSuccessResponse('Comunicado de Baja',array('resultado'=>$resultado,'obs'=>$obs,'error'=>['error_code'=>$error_code,'error_message'=>$error_message]));
        } catch (\Exception $ex) {
            return ApiResponse::SendErrorResponse();
        }
    }
    public function ExportReport($order_id,$filename,$type='invoice'){
        $invoice='';
        if ($type=='invoice') {
            $invoice = $this->GenerateInvoice($order_id);            
        }elseif ($type='summary') {
            $invoice = $this->GenerateRCSumary($order_id);
        }
        $pdf = $this->getPdf($invoice);
        file_put_contents(dirname(__DIR__,5).'\storage\app\FE\pdf\\'.$filename.'.pdf', $pdf);        
    }
    private function getHash(DocumentInterface $document): ?string
    {
        $see = $this->CreateConfig('');
        $xml = $see->getXmlSigned($document);
        
        return (new XmlUtils())->getHashSign($xml);
    }
    private function getParametersPdf(): array
    {
        $logo = file_get_contents(dirname(__DIR__,5).'\storage\app\loaded\img\logo.png');

        return [
            'system' => [
                'logo' => $logo,
                'hash' => ''
            ],
            'user' => [
                'resolucion' => '212321',
                'header' => '',
                'extras' => [
                    ['name' => 'FORMA DE PAGO', 'value' => 'Contado'],
                ],
            ]
        ];
    }  
    public function getPdf(DocumentInterface $document): ?string
    {
        $html = new HtmlReport();
        $resolver = new DefaultTemplateResolver();
        $template = $resolver->getTemplate($document);
        $html->setTemplate($template);

        $report = new PdfReport($html);
        $report->setOptions( [
            'no-outline',
            'viewport-size' => '1280x1024',
            'page-width' => '21cm',
            'page-height' => '29.7cm',
        ]);
        $report->setBinPath(dirname(__DIR__,5).'\vendor\bin\wkhtmltopdf\bin\wkhtmltopdf.exe');
        $hash = $this->getHash($document);
        $params = self::getParametersPdf();
        $params['system']['hash'] = $hash;
        $params['user']['footer'] = '<div>consulte en <a href="https://github.com/giansalex/sufel">sufel.com</a></div>';

        $pdf = $report->render($document, $params);
        return $pdf;
    }
    private function resetValues(){
        $this->serie='';
        $this->new_correlativo='';
        $this->fec_emision='';
    }

}