<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\interfaz;
use App\Models\interfaz_contenido;
use Illuminate\Support\Facades\DB;

class InterfazController extends Controller
{
    //método con json para probar si funciona con postman


    public function getInterfaz()
    {
        return response()->json(interfaz::all(), 200);
    }


    public function showpagina(interfaz $pagina)
    {

        return response()->json($pagina);
    }


    public function getInterfazxid($id)
    {
        $interfaz = interfaz::find($id);
        if (is_null($interfaz)) {
            return response()->json(['Mensaje' => 'Registro no encontrado'], 404);
        }
        return response()->json($interfaz::find($id), 200);
    }

    public function insertInterfaz(Request $request)
    {
        $interfaz = interfaz::create($request->all());
        return response($interfaz, 200);
    }

    public function updateInterfaz(Request $request, $id)
    {
        $interfaz = interfaz::find($id);
        if (is_null($interfaz)) {
            return response()->json(['Mensaje' => 'Registro no encontrado'], 404);
        }
        $interfaz->update($request->all());
        return response($interfaz, 200);
    }

    public function deleteInterfaz($id)
    {
        $interfaz = interfaz::find($id);
        if (is_null($interfaz)) {
            return response()->json(['Mensaje' => 'Registro no encontrado'], 404);
        }
        $interfaz->delete();
        return response()->json(['Mensaje' => 'Registro Eliminado'], 200);
    }

    public function getInterfazContenidos($params)
    {

        $interfaz = interfaz::where('pagina', $params)->get();
        $response = false;
        $array = [];

        if ($interfaz->count() > 0) {
            foreach ($interfaz as $i) {
                $contenidos = interfaz_contenido::where('id_interfazs', $i->id)
                    ->orderBy('nombre', 'asc')->get();

                if ($contenidos->count() > 0)
                    foreach ($contenidos as $c)     $array[] = $c;
            }

            if ($array)
                foreach ($array as $c)  $c->interfaz;

            $response = $array;
            return response()->json($response);
        }
    }
}
