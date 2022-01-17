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
    public function getFirmas_new(){

        $response = [];
        $firmas = firmas::where('id', '>=', 1)->orderBy('nombres', 'asc')->get();

        if($firmas->count() > 0 )   $response = $firmas;
        return response()->json($response);
    }

    public function insertarFirmas(Request $request){

        $firmas = (object)$request->firmas;

        $firmas->titulo_academico = trim(ucfirst($firmas->titulo_academico));
        $firmas->nombres = trim(ucwords($firmas->nombres));
        $firmas->cargo = trim(ucfirst($firmas->cargo));
        $firmas->institucion = trim(ucfirst($firmas->institucion));

        $existe = firmas::where('nombres', $firmas->nombres)->first();

        if($existe){    //Existe el nombre de la firma del emisor
            $response = [
                'estado' => false,
                'mensaje' => 'El firmante ya se encuentra registrado !'
            ];
        }else{
            $new = new firmas();

            $new->titulo_academico = $firmas->titulo_academico;
            $new->nombres = $firmas->nombres;
            $new->cargo = $firmas->cargo;
            $new->institucion= $firmas->institucion;
            $new->save();

            $response = [
                'estado' => true,
                'mensaje' => 'Se ha registrado la firma!'
            ];
        }

        return response()->json($response);

    }

}
