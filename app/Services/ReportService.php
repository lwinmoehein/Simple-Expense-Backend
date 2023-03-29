<?php
namespace App\Services;

use App\Exports\TransactionMonthExport;
use App\Exports\TransactionTotalExport;
use App\Exports\TransactionYearExport;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Str;

class ReportService {
    private $excel ;
    private $transactionRepository;

    public function __construct(Excel  $excel,TransactionRepository $transactionRepository){
        $this->excel = $excel;
        $this->transactionRepository = $transactionRepository;
    }

    public function generateExcelFile($type,$month,$year){
        $fileName ="lwin_".$type."_transactions_". Carbon::now()->timestamp.".xlsx";

         switch ($type){
            case "monthly":
               return (new TransactionMonthExport($month,$year))->download($fileName);
            case "yearly":
               return (new TransactionYearExport($year))->download($fileName);
            default:
                return (new TransactionTotalExport())->download($fileName);
        }
    }

    private function generateMonthlyExcelFile(string $date){
          return $this->transactionRepository->getMonthTransactions($date);
    }
    private function generateYearlyExcelFile(string $date){

    }
    private function generateTotalExcelFile(){

    }
}
