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

    public function getFirma_v2(){

        $response = [];
        $firmas = Firma_emisor::where('id', '>=', 1)->orderBy('nombre_emisor', 'asc')->get();

        if($firmas->count() > 0 )   $response = $firmas;
        return response()->json($response);
    }

    public function insertar_v2(Request $request){

        $firmaEmisor = (object)$request->firma_emisor;

        $firmaEmisor->titulo_academico = trim(ucfirst($firmaEmisor->titulo_academico));
        $firmaEmisor->nombre_emisor = trim(ucwords($firmaEmisor->nombre_emisor));
        $firmaEmisor->cargo_emisor = trim(ucfirst($firmaEmisor->cargo_emisor));
        $firmaEmisor->institucion_emisor = trim(ucfirst($firmaEmisor->institucion_emisor));

        $existe = Firma_emisor::where('nombre_emisor', $firmaEmisor->nombre_emisor)->first();

        if($existe){    //Existe el nombre de la firma del emisor
            $response = [
                'estado' => false,
                'mensaje' => 'El emisor ya se encuentra registrado !'
            ];
        }else{
            $new = new Firma_emisor();

            $new->titulo_academico = $firmaEmisor->titulo_academico;
            $new->nombre_emisor = $firmaEmisor->nombre_emisor;
            $new->cargo_emisor = $firmaEmisor->cargo_emisor;
            $new->institucion_emisor = $firmaEmisor->institucion_emisor;
            $new->save();

            $response = [
                'estado' => true,
                'mensaje' => 'Se ha registrado la firma del emisor !'
            ];
        }

        return response()->json($response);

    }
}
