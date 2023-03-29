<?php

namespace App\Http\Controllers;

use App\Exports\TransactionMonthExport;
use App\Http\Requests\GenerateReport;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ReportController extends Controller
{
    //
    private $reportService;


    public function __construct(Excel $excel)
    {
        $this->reportService = new ReportService($excel);
    }

    public function exportTransaction(GenerateReport  $request){
        return $this->reportService->generateExcelFile($request->type,$request->month,$request->year);
    }
}
