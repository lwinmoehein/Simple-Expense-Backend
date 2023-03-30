<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionYearExport implements FromQuery,ShouldAutoSize,WithHeadings,WithStyles
{
    use Exportable,TransactionExportTrait;

    protected $year;

    public function __construct(int $year){
        $this->year = $year;
    }

    public function query()
    {
        return $this->getExportTransactionBaseQuery()
                ->whereYear("transactions.created_at",$this->year);
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
            'A1' => ['font' => ['bold' => true]],
            'B1' => ['font' => ['bold' => true]],
            'C1' => ['font' => ['bold' => true]],
            'D1' => ['font' => ['bold' => true]]
        ];
    }
}
