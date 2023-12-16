<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
class DataChartExport implements WithHeadings, FromArray, ShouldAutoSize, WithTitle
{
    public $data_headings=array();
    public $array_data=array();
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return $this->data_headings;
    }
    public function array(): array
    {
        return $this->array_data;
    }
    public function setDataHeading($array){
        $this->data_headings=$array;
    }
    public function setArrayData($array){
        $this->array_data=$array;
    }
    public function title(): string
    {
        return "Informacion detallada";
    }
}
