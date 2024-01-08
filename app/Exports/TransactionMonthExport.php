<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionMonthExport implements FromQuery,ShouldAutoSize,WithHeadings,WithStyles
{
    use Exportable,TransactionExportTrait;

    protected $month;
    protected $year;

    public function __construct(int $month,int $year){
        $this->month = $month;
        $this->year = $year;
    }

    public function query()
    {
        return $this->getExportTransactionBaseQuery()
                ->whereMonth("transactions.created_at",$this->month)
                ->whereYear("transactions.created_at",$this->year);
    }

    public function headings(): array
    {
       return [
           'ခေါင်းစဥ်',
           'အမျိုးအစား',
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
            'D1' => ['font' => ['bold' => true]],
            'E1' => ['font' => ['bold' => true]]
        ];
    }
}
