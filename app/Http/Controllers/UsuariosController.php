<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    //
      //metodo con json para probar si funciona con postman
      public function getUsuarios(){
        return response()->json(usuarios::all(),200);
    }

    public function getUsuariosxid($id){
        $usuarios = usuarios::find($id);
        if(is_null($usuarios)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($usuarios::find($id),200);
    }

    public function insertUsuarios(Request $request){
        $usuarios = usuarios::create ($request->all());
        return response($usuarios,200);
    }

    public function updateUsuarios(Request $request,$id){
        $usuarios=usuarios::find($id);
        if (is_null($usuarios)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $usuarios->update($request->all());
        return response($usuarios,200);
    }

    public function deleteUsuarios($id){
        $usuarios=usuarios::find($id);
        if (is_null($usuarios)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $usuarios->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
