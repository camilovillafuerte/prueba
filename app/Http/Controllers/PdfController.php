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

       for($k = 0;$k< count($data->clausulas);$k++)
       {
        $data->clausulas[$k]['descripcion']=$this->repleceEnter($data->clausulas[$k]['descripcion']);
       }
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

    public function makePdfConvenios_v2(Request $request){
        // header("Access-Control-Allow-Origin: *");
        $data = (object)$request->data;

        $namePDf = "Convenio-".date('Y-m-d-H-i-s').'.pdf';

        $exist = Storage::disk('convenios')->exists($namePDf);

        if($exist){
            $response = [
                'estado' => false,
                'mensaje' => 'El archivo ya existe',
                'file' => false
            ];
        }else{
            $path = storage_path().'/app/convenios/'.$namePDf;
            $pdf = PDF::loadView('convenio2', ['data' => $data])->save($path)->stream($namePDf);
            // dd($pdf);

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

    public function eliminarArchivos()
    {
     $data=convenios::where('tipo_documento','G')->orWhere('tipo_documento','P')->get();
     $newtipo=[];
     $existe=[];
     $files = Storage::disk('local')->Files('convenios'); // los archivos


     foreach($files as $fil)
     {
         $nombre=substr($fil,10);
         $newtipo[]=$nombre;
       foreach ($data as $d)
       {
         if($d->PDF==$nombre)
         {
             $dato=$d->PDF;
             $existe[]=$dato;
         }
       }
     }

     $files_eliminar=array_diff($newtipo,$existe);
     $contar=0;

     foreach($files_eliminar as $f)
     {
        $eliminar = Storage::disk('convenios')->delete($f);
        if($eliminar){
            $contar++;
        }

     }

     if($contar==count($files_eliminar))
     {
         $response=[
             'estado'=>true,
             'mensaje'=>'Se elimino los archivos',
             'archivos_eliminados'=>$contar
         ];
     }
     else
     {
        $response=[
            'estado'=>false,
            'mensaje'=>'No se elimino todos los archivos',
            'archivos_eliminados'=>$contar
        ];

     }
     return response()->json($response);

    }

    
}

