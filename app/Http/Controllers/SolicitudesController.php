<?php

namespace App\Http\Controllers;

use App\Models\s_aprobadas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SolicitudesController extends Controller
{
    private $baseCtrl;

    public function __construct()
    {
        $this->baseCtrl = new BaseController();
    }

    public function subirDocumentoMovilidadyBecas(Request $request)
    {
        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '_' . uniqid() . '.' . $extension;

            Storage::disk('ftp12')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosSolicitudesAprobadas/');

            $response = [
                'estado' => true,
                'documento' => $url . $filenametostore,
                'mensaje' => 'El documento se ha subido al servidor'
            ];
        } else {
            $response = [
                'estado' => false,
                'documento' => '',
                'mensaje' => 'No hay un archivo para procesar'
            ];
        }

        return response()->json($response);
    }

    public function actualizarAprobados(Request $request){
        $data = (object)$request->data;
        $aprobados=s_aprobadas::where('id',(intval($data->id)))->first();
        if($aprobados){
            if(trim($data->estado)=='S'){
                $aprobados->PDF=trim($data->PDF);
                $aprobados->tipo = trim($data->tipo);
                $aprobados->estado=trim($data->estado);
        $aprobados->save();
        $response=[
            'estado'=> true,
            'mensaje' => 'Se actualizo el estado del informe a Finalizado'
        ];
            }else {
                $response = [
                    'estado' => false,
                    'mensaje' => 'Solo se pude actualizar las solicitudes sin Informes'
                ];
            }
    } else{
        $response = [
            'estado' => false,
            'mensaje' => 'No existe la solicitud'
        ];
    }
    return response()->json($response);
    }
}
