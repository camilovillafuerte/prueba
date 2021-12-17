<?php

namespace App\Http\Controllers;

use App\Models\funcionalidad_usuario;
use Illuminate\Http\Request;

class Funcionalidad_usuarioController extends Controller
{
    //
    //metodo con json para probar si funciona con postman
    public function getFusuario(){
        return response()->json(funcionalidad_usuario::all(),200);
    }

    public function getFUsuarioxid($id){
        $fusuario = funcionalidad_usuario::find($id);
        if(is_null($fusuario)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($fusuario::find($id),200);
    }

    public function insertFusuario(Request $request){
        $fusuario = funcionalidad_usuario::create ($request->all());
        return response($fusuario,200);
    }

    public function updateFusuario(Request $request,$id){
        $fusuario=funcionalidad_usuario::find($id);
        if (is_null($fusuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $fusuario->update($request->all());
        return response($fusuario,200);
    }

    public function deleteFusuario($id){
        $fusuario=funcionalidad_usuario::find($id);
        if (is_null($fusuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $fusuario->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
