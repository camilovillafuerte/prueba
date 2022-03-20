<?php

namespace App\Http\Controllers;

use App\Models\becas_apoyos;
use App\Models\m_montos;
use App\Models\modalidades;
use App\Models\natu_intercambios;
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
->join('esq_catalogos.tipo as t3','esq_datos_personales.personal.idtipo_discapacidad','=','t3.idtipo')
->join('esq_catalogos.ubicacion_geografica','esq_datos_personales.personal.idtipo_pais_residencia','=','esq_catalogos.ubicacion_geografica.idubicacion_geografica')
->join('esq_catalogos.ubicacion_geografica as u1','esq_datos_personales.personal.idtipo_provincia_residencia','=','u1.idubicacion_geografica')
->join('esq_catalogos.ubicacion_geografica as u2','esq_datos_personales.personal.idtipo_canton_residencia','=','u2.idubicacion_geografica')

->select(/*'tbl_rol.descripcion as Rol',*/'personal.idpersonal','personal.cedula', 'personal.apellido1', 'personal.apellido2','personal.nombres','personal.fecha_nacimiento',
'tipo.nombre as Nacionalidad','personal.genero','personal.residencia_calle_1', 'personal.residencia_calle_2', 'personal.residencia_calle_3',
'personal.correo_personal_institucional','personal.correo_personal_alternativo', 't1.nombre as Estado_civil',
'ubicacion_geografica.nombre as Pais', 'u1.nombre as Provincia','u2.nombre as Canton',
'personal.telefono_personal_domicilio', 'personal.telefono_personal_celular', 't2.nombre as Tipo_Sangre', 't3.nombre as Nombre_Discapacidad',
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
->orderBy('tbl_personal_rol.fecha','DESC')

->get();

$consulta->roles=$consulta2;
$verificar=0;
$egresado=0;
$graduado=0;

foreach($consulta2 as $rol){
    $rolObj=(Object) $rol;
    if($rolObj->Rol=='ESTUDIANTE'){
        $consultaDocente=$this->verificarDocente($consulta->idpersonal);
        if($consultaDocente)
        {
         $response=[
             'estado'=> false,
             'mensaje' =>'Usted no es un Estudiante' 
         ];
 
        }
        else{
        // consultar utlimo promedio, carrera que estudia y ultimo periodo
        $semestre=$this->consultarPeriodo($consulta->idpersonal);
        if($semestre){
            $consulta->carrera=$semestre;
            // $consulta->carrera=$semestre->escuela_nombre;
            // $consulta->promedio=$semestre->promedio;
             $response=[
                 'estado'=> true,
                 'usuario' => $consulta
             ];

        }
        else{
            $response=[
                'estado'=> false,
                'mensaje' => 'Usted no puede solicitar este tipo de becas'

            ];
        }
    }
        $verificar=1;
    }
    else if($rolObj->Rol=='EGRESADO'){
        $egresado=1;

    }
    else if($rolObj->Rol=='GRADUADO'){
       $graduado=1;
    }
}
if($verificar==0 || $egresado==1 || $graduado==1)
$response=[
    'estado'=> false,
    'mensaje' => 'Usted no forma parte de los Estudiantes de UTM'

];
} else{
    $response= [
        'estado'=> false,
        'mensaje' => 'Usted no pertenece a la UTM'
    ];

}

return response()->json($response);

}


public function verificarDocente($idpersonal){
    $consulta= DB::select("select f.idfacultad, f.nombre facultad, d.iddepartamento, d.nombre departamento, dd.idpersonal, p.apellido1 || ' ' || p.apellido2 || ' ' || p.nombres nombres
     from esq_distributivos.departamento d
     join esq_inscripciones.facultad f 
         on d.idfacultad = f.idfacultad
         and not f.nombre = 'POSGRADO'
         and not f.nombre = 'CENTRO DE PROMOCIÓN Y APOYO AL INGRESO'
         and not f.nombre = 'INSTITUTO DE INVESTIGACIÓN'
         and d.habilitado = 'S'
     join esq_distributivos.departamento_docente dd
         on dd.iddepartamento = d.iddepartamento
     join esq_datos_personales.personal p 
         on dd.idpersonal = p.idpersonal
     where p.idpersonal = ".$idpersonal."
     order by d.idfacultad, d.iddepartamento, p.idpersonal");
     return $consulta;
 
 }

public function consultarPeriodo($idpersonal){
    $consulta3 = DB::select("select es.idescuela,es.nombre as Escuela_Nombre,pa.nombre as PERIODO ,i.prom_s as Promedio, m.nombre as Semestre
    from esq_inscripciones.inscripcion i
    join  esq_inscripciones.escuela es on  i.idescuela = es.idescuela 
    join esq_periodos_academicos.periodo_academico pa on pa.idperiodo=i.idperiodo 
    join esq_mallas.nivel m on i.idnivel=m.idnivel 
    where i.idpersonal = ".$idpersonal." and pa.actual  = 'S'
    order by pa.idperiodo DESC");
    $i=0;
    $consulta4=json_decode(json_encode($consulta3));
    // foreach($consulta4 as $per){
    // $periObj=(Object) $per;
    // if($i==0)
    // {
    //     $response=$periObj;
    //     return $response;
    // }
    // $i++;
    // }

    return ($consulta4);
    }


    public function modalidad($tipo){
        $exist=modalidades::where("tipo", intval($tipo ))->get();
        if($exist){
            $response=[
                'estado'=>true,
                'modalidad' => $exist
            ];

        }else{
            $response=[
                'estado'=>false,
                'mensaje' => 'No existe esa modalidad'
            ];
        }
  
        return response()->json($response);
    }


    public function naturaleza($tipo){
        $exist=natu_intercambios::where("tipo", $tipo )->get();
        if($exist){
            $response=[
                'estado'=>true,
                'naturaleza' => $exist
            ];

        }else{
            $response=[
                'estado'=>false,
                'mensaje' => 'No existe esa naturaleza de movilidad'
            ];
        }
  
        return response()->json($response);
    }


    public function becas($tipo){
        $exist=becas_apoyos::where("tipo", $tipo )->get();
        if($exist){
            $response=[
                'estado'=>true,
                'naturaleza' => $exist
            ];

        }else{
            $response=[
                'estado'=>false,
                'mensaje' => 'No existe esa beca'
            ];
        }
  
        return response()->json($response);
    }
  

    public function monto($tipo){
        $exist=m_montos::where("tipo", $tipo )->get();
        if($exist){
            $response=[
                'estado'=>true,
                'naturaleza' => $exist
            ];

        }else{
            $response=[
                'estado'=>false,
                'mensaje' => 'No existe el monto'
            ];
        }
  
        return response()->json($response);
    }

    public function universidad (){
        $consulta= DB::select("select iduniversidad, nombre
        from esq_datos_personales.p_universidad");

        return response()->json($consulta);
    }
}





