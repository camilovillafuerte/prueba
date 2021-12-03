<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contenido_articulos;

class Contenido_articulosController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $con_art = contenido_articulos::all();
        return $con_art;
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
        $con_art = new contenido_articulos();
        $con_art->id_contenidos= $request->id_contenidos;
        $con_art->id_articulos= $request->id_articulos;
        $con_art->save();
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
        $con_art=contenido_articulos::findOrFail($request->id);
        $con_art->id_contenidos= $request->id_contenidos;
        $con_art->id_articulos= $request->id_articulos;
        $con_art->save();
        return $con_art;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $con_art=contenido_articulos::destroy($request->id);
        return $con_art;
    }

    //metodo con json para probar si funciona con postman
    public function getCon_art(){
        return response()->json(contenido_articulos::all(),200);
    }

    public function getCon_artxid($id){
        $con_art = contenido_articulos::find($id);
        if(is_null($con_art)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($con_art::find($id),200);
    }

    public function insertCon_art(Request $request){
        $con_art = contenido_articulos::create ($request->all());
        return response($con_art,200);
    }

    public function updateCon_art(Request $request,$id){
        $con_art=contenido_articulos::find($id);
        if (is_null($con_art)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $con_art->update($request->all());
        return response($con_art,200);
    }

    public function deleteCon_art($id){
        $con_art=contenido_articulos::find($id);
        if (is_null($con_art)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $con_art->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
