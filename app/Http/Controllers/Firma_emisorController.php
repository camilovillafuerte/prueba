<?php

namespace App\Http\Controllers;

use App\Models\Firma_emisor;
use Illuminate\Http\Request;

class Firma_emisorController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getFirmaemi(){
        return response()->json(Firma_emisor::all(),200);
    }

    public function getFirmaemixid($id){
        $femisor = Firma_emisor::find($id);
        if(is_null($femisor)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($femisor::find($id),200);
    }

    public function insertFirmaemi(Request $request){
        $femisor = Firma_emisor::create ($request->all());
        return response($femisor,200);
    }

    public function updateFirmaemi(Request $request,$id){
        $femisor=Firma_emisor::find($id);
        if (is_null($femisor)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $femisor->update($request->all());
        return response($femisor,200);
    }

    public function deleteFirmaemi($id){
        $femisor=Firma_emisor::find($id);
        if (is_null($femisor)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $femisor->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }

}
