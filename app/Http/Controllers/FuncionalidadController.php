<?php

namespace App\Http\Controllers;

use App\Models\funcionalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuncionalidadController extends Controller
{
    //
    //metodo con json para probar si funciona con postman
    public function getFuncionalidad(){
        return response()->json(funcionalidad::all(),200);
    }

    public function getFuncionalidadxid($id){
        $funcionalidad = funcionalidad::find($id);
        if(is_null($funcionalidad)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($funcionalidad::find($id),200);
    }

    public function insertFuncionalidad(Request $request){
        $funcionalidad = funcionalidad::create ($request->all());
        return response($funcionalidad,200);
    }

    public function updateFuncionalidad(Request $request,$id){
        $funcionalidad=funcionalidad::find($id);
        if (is_null($funcionalidad)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $funcionalidad->update($request->all());
        return response($funcionalidad,200);
    }

    public function deleteFuncionalidad($id){
        $funcionalidad=funcionalidad::find($id);
        if (is_null($funcionalidad)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $funcionalidad->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
    public function getFuncionalidad_v2(){

        $funcionalidad=DB::table('esq_dricb.funcionalidads')
        ->select('funcion_id', 'funcionalidad')
        ->orderBy('funcionalidad','ASC')
        ->get();
        if($funcionalidad){
            $response=[
                'estado'=> true,
                'datos'=> $funcionalidad
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
