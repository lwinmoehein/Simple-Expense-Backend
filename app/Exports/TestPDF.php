<?php
namespace App\Exports;

use TCPDF;
use TCPDF_FONTS;

class TestPDF extends Tcpdf
{
    public function __construct()
    {
        // Call parent constructor
        parent::__construct();

        // Set default font
// Set the font for the PDF
        $this->SetFont(base_path('public/fonts/myanmar_3.ttf'), '', 14);

        // Set page format and orientation
        $this->SetCreator('MyPDF');
        $this->SetAuthor('MyPDF');
        $this->SetTitle('MyPDF');
        $this->SetSubject('MyPDF');
        $this->SetKeywords('MyPDF');
        $this->SetMargins(10, 10, 10);
        $this->SetAutoPageBreak(true, 10);
        $this->AddPage();
    }

    public function render($html)
    {
        // Convert HTML to PDF using TCPDF
        $this->writeHTML($html, true, false, true, false, '');
        $this->lastPage();
        $this->Output('document.pdf', 'D');
    }


}
