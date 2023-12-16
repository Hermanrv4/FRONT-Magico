<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class CategoriesExport implements FromArray, WithTitle, WithStyles, WithHeadings, ShouldAutoSize
{

    private $numColumns;
    public function styles(Worksheet $sheet){
        return [
            1    => ['font' => ['bold' => true] ],
        ];
    }
    public function headings() : array
    {
        $array=array(
            "CODE",
            "ROOT_CODE",
            "NAME_CATEGORIE"
        );
        return $array;
    }
    public function array(): array
    {
        return [];
    }
    public function title() : string
    {
        return "Categorias";
    }
}
