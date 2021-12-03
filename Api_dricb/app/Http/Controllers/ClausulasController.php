<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\clausulas;

class ClausulasController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clausulas = clausulas::all();
        return $clausulas;
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
        $clausulas = new clausulas();
        $clausulas->nombre_clau= $request->nombre_clau;
        $clausulas->save();
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
        $clausulas=clausulas::findOrFail($request->id);
        $clausulas->nombre_clau = $request->nombre_clau;
        $clausulas->save();
        return $clausulas;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $clausulas=clausulas::destroy($request->id);
        return $clausulas;
    }
    
    //metodo con json para probar si funciona con postman
    public function getClausulas(){
        return response()->json(clausulas::all(),200);
    }

    public function getClausulasxid($id){
        $clausulas = clausulas::find($id);
        if(is_null($clausulas)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($clausulas::find($id),200);
    }

    public function insertClausulas(Request $request){
        $clausulas = clausulas::create ($request->all());
        return response($clausulas,200);
    }

    public function updateClausulas(Request $request,$id){
        $clausulas=clausulas::find($id);
        if (is_null($clausulas)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $clausulas->update($request->all());
        return response($clausulas,200);
    }

    public function deleteClausulas($id){
        $clausulas=clausulas::find($id);
        if (is_null($clausulas)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $clausulas->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
