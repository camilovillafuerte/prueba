<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BecasMaestriaDoctoradoController extends Controller
{
    //
    private $baseCtrl;

    public function __construct()
    {
    $this->baseCtrl = new BaseController();
    }


    public function consultarbecas($cedula){

        $consulta = DB::table('esq_datos_personales.personal')
       
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
        ->orderBy('tbl_personal_rol.fecha','DESC')
        
        ->get();
    
        
        $consulta->roles=$consulta2;
        $verificar=0;
        foreach($consulta2 as $rol){
            $rolObj=(Object) $rol;
            if($rolObj->Rol=='ESTUDIANTE'){
                $consultaDocente=$this->verificarDocente($consulta->idpersonal);
                if($consultaDocente)
                {
                    $verificar=0;
                }
                else
                {
                    $response=[
                        'estado'=> false,
                        'mensaje' => 'Usted no puede solicitar una Beca'

                    ];
                    $verificar=1;

                }
            }
           
        }
        if($verificar==0){
            $consultaDocente2=$this->verificarDocente($consulta->idpersonal);
            if($consultaDocente2)
            {
                 $response=[
                'estado'=> true,
                'usuario' => $consulta
                ];
            }
            else{
                $response=[
                    'estado'=> false,
                    'mensaje' => 'Usted no puede solicitar una Beca'

                ];
            }


        }
        
      
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


         public function consultarBeca($cedula){
            $buscar=DB::select("select (p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, f.nombre As Nombre_Facultad, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud
            from esq_distributivos.departamento d
            join esq_inscripciones.facultad f on d.idfacultad = f.idfacultad
            join esq_distributivos.departamento_docente dd on dd.iddepartamento = d.iddepartamento
            join esq_datos_personales.personal p on dd.idpersonal = p.idpersonal
            join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
            join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
            join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
            

            where p.cedula='$cedula' and s.tipo = 'B' 
            order by s.id DESC");
    
            if($buscar){
                $response=[
                    'estado'=> true,
                    'datos'=> $buscar,
                ];
            }else{
                $response=[
                    'estado'=> false,
                    'mensaje'=> 'Estud no tiene una solicitud'
                ];
    
            }
            return response()->json($response);
        }


        public function subirDocumentoBecas(Request $request)
        {
    
            if ($request->hasFile('document')) {
                $documento = $request->file('document');
                $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
                $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
                $filenametostore = $filename . '' . uniqid() . '.' . $extension;
    
                Storage::disk('ftp11')->put($filenametostore, fopen($request->file('document'), 'r+'));
    
                $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosBecas/');
    
                $response = [
                    'estado' => true,
                    'documento' => $url . $filenametostore,
                    'mensaje' => 'El documento se ha subido al servidor'
                ];
            } else {
                $response = [
                    'estado' => false,
                    'documento' => '',
                    'mensaje' => 'No hay un archivo para procesar'
                ];
            }
    
            return response()->json($response);
        }

        }
