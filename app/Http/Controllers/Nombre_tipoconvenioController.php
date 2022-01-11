<?php

namespace App\Http\Controllers;

use App\Models\nombre_tipoconvenio;
use Illuminate\Http\Request;

class Nombre_tipoconvenioController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getNombre_tc(){
        return response()->json(nombre_tipoconvenio::all(),200);
    }

    public function getNombre_tcxid($id){
        $nombretc = nombre_tipoconvenio::find($id);
        if(is_null($nombretc)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($nombretc::find($id),200);
    }

    public function insertNombre_tc(Request $request){
        $nombretc = nombre_tipoconvenio::create ($request->all());
        return response($nombretc,200);
    }

    public function updateNombre_tc(Request $request,$id){
        $nombretc=nombre_tipoconvenio::find($id);
        if (is_null($nombretc)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $nombretc->update($request->all());
        return response($nombretc,200);
    }

    public function deleteNombre_tc($id){
        $nombretc=nombre_tipoconvenio::find($id);
        if (is_null($nombretc)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $nombretc->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
