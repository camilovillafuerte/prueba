<?php

namespace App\Http\Controllers;

use App\Models\convenios;
use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller{

    public function makePdfConvenios(){

        $namePDf = "Convenio-".date('Y-m-d').'.pdf';
        $convenios = convenios::all();

        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('convenio', ['data' => $convenios]);
        return $pdf->stream($namePDf);
    }


    public function dowloandPdfConvenio(){
        $namePDf = "Convenio-".date('Y-m-d').'.pdf';
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('myPDF', $data);
        return $pdf->stream('itsolutionstuff.pdf');
    }
}
