<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
class ProductExport implements WithHeadings, FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    private $numColumns;
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true] ],
        ];
    }
    public function headings(): array
    {
        $array=array();
        //obtenemos las especificaciones
        $default_id= ApiService::Request(config('env.app_group_admin'), 'entity','parameter-get-codes',array('code'=>'default_id'))->response;
        $specification = ApiService::Request(config('env.app_group_admin'), 'entity', 'Specification-Get', array('specification_code'=>$default_id))->response;
        //obtenemos un array de parameter
        $parametergen= ApiService::Request(config('env.app_group_admin'), 'entity','parameter-get-codes',array('code'=>'is_gen'))->response;
        //buscar dentro del array un valor
        $array[]="CATEGORIA"; 
        $array[]="GRUPO";
        $array[]="NOMBRE DEL GRUPO";
        $array[]="NOMBRE DEL PRODUCTO";
        $array[]="DESCRIPCION DEL PRODUCTO";
        $value=false;
        if($parametergen=="1"){
            $array[]="GEN-ITEM-NO";
            $array[]="GEN-TALLA";
            $value=true;
        }
        $array[]="CATALOGO";
        if($parametergen=="0"){
            $array[]="STOCK";
            $array[]="PRECIO REGULAR";
            $array[]="PRECIO ONLINE";
        }
        for($a=0; $a<5; $a++){
            $array[]="FOTO-".($a+1)."";
        }
        //asignamos valores de los name al array
        for ($i=0; $i < count($specification); $i++) { 
            $array[]=$specification[$i]["code"];
        }
        $array[]="IS_UPDATE";
        $this->numColumns = count($array);
        return $array;
    }
    public function array(): array
    {
        return [];
    }
    public function title(): string
    {
        return "Productos";
    }
    public function registerEvents(): array
{
    return [
        AfterSheet::class    => function(AfterSheet $event) {

            $styleArray =  array('fill' => array(
                'color' => array('rgb' => '50151213')
            ));

            $cellRange = 'A1:W1'; // All headers
            $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            $event->sheet->cells('A2:E2', function ($cells) {
                $cells->setBackground('#6D8947');
              });
        },
    ];
}
}