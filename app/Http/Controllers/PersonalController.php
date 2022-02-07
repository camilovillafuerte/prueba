<?php

namespace App\Http\Controllers;

use App\Models\personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getPersonal(){
        return response()->json(personal::all(),200);
    }

    public function getPersonalxid($id){
        $usuarios = personal::find($id);
        if(is_null($usuarios)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($usuarios::find($id),200);
    }

    public function insertPersonal(Request $request){
        $usuarios = personal::create ($request->all());
        return response($usuarios,200);
    }

    public function updatePersonal(Request $request,$id){
        $usuarios=personal::find($id);
        if (is_null($usuarios)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $usuarios->update($request->all());
        return response($usuarios,200);
    }

    public function deletePersonal($id){
        $usuarios=personal::find($id);
        if (is_null($usuarios)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $usuarios->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}

