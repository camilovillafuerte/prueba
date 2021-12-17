<?php

namespace App\Http\Controllers;

use App\Models\cargo_usuario;
use Illuminate\Http\Request;

class Cargo_usuarioController extends Controller
{
    //
    //metodo con json para probar si funciona con postman
    public function getCusuario(){
        return response()->json(cargo_usuario::all(),200);
    }

    public function getCusuarioxid($id){
        $cargou= cargo_usuario::find($id);
        if(is_null($cargou)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($cargou::find($id),200);
    }

    public function insertCusuario(Request $request){
        $cargou = cargo_usuario::create ($request->all());
        return response($cargou,200);
    }

    public function updateCusuario(Request $request,$id){
        $cargou=cargo_usuario::find($id);
        if (is_null($cargou)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $cargou->update($request->all());
        return response($cargou,200);
    }

    public function deleteCusuario($id){
        $cargou=cargo_usuario::find($id);
        if (is_null($cargou)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $cargou->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
