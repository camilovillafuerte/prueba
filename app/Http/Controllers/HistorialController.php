<?php

namespace App\Http\Controllers;

use App\Models\historial_usuario;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getHistorial(){
        return response()->json(historial_usuario::all(),200);
    }

    public function getHistorialxid($id){
        $husuario = historial_usuario::find($id);
        if(is_null($husuario)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($husuario::find($id),200);
    }

    public function insertHistorial(Request $request){
        $husuario = historial_usuario::create ($request->all());
        return response($husuario,200);
    }

    public function updateHistorial(Request $request,$id){
        $husuario=historial_usuario::find($id);
        if (is_null($husuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $husuario->update($request->all());
        return response($husuario,200);
    }

    public function deleteHistorial($id){
        $husuario=historial_usuario::find($id);
        if (is_null($husuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $husuario->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
