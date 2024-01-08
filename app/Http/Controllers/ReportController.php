<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;

class ReportController extends Controller
{
    //
    private $reportService;
    private $transactionRepository;


    public function __construct(Excel $excel,TransactionRepository  $transactionRepository)
    {
        $this->reportService = new ReportService($excel);
        $this->transactionRepository = $transactionRepository;
    }

    public function exportExcel(Request  $request){
        $type="mothly";
        $month="03";
        $year="2023";
        $binaryFile =  $this->reportService->generateExcelFile($request->type,$request->month,$request->year);

        return $binaryFile;
    }

    public function exportPDF(Request  $request) {
        // Set the content type to PDF
        $type="mothly";
        $month="03";
        $year="2023";
        $transactions = $this->transactionRepository->getTransactionsForExport($type,$month,$year);
        //dd($transactions);
        $transactions=Transaction::all();
        $fileName =Str::slug(auth()->user()->name)."_".$type."_transactions_". Carbon::now()->timestamp.".pdf";




        $html = view('pdf',compact('transactions'))->render();
        // Generate the PDF using the mPDF library
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY, true, false);


        // Return the PDF as a response
        return Response::make($mpdf->Output($fileName,"I"), 200);
    }
}
