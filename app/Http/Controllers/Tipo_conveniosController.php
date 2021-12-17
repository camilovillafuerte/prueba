<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tipo_convenios;
use Illuminate\Support\Facades\DB;

class Tipo_conveniosController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo_con = tipo_convenios::all();
        return $tipo_con;
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
        $tipo_con = new tipo_convenios();
        $tipo_con->nombre_tc= $request->nombre_tc;
        $tipo_con->descripcion_tc= $request->descripcion_tc;
        $tipo_con->id_convenios= $request->id_convenios;
        $tipo_con->id_convenios_especificos= $request->id_convenios_especificos;
        $tipo_con->save();
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
        $tipo_con=tipo_convenios::findOrFail($request->id);
        $tipo_con = new tipo_convenios();
        $tipo_con->nombre_tc= $request->nombre_tc;
        $tipo_con->descripcion_tc= $request->descripcion_tc;
        $tipo_con->id_convenios= $request->id_convenios;
        $tipo_con->id_convenios_especificos= $request->id_convenios_especificos;
        $tipo_con->save();
        return $tipo_con;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tipo_con=tipo_convenios::destroy($request->id);
        return $tipo_con;
    }

    //metodo con json para probar si funciona con postman


    public function getTipoconvenio(){
        $tipo_con2 = DB::table('tipo_convenios')
        ->join('convenios','convenios.id','=','tipo_convenios.id_convenios')
        ->join ('convenios_especificos','convenios_especificos.id','=','tipo_convenios.id_convenios_especificos' )
        ->select('convenios.id','convenios.titulo_convenio', 'convenios.f_creaciondoc','convenios.estado','convenios.tipo_documento','convenios.PDF'
        ,'tipo_convenios.id','tipo_convenios.nombre_tc','tipo_convenios.descripcion_tc','tipo_convenios.id_convenios_especificos','convenios_especificos.descripcion_ce')
        -> where('convenios.estado','A') 
        -> where ('convenios.tipo_documento','A')
        -> orderByAsc('convenios.id')
        -> get();
        return response() -> json ($tipo_con2);
       } 
       


    public function getTipo_con(){
        return response()->json(tipo_convenios::all(),200);
    }

    public function getTipo_conxid($id){
        $tipo_con = tipo_convenios::find($id);
        if(is_null($tipo_con)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($tipo_con::find($id),200);
    }

    public function insertTipo_con(Request $request){
        $tipo_con = tipo_convenios::create ($request->all());
        return response($tipo_con,200);
    }

    public function updateTipo_con(Request $request,$id){
        $tipo_con=tipo_convenios::find($id);
        if (is_null($tipo_con)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $tipo_con->update($request->all());
        return response($tipo_con,200);
    }

    public function deleteTipo_con($id){
        $tipo_con=tipo_convenios::find($id);
        if (is_null($tipo_con)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $tipo_con->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }
}
