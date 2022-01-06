<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    //
      //metodo con json para probar si funciona con postman
      public function getUsuarios(){
        return response()->json(usuario::all(),200);
    }

    public function getUsuariosxid($id){
        $usuarios = usuario::find($id);
        if(is_null($usuarios)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($usuarios::find($id),200);
    }

    public function insertUsuarios(Request $request){
        $usuarios = usuario::create ($request->all());
        return response($usuarios,200);
    }

    public function updateUsuarios(Request $request,$id){
        $usuarios=usuario::find($id);
        if (is_null($usuarios)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $usuarios->update($request->all());
        return response($usuarios,200);
    }

    public function deleteUsuarios($id){
        $usuarios=usuario::find($id);
        if (is_null($usuarios)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $usuarios->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
