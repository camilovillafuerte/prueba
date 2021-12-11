<?php

namespace App\Http\Controllers;

use App\Models\interfaz_contenido;
use Illuminate\Http\Request;

class Interfaz_contenidoController extends Controller
{
    //método con json para probar si funciona con postman
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
