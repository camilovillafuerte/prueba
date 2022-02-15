<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\convenios_clausulas;

class Convenios_clausulasController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $con_clau = convenios_clausulas::all();
        return $con_clau;
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
        $con_clau = new convenios_clausulas();
        $con_clau->id_convenios= $request->id_convenios;
        $con_clau->id_clausulas= $request->id_clausulas;
        $con_clau->id_contenidos= $request->id_contenidos;
        $con_clau->estado= $request->estado;
        $con_clau->save();
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
        $con_clau=convenios_clausulas::findOrFail($request->id);
        $con_clau->id_convenios= $request->id_convenios;
        $con_clau->id_clausulas= $request->id_clausulas;
        $con_clau->id_contenidos= $request->id_contenidos;
        $con_clau->save();
        return $con_clau;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $con_clau=convenios_clausulas::destroy($request->id);
        return $con_clau;
    }

     //metodo con json para probar si funciona con postman
     public function getCon_clau(){
        return response()->json(convenios_clausulas::all(),200);
    }

    public function getCon_clauxid($id){
        $con_clau = convenios_clausulas::find($id);
        if(is_null($con_clau)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($con_clau::find($id),200);
    }

    public function insertCon_clau(Request $request){
        $con_clau = convenios_clausulas::create ($request->all());
        return response($con_clau,200);
    }

    public function updateCon_clau(Request $request,$id){
        $con_clau=convenios_clausulas::find($id);
        if (is_null($con_clau)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $con_clau->update($request->all());
        return response($con_clau,200);
    }

    public function deleteCon_clau($id){
        $con_clau=convenios_clausulas::find($id);
        if (is_null($con_clau)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $con_clau->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
