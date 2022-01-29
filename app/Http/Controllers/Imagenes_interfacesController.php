<?php

namespace App\Http\Controllers;

use App\Models\imagenes_interfaces;
use Illuminate\Http\Request;

class Imagenes_interfacesController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getImginter(){
        return response()->json(imagenes_interfaces::all(),200);
    }

    public function getImginterxid($id){
        $fusuario = imagenes_interfaces::find($id);
        if(is_null($fusuario)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($fusuario::find($id),200);
    }

    public function insertImginter(Request $request){
        $fusuario = imagenes_interfaces::create ($request->all());
        return response($fusuario,200);
    }

    public function updateImginter(Request $request,$id){
        $fusuario=imagenes_interfaces::find($id);
        if (is_null($fusuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $fusuario->update($request->all());
        return response($fusuario,200);
    }

    public function deleteImginter($id){
        $fusuario=imagenes_interfaces::find($id);
        if (is_null($fusuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $fusuario->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
