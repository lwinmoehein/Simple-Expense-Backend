<?php
namespace App\Services;

use App\Exports\TransactionMonthExport;
use App\Repositories\TransactionRepository;
use Maatwebsite\Excel\Excel;



class ReportService {
    private $excel ;
    private $transactionRepository;

    public function __construct(Excel  $excel,TransactionRepository $transactionRepository){
        $this->excel = $excel;
        $this->transactionRepository = $transactionRepository;
    }

    public function generateExcelFile($type,$month,$year){
        switch ($type){
            case "monthly":
               return (new TransactionMonthExport($month,$year))->download('transactions.xlsx');
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
