<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bibliotecavirtual;

class BibliotecavirtualController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bvirtual = bibliotecavirtual::all();
        return $bvirtual;
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
        $bvirtual = new bibliotecavirtual();
        $bvirtual->nombre_uni= $request->nombre_uni;
        $bvirtual->url_biblioteca= $request->url_biblioteca;
        $bvirtual->url_pprincipal= $request->url_pprincipal;
        $bvirtual->save();
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
        $bvirtual=bibliotecavirtual::findOrFail($request->id);
        $bvirtual->nombre_uni= $request->nombre_uni;
        $bvirtual->url_biblioteca= $request->url_biblioteca;
        $bvirtual->url_pprincipal= $request->url_pprincipal;
        $bvirtual->save();
        return $bvirtual;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $bvirtual=bibliotecavirtual::destroy($request->id);
        return $bvirtual;
    }
    
    //metodo con json para probar si funciona con postman
    public function getBvirtual(){
        return response()->json(bibliotecavirtual::all(),200);
    }

    public function getBvirtualxid($id){
        $bvirtual = bibliotecavirtual::find($id);
        if(is_null($bvirtual)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($bvirtual::find($id),200);
    }

    public function insertBvirtual(Request $request){
        $bvirtual = bibliotecavirtual::create ($request->all());
        return response($bvirtual,200);
    }

    public function updateBvirtual(Request $request,$id){
        $bvirtual=bibliotecavirtual::find($id);
        if (is_null($bvirtual)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $bvirtual->update($request->all());
        return response($bvirtual,200);
    }

    public function deleteBvirtual($id){
        $bvirtual=bibliotecavirtual::find($id);
        if (is_null($bvirtual)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $bvirtual->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
