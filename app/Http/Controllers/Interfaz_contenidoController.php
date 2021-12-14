<?php

namespace App\Http\Controllers;

use App\Models\interfaz_contenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Interfaz_contenidoController extends Controller
{
    //método con json para probar si funciona con postman

    public function getInterfazconprueba(){
        $interfazcon2 = DB::table('interfazs')
        ->join('interfaz_contenidos','interfaz_contenidos.id','=','interfaz.id')
        ->select('interfazs.nombre','interfazs.pagina', 'interfaz_contenidos.id_interfazs',
         'interfaz_contenidos.nombre','interfaz_contenidos.descripcion',
         'interfaz_contenidos.urlimagen','interfaz_contenidos.estado')
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
}
