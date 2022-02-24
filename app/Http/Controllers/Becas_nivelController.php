<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\becas_nivel;
use Database\Seeders\Becas_nivelSeeder;
use Illuminate\Support\Facades\DB;


class Becas_nivelController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function consulta()
    {
    $sql = 'SELECT * FROM becas_nivels WHERE estado="A"';
      $becas = DB::select($sql);
       
        //$becas = becas_nivel::all();
       //$becas = Becas_nivel::where('tipo','C')->get();
       return $becas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = (object)$request->data;
        $nombre=trim(ucfirst($data->nombre));
        $existe = becas_nivel::where('nombre', $nombre)->where('tipo',trim($data->tipo))->first();
        if($existe){    //Existe el nombre de la firma del emisor
            $response = [
                'estado' => false,
                'mensaje' => 'La categoria ya se encuentra registrada !'
            ];
        }else{
            $new = new becas_nivel();
            $new->usuario_id= intval($data->id_usuario);
            $new->nombre=$nombre;
            $new->tipo=trim($data->tipo);
            $new->estado = 'A';
            $new->fecha_creacion = date('Y-m-d H:i:s');
            $new->save();

            $response = [
                'estado' => true,
                'mensaje' => 'Se ha registrado la categoria beca!'
            ]; 
         }
         return response()->json($response);
    }

    public function updateEstado(Request $request){
        $data = (object)$request->data;
        $existe = becas_nivel::where('id',trim(intval($data->id)))->first();
        if($existe)
        {
            $existe->estado=trim($data->estado);
            $existe->save();
            $response=[
                'estado'=>true,
                'mensaje'=>'Se cambio el estado con exito'
            ];
        }
        else
        {
            $response=[
                'estado'=>false,
                'mensaje'=>'No encontro la categoria becas .....!!'
            ];
        }
        return response()->json($response);
    }
    public function updatenombre(Request $request)
    {
        $data = (object)$request->data;
        $nombre=trim(ucfirst($data->nombre));
        $existe = becas_nivel::where('id', intval($data->id))->first();
        if($existe)
        {
            $existe->nombre=trim($nombre);
            $existe->save();
            $response=[
                'estado'=>true,
                'mensaje'=>'Se actualizo la categoria con exito....!!'
            ];


        }
        else
        {
            $response=[
                'estado'=>false,
                'mensaje'=>'No encontro la categoria becas .....!!'
            ];
        }

        return response()->json($response);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $becas = new becas_nivel();
        $becas->nombre= $request->nombre;
        $becas->tipo = $request->tipo;
        $becas->estado = $request->estado;
        $becas->fecha_creacion = $request->fecha_creacion;

        $becas->save();
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
        $becas=becas_nivel::findOrFail($request->id);
        $becas->nombre= $request->nombre;
        $becas->tipo = $request->tipo;
        $becas->estado = $request->estado;
        $becas->fecha_creacion = $request->fecha_creacion;
        $becas->save();
        return $becas;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $becas=becas_nivel::destroy($request->id);
        return $becas;

    }

//metodo con json para probar si funciona con postman
   
    public function getBecas_nivel(){
        return response()->json(becas_nivel::all(),200);
    }

   

    public function getBecas_niveldes(){
        $becas2 = DB::table('becas_nivels')
        -> select('id', 'usuario_id','nombre', 'tipo', 'estado','fecha_creacion')
        //-> where('estado','A') 
        -> orderBy('id', 'DESC')
        -> get();
        //-> toJson();
        return response() -> json ($becas2);
     // return $becas2;

    }


    public function getBecas_nivelxid($id){
        $becas = becas_nivel::find($id);
        if(is_null($becas)){
            return response () -> json(['Mensaje'=>'Registro no encontrado'],404);
        } 
        return response ()->json($becas::find($id),200);
    }

    public function insertBecas_nivel(Request $request){
        $becas = becas_nivel::create ($request->all());
        return response($becas,200);
    }

    public function updateBecas_nivel(Request $request,$id){
        $becas = becas_nivel::find($id);
        if (is_null($becas)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
        $becas->update($request->all());
        return response($becas,200);
    }

    public function deleteBecas_nivel($id){
        $becas = becas_nivel::find($id);
        if (is_null($becas)){
            return response()->json(['Mensaje'=>'Registro no encontrado'],404);
         }
         $becas->delete();
         return response()->json(['Mensaje'=>'Registro Eliminado'],200);
    }

    public function becas_v2($tipo){

        $tipo = strtoupper($tipo);
        $becas = becas_nivel::where('tipo', $tipo)->where('estado','A')->orderBy('id','desc')->get();
        if($becas->count() > 0)
        {
            foreach($becas as $b)   $b->becas_nivel_body;

            $response = [
                'estado' => true,
                'mensaje' => 'Datos',
                'data' => $becas
            ];
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'Datos',
                'data' => []
            ];
        }


        return response()->json($response);
    }
}
