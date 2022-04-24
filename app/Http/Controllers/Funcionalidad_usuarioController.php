<?php

namespace App\Http\Controllers;

use App\Models\funcionalidad;
use App\Models\funcionalidad_usuario;
use Illuminate\Http\Request;

class Funcionalidad_usuarioController extends Controller
{
    //
    //metodo con json para probar si funciona con postman
    public function getFusuario(){
        return response()->json(funcionalidad_usuario::all(),200);
    }

    public function getFUsuarioxid($id){
        $fusuario = funcionalidad_usuario::find($id);
        if(is_null($fusuario)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($fusuario::find($id),200);
    }

    public function insertFusuario(Request $request){
        $fusuario = funcionalidad_usuario::create ($request->all());
        return response($fusuario,200);
    }

    public function updateFusuario(Request $request,$id){
        $fusuario=funcionalidad_usuario::find($id);
        if (is_null($fusuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $fusuario->update($request->all());
        return response($fusuario,200);
    }

    public function deleteFusuario($id){
        $fusuario=funcionalidad_usuario::find($id);
        if (is_null($fusuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $fusuario->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }

    public function getFuncionalidad($id){

        $funcionalidad=funcionalidad_usuario::where('usuario_id',intval($id))->orderBy('id','DESC' )->get();
        $funcion_final=[];
        if($funcionalidad)
        {
            foreach($funcionalidad as $fun){
                $ObjFun = (object)$fun;
                $funcion=funcionalidad::where('funcion_id',$ObjFun->funcion_id)->first();
               $funcion_usuario=[
                   'fusuarios_id'=>$ObjFun->fusuarios_id,
                   'funcion_id'=>$ObjFun->funcion_id,
                   'funcionalidad'=>$funcion->funcionalidad,
                    'estado'=>$ObjFun->estado
                ];

                $funcion_final[]=$funcion_usuario;
            }

        }

        $response=[
            'estado'=>true,
            'funcion'=>$funcion_final
        ];

         return response()->json($response);

    }


    public function UpdateEstado(Request $request)
    {
        $data = (object)$request->data;

        $funcionalidad=funcionalidad_usuario::where('usuario_id',intval($data->id))->where('funcion_id',intval($data->funcion_id))->first();
        if($funcionalidad)
        {
            $funcionalidad->estado=$data->estado;
            $funcionalidad->save();
            $response=[
                'estado'=>true,
                'mensaje'=>'Se actualizo correctamente el estado..!!!',
            ];
        }
        else{
            $response=[
                'estado'=>false,
                'mensaje'=>'No se pudo actualizar el estado....!!',
            ];
        }



        return response()->json($response);
    }
    public function  agregarFuncionalidad(Request $request)
    {
        $data = (object)$request->data;
        $funcionalidad=funcionalidad_usuario::where('usuario_id',intval($data->id))->where('funcion_id',intval($data->funcion_id))->first();
        if($funcionalidad)
        {
            $response=[
                'estado'=>false,
                'mensaje'=>'La funcionalidad ya se encuentra ingresa....!!'
            ];
        }
        else{
            $newfuncion=new funcionalidad_usuario();
            $newfuncion->usuario_id=intval($data->id);
            $newfuncion->funcion_id=intval($data->funcion_id);
            $newfuncion->posicion=0;
            $newfuncion->estado="A";
            $newfuncion->save();
            $response=[
                'estado'=>true,
                'mensaje'=>'La funcionalidad se ingreso correctamente....!!'
            ];

        }
        return response()->json($response);

    }
}
