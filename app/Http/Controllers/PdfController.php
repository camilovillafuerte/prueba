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
        $data->nombre_convenio = $this->repleceEnter($data->nombre_convenio);
        $data->comparecientes = $this->repleceEnter($data->comparecientes);
        $namePDf = "Convenio-".date('Y-m-d').'.pdf';

        for($i = 0; $i < count($data->clausulas); $i++){
            for($j = 0; $j < count($data->clausulas[$i]['articulos']); $j++){
                $data->clausulas[$i]['articulos'][$j]['des_art'] = $this->repleceEnter($data->clausulas[$i]['articulos'][$j]['des_art']);
            }
        }

        $image = Storage::disk('files')->get('logo_u.jpeg');
        // return response()->json($data->clausulas);

        $pdf = PDF::loadView('convenio', ['data' => $data, 'logo' => $image]);
        return $pdf->stream($namePDf);
        // return new Response($image, 200);
    }

    private function repleceEnter($data){
        $order   = array("\r\n", "\n", "\r");
        $replace = '<br />';

        $data = str_replace($order, $replace, $data);
        (array)$data = explode($replace, $data);

        return $data;
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
