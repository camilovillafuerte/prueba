<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\convenios;

class ConveniosController extends Controller
{
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
    public function create()
    {
        //
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
        //
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
}
