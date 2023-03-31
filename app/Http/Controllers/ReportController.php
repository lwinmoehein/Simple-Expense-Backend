<?php

namespace App\Http\Controllers;

use App\Exports\TransactionMonthExport;
use App\Http\Requests\GenerateReport;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\ReportService;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    public function exportExcel(GenerateReport  $request){
        return $this->reportService->generateExcelFile($request->type,$request->month,$request->year);
    }

    public function exportPDF(GenerateReport  $request) {
        // Set the content type to PDF
        $transactions = $this->transactionRepository->getTransactionsForExport($request->type,$request->month,$request->year);

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="example.pdf"',
        ];

        $html = view('pdf',compact('transactions'))->render();
        // Generate the PDF using the mPDF library
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY, true, false);
        $mpdf->Output();

        // Return the PDF as a response
        return Response::make($mpdf->Output(), 200, $headers);
    }
}
