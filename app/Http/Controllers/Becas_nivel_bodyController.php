<?php

namespace App\Http\Controllers;

use App\Models\becas_nivel;
use Illuminate\Http\Request;
use App\Models\becas_nivel_body;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Becas_nivel_bodyController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $baseCtrl;

    public function __construct()
    {
        $this->baseCtrl = new BaseController();
    }

    public function consulta()
    {
        $sql = 'SELECT * FROM becas_nivel_bodies WHERE estado="A"';
        $becas_body = DB::select($sql);
        //$becas_body = becas_nivel_body::all();
       return $becas_body;
    }

    public function getBecasnivelBody($id)
    {

        $becas = [];
        $existe = becas_nivel::find(intval($id));

        if ($existe) {
            $becas_body = becas_nivel_body::where('id_becas_nivels', $existe->id)->where('estado', 'A')->orderBy('nombre', 'asc')->get();

            foreach ($becas_body as $be) {
                $becasObj = (object)$be;
                $aux = $becasObj;
                $becas[] = $aux;
            }

            $response = [
                'estado' => true,
                'becas' => $becas
            ];
        } else {
            $response = [
                'estado' => false,
                'becas' => $becas
            ];
        }
        return response()->json($response);
    }
    
    // ftp becas

    public function subirDocumentoBecasCapacitaciones(Request $request)
    {
        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp5')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Becas/Capacitaciones/');

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
    public function subirDocumentoBecasPregrado(Request $request)
    {
        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp6')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Becas/Pregrado/');

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
public function subirDocumentoBecasInvestigacion(Request $request)
    {
        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp8')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Becas/Investigacion/');

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
public function subirDocumentoBecasMaestria(Request $request)
    {
        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp9')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Becas/Maestrias/');

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
public function subirDocumentoBecasDoctorado(Request $request)
    {
        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '' . uniqid() . '.' . $extension;

            Storage::disk('ftp7')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Becas/Doctorados/');

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



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = (object)$request->data;
        $newBecas = new becas_nivel_body();
        $newBecas->nombre = trim(ucfirst($data->nombre));
        $newBecas->pais = trim(ucfirst($data->pais));
        $newBecas->idioma = trim(ucfirst($data->idioma));
        $newBecas->id_becas_nivels = trim(intval($data->id_becas_nivels));

        if (strlen($data->area_estudio) != 0) {
            $newBecas->area_estudio = trim(ucfirst($data->area_estudio));
        }
        if (strlen($data->fecha_postulacion) != 0) {
            $newBecas->fecha_postulacion = trim(ucfirst($data->fecha_postulacion));
        }

        if (strlen($data->url) != 0) {
            $newBecas->url = trim(ucfirst($data->url));
        }

        if (strlen($data->modalidad) != 0) {
            $newBecas->modalidad = trim(ucfirst($data->modalidad));
        }

        if (strlen($data->requisitos) != 0) {
            $newBecas->requisitos = trim(ucfirst($data->requisitos));
        }

        if (strlen($data->reconocimiento) != 0) {
            $newBecas->reconocimiento_titulo = trim(ucfirst($data->reconocimiento));
        }

        if (strlen($data->pdf) != 0) {
            $newBecas->pdf = trim(ucfirst($data->pdf));
        }

        $newBecas->estado = "A";
        $newBecas->save();
        $response = [
            'estado' => true,
            'mensaje' => "se ingreso correctamente.....!!"
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $becas_body = new becas_nivel_body();
        $becas_body->id_becas_nivels = $request->id_becas_nivels;
        $becas_body->nombre = $request->nombre;
        $becas_body->pais = $request->pais;
        $becas_body->idioma = $request->idioma;
        $becas_body->area_estudio = $request->area_estudio;
        $becas_body->fecha_postulacion = $request->fecha_postulacion;
        $becas_body->url = $request -> url;
        $becas_body->modalidad = $request->modalidad;
        $becas_body->requisitos = $request->requisitos;
        $becas_body->reconocimiento_titulo = $request->reconocimiento_titulo;
        $becas_body->pdf = $request->pdf;
        $becas_body->estado = $request ->estado;

        $becas_body->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = (object)$request->data;

        $existe = becas_nivel_body::find(intval($data->id));
        if ($existe) {

            $existe->nombre = trim(ucfirst($data->nombre));
            $existe->pais = trim(ucfirst($data->pais));
            $existe->idioma = trim(ucfirst($data->idioma));
            $existe->fecha_postulacion = trim(ucfirst($data->fecha_postulacion));

            if (strlen($data->area_estudio) != 0) {
                $existe->area_estudio = trim(ucfirst($data->area_estudio));
            }else{
                $existe->area_estudio=null;
            }
            if (strlen($data->url) != 0) {
                $existe->url = trim(ucfirst($data->url));
            }else{
                $existe->url=null;
            }

            if (strlen($data->modalidad) != 0) {
                $existe->modalidad = trim(ucfirst($data->modalidad));
            }
            else{
                $existe->modalidad=null;
            }

            if (strlen($data->requisitos) != 0) {
                $existe->requisitos = trim(ucfirst($data->requisitos));
            }else{
                $existe->requisitos=null;
            }

            if (strlen($data->reconocimiento) != 0) {
                $existe->reconocimiento_titulo = trim(ucfirst($data->reconocimiento));
            }
            else{
                $existe->reconocimiento_titulo=null;
            }

            if (strlen($data->pdf) != 0) {
                $existe->pdf = trim(ucfirst($data->pdf));
            }
            else{
                $existe->pdf=null;
            }
            $existe->save();
            $response=[
                'estado' => true,
                'mensaje' => 'Se Modifico correctamente.....!!'

            ];
} else {
            $response = [
                'estado' => false,
                'mensaje' => 'No se encontro la Beca'
            ];
        }
        return response()->json($response);

        //
    }

    public function updateEstado(Request $request)
    {
        $data = (object)$request->data;
        $existe=becas_nivel_body::find(intval($data->id));
        if($existe)
        {
            $existe->estado="D";
            $existe->save();
            $response=[
                'estado'=>true,
                'mensaje'=>'Se elimino correctamente....!!'
            ];

        }
        else{
            $response=[
                'estado'=>false,
                'mensaje'=>'No se encontro la beca'

            ];
        }

        return response()->json($response);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $becas_body=becas_nivel_body::findOrFail($request->id);
        $becas_body->id_becas_nivels = $request->id_becas_nivels;
        $becas_body->nombre = $request->nombre;
        $becas_body->pais = $request->pais;
        $becas_body->idioma = $request->idioma;
        $becas_body->area_estudio = $request->area_estudio;
        $becas_body->fecha_postulacion = $request->fecha_postulacion;
        $becas_body->url = $request -> url;
        $becas_body->modalidad = $request->modalidad;
        $becas_body->requisitos = $request->requisitos;
        $becas_body->reconocimiento_titulo = $request->reconocimiento_titulo;
        $becas_body->pdf = $request->pdf;
        $becas_body->estado = $request ->estado;
        $becas_body->save();
        return $becas_body;



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $becas_body=becas_nivel_body::destroy($request->id);
        return $becas_body;

    }
//metodo con json para probar si funciona con postman
   public function getBecas_nivelb(){
        return response()->json(becas_nivel_body::all(),200);
    }
    
  /*  public function getBecasnivelb_json(){
        return response() -> json(becas_nivel_body::raw('SELECT * FROM becas_nivel_bodies WHERE estado="A"'));
        }*/

    public function getBecas_nivelbdes(){
            $becas_body2 = DB::table('becas_nivel_bodies')
            -> select('id','id_becas_nivels' ,'nombre', 'pais', 'idioma','area_estudio','fecha_postulacion',
            'url','modalidad','requisitos','reconocimiento_titulo','pdf','estado')
            -> where('estado','A') 
            -> orderBy('id', 'DESC')
            -> get();
            //-> toJson();
            return response() -> json ($becas_body2);
         // return $becas_body2;
    
        }

    public function getBecas_nivelbxid($id){
        $becas_body = becas_nivel_body::find($id);
        if(is_null($becas_body)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($becas_body::find($id),200);
    }

    public function insertBecas_nivelb(Request $request){
        $becas_body = becas_nivel_body::create ($request->all());
        return response($becas_body,200);
    }

    public function updateBecas_nivelb(Request $request,$id){
        $becas_body = becas_nivel_body::find($id);
        if (is_null($becas_body)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $becas_body->update($request->all());
        return response($becas_body,200);
    }

    public function deleteBecas_nivelb($id){
        $becas_body = becas_nivel_body::find($id);
        if (is_null($becas_body)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $becas_body->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }


}
