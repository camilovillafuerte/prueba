<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contenido;

class ContenidoController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contenido = contenido::all();
        return $contenido;
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
        $contenido = new contenido();
        $contenido->des_cont= $request->des_cont;
        $contenido->tipo= $request->tipo;
        $contenido->save();
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
        $contenido=contenido::findOrFail($request->id);
        $contenido->des_cont= $request->des_cont;
        $contenido->tipo= $request->tipo;
        $contenido->save();
        return $contenido;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $contenido=contenido::destroy($request->id);
        return $contenido;
    }

     //metodo con json para probar si funciona con postman
     public function getContenido(){
        return response()->json(contenido::all(),200);
    }

    public function getContenidoxid($id){
        $contenido = contenido::find($id);
        if(is_null($contenido)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($contenido::find($id),200);
    }

    public function insertContenido(Request $request){
        $contenido = contenido::create ($request->all());
        return response($contenido,200);
    }

    public function updateContenido(Request $request,$id){
        $contenido=contenido::find($id);
        if (is_null($contenido)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $contenido->update($request->all());
        return response($contenido,200);
    }

    public function deleteContenido($id){
        $contenido=contenido::find($id);
        if (is_null($contenido)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $contenido->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
