<?php

namespace App\Http\Controllers;

use App\Models\historial_usuario;
use App\Models\m_materias;
use App\Models\s_aprobadas;
use App\Models\solicitudes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SolicitudesController extends Controller
{
    private $baseCtrl;

    public function __construct()
    {
        $this->baseCtrl = new BaseController();
    }

    public function subirDocumentoMovilidadyBecas(Request $request)
    {
        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '_' . uniqid() . '.' . $extension;

            Storage::disk('ftp12')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/DocumentosSolicitudesAprobadas/');

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

    public function actualizarAprobados(Request $request){
        $data = (object)$request->data;
        $aprobados=s_aprobadas::where('id',(intval($data->id)))->first();
        if($aprobados){
            if(trim($aprobados->estado)=='S'){
                $aprobados->pdf=trim($data->PDF);
                $aprobados->tipo = trim($data->tipo);
                $aprobados->estado="F";
                $aprobados->save();
                $response=[
            'estado'=> true,
            'mensaje' => 'Se actualizo el estado del informe a Finalizado'
        ];
            }else {
                $response = [
                    'estado' => false,
                    'mensaje' => 'Solo se pude actualizar las solicitudes sin Informes'
                ];
            }
    } else{
        $response = [
            'estado' => false,
            'mensaje' => 'No existe la solicitud'
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
        a.id as id_alergias, a.descripcion as Alergias, ea.id as id_especificar_alergias, ea.especificar_alergia, en.id as id_enfermedades_cronicas, en.enfermedades_tratamiento,s.poliza_seguro,pdf.id as id_pdf, 
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

    public function solicitudBecas($id){
        $becas=DB::select("
        select p.idpersonal, p.cedula, p.apellido1, p.apellido2, p.nombres,p.fecha_nacimiento,
    t.nombre as Nacionalidad,p.genero,p.residencia_calle_1, p.residencia_calle_2, p.residencia_calle_3,
    p.correo_personal_institucional,p.correo_personal_alternativo, t1.nombre as Estado_civil,
    u.nombre as Pais, u1.nombre as Provincia,u2.nombre as Canton,
    p.telefono_personal_domicilio, p.telefono_personal_celular, t2.nombre as Tipo_Sangre, t3.nombre as Nombre_Discapacidad,
    p.contacto_emergencia_apellidos,p.contacto_emergencia_nombres,
    p.contacto_emergencia_telefono_1,p.contacto_emergencia_telefono_2,
    f.idfacultad, f.nombre As Nombre_Facultad,m1.id as id_modalidad1 ,m1.tipo_modalidad as Modalidad,m2.id as id_modalidad2 ,m2.tipo_modalidad as Tipo_Destino,uni.iduniversidad ,uni.nombre as Universidad_Destino,
    s.campus_destino, s.numero_semestre,s.fecha_inicio, s.fecha_fin,ni.id as id_naturaleza,ni.descripcion as Naturaleza,b.id as id_becasapoyo ,b.descripcion as Beca_Apoyo,
    m.id as id_monto,m.descripcion as Monto_Referencial, 
    a.id as id_alergias,a.descripcion as Alergias, ea.id as id_especificar_alergias,ea.especificar_alergia,en.id as id_enfermedades_cronicas ,en.enfermedades_tratamiento,s.poliza_seguro,pdf.id as id_pdf, 
    pdf.pdfcarta_aceptacion, pdf.pdftitulo



        from esq_distributivos.departamento d
        join esq_inscripciones.facultad f on d.idfacultad = f.idfacultad
        join esq_distributivos.departamento_docente dd on dd.iddepartamento = d.iddepartamento
        join esq_datos_personales.personal p on dd.idpersonal = p.idpersonal
        join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
        join esq_catalogos.tipo t on p.idtipo_nacionalidad = t.idtipo
        join esq_catalogos.tipo t1 on p.idtipo_estado_civil = t1.idtipo
        join esq_catalogos.tipo t2 on p.idtipo_sangre= t2.idtipo
        join esq_catalogos.tipo t3 on p.idtipo_discapacidad = t3.idtipo
        join esq_catalogos.ubicacion_geografica u on p.idtipo_pais_residencia = u.idubicacion_geografica
        join esq_catalogos.ubicacion_geografica as u1 on p.idtipo_provincia_residencia = u1.idubicacion_geografica
        join esq_catalogos.ubicacion_geografica as u2 on p.idtipo_canton_residencia = u2.idubicacion_geografica
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
    
        where pdf.tipo='B' and s.tipo='B' and s.id = ".$id."");
        $becas2= $becas2=(object)$becas[0];
        return ($becas2);
    }

    public function consultarSolicitud($tipo,$id,$tipo_solicitud)
    {
        if($tipo=='M')
        {
            $buscar1=$this->solicitud($id);
             $buscar2=json_decode(json_encode($buscar1));

             if($buscar2)
             {
                 if($tipo_solicitud=="A")
                 {
                    $solicitud=solicitudes::where('id',intval($id))->first();
                    $pdf_final=s_aprobadas::where('solicitud_id',$solicitud->id)->first();
                    $buscar2->s_aprobado=$pdf_final;
                 }
                 $materias=m_materias::where('solicitud_id',intval($id))
                 ->where ('estado','=','A')
                 ->orderBy('id','ASC' )
                 ->get();
                 if($materias){
                    $buscar2->materias=$materias;
                 }

                 $response=[
                    'estado'=>true,
                    'datos' =>$buscar2 
                ];
            
             }
             else{
                $response=[
                    'estado'=>false,
                    'mensaje' =>'No existe la solicitud' 
                ];

             }
            
        }
        else
        {
            $buscar1=$this->solicitudBecas($id);
             $buscar2=json_decode(json_encode($buscar1));
             if($buscar2)
             {
                if($tipo_solicitud=="A")
                {
                   $solicitud=solicitudes::where('id',intval($id))->first();
                   $pdf_final=s_aprobadas::where('solicitud_id',$solicitud->id)->first();
                   $buscar2->s_aprobado=$pdf_final;
                }

                $response=[
                   'estado'=>true,
                   'datos' =>$buscar2 
               ];

             }
             else
             {
                 $response=[
                'estado'=>false,
                'mensaje' =>'No existe la solicitud' 
            ];


             }


        }
      
        return response()->json($response);
    }

    public function findsolicitudes($id)
    {
        $data = solicitudes::find($id);
        $response = [
            'estado' => true,
            'solicitud' => $data
        ];

        return response()->json($response);
    }
}
