<?php
namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class TransactionMonthExport implements FromQuery
{
    use Exportable;

    protected $month;
    protected $year;

    public function __construct(int $month,int $year){
        $this->month = $month;
        $this->year = $year;
    }

    public function query()
    {
        return Transaction::query()->whereYear('created_at', $this->year)->whereMonth("created_at",$this->month);
    }
}
