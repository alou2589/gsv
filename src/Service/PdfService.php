<?php

namespace App\Service;

use DomPdf\DomPdf;
use Dompdf\Options;

class  PdfService {
    
    
    private $dompdf;
    
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->dompdf = new DomPdf();
        
        $pdfOptions= new Options();
        
        $pdfOptions->set('defaultFont', 'Garamond');
        
        $this->dompdf->setOptions($pdfOptions);
    }
    
    public function showPdfFile($html){
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
        $this->dompdf->stream("cartepro.pdf", [
            'Attachement'=> false
        ]);
    }
    
    public function generateBinaryPDF($html){
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
        $this->dompdf->output();
    }
}