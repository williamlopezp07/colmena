<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

class ExportMetricas implements FromArray,WithHeadings
// ,ShouldAutoSize,WithEvents,WithCustomStartCell
{
    protected $header;
    protected $data;
    protected $num_metricas;

    function __construct($header, $data,$num_metricas)
    {
            $this->header = $header;

            $this->data = $data;

            $this->num_metricas = $num_metricas;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {

        return $this->header;

    }
    public function array(): array
     {
         return [
            $this->data
         ];
     }

         // public function registerEvents(): array
         // {
         //     return [
         //         AfterSheet::class    => function(AfterSheet $event) {
         //           Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
         //               $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
         //           });
         //           $event->sheet->styleCells('A:Z', [
         //               'alignment' => [
         //                   'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
         //                   'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
         //               ],
         //           ]);
         //           $Cantidad_de_columnas_a_crear=$this->num_metricas[0];
         //            $Contador=0;
         //            $Letra='A';
         //
         //            while($Contador<$Cantidad_de_columnas_a_crear)
         //            {
         //                echo    $Letra. "  ";
         //                $Contador++;
         //                $Letra++;
         //            }
         //           $event->sheet->mergeCells('A1:A2');
         //           $event->sheet->setCellValue('A1', "MODELO");
         //           $event->sheet->mergeCells('B1:B2');
         //           $event->sheet->setCellValue('B1', "SERIE ACTUAL");
         //           $event->sheet->mergeCells('C1:C2');
         //           $event->sheet->setCellValue('C1', "AÑO DE FAB.");
         //           $event->sheet->mergeCells('D1:D2');
         //           $event->sheet->setCellValue('D1', "MÁQUINA");
         //         },
         //     ];
         // }
}
