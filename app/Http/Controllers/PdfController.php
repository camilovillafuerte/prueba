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
        $namePDf = "Convenio-".date('Y-m-d-H-i-s').'.pdf';

        for($i = 0; $i < count($data->clausulas); $i++){
            for($j = 0; $j < count($data->clausulas[$i]['articulos']); $j++){
                $data->clausulas[$i]['articulos'][$j]['des_art'] = $this->repleceEnter($data->clausulas[$i]['articulos'][$j]['des_art']);
            }
        }

        $exist = Storage::disk('convenios')->exists($namePDf);

        if($exist){
            $response = [
                'estado' => false,
                'mensaje' => 'El archivo ya existe',
                'file' => false
            ];
        }else{
            $path = storage_path().'/app/convenios/'.$namePDf;
            $pdf = PDF::loadView('convenio', ['data' => $data])->save($path)->stream($namePDf);

            $response = [
                'estado' => true,
                'mensaje' => 'PDF generado con éxito',
                'file' => $namePDf
            ];
        }

        return response()->json($response);
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

    public function getFile($folder, $file){
        $existe = Storage::disk($folder)->exists($file);

        if($existe){
            $archivo = Storage::disk($folder)->get($file);
            //    return new Response($archivo, 200);
            return response( Storage::disk($folder)->get($file), 200)
                ->header('Content-Type', Storage::disk($folder)
                    ->mimeType($file)
                );
        }else{
            $data = [
                'estado' => false,
                'mensaje' => 'Archivo no existe',
                'error' => 404
            ];
        }
        return response()->json($data);
    }
}

