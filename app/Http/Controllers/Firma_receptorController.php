<?php

namespace App\Http\Controllers;

use App\Models\Firma_receptor;
use Illuminate\Http\Request;

class Firma_receptorController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getFirmarec(){
        return response()->json(Firma_receptor::all(),200);
    }

    public function getFirmarecxid($id){
        $freceptor = Firma_receptor::find($id);
        if(is_null($freceptor)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($freceptor::find($id),200);
    }

    public function insertFirmarec(Request $request){
        $freceptor = Firma_receptor::create ($request->all());
        return response($freceptor,200);
    }

    public function updateFirmarec(Request $request,$id){
        $freceptor=Firma_receptor::find($id);
        if (is_null($freceptor)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $freceptor->update($request->all());
        return response($freceptor,200);
    }

    public function deleteFirmarec($id){
        $freceptor=Firma_receptor::find($id);
        if (is_null($freceptor)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $freceptor->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
