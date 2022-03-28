<?php

namespace App\Http\Controllers;

use App\Models\alergias;
use App\Models\becas_apoyos;
use App\Models\enfermedades_cronicas;
use App\Models\especificar_alergias;
use App\Models\m_beneficios;
use App\Models\m_materias;
use App\Models\m_montos;
use App\Models\modalidades;
use App\Models\natu_intercambios;
use App\Models\pdf_solicitudes;
use App\Models\solicitudes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Object_;

class MovilidadController extends Controller
{
    //
    private $baseCtrl;

    public function __construct()
    {
        $this->baseCtrl = new BaseController();
    }
  
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

    public function beneficios_naturaleza($id){


        $consulta=DB::select("select n.descripcion, b.descripcion 
        from esq_dricb.natu_intercambios n
        join esq_dricb.beneficios_becas bn on n.id = bn.naturaleza_id
        join esq_dricb.m_beneficios b on  bn.beneficios_id = b.id
        where  n.id=".$id."");
        if($consulta){
            $response=[
                'estado'=> true,
                'beneficios'=> $consulta,
            ];
        }else{
            $response=[
                'estado'=> false,
                'mensaje'=> 'Esta naturaleza no tiene beneficios'
            ];

        }
        return response()->json($response);

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
        $newsoli->carrera_destino=trim(ucfirst($data->carrera_destino));
        $newsoli->semestre_cursar=trim(ucfirst($data->semestre_cursar));
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

    public function consultarMovilidad($cedula){
        $buscar=DB::select("select (p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, es.nombre As Nombre_carrera, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud
        from esq_datos_personales.personal p
        join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
        join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
        join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
        join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
        where p.cedula='$cedula' and s.tipo = 'M' and s.estado='A'
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
        es.nombre As Nombre_carrera,m1.tipo_modalidad as Modalidad, m2.tipo_modalidad as Tipo_Destino,
        uni.nombre as Universidad_Destino, s.carrera_destino, s.semestre_cursar, s.fecha_inicio,s.fecha_fin,
        ni.descripcion as Naturaleza, b.descripcion as Beca_Apoyo, m.descripcion as Monto_Referencial,
        a.descripcion as Alergias, ea.especificar_alergia, en.enfermedades_tratamiento,s.poliza_seguro, 
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
    
    return response()->json($response);
    }




    public function consultarSolicitudes($tipo, $estado){
        $buscar=DB::select("select s.id,p.cedula,(p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, es.nombre As Nombre_carrera, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud
        from esq_datos_personales.personal p
        join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
        join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
        join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
        join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
        where s.tipo = '$tipo' and s.estado_solicitud='$estado' and s.estado='A'
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


}





