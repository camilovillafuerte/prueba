<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class MovilidadController extends Controller
{
    //
  
public function consultar($cedula){

$consulta = DB::table('esq_datos_personales.personal')
//->join('esq_roles.tbl_personal_rol','esq_roles.tbl_personal_rol.id_personal','=','esq_datos_personales.personal.idpersonal')
//->join('esq_roles.tbl_rol','esq_roles.tbl_personal_rol.id_rol','=','esq_roles.tbl_rol.id_rol')

->join('esq_catalogos.tipo','esq_datos_personales.personal.idtipo_nacionalidad','=','esq_catalogos.tipo.idtipo')

->join('esq_catalogos.tipo as t1','esq_datos_personales.personal.idtipo_estado_civil','=','t1.idtipo')
->join('esq_catalogos.tipo as t2','esq_datos_personales.personal.idtipo_sangre','=','t2.idtipo')

->join('esq_catalogos.ubicacion_geografica','esq_datos_personales.personal.idtipo_pais_residencia','=','esq_catalogos.ubicacion_geografica.idubicacion_geografica')
->join('esq_catalogos.ubicacion_geografica as u1','esq_datos_personales.personal.idtipo_provincia_residencia','=','u1.idubicacion_geografica')
->join('esq_catalogos.ubicacion_geografica as u2','esq_datos_personales.personal.idtipo_canton_residencia','=','u2.idubicacion_geografica')

->select(/*'tbl_rol.descripcion as Rol',*/'personal.idpersonal','personal.cedula', 'personal.apellido1', 'personal.apellido2','personal.nombres','personal.fecha_nacimiento',
'tipo.nombre as Nacionalidad','personal.genero','personal.residencia_calle_1', 'personal.residencia_calle_2', 'personal.residencia_calle_3',
'personal.correo_personal_institucional','personal.correo_personal_alternativo', 't1.nombre as Estado_civil',
'ubicacion_geografica.nombre as Pais', 'u1.nombre as Provincia','u2.nombre as Canton',
'personal.telefono_personal_domicilio', 'personal.telefono_personal_celular', 't2.nombre as Tipo_Sangre',
'personal.contacto_emergencia_apellidos','personal.contacto_emergencia_nombres',
'personal.contacto_emergencia_telefono_1','personal.contacto_emergencia_telefono_2'
)
-> where ('esq_datos_personales.personal.cedula', $cedula)

-> first();
if($consulta){
$consulta2 = DB::table('esq_roles.tbl_personal_rol')
->join('esq_roles.tbl_rol','esq_roles.tbl_personal_rol.id_rol','=','esq_roles.tbl_rol.id_rol')
->join('esq_datos_personales.personal','esq_datos_personales.personal.idpersonal','=','esq_roles.tbl_personal_rol.id_personal')
->select('tbl_rol.id_rol','tbl_rol.descripcion as Rol', 'tbl_personal_rol.fecha')
->where('personal.idpersonal','=',$consulta->idpersonal)
->where('tbl_rol.estado','=','S')
->where('tbl_rol.descripcion','<>','EGRESADO')
->orderBy('tbl_personal_rol.fecha','DESC')

->get();

$consulta->roles=$consulta2;
$verificar=0;
foreach($consulta2 as $rol){
    $rolObj=(Object) $rol;
    if($rolObj->Rol=='ESTUDIANTE'){
        $response=[
            'estado'=> true,
            'usuario' => $consulta
        ];
        $verificar=1;
    }
   // $response=$rolObj;
}
if($verificar==0)
$response=[
    'estado'=> false,
    'mensaje' => 'Usted no es un Estudiante'

];
} else{
    $response= [
        'estado'=> false,
        'mensaje' => 'Usted no pertenece a la UTM'
    ];

}

return response()->json($response);

}




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
