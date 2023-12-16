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

class SpecificationsExport implements WithHeadings, FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    private $numColumns;

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true] ],
        ];
    }
    public function headings() : array
    {
        $header=array("SP_CODE", "NAME_SPECIFICACION", "COLOR", "HTML", "PREVIEW", "IMAGE", "GB_FILTER");
        return $header;
    }
    public function array(): array
    {
        return [];
    }
    public function title(): string
    {
        return "Especificaciones";
    }

}
