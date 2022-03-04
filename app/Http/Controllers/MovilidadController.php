<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovilidadController extends Controller
{
    //
public function rol_estudiantes($cedula)
{ 
    $response = [];
    //if(isset($cedula)){
    $rolestudiante = DB::table('esq_datos_personales.personal')
    ->join('esquema_dricb.usuarios','esquema_dricb.usuarios.personal_id','=','esq_datos_personales.personal.id')
    ->join('esq_roles.tbl_personal_rol','esq_roles.tbl_personal_rol.id_personal','=','esq_datos_personales.personal.id')
    ->join('esq_roles.tbl_rol','esq_roles.tbl_personal_rol.id_rol','=','esq_roles.tbl_rol.id_rol')
    ->select('usuarios.*','personal.*','tbl_personal_rol.*','tbl_rol.*')
    -> where ('descripcion','ESTUDIANTE')
    -> where ('esq_datos_personales.personal.cedula', $cedula)
    -> get();

    if($rolestudiante){
        $response = [
            'estado' => true,
            'mensaje' => 'Usted es un estudiante',
            'datos' => $rolestudiante
          
        ];
    }else{
        $response = [
            'estado' => false,
            'mensaje' => 'La cédula no pertenece a un estudiante',
            'datos' => $rolestudiante
        ];
    }
/*}else{
    $response = [
        'estado' => false,
        'mensaje' => 'No hay data',
        'datos' => false
    ];
}*/

    return response()->json($response);
 
}

public function roles()
{ 
    $roles = DB::table('esquema_dricb.usuarios')
    ->join('esq_datos_personales.personal','esquema_dricb.usuarios.personal_id','=','esq_datos_personales.personal.id')
    ->join('esq_roles.tbl_personal_rol','esq_roles.tbl_personal_rol.id_personal','=','esq_datos_personales.personal.id')
    ->join('esq_roles.tbl_rol','esq_roles.tbl_personal_rol.id_rol','=','esq_roles.tbl_rol.id_rol')
    ->select('usuarios.*','personal.*','tbl_personal_rol.*','tbl_rol.*')
    -> where('descripcion','<>','ESTUDIANTE') 
    -> get();
  
    return response() -> json ($roles);
}



}
