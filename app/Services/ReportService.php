<?php
namespace App\Services;

use App\Exports\TestPDF;
use App\Exports\TransactionMonthExport;
use App\Exports\TransactionTotalExport;
use App\Exports\TransactionYearExport;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;
use Dompdf\Options;

class ReportService {
    private $excel ;

    public function __construct(Excel  $excel){
        $this->excel = $excel;
    }

    public function generateExcelFile($type,$month,$year){
        $fileName =Str::slug(auth()->user()->name)."_".$type."_transactions_". Carbon::now()->timestamp.".xlsx";

         switch ($type){
            case "monthly":
               return (new TransactionMonthExport($month,$year))->download($fileName);
            case "yearly":
               return (new TransactionYearExport($year))->download($fileName);
            default:
                return (new TransactionTotalExport())->download($fileName);
        }
    }
}

