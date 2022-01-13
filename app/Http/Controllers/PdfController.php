<?php

namespace App\Http\Controllers;

use App\Models\convenios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use PDF;

class PdfController extends Controller{

    public function makePdfConvenios(Request $request){

        $data = (object)$request->data;
        $namePDf = "Convenio-".date('Y-m-d').'.pdf';

        $image = Storage::disk('files')->get('logo_u.jpeg');
        // dd($data);
        $pdf = PDF::loadView('convenio', ['data' => $data, 'logo' => $image]);
        return $pdf->stream($namePDf);
        // return new Response($image, 200);
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
