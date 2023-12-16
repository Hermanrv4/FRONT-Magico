<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class GeneralExport implements WithMultipleSheets, ShouldAutoSize
{
    use Exportable;
    
    public function sheets() : array
    {
        return array(
            "1"=>new CategoriesExport(),
            "2"=>new ProductExport(),
        );
    }

}
