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

    protected string $start;
    protected string $end;
    protected string $userId;

    public function __construct(string $userId,string $start,string $end){
        $this->userId = $userId;
        $this->start = $start;
        $this->end = $end;
    }

    public function query()
    {
        return $this->getExportTransactionBaseQuery()
            ->where("transactions.user_id","=",$this->userId)
            ->whereDate("transactions.created_at", ">=", $this->start)
            ->whereDate("transactions.created_at", "<=", $this->end);
    }
    public function collection(){

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
