<?php

namespace App\Http\Controllers;

use App\Models\interfaz_contenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Interfaz_contenidoController extends Controller
{
    private $baseCtrl;

    public function __construct(){
        $this->baseCtrl = new BaseController();
    }
    //método con json para probar si funciona con postman

    public function getInterfazconprueba(){
        $interfazcon2 = DB::table('interfazs')
        ->join('interfaz_contenidos','interfazs.id','=','interfaz_contenidos.id_interfazs')
        ->select('interfazs.nombre as InterfazNombre','interfazs.pagina', 'interfaz_contenidos.id_interfazs','interfaz_contenidos.nombre','interfaz_contenidos.descripcion','interfaz_contenidos.urlimagen','interfaz_contenidos.estado')
        -> where('estado','A') 
        -> get();
        return response() -> json ($interfazcon2);
       } 
       

    public function getInterfazcon(){
        return response()->json(interfaz_contenido::all(),200);
    }

    public function getInterfazconxid($id){
        $interfazcon = interfaz_contenido::find($id);
        if(is_null($interfazcon)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($interfazcon::find($id),200);
    }

    public function insertInterfazcon(Request $request){
        $interfazcon = interfaz_contenido::create ($request->all());
        return response($interfazcon,200);
    }

    public function updateInterfazcon(Request $request,$id){
        $interfazcon = interfaz_contenido::find($id);
        if (is_null($interfazcon)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $interfazcon -> update($request->all());
        return response($interfazcon,200);
    }

    public function deleteInterfazcon($id){
        $interfazcon = interfaz_contenido::find($id);
        if (is_null($interfazcon)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $interfazcon -> delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }

    public function subirDocumento(Request $request){

        if($request->hasFile('document')){
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;

            Storage::disk('ftp4')->put($filenametostore, fopen($request->file('document'), 'r+'));

           $url = $this->baseCtrl->getUrlServer('/Contenido/Informacion/');

            $response = [
                'estado' => true,
                'documento' => $url.$filenametostore,
                'mensaje' => 'El documento se ha subido al servidor'
            ];
        }else{
            $response = [
                'estado' => false,
                'documento' => '',
                'mensaje' => 'No hay un archivo para procesar'
            ];
        }

        return response()->json($response);
    }
}
