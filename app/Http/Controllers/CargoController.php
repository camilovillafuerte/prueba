<?php

namespace App\Http\Controllers;

use App\Models\cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargoController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getCargo(){
        return response()->json(cargo::all(),200);
    }

    public function getCargoxid($id){
        $cargo= cargo::find($id);
        if(is_null($cargo)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($cargo::find($id),200);
    }

    public function insertCargo(Request $request){
        $cargo = cargo::create ($request->all());
        return response($cargo,200);
    }

    public function updateCargo(Request $request,$id){
        $cargo=cargo::find($id);
        if (is_null($cargo)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $cargo->update($request->all());
        return response($cargo,200);
    }

    public function deleteCargo($id){
        $cargo=cargo::find($id);
        if (is_null($cargo)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $cargo->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }

    public function obtenercargos(){
        $cargo=DB::table('esq_dricb.cargos')
        ->select('cargos_id', 'cargo')
        ->where ('estado','=','A')
        ->orderBy('cargo','ASC')
        ->get();
        if($cargo){
            $response=[
                'estado'=> true,
                'datos'=> $cargo
            ];
        }else{
            $response=[
                'estado'=> false,
                'mensaje'=> 'No hay cargos'
            ];
        }

        return response()->json($response);
    }
}
