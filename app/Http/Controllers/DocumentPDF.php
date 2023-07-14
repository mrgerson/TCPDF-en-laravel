<?php

namespace App\Http\Controllers;

use PDFTC;
/* use Elibyy\TCPDF\Facades\TCPDF; */
use Illuminate\Http\Request;

class DocumentPDF extends Controller
{
    public function documentPdf()
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
