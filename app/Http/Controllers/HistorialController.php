<?php

namespace App\Http\Controllers;

use App\Models\historial_usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    //metodo con json para probar si funciona con postman
    public function getHistorial(){
        return response()->json(historial_usuario::all(),200);
    }

    public function getHistorialxid($id){
        $husuario = historial_usuario::find($id);
        if(is_null($husuario)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($husuario::find($id),200);
    }

    public function insertHistorial(Request $request){
        $husuario = historial_usuario::create ($request->all());
        return response($husuario,200);
    }

    public function updateHistorial(Request $request,$id){
        $husuario=historial_usuario::find($id);
        if (is_null($husuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $husuario->update($request->all());
        return response($husuario,200);
    }

    public function deleteHistorial($id){
        $husuario=historial_usuario::find($id);
        if (is_null($husuario)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $husuario->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }


    public function traerdatoshistorial(){
        $buscar=DB::select("select p.cedula, (p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres,
        h.id, h.titulo, h.detalle, h.dato_viejo,h.dato_nuevo,h.fecha_creacion
        
        
        from esq_datos_personales.personal p
        join esq_dricb.usuarios u on p.idpersonal = u.personal_id
        join esq_dricb.historial_usuarios h on u.id = h.usuario_id
        order by h.id DESC"
    );
    if($buscar){
            
        $response=[
            'estado'=> true,
            'datos'=> $buscar,
        ];
    }else{
        $response=[
            'estado'=> false,
            'mensaje'=> 'No existen datos'
        ];

    }
    return response()->json($response);


    }


    public function traerdatoshistorialxid($id){
        $buscar=DB::select("select p.cedula, (p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres,
        h.id as historial_id, h.titulo, h.detalle, h.dato_viejo,h.dato_nuevo,h.fecha_creacion
        
        
        from esq_datos_personales.personal p
        join esq_dricb.usuarios u on p.idpersonal = u.personal_id
        join esq_dricb.historial_usuarios h on u.id = h.usuario_id
        where h.id = ".$id." "
    );
    if($buscar){
            
        $response=[
            'estado'=> true,
            'datos'=> $buscar,
        ];
    }else{
        $response=[
            'estado'=> false,
            'mensaje'=> 'No existen datos'
        ];

    }
    return response()->json($response);


    }
}
