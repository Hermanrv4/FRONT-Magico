<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ChartGeneral implements WithMultipleSheets, ShouldAutoSize
{
    public $list=array();
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets() : array
    {
        return $this->list;
    }
    public function setList($array){
        $this->list=$array;
    }
}
