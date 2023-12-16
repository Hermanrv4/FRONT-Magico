<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ChartsExport implements WithDrawings, WithTitle, WithEvents, FromArray, WithStyles, ShouldAutoSize
{
    public $img_path;
    public $title_sheet;
    public $head_title_sheet;
    public $heading_result;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(storage_path("app/loaded/img/prod/".$this->img_path));
        $drawing->setHeight(600);
        $drawing->setWidth(700);
        $drawing->setCoordinates('E3');

        return $drawing;
    }

    public function styles(Worksheet $sheet){
        return [
            1    => ['font' => ['bold' => true] ],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event){
                $cellRange = 'A1:W1'; 
                $event->sheet->mergeCells("A1:R1");
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

    public function array(): array
    {
        return [
                [$this->head_title_sheet],
            ];
    }
    public function SetImgPath($obj){
        $this->img_path=$obj;
    }
    public function setTitle($string){
        $this->title_sheet=$string;
    }
    public function setHeaderTitle($string){
        $this->head_title_sheet=$string;
    }
    public function title() : string {
        return $this->title_sheet ?? "";
    }
}
