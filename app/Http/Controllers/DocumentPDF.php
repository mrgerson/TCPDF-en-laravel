<?php

namespace App\Http\Controllers;

use PDFTC;
/* use Elibyy\TCPDF\Facades\TCPDF; */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Fpdf;
use setasign\Fpdi\Fpdi;

class DocumentPDF extends Controller
{
    public function documentPdf()
    {

        $directorio = 'pdfblog/';

        if (!Storage::disk('public')->exists($directorio)) {

            Storage::disk('public')->makeDirectory($directorio);
        }

        // Ruta del PDF existente que deseas editar
        $existingPdfPath = storage_path('app/public/pdfblog/anti.pdf');

        // Ruta para guardar el nuevo PDF editado
        $editedPdfPath = storage_path('app/public/pdfblog/pdf_editado.pdf');

        // Ruta de la imagen que deseas agregar
        //$imagePath = public_path('images/7142336_firm.png');
        $imagePath = storage_path('app/public/images/7142336_firm.png');


        // Instanciar FPDI y TCPDF
        $pdf = new Fpdi();
        /*  $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false); */


        // Agregar una página en blanco
        $pdf->AddPage();

        // Importar la página del PDF existente
        $pageCount = $pdf->setSourceFile($existingPdfPath);
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

        // Realizar modificaciones en el PDF (opcional)
        // Aquí puedes agregar contenido adicional, cambiar texto, etc.

        // Agregar nuevos datos al PDF
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(100, 325);
        $pdf->Cell(0, 10, 'fecha ingreso: 2023-06-14 14:13:35', 0, 1, 'C');


        // Agregar imagen al PDF
        $pdf->Image($imagePath, 20, 310, 35, 35, 'PNG');

        // Generar el nuevo PDF editado
        $pdf->Output($editedPdfPath, 'F');


        // Por ejemplo, copia el PDF existente en el nuevo archivo editado
        // Storage::copy('public/pdfblog/1.pdf', 'public/pdfblog/nuevo.pdf');

        return "hecho";

        // Descargar el nuevo PDF
        //return response()->download($editedPdfPath);


    }

    public function TCPDFdocument()
    {

        $fileName = 'demo.pdf';

        $data = [
            'tittle' => 'Generar pdf',
        ];

        $html = view()->make('pdfExample', $data)->render();

        $pdf = new PDFTC;

        PDFTC::SetTitle('Hello World');

        PDFTC::AddPage();
        PDFTC::WriteHTML($html, true, false, true, false);
        PDFTC::Output(public_path($fileName), 'F');

        return response()->download(public_path($fileName));
    }
}
