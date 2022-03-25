<?php

namespace App\Http\Controllers;

use App\Models\beneficios_becas;
use App\Models\enfermedades_cronicas;
use App\Models\especificar_alergias;
use App\Models\m_beneficios;
use App\Models\pdf_solicitudes;
use App\Models\solicitudes;
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
            

            where p.cedula='$cedula' and s.tipo = 'B' and s.estado='A'
            order by s.id DESC");
    
            if($buscar){
                $response=[
                    'estado'=> true,
                    'datos'=> $buscar,
                ];
            }else{
                $response=[
                    'estado'=> false,
                    'mensaje'=> 'Usted no dispone de solicitudes dentro de Becas'
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

        public function create_Solicitud_becas(Request $request)
        {
            $data=(Object)$request->data;
            $newsoli=new solicitudes();
            $newsoli->personal_id=$data->idpersonal;
            $newsoli->logo_id=1;
            $newsoli->universidad_id=$data->id_universidad;
            $newsoli->escuela_id=1; //datos puesto por defecto para evitar inconvenientes
            $newsoli->naturaleza_id=$data->id_naturaleza;
            $newsoli->modalidad1_id=$data->modalidad1;
            $newsoli->modalidad2_id=$data->modalidad2;
            $newsoli->becas_id=$data->id_becas;
            $newsoli->montos_id=1;// $data->id_monto
           $newsoli->campus_destino=trim(ucfirst($data->campus_destino));
            $newsoli->numero_semestre=trim(intval($data->numero_semestre));
            $newsoli->fecha_inicio=Date($data->fecha_inicio);
            $newsoli->fecha_fin=Date($data->fecha_fin);
            $newsoli->fcreacion_solicitud = date('Y-m-d H:i:s');
            $newsoli->estado_solicitud="P";
            $newsoli->poliza_seguro=$data->poliza_seguro;
            $newsoli->tipo="B";
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


            //pdf
            $newPdf=new pdf_solicitudes();
            $newPdf->solicitud_id=$newsoli->id;
            $newPdf->pdfcarta_aceptacion=$data->pdfcarta_aceptacion;
            $newPdf->pdftitulo=$data->pdftitulo;
            $newPdf->tipo="B";
            $newPdf->save();

            $response=[
                'estado'=>true,
                'mensaje' =>'Se creo correctamente la solicitud' 
            ];

            return response()->json($response);

        }

        public function solicitudBecas($id){
            $becas=DB::select("
            select p.cedula, p.apellido1, p.apellido2, p.nombres,p.fecha_nacimiento,
        t.nombre as Nacionalidad,p.genero,p.residencia_calle_1, p.residencia_calle_2, p.residencia_calle_3,
        p.correo_personal_institucional,p.correo_personal_alternativo, t1.nombre as Estado_civil,
        u.nombre as Pais, u1.nombre as Provincia,u2.nombre as Canton,
        p.telefono_personal_domicilio, p.telefono_personal_celular, t2.nombre as Tipo_Sangre, t3.nombre as Nombre_Discapacidad,
        p.contacto_emergencia_apellidos,p.contacto_emergencia_nombres,
        p.contacto_emergencia_telefono_1,p.contacto_emergencia_telefono_2,
        f.nombre As Nombre_Facultad, m1.tipo_modalidad as Modalidad, m2.tipo_modalidad as Tipo_Destino,uni.nombre as Universidad_Destino,
        s.campus_destino, s.numero_semestre,s.fecha_inicio, s.fecha_fin,ni.descripcion as Naturaleza, b.descripcion as Beca_Apoyo,
        m.descripcion as Monto_Referencial, 
        a.descripcion as Alergias, ea.especificar_alergia, en.enfermedades_tratamiento,s.poliza_seguro,
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
           /* if($becas)
            {
                $beneficios=DB::select("select be.descripcion as Beneficios
                from esq_dricb.natu_intercambios ni
                join esq_dricb.solicitudes s on s.naturaleza_id=ni.id
                join esq_dricb.beneficios_becas bbe on bbe.naturaleza_id = ni.id
                join esq_dricb.m_beneficios be on be.id = bbe.beneficios_id

                order by be.id ASC");
                if($beneficios){
                $response= [
                'estado'=> true,
                'datos' => $becas,
                'beneficios' => $beneficios
            ];
         }
        }else{
            $response= [
                'estado'=> false,
                'mensaje' => 'No existe la solicitud'
            ];
        
        }
        
        return response()->json($response);*/
        $becas2= $becas2=(object)$becas[0];
        return ($becas2);
        }

        public function beneficios($id){
            $becas1=$this->solicitudBecas($id);
            $becas2=json_decode(json_encode($becas1));
            
            if ($becas2){
                $bene=beneficios_becas::where('beneficios_id',intval($id))->get();
                if($bene)
                {
                   
                    $becas2->descripcion=$bene;
                    $response= [
                    'estado'=> true,
                    'datos' => $becas2,
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
        }


    
