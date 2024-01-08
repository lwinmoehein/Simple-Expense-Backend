<?php
namespace App\Services;

use App\Exports\TransactionMonthExport;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportService {

    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getExcelExportObject(User $user,$start,$end):TransactionMonthExport{
        return new TransactionMonthExport($user->google_user_id,$start,$end);
    }

    public function getPDFObject(User $user,$start,$end):Mpdf{
        $transactions = $this->transactionRepository->getTransactionsForExport($user->google_user_id,$start,$end);

        $html = view('pdf',compact('transactions','start','end'))->render();
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY, true, false);

        return $mpdf;
    }

    public function getExportFileName($start, $end, $type="pdf"){
        if($type=="pdf"){
            return  "simple-expense-".$start."-".$end.".pdf";
        }
        return "simple-expense-".$start."-".$end.".xlsx";
    }
}

