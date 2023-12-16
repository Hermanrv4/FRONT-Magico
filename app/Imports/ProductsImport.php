<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMappedCells;
/* use Maatwebsite\Excel\Concerns\WithMultipleSheets; */

class ProductsImport implements WithHeadingRow, ToCollection /* WithMultipleSheets */{

    /* public function sheets():array
    {
        return [
            "Productos"=>new ProductExport(),
            "Categorias"=> new CategoriesExport(),
            "Especificaciones"=>new SpecificationsExport(),
        ];
    } */
    public function collection(Collection $rows){
        return $rows;
    }
    
}
