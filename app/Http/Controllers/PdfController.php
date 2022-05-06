<?php

namespace App\Http\Controllers;

use App\Models\convenios;
use App\Models\imagenes_convenios;
use App\Models\imagenes_solicitudes;
use App\Models\m_materias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PDF;


class PdfController extends Controller{

    public function makePdfConvenios(Request $request){
        $data = (object)$request->data;
        $data->nombre_convenio = $this->repleceEnter($data->nombre_convenio);
        $data->comparecientes = $this->repleceEnter($data->comparecientes);
        $namePDf = "Convenio-".date('Y-m-d-H-i-s').'.pdf';

       for($k = 0;$k< count($data->clausulas);$k++)
       {
        $data->clausulas[$k]['descripcion']=$this->repleceEnter($data->clausulas[$k]['descripcion']);
       }
        for($i = 0; $i < count($data->clausulas); $i++){

            for($j = 0; $j < count($data->clausulas[$i]['articulos']); $j++){

                $data->clausulas[$i]['articulos'][$j]['des_art'] = $this->repleceEnter($data->clausulas[$i]['articulos'][$j]['des_art']);
            }
        }

        $exist = Storage::disk('convenios')->exists($namePDf);

        if($exist){
            $response = [
                'estado' => false,
                'mensaje' => 'El archivo ya existe',
                'file' => false
            ];
        }else{
            $path = storage_path().'/app/convenios/'.$namePDf;
            $pdf = PDF::loadView('convenio', ['data' => $data])->save($path)->stream($namePDf);

            $response = [
                'estado' => true,
                'mensaje' => 'PDF generado con éxito',
                'file' => $namePDf
            ];
        }

        return response()->json($response);

    }

    public function makePdfConvenios_v2(Request $request){
        // header("Access-Control-Allow-Origin: *");
        $data = (object)$request->data;

        $namePDf = "Convenio-".date('Y-m-d-H-i-s').'.pdf';

        $exist = Storage::disk('convenios')->exists($namePDf);

        if($exist){
            $response = [
                'estado' => false,
                'mensaje' => 'El archivo ya existe',
                'file' => false
            ];
        }else{
            $path = storage_path().'/app/convenios/'.$namePDf;
            $pdf = PDF::loadView('convenio2', ['data' => $data])->save($path)->stream($namePDf);
            // dd($pdf);

            $response = [
                'estado' => true,
                'mensaje' => 'PDF generado con éxito',
                'file' => $namePDf
            ];
        }

        return response()->json($response);

    }


    public function eliminarArchivos()
    {
     $data=convenios::where('tipo_documento','G')->orWhere('tipo_documento','P')->get();
     $newtipo=[];
     $existe=[];
     $files = Storage::disk('local')->Files('convenios'); // los archivos
     

     foreach($files as $fil)
     {
         $nombre=substr($fil,10);
         $newtipo[]=$nombre;
       foreach ($data as $d)
       {
         if($d->PDF==$nombre)
         {
             $dato=$d->PDF;
             $existe[]=$dato;
         }
       }
     }

     $files_eliminar=array_diff($newtipo,$existe);
     $contar=0;
     
     foreach($files_eliminar as $f)
     {
        $eliminar = Storage::disk('convenios')->delete($f);
        if($eliminar){
            $contar++;
        }

     }

     if($contar==count($files_eliminar))
     {
         $response=[
             'estado'=>true,
             'mensaje'=>'Se elimino los archivos',
             'archivos_eliminados'=>$contar
         ];
     }
     else
     {
        $response=[
            'estado'=>false,
            'mensaje'=>'No se elimino todos los archivos',
            'archivos_eliminados'=>$contar
        ];

     }
     return response()->json($response);

    }

    private function repleceEnter($data){
        $order   = array("\r\n", "\n", "\r");
        $replace = '<br />';

        $data = str_replace($order, $replace, $data);
        (array)$data = explode($replace, $data);

        return $data;
    }

    public function dowloandPdfConvenio(){
        $namePDf = "Convenio-".date('Y-m-d').'.pdf';
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('myPDF', $data);
        return $pdf->stream('itsolutionstuff.pdf');
    }

    public function getFile($folder, $file){
        $existe = Storage::disk($folder)->exists($file);

        if($existe){
            $archivo = Storage::disk($folder)->get($file);
            //    return new Response($archivo, 200);
            return response( Storage::disk($folder)->get($file), 200)
                ->header('Content-Type', Storage::disk($folder)
                    ->mimeType($file)
                );
        }else{
            $data = [
                'estado' => false,
                'mensaje' => 'Archivo no existe',
                'error' => 404
            ];
        }
        return response()->json($data);
    }
    
    public function convenioReportePdf(Request $request){

        $data = (object)$request->data;
        $data->tipo_documento = strtoupper($data->tipo_documento);
        $response = [];

        $convenios = convenios::where('tipo_documento', $data->tipo_documento)
            ->whereDate('f_creaciondoc', '>=', $data->fecha_inicio)->whereDate('f_creaciondoc', '<=', $data->fecha_fin)
            ->orderBy('f_creaciondoc', 'asc')->get();

        if($convenios->count() > 0){
            for($i = 0;  $i < $convenios->count(); $i++){
                $convenios[$i]->titulo_convenio = $this->scapeHtml($convenios[$i]->titulo_convenio);
                $convenios[$i]->f_creaciondoc = $this->formatDate($convenios[$i]->f_creaciondoc);
            }
        }else{
            $convenios = [];
        }

        // $namePDf = "Tipo-convenio-".date('Y-m-d-H-i-s').'.pdf';
        $item = 0;
        switch($data->tipo_documento){
            case "A":   $item = "aprobado";     break;
            case "G":   $item = "guardado";     break;
            case "P":   $item = "plantilla";     break;
        }
        $namePDf = "Tipo-convenio-".$item.".pdf";

        $exist = Storage::disk('convenios')->exists($namePDf);
        $datos = (object)[ 'request' => $data, 'convenios' => $convenios ];

        $path = storage_path().'/app/convenios/'.$namePDf;
        $pdf = PDF::loadView('reporteTipoConvenio', ['data' => $datos])->save($path)->stream($namePDf);
        // dd($pdf);

        $response = [
            'estado' => true,
            'mensaje' => 'PDF generado con éxito',
            'file' => $namePDf
        ];
        
        return response()->json($response);        
    }

    
    public function becasReportepdf(Request $request)
    {
        $data = (object)$request->data;
        $data->estado = strtoupper($data->estado);
        $response = [];
        $becas=$this->consultarSolicitudesBecas($data->tipo,$data->estado,$data->fecha_inicio,$data->fecha_fin);
        $becas_=json_decode(json_encode($becas));
        $item = 0;
        switch($data->estado){
            case "A":   $item = "aprobado";     break;
            case "R":   $item = "rechazado";     break;
            case "P":   $item = "pendiente";     break;
        }
        $namePDf = "Tipo-becas-".$item.".pdf";
        $exist = Storage::disk('becas')->exists($namePDf);
       
            $datos = (object)[ 'request' => $data, 'becas' => $becas_];
    
            $path = storage_path().'/app/becas/'.$namePDf;
            $pdf = PDF::loadView('reporteTipoBecas', ['data' => $datos])->setPaper("A4","Landscape")->save($path);
            $response = [
                'estado' => true,
                'mensaje' => 'PDF generado con éxito',
                'file' => $namePDf
            ];

        
        return response()->json($response);  

    }

    public function movilidadReportepdf(Request $request)
    {
        $data = (object)$request->data;
        $data->estado = strtoupper($data->estado);
        $response = [];
        $movilidad=$this->consultarSolicitudesMovilidad($data->tipo,$data->estado,$data->fecha_inicio,$data->fecha_fin);
        $movilidad_=json_decode(json_encode($movilidad));
        $item = 0;
        switch($data->estado){
            case "A":   $item = "aprobado";     break;
            case "R":   $item = "rechazado";     break;
            case "P":   $item = "pendiente";     break;
        }
        $namePDf = "Tipo-movilidad-".$item.".pdf";
        $exist = Storage::disk('movilidad')->exists($namePDf);
       
            $datos = (object)[ 'request' => $data, 'movilidad' => $movilidad_];
    
            $path = storage_path().'/app/movilidad/'.$namePDf;
            $pdf = PDF::loadView('reporteTipoMovilidad', ['data' => $datos])->setPaper("A4","Landscape")->save($path);
            $response = [
                'estado' => true,
                'mensaje' => 'PDF generado con éxito',
                'file' => $namePDf
            ];

        
        return response()->json($response);  

    }

    public function consultarSolicitudesBecas($tipo, $estado,$fecha_inicio,$fecha_fin){

        if($estado=='A')
        {
         $buscar=DB::select("select s.id,p.cedula,(p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, f.nombre As Nombre_facultad, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud,sa.pdf as pdf_final,s.fcreacion_solicitud
        from esq_distributivos.departamento d
        join esq_inscripciones.facultad f on d.idfacultad = f.idfacultad
        join esq_distributivos.departamento_docente dd on dd.iddepartamento = d.iddepartamento
        join esq_datos_personales.personal p on dd.idpersonal = p.idpersonal
        join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
        join esq_dricb.s_aprobadas sa on sa.solicitud_id = s.id
        join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
        join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
        where s.tipo = '$tipo' and s.estado_solicitud='$estado' and s.estado='A' and s.fcreacion_solicitud BETWEEN '$fecha_inicio' and '$fecha_fin'
        order by s.fcreacion_solicitud ASC");

        }
        else{
        $buscar=DB::select("select s.id,p.cedula,(p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, f.nombre As Nombre_facultad, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud
        from esq_distributivos.departamento d
        join esq_inscripciones.facultad f on d.idfacultad = f.idfacultad
        join esq_distributivos.departamento_docente dd on dd.iddepartamento = d.iddepartamento
        join esq_datos_personales.personal p on dd.idpersonal = p.idpersonal
        join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
        join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
        join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
        where s.tipo = '$tipo' and s.estado_solicitud='$estado' and s.estado='A' and s.fcreacion_solicitud BETWEEN '$fecha_inicio' and '$fecha_fin'
        order by s.fcreacion_solicitud ASC");

        }
        

        if($buscar){
            $response=$buscar;
        }else{
            $response=[];

        }
        return ($response);
    }

    public function consultarSolicitudesMovilidad($tipo, $estado,$fecha_inicio,$fecha_fin){

        if($estado=='A')
        {
            $buscar=DB::select("select s.id,p.cedula,(p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, es.nombre As Nombre_carrera, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud, sa.pdf as pdf_final
            from esq_datos_personales.personal p
            join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
            join esq_dricb.s_aprobadas sa on sa.solicitud_id = s.id
            join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
            join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
            join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
            where s.tipo = '$tipo' and s.estado_solicitud='$estado' and s.estado='A' and s.fcreacion_solicitud BETWEEN '$fecha_inicio' and '$fecha_fin'
            order by s.fcreacion_solicitud ASC");
        }
        else
        {
            $buscar=DB::select("select s.id,p.cedula,(p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, u.nombre as Universidad_Destino, es.nombre As Nombre_carrera, ni.descripcion as Naturaleza, s.fecha_inicio, s.fecha_fin, s.estado_solicitud
            from esq_datos_personales.personal p
            join esq_dricb.solicitudes s on p.idpersonal = s.personal_id
            join esq_inscripciones.escuela es on es.idescuela = s.escuela_id
            join esq_datos_personales.p_universidad u on u.iduniversidad = s.universidad_id
            join esq_dricb.natu_intercambios ni on ni.id = s.naturaleza_id 
            where s.tipo = '$tipo' and s.estado_solicitud='$estado' and s.estado='A'  and s.fcreacion_solicitud BETWEEN '$fecha_inicio' and '$fecha_fin'
            order by s.fcreacion_solicitud ASC");

        }
       
        if($buscar){
            $response=$buscar;
        }else{
            $response=[];

        }
        return ($response);
    }


    private function scapeHtml($data){
        #valores a escapar
        $scape = ['<p>', '</p>','<strong>','</strong>'];
        $string = str_replace($scape, '', $data);
        return $string;
    }
   
    private function formatDate($date){
        $aux = explode(' ', $date);
        return $aux[0];
    }

    public function pdfSolicitudMovilidad(Request $request){
        $data = (object)$request->data;
        $response = [];
        $soli_movi=$this->solicitudMovilidad($data->id);
        $soli_movi_=json_decode(json_encode($soli_movi));
        $item = 0;
       
        $namePDf = "Solicitud-movilidad-".$item.".pdf";
        $exist = Storage::disk('solicitudmovilidad')->exists($namePDf);
       
            $datos = (object)[ 'request' => $data, 'movilidad' => $soli_movi_];
            $datos = compact('datos');
            //    $pdf = PDF::loadView('movilidad', ['datos' => $datos]);
            $path = storage_path().'/app/solicitudmovilidad/'.$namePDf;
            $pdf = PDF::loadView('solicitudMovilidad', ['data' => $datos])->save($path);
            $response = [
                'estado' => true,
                'mensaje' => 'PDF generado con éxito',
                'file' => $namePDf
            ];

        
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
    $buscar2= $buscar2=(object)$buscar;
    return ($buscar2);

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
    
        return ($consulta4);
        }

    public function solicitudMovilidad($id){
       
    $buscar1=$this->solicitud($id);
    $buscar2=json_decode(json_encode($buscar1));
    
    if ($buscar2){
       // $semestre=$this->consultarPeriodo($buscar2->idpersonal);
        $materias=m_materias::where('solicitud_id',intval($id))
        ->where('estado','=','A')
        ->orderBy('id','ASC' )
        ->get();
        if($materias)
        {
           
            $buscar2->materias=$materias;
           // $buscar2->carrera=$semestre;
            $response= $buscar2;
       
    }
    }else{
        $response= [ ];
    
    }

     return ($response);
    }


    public function pdfSolicitudBecas(Request $request){
        $data = (object)$request->data;
        $response = [];
        $solibecas=$this->beneficios($data->id);
        $solibecas_=json_decode(json_encode($solibecas));
        $item = 0;
       
        $namePDf = "Solicitud-becas-".$item.".pdf";
        $exist = Storage::disk('solicitudmovilidad')->exists($namePDf);
       
            $datos = (object)[ 'request' => $data, 'becas' => $solibecas_];
    
            $path = storage_path().'/app/solicitudbecas/'.$namePDf;
            $pdf = PDF::loadView('solicitudBecas', ['data' => $datos])->save($path);
            $response = [
                'estado' => true,
                'mensaje' => 'PDF generado con éxito',
                'file' => $namePDf
            ];

        
        return response()->json($solibecas); 

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
    a.id as id_alergias,a.descripcion as Alergias, ea.id as id_esalergias,ea.especificar_alergia,en.id as id_enfermedades ,en.enfermedades_tratamiento,s.poliza_seguro,pdf.id as id_pdf, 
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
        $becas2= $becas2=(object)$becas;
        return ($becas2);
    }

        public function beneficios($id){
        $becas1=$this->solicitudBecas($id);
        $becas2=json_decode(json_encode($becas1));
        if($becas2){
        $beneficios=DB::select("select be.descripcion as Beneficios
        from esq_dricb.natu_intercambios ni
        join esq_dricb.solicitudes s on s.naturaleza_id=ni.id
        join esq_dricb.beneficios_becas bbe on bbe.naturaleza_id = ni.id
        join esq_dricb.m_beneficios be on be.id = bbe.beneficios_id
        where s.id = ".$id."
        order by be.id ASC");
        if($beneficios)
         {
        $becas2->beneficios=$beneficios;
        $response= $becas2;
        
        }
        }else{
         $response= [];
         }

        return ($response);    
    }

    //Obtener la imagen 
    public function getImgSolicitudes(){
        $imagen=imagenes_solicitudes::where('id',1)->first();
        if($imagen)
        {
            $imagen_convenio=imagenes_convenios::where('id',$imagen->imagenescon_id)->first();
            $response=$imagen_convenio;
        }
        else
        {
            $response=[];

        }

        return ($response);
    }
}

