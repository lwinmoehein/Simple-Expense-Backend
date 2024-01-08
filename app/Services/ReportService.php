<?php
namespace App\Services;

use App\Exports\TransactionMonthExport;
use App\Exports\TransactionTotalExport;
use App\Exports\TransactionYearExport;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ReportService {

    public function generateExcelFile($month,$year){
        $fileName =Str::slug(auth()->user()->name)."_transactions_". Carbon::now()->timestamp.".xlsx";

        return Excel::download(new TransactionMonthExport($month,$year), $fileName,null,[
            "Content-Disposition"=>'attachment; filename="' .$fileName . '"'.'helo',
        ]);
    }
}

