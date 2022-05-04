<?php

namespace App\Http\Controllers;

use App\Models\convenios;
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
            $pdf = PDF::loadView('reporteTipoBecas', ['data' => $datos])->save($path)->setPaper("A4","Landscape");
            // $pdf->setPaper("A4","Landscape");
            $pdf->stream($namePDf);
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
        where s.tipo = '$tipo' and s.estado_solicitud='$estado' and s.estado='A'
        order by s.id DESC");

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
}

