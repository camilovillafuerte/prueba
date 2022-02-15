<?php

namespace App\Http\Controllers;

use App\Models\articulos;
use App\Models\clausulas;
use App\Models\contenido;
use App\Models\contenido_articulos;
use Illuminate\Http\Request;
use App\Models\convenios;
use App\Models\convenios_clausulas;
use App\Models\imagenes_convenios;
use App\Models\tipo_convenios;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ConveniosController extends Controller
{
    private $baseCtrl;

    public function __construct()
    {
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
    public function create(Request $request)
    {

        $data = (object)$request->data;
        $response = [];

        //Crear convenio
        $newConvenio = new convenios();
        $newConvenio->usuario_id = intval($data->id_usuario);
        $newConvenio->femisor_id = intval($data->selectFirmaEmisor);
        $newConvenio->freceptor_id = intval($data->selectFirmaReceptor);
        $newConvenio->titulo_convenio = trim($data->nombre_convenio);
        $newConvenio->f_creaciondoc = date('Y-m-d H:i:s');
        $newConvenio->estado  = 'A';
        $newConvenio->tipo_documento = 'P';
        $newConvenio->PDF = trim($data->PDF);
        $newConvenio->imagen1_id = intval($data->id_imagen1);
        $newConvenio->imagen2_id = intval($data->id_imagen2);
        $newConvenio->save();

        //Crear tipo de convenio
        $newTipoConvenio = new tipo_convenios();

        $newTipoConvenio->descripcion_tc = trim($data->comparecientes);
        $newTipoConvenio->nombretc_id = intval($data->id_tipoconvenio);
        $newTipoConvenio->id_convenios = $newConvenio->id;
        $newTipoConvenio->id_convenios_especificos = intval($data->id_tipoespecifico);
        $newTipoConvenio->save();

        //Recorrer las clausulas
        foreach ($data->clausulas as $clau) {
            // //Crear el contenido de la clausula
            $clauObj = (object)$clau;

            $newContenido = new contenido();
            $newContenido->des_cont = trim($clauObj->descripcion);
            $newContenido->tipo = 'P';
            $newContenido->save();

            $existeConvenioClau = convenios_clausulas::where('id_convenios',  $newConvenio->id)
                ->where('id_clausulas', intval($clauObj->id))->where('id_contenidos', $newContenido->id)->first();

            if ($existeConvenioClau) {
                $newConvenioClau = $existeConvenioClau;
            } else {
                //Armar la relacion de convenios_clausulas
                $newConvenioClau = new convenios_clausulas();
                $newConvenioClau->id_convenios =  $newConvenio->id;
                $newConvenioClau->id_clausulas = intval($clauObj->id);
                $newConvenioClau->id_contenidos = $newContenido->id;
                $newConvenioClau->estado = 'A';
                $newConvenioClau->save();
            }

            if (count($clauObj->articulos) > 0) {
                foreach ($clauObj->articulos as $art) {
                    $artObjt = (object)$art;

                    $newArt = new articulos();
                    $newArt->des_art = trim($artObjt->des_art);
                    $newArt->subtipo = strtoupper($artObjt->subtipo);
                    $newArt->save();

                    //Construir relacion contenidos-articulos
                    $cont_art = new contenido_articulos();
                    $cont_art->id_contenidos =  $newContenido->id;
                    $cont_art->id_articulos = $newArt->id;
                    $cont_art->estado='A';
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

    public function guardar(Request $request)
    {

        $data = (object)$request->data;
        $response = [];

        //Crear convenio
        $newConvenio = new convenios();
        $newConvenio->usuario_id = intval($data->id_usuario);
        $newConvenio->femisor_id = intval($data->selectFirmaEmisor);
        $newConvenio->freceptor_id = intval($data->selectFirmaReceptor);
        $newConvenio->titulo_convenio = trim($data->nombre_convenio);
        $newConvenio->f_creaciondoc = date('Y-m-d H:i:s');
        $newConvenio->estado  = 'A';
        $newConvenio->tipo_documento = 'G';
        $newConvenio->PDF = trim($data->PDF);
        $newConvenio->imagen1_id = intval($data->id_imagen1);
        $newConvenio->imagen2_id = intval($data->id_imagen2);
        $newConvenio->save();

        //Crear tipo de convenio
        $newTipoConvenio = new tipo_convenios();

        $newTipoConvenio->descripcion_tc = trim($data->comparecientes);
        $newTipoConvenio->nombretc_id = intval($data->id_tipoconvenio);
        $newTipoConvenio->id_convenios = $newConvenio->id;
        $newTipoConvenio->id_convenios_especificos = intval($data->id_tipoespecifico);
        $newTipoConvenio->save();

        //Recorrer las clausulas
        foreach ($data->clausulas as $clau) {
            // //Crear el contenido de la clausula
            $clauObj = (object)$clau;

            $newContenido = new contenido();
            $newContenido->des_cont = trim($clauObj->descripcion);
            $newContenido->tipo = 'P';
            $newContenido->save();

            $existeConvenioClau = convenios_clausulas::where('id_convenios',  $newConvenio->id)
                ->where('id_clausulas', intval($clauObj->id))->where('id_contenidos', $newContenido->id)->first();

            if ($existeConvenioClau) {
                $newConvenioClau = $existeConvenioClau;
            } else {
                //Armar la relacion de convenios_clausulas
                $newConvenioClau = new convenios_clausulas();
                $newConvenioClau->id_convenios =  $newConvenio->id;
                $newConvenioClau->id_clausulas = intval($clauObj->id);
                $newConvenioClau->id_contenidos = $newContenido->id;
                $newConvenioClau->estado = 'A';
                $newConvenioClau->save();
            }

            if (count($clauObj->articulos) > 0) {
                foreach ($clauObj->articulos as $art) {
                    $artObjt = (object)$art;

                    $newArt = new articulos();
                    $newArt->des_art = trim($artObjt->des_art);
                    $newArt->subtipo = strtoupper($artObjt->subtipo);
                    $newArt->save();

                    //Construir relacion contenidos-articulos
                    $cont_art = new contenido_articulos();
                    $cont_art->id_contenidos =  $newContenido->id;
                    $cont_art->id_articulos = $newArt->id;
                    $cont_art->estado='A';
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


    public function find($id)
    {
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
        $convenios->usuario_id = $request->usuario_id;
        $convenios->femisor_id = $request->femisor_id;
        $convenios->freceptor_id = $request->freceptor_id;
        $convenios->imagen1_id = $request->imagen1_id;
        $convenios->imagen2_id = $request->imagen2_id;
        $convenios->titulo_convenio = $request->titulo_convenio;
        $convenios->f_creaciondoc = $request->f_creaciondoc;
        $convenios->estado = $request->estado;
        $convenios->tipo_documento = $request->tipo_documento;
        $convenios->PDF = $request->PDF;
        $convenios->fecha_firma = $request-> fecha_firma;
        $convenios->fecha_fin = $request-> fecha_fin;
        
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
        $imagen1 = imagenes_convenios::find($data->imagen1_id);
        $imagen2 = imagenes_convenios::find($data->imagen2_id);
        $tipoConvenios = tipo_convenios::where('id_convenios', $id)->first();
        $clausulas = convenios_clausulas::where('id_convenios', $id)->get();

        $newClau = [];
        foreach ($clausulas as $c) {
            $clau = clausulas::find($c->id_clausulas);
            $retConCla = convenios_clausulas::where('id_convenios', $id)->where('id_clausulas', $c->id_clausulas)->where('estado','A')->first();
            if($retConCla)
            {
            $contenido = contenido::find($retConCla->id_contenidos);
            $retContArt = contenido_articulos::where('id_contenidos', $retConCla->id_contenidos)->where('estado','A')->get();

            $newArt = [];
            foreach ($retContArt as $art) {
                $articulo = articulos::find($art->id_articulos);

                $auxArt = [
                    'art_id' => $articulo->id,
                    'des_art' => $articulo->des_art,
                    'subtipo' => $articulo->subtipo,
                    'estado'=>$art->estado
                ];
                $newArt[] = $auxArt;
            }

            $aux = [
                'id' => $c->id_clausulas,
                'nombre' => $clau->nombre_clau,
                'id_contenido' => $contenido->id,
                'descripcion' => $contenido->des_cont,
                'tipo' => $contenido->tipo,
                'estado'=> $retConCla->estado,
                'articulos' => $newArt
            ];

            $newClau[] = $aux;

            }

        }
        $newData = [
            'id_usuario' => $data->usuario_id,
            'id_tipoconvenio' => $tipoConvenios->nombretc_id,
            'id_tipoespecifico' => $tipoConvenios->id_convenios_especificos,
            'id_imagen1' => $imagen1->id,
            'id_imagen2' => $imagen2->id,
            'urlimagen1' => $imagen1->url_imagen,
            'urlimagen2' => $imagen2->url_imagen,
            'nombre_convenio' => $data->titulo_convenio,
            'comparecientes' => $tipoConvenios->descripcion_tc,
            'clausulas' => $newClau,
            'selectFirmaEmisor' => $data->femisor_id,
            'selectFirmaReceptor' => $data->freceptor_id,
            'PDF'=> $data->PDF
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
        $convenios = convenios::findOrFail($request->id);
        $convenios->cedula_usuario = $request->cedula_usuario;
        $convenios->titulo_convenio = $request->titulo_convenio;
        $convenios->f_creaciondoc = $request->f_creaciondoc;
        $convenios->estado = $request->estado;
        $convenios->tipo_documento = $request->tipo_documento;
        $convenios->PDF = $request->PDF;
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
        $convenios = convenios::destroy($request->id);
        return $convenios;
    }

    //metodo con json para probar si funciona con postman
    public function getConvenios()
    {
        return response()->json(convenios::all(), 200);
    }

    public function getConveniosxid($id)
    {
        $convenios = convenios::find($id);
        if (is_null($convenios)) {
            return response()->json(['Mensaje' => 'Registro no encontrado'], 404);
        }
        return response()->json($convenios::find($id), 200);
    }

    public function insertConvenios(Request $request)
    {
        $convenios = convenios::create($request->all());
        return response($convenios, 200);
    }

    public function updateConvenios(Request $request, $id)
    {
        $convenios = convenios::find($id);
        if (is_null($convenios)) {
            return response()->json(['Mensaje' => 'Registro no encontrado'], 404);
        }
        $convenios->update($request->all());
        return response($convenios, 200);
    }

    public function deleteConvenios($id)
    {
        $convenios = convenios::find($id);
        if (is_null($convenios)) {
            return response()->json(['Mensaje' => 'Registro no encontrado'], 404);
        }
        $convenios->delete();
        return response()->json(['Mensaje' => 'Registro Eliminado'], 200);
    }

    public function getConveniosByTipoDocumento($tipo_documento)
    {

        $tipo_documento = strtoupper($tipo_documento);
        $response = [];

        $convenios = convenios::where('tipo_documento', $tipo_documento)->orderBy('titulo_convenio')->get();

        if ($convenios->count() > 0)
            $response = $convenios;

        return response()->json($response);
    }

    public function uploadDocumentServer(Request $request)
    {

        if ($request->hasFile('document')) {
            $documento = $request->file('document');
            $filenamewithextension = $documento->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('document')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename . '_' . uniqid() . '.' . $extension;

            Storage::disk('ftp2')->put($filenametostore, fopen($request->file('document'), 'r+'));

            $url = $this->baseCtrl->getUrlServer('Contenido/ConveniosGuardados/');

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

    public function findconvenio($id)
    {
        $data = convenios::find($id);
        $response = [
            'estado' => true,
            'convenio' => $data
        ];

        return response()->json($response);
    }

    public function eliminarConvenio(Request $request)
    {
        $data = (object)$request->data;

        $convenio = convenios::find(floatval($data->id_convenio));
        if ($convenio) {
            $convenio->estado = trim($data->estado);
            $convenio->save();

            $response = [
                'estado' => true,
                'mensaje' => 'El convenio ha sido eliminado !'
            ];
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'El convenio no existe !!'
            ];
        }

        return response()->json($response);
    }

    public function updateConveniosAprobados(Request $request)
    {
        $data = (object)$request->data;

        $convenio = convenios::find(floatval($data->id_convenio));
        if ($convenio) {
            if ($convenio->tipo_documento == 'A') {
                $convenio->titulo_convenio = trim(ucfirst($data->nombre_convenio));
                $convenio->PDF = trim($data->PDF);
                $convenio->save();

                $response = [
                    'estado' => true,
                    'mensaje' => 'El convenio se ha actualizado'
                ];
            } else {
                $response = [
                    'estado' => false,
                    'mensaje' => 'No se puede actualizar el convenio, solo los aprobados, verifique !!'
                ];
            }
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No existe el convenio !!'
            ];
        }

        return response()->json($response);
    }

    public function updatePDFURl(Request $request)
    {
        $data = (object)$request->data;

        $convenio = convenios::find(intval($data->id_convenio));
        if ($convenio) {
            if ($convenio->tipo_documento == 'G') {

                $convenio->PDF = trim($data->PDF);
                $convenio->tipo_documento = 'A';
                $convenio->fecha_firma = $data->fecha_inicio;
                $convenio->fecha_fin = $data->fecha_fin;
                $convenio->save();

                $response = [
                    'estado' => true,
                    'mensaje' => 'Se actualizó el pdf del convenio !!'
                ];
            } else {
                $response = [
                    'estado' => false,
                    'mensaje' => 'Solo se pude actualizar convenios de tipo guardado'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'El convenio no existe'
            ];
        }

        return response()->json($response);
    }

    private function _updateConvenio($id, $usuario, $img1, $img2, $nombre,$PDF)
    {
        $convenio = convenios::find($id);
        $convenio->usuario_id = $usuario;
        $convenio->imagen1_id = $img1;
        $convenio->imagen2_id = $img2;
        $convenio->titulo_convenio = trim($nombre);
        $convenio->PDF=$PDF;
        $convenio->save();

        return $convenio;
    }

    private function _updateTipoConvenio($id, $convenio, $decripcion, $tipoconvenio, $convenioEspecifico)
    {
        $tipoConv = tipo_convenios::find($id);
        // $tipoConv->nombretc_id = $convenio;
        $tipoConv->descripcion_tc = trim($decripcion);
        $tipoConv->id_convenios = $tipoconvenio;
        $tipoConv->id_convenios_especificos = $convenioEspecifico;
        $tipoConv->save();
    }

    public function updateAllConvenio(Request $request){

        $data = (object)$request->data;

        //Actuallizar el convenio
        $convenio = $this->_updateConvenio($data->id_convenio, $data->id_usuario, $data->id_imagen1, $data->id_imagen2, $data->nombre_convenio,$data->PDF);
        //Actualizar tipo de convenio
        $tipoConv = $this->_updateTipoConvenio($data->id_tipoconvenio, $convenio->id, $data->comparecientes, $data->id_tipoconvenio, $data->id_tipoespecifico);

        //Recorrer el array de eliminacion
        foreach ($data->eliminacion as $clausula) {
            $clausula = (object)$clausula;
            // var_dump($clausula);    die();
            $contenido_id = $clausula->id_contenido;

            //Eliminar solo articulos
            if ($clausula->estado == 'A') {
                foreach ($clausula->articulos as $art) {
                    $art = (object)$art;
                    if ($art->estado == 'D') {    //Eliminar
                        $conArt = contenido_articulos::where('id_contenidos', $contenido_id)
                            ->where('id_articulos', $art->art_id)->first();
                        $conArt->estado = 'D';
                        $conArt->save();
                    }
                }
            } else
            //ELiminar calusula y sus articulos
            {
                foreach ($clausula->articulos as $art) {
                    if ($art->estado == 'D') {    //Eliminar
                        $conArt = contenido_articulos::where('id_contenidos', $contenido_id)
                            ->where('id_articulos', $art->art_id)->first();
                        $conArt->estado = 'D';
                        $conArt->save();
                    }
                }

                //Eliminar en convenio-clausula_
                $_clau = convenios_clausulas::where('id_clausulas', $clausula->id_clausula)
                    ->where('id_convenios', $data->id_convenio)->where('id_contenidos', $clausula->id_contenido)->first();

                $_clau->estado = 'D';
                $_clau->save();
            }
        }

        //Recorrer el array para editar o insertar
        foreach ($data->clausulas as $clausula) {
            $clausula = (object)$clausula;
            if ($clausula->id_contenido == 0) {   //Insertar
                //Crear contenido
                $newcontenido = new contenido();
                $newcontenido->des_cont = trim($clausula->descripcion);
                $newcontenido->tipo="P";
                $newcontenido->save();

                //Crear articulo
                foreach ($clausula->articulos as $articulo) {
                    if ($articulo['art_id'] == 0) {
                        $newArt = new articulos();
                        $newArt->des_art = trim(ucfirst($articulo['des_art']));
                        $newArt->subtipo = $articulo['subtipo'];
                        $newArt->save();

                        //Crear la relacion
                        $newContArt = new contenido_articulos();
                        $newContArt->id_contenidos = $newcontenido->id;
                        $newContArt->id_articulos = $newArt->id;
                        $newContArt->estado='A';
                        $newContArt->save();
                    }
                }

                //Crear convenios-clausulas
                $newConClau = new convenios_clausulas();
                $newConClau->id_convenios = $data->id_convenio;
                $newConClau->id_clausulas = $clausula->id;
                $newConClau->id_contenidos = $newcontenido->id;
                $newConClau->estado = 'A';
                $newConClau->save();
            } else {
                //update clausulas
                $objectClau = clausulas::find($clausula->id);
                $objectClau->nombre_clau = trim(ucfirst($clausula->nombre));
                $objectClau->save();

                //update contenido
                $objectCont = contenido::find($clausula->id_contenido);
                $objectCont->des_cont = trim(ucfirst($clausula->descripcion));
                $objectCont->save();

                $convClau = convenios_clausulas::where('id_clausulas', $clausula->id)
                    ->where('id_contenidos', $clausula->id_contenido)->first();

                if (!$convClau) {
                    $newConClau = new convenios_clausulas();
                    $newConClau->id_clausulas = $clausula->id;
                    $newConClau->id_contenido = $clausula->id_contenido;
                    $newConClau->estado = 'A';
                    $newConClau->save();
                }

                if (count($clausula->articulos) > 0) {

                    foreach ($clausula->articulos as $art) {
                        // $art = (object)$art;
                        // var_dump($art['des_art']); die();

                        if($art['art_id'] != 0){
                            $objArt = articulos::find($art['art_id']);
                            $objArt->des_art = trim(ucfirst($art['des_art']));
                            $objArt->save();
                        }
                    }
                }
            }
        }

        $response = [
            'status' => true,
            'message' => 'Se ha actualizado el documento !!'
        ];

        return response()->json($response);
    }

    public function InsertConveniosSQL(){
        $conve = DB::insert('insert into convenios (id, name) values (?, ?)', [1, 'Dayle']);

        //-> toJson();
        return response() -> json ($conve);
     

    }


}
