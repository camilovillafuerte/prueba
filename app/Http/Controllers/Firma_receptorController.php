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

    public function get_v2(){

        $response = [];
        $firmas = Firma_receptor::where('id', '>=', 1)->orderBy('nombre_receptor', 'asc')->get();

        if($firmas->count() > 0)    $response = $firmas;
        return response()->json($response);
    }

    public function insertar_v2(Request $request){

        $response = [];
        $firma_receptor = (object)$request->firma_receptor;

        $firma_receptor->titulo_academico = trim(ucfirst($firma_receptor->titulo_academico));
        $firma_receptor->nombre_receptor = trim(ucwords($firma_receptor->nombre_receptor));
        $firma_receptor->cargo_receptor = trim(ucfirst($firma_receptor->cargo_receptor));
        $firma_receptor->institucion_receptor = trim(ucfirst($firma_receptor->institucion_receptor));

        $existe = Firma_receptor::where('nombre_receptor',  $firma_receptor->nombre_receptor)->first();

        if($existe){
            $response  = [
                'estado' => false,
                'mensaje' => 'El receptor ya se encuentra registrado !'
            ];
        }else{
            $new = new Firma_receptor();
            $new->titulo_academico = $firma_receptor->titulo_academico;
            $new->nombre_receptor = $firma_receptor->nombre_receptor;
            $new->cargo_receptor = $firma_receptor->cargo_receptor;
            $new->institucion_receptor = $firma_receptor->institucion_receptor;
            $new->save();

            $response  = [
                'estado' => true,
                'mensaje' => 'El receptor se ha registrado !'
            ];
        }

        return response()->json($response);
    }
}
