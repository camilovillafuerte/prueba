<?php

namespace App\Http\Controllers;

use App\Models\firmas;
use Illuminate\Http\Request;

class FirmasController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getFirmas(){
        return response()->json(firmas::all(),200);
    }

    public function getFirmasxid($id){
        $firmas = firmas::find($id);
        if(is_null($firmas)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        }
        return response ()->json($firmas::find($id),200);
    }

    public function insertFirmas(Request $request){
        $firmas = firmas::create ($request->all());
        return response($firmas,200);
    }

    public function updateFirmas(Request $request,$id){
        $firmas=firmas::find($id);
        if (is_null($firmas)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $firmas->update($request->all());
        return response($firmas,200);
    }

    public function deleteFirmas($id){
        $firmas=firmas::find($id);
        if (is_null($firmas)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $firmas->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
////////////////////////////////////////////
    public function getFirma_emi(){

        $response = [];
        $firmas = firmas::where('id', '>=', 1)->orderBy('nombres', 'asc')->get();

        if($firmas->count() > 0 )   $response = $firmas;
        return response()->json($response);
    }

    public function insertar_emi(Request $request){

        $firmaEmisor = (object)$request->firma_emisor;

        $firmaEmisor->titulo_academico = trim(ucfirst($firmaEmisor->titulo_academico));
        $firmaEmisor->nombres = trim(ucwords($firmaEmisor->nombres));
        $firmaEmisor->cargo = trim(ucfirst($firmaEmisor->cargo));
        $firmaEmisor->institucion = trim(ucfirst($firmaEmisor->institucion));

        $existe = firmas::where('nombres', $firmaEmisor->nombres)->first();

        if($existe){    //Existe el nombre de la firma del emisor
            $response = [
                'estado' => false,
                'mensaje' => 'El emisor ya se encuentra registrado !'
            ];
        }else{
            $new = new firmas();

            $new->titulo_academico = $firmaEmisor->titulo_academico;
            $new->nombres = $firmaEmisor->nombres;
            $new->cargo = $firmaEmisor->cargo;
            $new->institucion= $firmaEmisor->institucion;
            $new->save();

            $response = [
                'estado' => true,
                'mensaje' => 'Se ha registrado la firma del emisor !'
            ];
        }

        return response()->json($response);

    }
/////////////////////////////////////////////////////
    public function getFirma_recep(){

        $response = [];
        $firmas = firmas::where('id', '>=', 1)->orderBy('nombres', 'asc')->get();

        if($firmas->count() > 0)    $response = $firmas;
        return response()->json($response);
    }

    public function insertar_recep(Request $request){

        $response = [];
        $firma_receptor = (object)$request->firma_receptor;

        $firma_receptor->titulo_academico = trim(ucfirst($firma_receptor->titulo_academico));
        $firma_receptor->nombres = trim(ucwords($firma_receptor->nombres));
        $firma_receptor->cargo = trim(ucfirst($firma_receptor->cargo));
        $firma_receptor->institucion = trim(ucfirst($firma_receptor->institucion));

        $existe = firmas::where('nombres',  $firma_receptor->nombres)->first();

        if($existe){
            $response  = [
                'estado' => false,
                'mensaje' => 'El receptor ya se encuentra registrado !'
            ];
        }else{
            $new = new firmas();
            $new->titulo_academico = $firma_receptor->titulo_academico;
            $new->nombres = $firma_receptor->nombres;
            $new->cargo = $firma_receptor->cargo;
            $new->institucion = $firma_receptor->institucion;
            $new->save();

            $response  = [
                'estado' => true,
                'mensaje' => 'El receptor se ha registrado !'
            ];
        }

        return response()->json($response);
    }
}
