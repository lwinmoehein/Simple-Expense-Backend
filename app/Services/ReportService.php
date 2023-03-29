<?php
namespace App\Services;

use App\Exports\TransactionMonthExport;
use App\Exports\TransactionTotalExport;
use App\Exports\TransactionYearExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use Dompdf\Options;
use Dompdf\Dompdf;

class ReportService {
    use PDFGenerator;
    private $excel ;

    public function __construct(Excel  $excel){
        $this->excel = $excel;
    }

    public function generateExcelFile($type,$month,$year){
        $fileName ="lwin_".$type."_transactions_". Carbon::now()->timestamp.".pdf";
        return $this->generate();

         switch ($type){
            case "monthly":
               return (new TransactionMonthExport($month,$year))->download($fileName);
            case "yearly":
               return (new TransactionYearExport($year))->download($fileName);
            default:
                return (new TransactionTotalExport())->download($fileName,\Maatwebsite\Excel\Excel::MPDF);
        }
    }
}

trait  PDFGenerator{
   function generate(){
       $html = view('pdf')->render();
       $dompdf = new Dompdf();
       $dompdf->loadHtml($html);
       $dompdf->getOptions()->setFontDir(__DIR__ . '/fonts');
       $dompdf->getOptions()->setDefaultFont('myanmar');
       $dompdf->render();
       $dompdf->stream('document.pdf', array('Attachment' => false));
   }
}
