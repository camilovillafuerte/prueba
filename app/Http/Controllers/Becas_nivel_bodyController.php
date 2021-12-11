<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\becas_nivel_body;
use Illuminate\Support\Facades\DB;

class Becas_nivel_bodyController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consulta()
    {
        $sql = 'SELECT * FROM becas_nivel_bodies WHERE estado="A"';
        $becas_body = DB::select($sql);
        //$becas_body = becas_nivel_body::all();
       return $becas_body;
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
            ->select('id', 'nombre', 'pais', 'idioma','area_estudio','fecha_postulacion',
            'url','modalidad','requisitos','reconocimiento_titulo','pdf','estado')
            ->where ("estado=A") 
            ->orderBy('id', 'DESC')
            ->get()
            ->toJson();
        
          return $becas_body2;
    
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
