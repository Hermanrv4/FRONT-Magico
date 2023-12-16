<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMappedCells;
class NameImagesExport implements WithHeadings, FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    private $numColumns;
    public $data_array;
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true] ],
        ];
    }
    public function setData($collec){
        $this->data_array=$collec;
    }
    public function getData():array{
        return $this->data_array;
    }
    public function headings() : array
    {
        $header=array("Nombre Original", "Nombre Nuevo");
        return $header;
    }
    public function array(): array
    {
        return [$this->data_array];
    }
    public function title(): string
    {
        return "Nombre de imagenes";
    }
    public static function convertArray($array_name, $array_old){
        $data=array();
        for($i=0; $i<count($array_name); $i++){
            $data[]=[$array_name[$i], $array_old[$i]];
        }
        return $data;
    }
}