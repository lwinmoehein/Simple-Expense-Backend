<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionTotalExport implements FromQuery,ShouldAutoSize,WithHeadings,WithStyles
{

    use Exportable,TransactionExportTrait;


    public function query()
    {
        return $this->getBaseQuery();
    }

    public function headings(): array
    {
       return [
           'ခေါင်းစဥ်',
           'ပမာဏ',
           'မှတ်စု',
           'နေ့ရက်'
       ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1' => ['font' => ['bold' => true,'name'=>'Padauk-Regular']],
            'B1' => ['font' => ['bold' => true,'name'=>'Padauk-Regular']],
            'C1' => ['font' => ['bold' => true,'name'=>'Padauk-Regular']],
            'D1' => ['font' => ['bold' => true,'name'=>'Padauk-Regular']]
        ];
    }
}
