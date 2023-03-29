<?php
namespace App\Services;

use App\Exports\TransactionMonthExport;
use App\Repositories\TransactionRepository;
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
        $fileName ="lwin_transactions_".\Carbon\Carbon::now()->timestamp.".xlsx";

         switch ($type){
            case "monthly":
               return (new TransactionMonthExport($month,$year))->download($fileName);
            case "yearly":
               return $this->generateYearlyExcelFile($month);
            default:
                return $this->generateTotalExcelFile();
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
