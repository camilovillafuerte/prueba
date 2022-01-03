<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\convenios_especificos;

class Convenios_especificosController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $convenios_es = convenios_especificos::all();
        return $convenios_es;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){

        $convenioEsp = (object)$request->convenio_especifico;
        $response = [];

        //Buscar si existe la descipcion
        $existe = convenios_especificos::where('descripcion_ce', trim($convenioEsp->descripcion_ce))->first();

        if($existe){
            $response = [
                'status' => false,
                'mensaje' => 'La descripción ingresada ya existe',
                'convenio_especifico' => false
            ];
        }else{
            $new = new convenios_especificos();
            $new->descripcion_ce = ucfirst(trim($convenioEsp->descripcion_ce));
            $new->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha creado el convenio específico',
                'convenio_especifico' => false
            ];
        }

        return response()->json($response);
    }

    public function getConvenios(){

        $convenios_especificos = convenios_especificos::all();
        return response()->json($convenios_especificos);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $convenios_es = new convenios_especificos();
        $convenios_es->descripcion_ce= $request->descripcion_ce;
        $convenios_es->save();
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
        $convenios_es=convenios_especificos::findOrFail($request->id);
        $convenios_es = new convenios_especificos();
        $convenios_es->descripcion_ce= $request->descripcion_ce;
        $convenios_es->save();
        return $convenios_es;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $convenios_es=convenios_especificos::destroy($request->id);
        return $convenios_es;
    }

    //metodo con json para probar si funciona con postman
    public function getConvenios_es(){
        return response()->json(convenios_especificos::all(),200);
    }

    public function getConvenios_esxid($id){
        $convenios_es = convenios_especificos::find($id);
        if(is_null($convenios_es)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        }
        return response ()->json($convenios_es::find($id),200);
    }

    public function insertConvenios_es(Request $request){
        $convenios_es = convenios_especificos::create ($request->all());
        return response($convenios_es,200);
    }

    public function updateConvenios_es(Request $request,$id){
        $convenios_es=convenios_especificos::find($id);
        if (is_null($convenios_es)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $convenios_es->update($request->all());
        return response($convenios_es,200);
    }

    public function deleteConvenios_es($id){
        $convenios_es=convenios_especificos::find($id);
        if (is_null($convenios_es)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $convenios_es->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
