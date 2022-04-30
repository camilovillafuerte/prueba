<?php

namespace App\Http\Controllers;

use App\Models\alergias;
use App\Models\becas_apoyos;
use App\Models\enfermedades_cronicas;
use App\Models\especificar_alergias;
use App\Models\historial_usuario;
use App\Models\imagenes_convenios;
use App\Models\imagenes_solicitudes;
use App\Models\m_beneficios;
use App\Models\m_materias;
use App\Models\m_montos;
use App\Models\modalidades;
use App\Models\natu_intercambios;
use App\Models\pdf_solicitudes;
use App\Models\s_aprobadas;
use App\Models\solicitudes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Object_;
use PDF;

class MovilidadController extends Controller
{
    //
    private $baseCtrl;

    public function __construct()
    {
        $this->baseCtrl = new BaseController();
    }
  
public function consultar($id){

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

//-> where ('esq_datos_personales.personal.cedula', $cedula)
-> where ('esq_datos_personales.personal.idpersonal',$id)

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
                'apoyo' => $exist
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
                'monto' => $exist
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
        from esq_datos_personales.p_universidad
        order by nombre ASC");

        return response()->json($consulta);
    }

    


    public function tipoalergias(){
        $exist=alergias::select("*")
        -> orderBy('descripcion', 'ASC')
        ->get();
        if($exist){
            $response=[
                'estado'=>true,
                'alergias' => $exist
            ];

        }else{
            $response=[
                'estado'=>false,
                'mensaje' => 'No existe ese tipo de alergias'
            ];
        }
  
        return response()->json($response);
    }


    public function subirDocumentosMovilidad(Request $request)
    {
        $archivo=[];
        $objetoarchivo=(Object)$archivo;
        if ($request->hasFile('certificado_matricula'))
         {
            $documento = $request->file('certificado_matricula');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('certificado_matricula')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('certificado_matricula'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo-> certificado_matricula=$url . $filenametostore;


         }
         if($request->hasFile('copia_record'))
         {
            $documento = $request->file('copia_record');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('copia_record')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('copia_record'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->copia_record=$url . $filenametostore;
         }

        if($request->hasFile('solicitud_carta'))
         {
            $documento = $request->file('solicitud_carta');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('solicitud_carta')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('solicitud_carta'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->solicitud_carta=$url . $filenametostore;
         }
         if($request->hasFile('cartas_recomendacion'))
         {
            $documento = $request->file('cartas_recomendacion');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('cartas_recomendacion')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('cartas_recomendacion'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->cartas_recomendacion=$url . $filenametostore;
         }

        if($request->hasFile('no_sancion'))
         {
            $documento = $request->file('no_sancion');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('no_sancion')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('no_sancion'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->no_sancion=$url . $filenametostore;
         }

         if($request->hasFile('fotos'))
         {
            $documento = $request->file('fotos');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('fotos')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('fotos'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->fotos=$url . $filenametostore;
         }
        if($request->hasFile('seguro'))
         {
            $documento = $request->file('seguro');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('seguro')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('seguro'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->seguro=$url . $filenametostore;
         }

         if($request->hasFile('examen_psicometria'))
         {
            $documento = $request->file('examen_psicometria');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('examen_psicometria')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('examen_psicometria'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->examen_psicometria=$url . $filenametostore;
         }
         else{
            $objetoarchivo->examen_psicometria="";
         }

        if($request->hasFile('dominio_idioma'))
         {
            $documento = $request->file('dominio_idioma');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('dominio_idioma')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('dominio_idioma'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->dominio_idioma=$url . $filenametostore;
         }
         else{
            $objetoarchivo->dominio_idioma="";
         }

         if($request->hasFile('documento_udestino'))
         {
            $documento = $request->file('documento_udestino');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('documento_udestino')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('documento_udestino'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->documento_udestino=$url . $filenametostore;
         }
        if($request->hasFile('comprobante_solvencia'))
         {
            $documento = $request->file('comprobante_solvencia');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('comprobante_solvencia')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('comprobante_solvencia'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

            $objetoarchivo->comprobante_solvencia=$url . $filenametostore;
         }


         $arrayobjeto=(array)$objetoarchivo;
         if( count($arrayobjeto)==0)
         {
            $response=[
                'estado'=>false,
                'mensaje' =>"No existe ningun archivo" 
            ];

         }
         else{
            $response=[
                'estado'=>true,
                'pdf' =>$objetoarchivo 
            ];

         }
         return response()->json($response);
    }

    public function addsolicitud(Request $request)
    {
        $data = (object)$request->data;
        //solicitud
        /*  //HISTORIAL
          $historial = new historial_usuario();
          $historial->usuario_id = 1;
          $historial->titulo = "Solicitudes";
          $historial->detalle = trim($data->data);
          $historial->extra = "Insert";
          $historial->fecha_creacion = date('Y-m-d H:i:s');
          $historial->save();*/
        $newsoli=new solicitudes();
        $newsoli->personal_id=$data->idpersonal;
        $newsoli->logo_id=1;
        $newsoli->universidad_id=$data->id_universidad;
        $newsoli->escuela_id=$data->idescuela;
        $newsoli->naturaleza_id=$data->id_naturaleza;
        $newsoli->modalidad1_id=$data->modalidad1;
        $newsoli->modalidad2_id=$data->modalidad2;
        $newsoli->becas_id=$data->id_becas;
        $newsoli->montos_id=$data->id_monto;
        $newsoli->carrera_destino=trim(strtoupper($data->carrera_destino));
        $newsoli->semestre_cursar=trim(strtoupper($data->semestre_cursar));
        $newsoli->fecha_inicio=Date($data->fecha_inicio);
        $newsoli->fecha_fin=Date($data->fecha_fin);
        $newsoli->fcreacion_solicitud = date('Y-m-d H:i:s');
        $newsoli->estado_solicitud="P";
        $newsoli->poliza_seguro=$data->poliza_seguro;
        $newsoli->tipo="M";
        $newsoli->estado="A";
        $newsoli->save();

        //especificar_alergias
        $newespe=new especificar_alergias();
        $newespe->solicitud_id=$newsoli->id;
        $newespe->alergias_id=$data->id_alergias;
        $newespe->especificar_alergia=$data->especificar_alergias;
        $newespe->estado="A";
        $newespe->save();

        //enfermedades Cronicas
        $newenfer=new enfermedades_cronicas();
        $newenfer->solicitud_id=$newsoli->id;
        $newenfer->enfermedades_tratamiento=$data->enfermedades_tratamiento;
        $newenfer->estado="A";
        $newenfer->save();

        //Materias
        foreach ($data->materias as $mat) { 
            $mateObj = (object)$mat;
            $newMateria=new m_materias();
            $newMateria->solicitud_id=$newsoli->id;
            $newMateria->materia_origen=trim(ucfirst($mateObj->materia_origen));
            $newMateria->codigo_origen=trim($mateObj->clave_origen);
            $newMateria->materia_destino=trim(ucfirst($mateObj->materia_destino));
            $newMateria->codigo_destino=trim($mateObj->clave_destino);
            $newMateria->estado="A";
            $newMateria->save();
        }

        //pdf
        $newPdf=new pdf_solicitudes();
        $newPdf->solicitud_id=$newsoli->id;
        $newPdf->pdfcertificado_matricula=$data->pdfcertificado_matricula;
        $newPdf->pdfcopia_record=$data->pdfcopia_record;
        $newPdf->pdfsolicitud_carta=$data->pdfsolicitud_carta;
        $newPdf->pdfcartas_recomendacion=$data->pdfcartas_recomendacion;
        $newPdf->pdfno_sancion=$data->pdfno_sancion;
        $newPdf->pdffotos=$data->pdffotos;
        $newPdf->pdfseguro=$data->pdfseguro;
        $newPdf->pdfexamen_psicometrico=$data->pdfexamen_psicometrico;
        $newPdf->pdfdominio_idioma=$data->pdfdominio_idioma;
        $newPdf->pdfdocumentos_udestino=$data->pdfdocumento_udestino;
        $newPdf->pdfcomprobante_solvencia=$data->pdfcomprobante_solvencia;
        $newPdf->tipo="M";
        $newPdf->save();


        $response=[
            'estado'=>true,
            'mensaje' =>'Se creo correctamente la solicitud' 
        ];

        return response()->json($response);
    }

    public function consultarMovilidad($id){
        $buscar=DB::select("select (p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, es.nombre As Nombre_carrera, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud
        from esq_datos_personales.personal p
        join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
        join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
        join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
        join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
        where p.idpersonal=".$id." and s.tipo = 'M' and s.estado='A'
        order by s.id DESC");

        if($buscar){
            $response=[
                'estado'=> true,
                'datos'=> $buscar,
            ];
        }else{
            $response=[
                'estado'=> false,
                'mensaje'=> 'Usted no dispone de solicitudes dentro de Movilidad'
            ];

        }
        return response()->json($response);
    }


    public function subirDocumentoMovilidad(Request $request)
    {

        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '_' . uniqid() . '.' . $extension;

            Storage::disk('ftp10')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosMovilidad/');

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

    public function solicitud($id)
    {
        $buscar=DB::select("select p.idpersonal, p.cedula, p.apellido1, p.apellido2, p.nombres,p.fecha_nacimiento,
        t.nombre as Nacionalidad,p.genero,p.residencia_calle_1, p.residencia_calle_2, p.residencia_calle_3,
        p.correo_personal_institucional,p.correo_personal_alternativo, t1.nombre as Estado_civil,
        u.nombre as Pais, u1.nombre as Provincia,u2.nombre as Canton,
        p.telefono_personal_domicilio, p.telefono_personal_celular, t2.nombre as Tipo_Sangre, t3.nombre as Nombre_Discapacidad,
        p.contacto_emergencia_apellidos,p.contacto_emergencia_nombres,
        p.contacto_emergencia_telefono_1,p.contacto_emergencia_telefono_2,
        es.idescuela, es.nombre As Nombre_carrera,m1.id as id_modalidad1, m1.tipo_modalidad as Modalidad,m2.id as id_modalidad2, m2.tipo_modalidad as Tipo_Destino,
        uni.iduniversidad, uni.nombre as Universidad_Destino, s.carrera_destino, s.semestre_cursar, s.fecha_inicio,s.fecha_fin,
        ni.id as naturaleza_id, ni.descripcion as Naturaleza,b.id as id_becas, b.descripcion as Beca_Apoyo,m.id as id_monto, m.descripcion as Monto_Referencial,
        a.id as id_alergias, a.descripcion as Alergias, ea.id as id_esalergias, ea.especificar_alergia, en.id as id_enfermedades, en.enfermedades_tratamiento,s.poliza_seguro,pdf.id as id_pdf, 
        pdf.pdfcertificado_matricula, pdf.pdfcopia_record, pdf.pdfsolicitud_carta, pdf.pdfcartas_recomendacion, pdf.pdfno_sancion,
        pdf.pdffotos,pdf.pdfseguro, pdf.pdfexamen_psicometrico, pdf.pdfdominio_idioma, pdf.pdfdocumentos_udestino,
        pdfcomprobante_solvencia


    from esq_datos_personales.personal p
    join esq_catalogos.tipo t on p.idtipo_nacionalidad = t.idtipo
    join esq_catalogos.tipo t1 on p.idtipo_estado_civil = t1.idtipo
    join esq_catalogos.tipo t2 on p.idtipo_sangre= t2.idtipo
    join esq_catalogos.tipo t3 on p.idtipo_discapacidad = t3.idtipo
    join esq_catalogos.ubicacion_geografica u on p.idtipo_pais_residencia = u.idubicacion_geografica
    join esq_catalogos.ubicacion_geografica as u1 on p.idtipo_provincia_residencia = u1.idubicacion_geografica
    join esq_catalogos.ubicacion_geografica as u2 on p.idtipo_canton_residencia = u2.idubicacion_geografica
    join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
    join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
    join esq_datos_personales.p_universidad uni on uni.iduniversidad = s.universidad_id
    join esq_dricb.modalidades m1 on s.modalidad1_id = m1.id 
    join esq_dricb.modalidades m2 on s.modalidad2_id = m2.id 
    join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id
    join esq_dricb.becas_apoyos b on b.id = s.becas_id 
    join esq_dricb.m_montos m on m.id = s.montos_id
    join esq_dricb.especificar_alergias ea on ea.solicitud_id = s.id
    join esq_dricb.alergias a on a.id = ea.alergias_id
    join esq_dricb.enfermedades_cronicas en on en.solicitud_id = s.id
    
    join esq_dricb.pdf_solicitudes pdf on pdf.solicitud_id = s.id
    where pdf.tipo='M' and s.tipo='M' and s.id = ".$id."");
    $buscar2= $buscar2=(object)$buscar[0];
    return ($buscar2);

    }

    public function solicitudMovilidad($id){
       
    $buscar1=$this->solicitud($id);
    $buscar2=json_decode(json_encode($buscar1));
    
    if ($buscar2){
        $semestre=$this->consultarPeriodo($buscar2->idpersonal);
        $materias=m_materias::where('solicitud_id',intval($id))
        ->where('estado','=','A')
        ->orderBy('id','ASC' )
        ->get();
        if($materias)
        {
           
            $buscar2->materias=$materias;
            $buscar2->carrera=$semestre;
            $response= [
            'estado'=> true,
            'datos' => $buscar2,
        ];
    }
    }else{
        $response= [
            'estado'=> false,
            'mensaje' => 'No existe la solicitud'
        ];
    
    }
    //   $datos = compact('buscar2');
    //   $pdf = PDF::loadView('movilidad', ['datos' => $datos]);
    //   return $pdf->stream();
     return response()->json($response);
    }




    public function consultarSolicitudes($tipo, $estado){

        if($estado=='A')
        {
            $buscar=DB::select("select s.id,p.cedula,(p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, es.nombre As Nombre_carrera, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud, sa.pdf as pdf_final
            from esq_datos_personales.personal p
            join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
            join esq_dricb.s_aprobadas sa on sa.solicitud_id = s.id
            join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
            join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
            join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
            where s.tipo = '$tipo' and s.estado_solicitud='$estado' and s.estado='A'
            order by s.id DESC");
        }
        else
        {
            $buscar=DB::select("select s.id,p.cedula,(p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, es.nombre As Nombre_carrera, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud
            from esq_datos_personales.personal p
            join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
            join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
            join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
            join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
            where s.tipo = '$tipo' and s.estado_solicitud='$estado' and s.estado='A'
            order by s.id DESC");

        }
       
      
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


    public function updateSolicitudMovilidad(Request $request){
       $data = (object)$request->data;
        $soli_movi=solicitudes::where('id',(intval($data->id)))->first();
        if($soli_movi){
            if(trim($data->estado_solicitud)=='A')
            {
                $soli_movi->estado_solicitud=trim($data->estado_solicitud);
                $soli_movi->save();
                
                $aprobados= new s_aprobadas();
                $aprobados->solicitud_id=$soli_movi->id;
                $aprobados->tipo=trim($data->tipo);
                $aprobados->fecha_creacion=date('Y-m-d H:i:s');
                $aprobados->estado='S';
                $aprobados->save();
                
    
                $response=[
                    'estado'=> true,
                    'mensaje' => 'Se actualizo la solicitud a Aprobado'
                ];
            
        }else{
            $soli_movi->estado_solicitud=trim($data->estado_solicitud);
            $soli_movi->save();
            
            $response=[
                'estado'=>true,
                'mensaje' => 'Se actualizo la solicitud Rechazada'
            ];
        }


    }else{
        $response = [
            'estado' => false,
            'mensaje' => 'No existe la solicitud'
        ];
    }

    $universidad=DB::select("select (p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, uni.nombre as Universidad_Destino
    from esq_datos_personales.p_universidad uni
    join esq_dricb.solicitudes s on s.universidad_id=uni.iduniversidad
    join esq_datos_personales.personal p on s.personal_id= p.idpersonal
    where s.id=$data->id
    ");

   // return $universidad;

        $historial = new historial_usuario();
        $historial->usuario_id = intval($data->id_personal);
        $historial->titulo = "Modificación";
        $historial->detalle = "Se modifico el estado de la solicitud movilidad de ".json_encode($universidad).$soli_movi->estado_solicitud;
        $historial->dato_viejo =intval($data->id);
        $historial->dato_nuevo=json_encode($data);
        $historial->fecha_creacion = date('Y-m-d H:i:s');
        $historial->save();  
    return response()->json($response);

}

public function solicitudesAprobadas( $estado){
    $buscar=DB::select("select s.id as Solicitud_id, p.cedula,(p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, es.nombre As Nombre_carrera, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud, sa.id as s_aprobadas_id
    from esq_datos_personales.personal p
    join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
    join esq_dricb.s_aprobadas sa on sa.solicitud_id = s.id
    join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
    join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
    join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
    where s.tipo = 'M' and s.estado_solicitud='$estado' and s.estado='A' and sa.estado='S'
    order by s.id DESC");

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

public function updateSolicitudMovilidad_v2(Request $request)
{
    $data = (object)$request->data;

    if($data->tipo_documento=='A')
    { 
      $solicitud=solicitudes::where('id',intval($data->id))->first();
      if($solicitud)
      {
          if($data->pdf_final!=null)
          {
              $aprobados=s_aprobadas::where('solicitud_id',$solicitud->id)->first();
              $aprobados->pdf=trim($data->pdf_final);
              $aprobados->save();
          }
          $solicitud->fecha_inicio=Date($data->fecha_inicio);
          $solicitud->fecha_fin=Date($data->fecha_fin);
          $solicitud->save();
      }
      $response=[
          'estado'=>true,
          'mensaje'=>'Solicitud Movilidad actualizado con exito....!!'
      ];


    }
    else
    {
        $solicitud=solicitudes::where('id',intval($data->id))->first();
    if($solicitud)
    {
        $solicitud->universidad_id=intval($data->universidad_destino);
        $solicitud->naturaleza_id=intval($data->naturaleza);
        $solicitud->modalidad1_id=intval($data->modalidad);
        $solicitud->modalidad2_id=intval($data->tipo_destino);
        $solicitud->becas_id=intval($data->beca_apoyo);
        $solicitud->montos_id=intval($data->monto_referencial);
        $solicitud->carrera_destino=trim(strtoupper($data->carrera_destino));
        $solicitud->semestre_cursar=trim(strtoupper($data->semestre_cursar));
        $solicitud->fecha_inicio=Date($data->fecha_inicio);
        $solicitud->fecha_fin=Date($data->fecha_fin);
        $solicitud->poliza_seguro=trim($data->poliza_seguro);
        $solicitud->save();

        //especificar_alergias
        $newespe=especificar_alergias::where('solicitud_id',intval($solicitud->id))->first();
        $newespe->alergias_id= intval($data->alergias);
        $newespe->especificar_alergia=trim($data->especificar_alergia);
        $newespe->save();

        //enfermedades Cronicas
        $newenfer=enfermedades_cronicas::where('id',intval($data->id_enfermedades_cronicas))->first();
        $newenfer->enfermedades_tratamiento=$data->enfermedades_tratamiento;
        $newenfer->save();

        //Materias
        foreach ($data->materias as $mat) { 
            $mateObj = (object)$mat;
            if($mateObj->id==0)
            {
                $newMateria=new m_materias();
                $newMateria->solicitud_id=$solicitud->id;
                $newMateria->materia_origen=trim(ucfirst($mateObj->materia_origen));
                $newMateria->codigo_origen=trim($mateObj->clave_origen);
                $newMateria->materia_destino=trim(ucfirst($mateObj->materia_destino));
                $newMateria->codigo_destino=trim($mateObj->clave_destino);
                $newMateria->estado="A";
                $newMateria->save();
            }
            else{
                //materias update
                $materia=m_materias::where('id',intval($mateObj->id))->first();
                $materia->materia_origen=trim(ucfirst($mateObj->materia_origen));
                $materia->codigo_origen=trim($mateObj->clave_origen);
                $materia->materia_destino=trim(ucfirst($mateObj->materia_destino));
                $materia->codigo_destino=trim($mateObj->clave_destino);
                $materia->save();
            }
            
        }
        //eliminar materia
        foreach ($data->eliminar_materia as $matE) 
        {
            $mateObjE = (object)$matE;
            $materiaE=m_materias::where('id',intval($mateObjE->id))->first();
            $materiaE->estado='D';
            $materiaE->save();
         }


        //pdf
        $Pdf=pdf_solicitudes::where('solicitud_id',intval($solicitud->id))->first();
        $Pdf->pdfcertificado_matricula=$data->pdfcertificado_matricula;
        $Pdf->pdfcopia_record=$data->pdfcopia_record;
        $Pdf->pdfsolicitud_carta=$data->pdfsolicitud_carta;
        $Pdf->pdfcartas_recomendacion=$data->pdfcartas_recomendacion;
        $Pdf->pdfno_sancion=$data->pdfno_sancion;
        $Pdf->pdffotos=$data->pdffotos;
        $Pdf->pdfseguro=$data->pdfseguro;
        $Pdf->pdfexamen_psicometrico=$data->pdfexamen_psicometrico;
        $Pdf->pdfdominio_idioma=$data->pdfdominio_idioma;
        $Pdf->pdfdocumentos_udestino=$data->pdfdocumentos_udestino;
        $Pdf->pdfcomprobante_solvencia=$data->pdfcomprobante_solvencia;
        $Pdf->save();

        $response=[
            'estado'=>true,
            'mensaje'=>'Solicitud Movilidad actualizado con exito....!!'
        ];



    }

    }

    $universidad=DB::select("select (p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, uni.nombre as Universidad_Destino
    from esq_datos_personales.p_universidad uni
    join esq_dricb.solicitudes s on s.universidad_id=uni.iduniversidad
    join esq_datos_personales.personal p on s.personal_id= p.idpersonal
    where s.id=$data->id
    ");

   // return $universidad;

        $historial = new historial_usuario();
        $historial->usuario_id = intval($data->id_personal);
        $historial->titulo = "Modificación";
        $historial->detalle = "Se modifico la solicitud movilidad de ".json_encode($universidad);
        $historial->dato_viejo =intval($data->id);
        $historial->dato_nuevo=json_encode($data);
        $historial->fecha_creacion = date('Y-m-d H:i:s');
        $historial->save();  

    return response()->json($response);
}

    public function pdf_solicitud($id)
    {
        $buscar=DB::select("select p.idpersonal, p.cedula, p.apellido1, p.apellido2, p.nombres,p.fecha_nacimiento,
        t.nombre as Nacionalidad,p.genero,p.residencia_calle_1, p.residencia_calle_2, p.residencia_calle_3,
        p.correo_personal_institucional,p.correo_personal_alternativo, t1.nombre as Estado_civil,
        u.nombre as Pais, u1.nombre as Provincia,u2.nombre as Canton,
        p.telefono_personal_domicilio, p.telefono_personal_celular, t2.nombre as Tipo_Sangre, t3.nombre as Nombre_Discapacidad,
        p.contacto_emergencia_apellidos,p.contacto_emergencia_nombres,
        p.contacto_emergencia_telefono_1,p.contacto_emergencia_telefono_2,
        es.idescuela, es.nombre As Nombre_carrera,m1.id as id_modalidad1, m1.tipo_modalidad as Modalidad,m2.id as id_modalidad2, m2.tipo_modalidad as Tipo_Destino,
        uni.iduniversidad, uni.nombre as Universidad_Destino,s.carrera_destino, s.semestre_cursar, s.fecha_inicio,s.fecha_fin,
        ni.id as naturaleza_id, ni.descripcion as Naturaleza,b.id as id_becas, b.descripcion as Beca_Apoyo,m.id as id_monto, m.descripcion as Monto_Referencial,
        a.id as id_alergias, a.descripcion as Alergias, ea.id as id_esalergias, ea.especificar_alergia, en.id as id_enfermedades, en.enfermedades_tratamiento,s.poliza_seguro,pdf.id as id_pdf, 
        pdf.pdfcertificado_matricula, pdf.pdfcopia_record, pdf.pdfsolicitud_carta, pdf.pdfcartas_recomendacion, pdf.pdfno_sancion,
        pdf.pdffotos,pdf.pdfseguro, pdf.pdfexamen_psicometrico, pdf.pdfdominio_idioma, pdf.pdfdocumentos_udestino,
        pdfcomprobante_solvencia


    from esq_datos_personales.personal p
    join esq_catalogos.tipo t on p.idtipo_nacionalidad = t.idtipo
    join esq_catalogos.tipo t1 on p.idtipo_estado_civil = t1.idtipo
    join esq_catalogos.tipo t2 on p.idtipo_sangre= t2.idtipo
    join esq_catalogos.tipo t3 on p.idtipo_discapacidad = t3.idtipo
    join esq_catalogos.ubicacion_geografica u on p.idtipo_pais_residencia = u.idubicacion_geografica
    join esq_catalogos.ubicacion_geografica as u1 on p.idtipo_provincia_residencia = u1.idubicacion_geografica
    join esq_catalogos.ubicacion_geografica as u2 on p.idtipo_canton_residencia = u2.idubicacion_geografica
    join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
    join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
    join esq_datos_personales.p_universidad uni on uni.iduniversidad = s.universidad_id
    join esq_dricb.modalidades m1 on s.modalidad1_id = m1.id 
    join esq_dricb.modalidades m2 on s.modalidad2_id = m2.id 
    join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id
    join esq_dricb.becas_apoyos b on b.id = s.becas_id 
    join esq_dricb.m_montos m on m.id = s.montos_id
    join esq_dricb.especificar_alergias ea on ea.solicitud_id = s.id
    join esq_dricb.alergias a on a.id = ea.alergias_id
    join esq_dricb.enfermedades_cronicas en on en.solicitud_id = s.id
    
    join esq_dricb.pdf_solicitudes pdf on pdf.solicitud_id = s.id
    where pdf.tipo='M' and s.tipo='M' and s.id = ".$id."");
    $buscar2= $buscar2=(object)$buscar[0];
    return ($buscar2);

    }

    public function pdf_solicitudMovilidad($id){

     /*   $data = solicitudes::find($id);
        $imagen1 = imagenes_solicitudes::find($data->logo_id);
        $imagen1 = imagenes_convenios::find($data->imagenescon_id);
    */
    $buscar1=$this->pdf_solicitud($id);
    $buscar2=json_decode(json_encode($buscar1));
    
    if ($buscar2){
        $semestre=$this->consultarPeriodo($buscar2->idpersonal);
        $materias=m_materias::where('solicitud_id',intval($id))
        ->where('estado','=','A')
        ->orderBy('id','ASC' )
        ->get();
        if($materias)
        {
           
            $buscar2->materias=$materias;
            $buscar2->carrera=$semestre;
            $response= [
            'estado'=> true,
            'datos' => $buscar2,
        ];
    }
    }else{
        $response= [
            'estado'=> false,
            'mensaje' => 'No existe la solicitud'
        ];
    
    }
   
   /* $newData = [
        'logo_id' => $imagen1->logo_id,
        'urlimagen' => $imagen1->url_imagen,
    ];*/
    $datos = compact('buscar2');
    $pdf = PDF::loadView('movilidad', ['datos' => $datos]);
    return $pdf->stream();
     return response()->json($response);
    }
}





