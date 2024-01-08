<?php

namespace App\Http\Controllers;

use App\Exports\TransactionMonthExport;
use App\Http\Requests\GenerateReport;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    //
    private $reportService;
    private $transactionRepository;


    public function __construct(TransactionRepository  $transactionRepository)
    {
        $this->reportService = new ReportService($transactionRepository);
        $this->transactionRepository = $transactionRepository;
    }

    public function exportExcel(GenerateReport  $request){
        $fileName = $this->reportService->getExportFileName($request->start,$request->end,"xlsx");

        return Excel::download($this->reportService->getExcelExportObject(Auth::user(),$request->start,$request->end), $fileName);
    }

    public function exportPDF(GenerateReport  $request) {
        $fileName = $this->reportService->getExportFileName($request->start,$request->end);

        $mpdf = $this->reportService->getPDFObject(Auth::user(),$request->start,$request->end);

        return Response::make($mpdf->Output($fileName,"D"));
    }
}
