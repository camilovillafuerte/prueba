<?php

namespace App\Http\Controllers;

use App\Models\articulos;
use App\Models\clausulas;
use App\Models\contenido;
use App\Models\contenido_articulos;
use Illuminate\Http\Request;
use App\Models\convenios;
use App\Models\convenios_clausulas;
use App\Models\tipo_convenios;
use Illuminate\Support\Facades\Storage;

class ConveniosController extends Controller
{
    private $baseCtrl;

    public function __construct(){
        $this->baseCtrl = new BaseController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $convenios = convenios::all();
        return $convenios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){

        $data = (object)$request->data;
        $response = [];

        //Crear convenio
        $newConvenio = new convenios();
        $newConvenio->usuario_id = intval($data->id_usuario);
        $newConvenio->femisor_id = intval($data->selectFirmaEmisor);
        $newConvenio->freceptor_id = intval($data->selectFirmaReceptor);
        $newConvenio->titulo_convenio = ucfirst($data->nombre_convenio);
        $newConvenio->f_creaciondoc = date('Y-m-d H:i:s');
        $newConvenio->estado  = 'A';
        $newConvenio->tipo_documento = 'P';
        $newConvenio->PDF = "";
        $newConvenio->save();

        //Crear tipo de convenio
        $newTipoConvenio = new tipo_convenios();
        $_scpCompar = str_replace('\n', "</br>",$data->comparecientes);

        $newTipoConvenio->descripcion_tc = ucfirst($_scpCompar);
        $newTipoConvenio->nombretc_id = intval($data->id_tipoconvenio);
        $newTipoConvenio->id_convenios = $newConvenio->id;
        $newTipoConvenio->id_convenios_especificos = intval($data->id_tipoespecifico);
        $newTipoConvenio->save();

        //Recorrer las clausulas
        foreach($data->clausulas as $clau){
            // //Crear el contenido de la clausula
            $clauObj = (object)$clau;

            $newContenido = new contenido();
            $_scpContClau = str_replace('\n', "</br>", $clauObj->descripcion);
            $newContenido->des_cont = ucfirst($_scpContClau);
            $newContenido->tipo = 'P';
            $newContenido->save();

            $existeConvenioClau = convenios_clausulas::where('id_convenios',  $newConvenio->id)
            ->where('id_clausulas', intval($clauObj->id))->where('id_contenidos', $newContenido->id)->first();

            if($existeConvenioClau){
                $newConvenioClau = $existeConvenioClau;
            }else{
                //Armar la relacion de convenios_clausulas
                $newConvenioClau = new convenios_clausulas();
                $newConvenioClau->id_convenios =  $newConvenio->id;
                $newConvenioClau->id_clausulas = intval($clauObj->id);
                $newConvenioClau->id_contenidos = $newContenido->id;
                $newConvenioClau->save();
            }

            if(count($clauObj->articulos) > 0){
                foreach($clauObj->articulos as $art){
                   $artObjt = (object)$art;

                   $newArt = new articulos();
                   $_scpDetArt = str_replace('\n', "</br>", $artObjt->des_art);
                   $newArt->des_art = ucfirst($_scpDetArt);
                   $newArt->subtipo = strtoupper($artObjt->subtipo);
                   $newArt->save();

                   //Construir relacion contenidos-articulos
                   $cont_art = new contenido_articulos();
                   $cont_art->id_contenidos =  $newContenido->id;
                   $cont_art->id_articulos = $newArt->id;
                   $cont_art->save();
                }
            }
        }

        $response = [
            'estado'  => true,
            'mensaje' => 'Convenio guardado'
        ];

        return response()->json($response);
    }

    public function guardar(Request $request){

        $data = (object)$request->data;
        $response = [];

        //Crear convenio
        $newConvenio = new convenios();
        $newConvenio->usuario_id = intval($data->id_usuario);
        $newConvenio->femisor_id = intval($data->selectFirmaEmisor);
        $newConvenio->freceptor_id = intval($data->selectFirmaReceptor);
        $newConvenio->titulo_convenio = ucfirst($data->nombre_convenio);
        $newConvenio->f_creaciondoc = date('Y-m-d H:i:s');
        $newConvenio->estado  = 'A';
        $newConvenio->tipo_documento = 'G';
        $newConvenio->PDF = "";
        $newConvenio->save();

        //Crear tipo de convenio
        $newTipoConvenio = new tipo_convenios();
        $_scpCompar = str_replace('\n', "</br>",$data->comparecientes);

        $newTipoConvenio->descripcion_tc = ucfirst($_scpCompar);
        $newTipoConvenio->nombretc_id = intval($data->id_tipoconvenio);
        $newTipoConvenio->id_convenios = $newConvenio->id;
        $newTipoConvenio->id_convenios_especificos = intval($data->id_tipoespecifico);
        $newTipoConvenio->save();

        //Recorrer las clausulas
        foreach($data->clausulas as $clau){
            // //Crear el contenido de la clausula
            $clauObj = (object)$clau;

            $newContenido = new contenido();
            $_scpContClau = str_replace('\n', "</br>", $clauObj->descripcion);
            $newContenido->des_cont = ucfirst($_scpContClau);
            $newContenido->tipo = 'P';
            $newContenido->save();

            $existeConvenioClau = convenios_clausulas::where('id_convenios',  $newConvenio->id)
            ->where('id_clausulas', intval($clauObj->id))->where('id_contenidos', $newContenido->id)->first();

            if($existeConvenioClau){
                $newConvenioClau = $existeConvenioClau;
            }else{
                //Armar la relacion de convenios_clausulas
                $newConvenioClau = new convenios_clausulas();
                $newConvenioClau->id_convenios =  $newConvenio->id;
                $newConvenioClau->id_clausulas = intval($clauObj->id);
                $newConvenioClau->id_contenidos = $newContenido->id;
                $newConvenioClau->save();
            }

            if(count($clauObj->articulos) > 0){
                foreach($clauObj->articulos as $art){
                   $artObjt = (object)$art;

                   $newArt = new articulos();
                   $_scpDetArt = str_replace('\n', "</br>", $artObjt->des_art);
                   $newArt->des_art = ucfirst($_scpDetArt);
                   $newArt->subtipo = strtoupper($artObjt->subtipo);
                   $newArt->save();

                   //Construir relacion contenidos-articulos
                   $cont_art = new contenido_articulos();
                   $cont_art->id_contenidos =  $newContenido->id;
                   $cont_art->id_articulos = $newArt->id;
                   $cont_art->save();
                }
            }
        }

        $response = [
            'estado'  => true,
            'mensaje' => 'Convenio guardado'
        ];

        return response()->json($response);
    }


    public function find($id){

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $convenios = new convenios();
        $convenios->cedula_usuario= $request->cedula_usuario;
        $convenios->titulo_convenio= $request->titulo_convenio;
        $convenios->f_creaciondoc= $request->f_creaciondoc;
        $convenios->estado= $request->estado;
        $convenios->tipo_documento= $request->tipo_documento;
        $convenios->PDF= $request->PDF;
        $convenios->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = convenios::find($id);
        $tipoConvenios = tipo_convenios::where('id_convenios', $id)->first();
        $clausulas = convenios_clausulas::where('id_convenios', $id)->get();

        $newClau = [];
        foreach($clausulas as $c){
            $clau = clausulas::find($c->id_clausulas);
            $retConCla = convenios_clausulas::where('id_convenios', $id)->where('id_clausulas',$c->id_clausulas )->first();
            $contenido = contenido::find($retConCla->id_contenidos);
            $retContArt = contenido_articulos::where('id_contenidos', $retConCla->id_contenidos)->get();

            $newArt = [];
            foreach($retContArt as $art){
                $articulo = articulos::find($art->id_articulos);

                $auxArt = [
                    'art_id' => $articulo->id,
                   'des_art' => $articulo->des_art,
                   'subtipo' => $articulo->subtipo
                ];
                $newArt[] = $auxArt;
            }

            $aux = [
              'id' => $c->id_clausulas,
              'nombre' => $clau->nombre_clau,
              'descripcion' => $contenido->des_cont,
              'tipo' => $contenido->tipo,
              'articulos' => $newArt
            ];

            $newClau[] = $aux;
        }
        $newData = [
            'id_usuario' => $data->usuario_id,
            'id_tipoconvenio' => $tipoConvenios->nombretc_id,
            'id_tipoespecifico' => $tipoConvenios->id_convenios_especificos,
            'nombre_convenio' => $data->titulo_convenio,
            'comparecientes' => $tipoConvenios->descripcion_tc,
            'clausulas' => $newClau,
            'selectFirmaEmisor'=>$data->femisor_id,
            'selectFirmaReceptor'=>$data->freceptor_id
        ];

        return response()->json($newData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $convenios=convenios::findOrFail($request->id);
        $convenios->cedula_usuario= $request->cedula_usuario;
        $convenios->titulo_convenio= $request->titulo_convenio;
        $convenios->f_creaciondoc= $request->f_creaciondoc;
        $convenios->estado= $request->estado;
        $convenios->tipo_documento= $request->tipo_documento;
        $convenios->PDF= $request->PDF;
        $convenios->save();
        return $convenios;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $convenios=convenios::destroy($request->id);
        return $convenios;
    }

     //metodo con json para probar si funciona con postman
     public function getConvenios(){
        return response()->json(convenios::all(),200);
    }

    public function getConveniosxid($id){
        $convenios = convenios::find($id);
        if(is_null($convenios)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        }
        return response ()->json($convenios::find($id),200);
    }

    public function insertConvenios(Request $request){
        $convenios = convenios::create ($request->all());
        return response($convenios,200);
    }

    public function updateConvenios(Request $request,$id){
        $convenios=convenios::find($id);
        if (is_null($convenios)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $convenios->update($request->all());
        return response($convenios,200);
    }

    public function deleteConvenios($id){
        $convenios=convenios::find($id);
        if (is_null($convenios)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $convenios->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }

    public function getConveniosByTipoDocumento($tipo_documento){

        $tipo_documento = strtoupper($tipo_documento);
        $response = [];

        $convenios = convenios::where('tipo_documento', $tipo_documento)->orderBy('titulo_convenio')->get();

        if($convenios->count() > 0)
            $response = $convenios;

        return response()->json($response);
    }
    public function uploadDocumentServer(Request $request){

        if($request->hasFile('document')){
            $imagen = $request->file('document');

            $filenamewithextension = $imagen->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;

            Storage::disk('ftp2')->put($filenametostore, fopen($request->file('document'), 'r+'));

           $url = $this->baseCtrl->getUrlServer('/Contenido/ConveniosGuardados/');

            $response = [
                'estado' => true,
                'documento' => $url.$filenametostore,
                'mensaje' => 'El documento se ha subido al servidor'
            ];
        }else{
            $response = [
                'estado' => false,
                'documento' => '',
                'mensaje' => 'No hay un archivo para procesar'
            ];
        }

        return response()->json($response);
    }

    public function findconvenio($id)
    {
        $data = convenios::find($id);
        $response=[
           'estado'=>true,
            'convenio'=>$data
        ];

        return response()->json($response);
    }

    public function editarConvenio(Request $request){

    }
}
