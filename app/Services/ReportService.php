<?php
namespace App\Services;

use App\Exports\TestPDF;
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
//
//        $html = '<h1>လီးပဲ</h1>';
//        $pdf = new TestPDF();
//        return $pdf->render($html);


         switch ($type){
            case "monthly":
               return (new TransactionMonthExport($month,$year))->download($fileName);
            case "yearly":
               return (new TransactionYearExport($year))->download($fileName);
            default:
                return (new TransactionTotalExport())->download($fileName, Excel::MPDF)->setFont('');
        }
    }
}

trait  PDFGenerator{
   function generate(){
       $html = view('pdf')->render();
       $dompdf = new Dompdf();
       $dompdf->loadHtml($html);
       $dompdf->set_paper('A4', 'portrait');
       $dompdf->getOptions()->setFontDir(__DIR__ . '/fonts');
       $dompdf->getOptions()->setDefaultFont('myanmar');
       $dompdf->render();
       $dompdf->stream('document.pdf', array('Attachment' => false));
   }
}
