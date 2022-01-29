<?php

namespace App\Http\Controllers;

use App\Models\imagenes_convenios;
use Illuminate\Http\Request;

class Imagenes_conveniosController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getImgcon(){
        return response()->json(imagenes_convenios::all(),200);
    }

    public function getImgconxid($id){
        $fusuario = imagenes_convenios::find($id);
        if(is_null($fusuario)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($fusuario::find($id),200);
    }

    public function insertImgcon(Request $request){
        $fusuario = imagenes_convenios::create ($request->all());
        return response($fusuario,200);
    }

    public function updateImgcon(Request $request,$id){
        $fusuario=imagenes_convenios::find($id);
        if (is_null($fusuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $fusuario->update($request->all());
        return response($fusuario,200);
    }

    public function deleteImgcon($id){
        $fusuario=imagenes_convenios::find($id);
        if (is_null($fusuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $fusuario->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
