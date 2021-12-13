<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\interfaz;
use Illuminate\Support\Facades\DB;

class InterfazController extends Controller
{
    //método con json para probar si funciona con postman
    public function getInterfazprueba(){
        $interfaz2 = DB::table('interfaz_contenidos')
        ->join('interfazs','interfazs.id','=','interfaz_contenidos.id_interfazs')
        ->select('interfasz.nombre','interfazs.pagina', 'interfaz_contenidos.id_interfasz',
         'interfaz_contenidos.nombre','interfaz_contenidos.descripcion',
         'interfaz_contenidos.urlimagen','interfaz_contenidos.estado')
        -> where('estado','A') 
        -> get();
        return response() -> json ($interfaz2);
       } 
       
   
   
    public function getInterfaz(){
        return response()->json(interfaz::all(),200);
    }

    public function getInterfazxid($id){
        $interfaz = interfaz::find($id);
        if(is_null($interfaz)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($interfaz::find($id),200);
    }

    public function insertInterfaz(Request $request){
        $interfaz = interfaz::create ($request->all());
        return response($interfaz,200);
    }

    public function updateInterfaz(Request $request,$id){
        $interfaz = interfaz::find($id);
        if (is_null($interfaz)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $interfaz -> update($request->all());
        return response($interfaz,200);
    }

    public function deleteInterfaz($id){
        $interfaz = interfaz::find($id);
        if (is_null($interfaz)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $interfaz->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
