<?php

use App\Models\interfaz;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/leerbecas', function ()
{

    $becas=DB::table('becas_nivels')
    ->where('estado','A')
    ->orderByDesc('id')
    ->get();
    return response() -> json ($becas);

    /*$resultados=DB::select("SELECT * FROM becas_nivels WHERE estado=?",['A']);
    return response() -> json ($resultados);
    foreach ($resultados as $becas_nivel){
       //return $becas_nivel;
        return response() -> json ($becas_nivel); 
    }*/
});

Route::get('/leerbecasbody', function ()
{
    $becasbody=DB::table('becas_nivel_bodies')
    ->where('estado','A')
    ->orderByDesc('id')
    ->get();
    return response() -> json ($becasbody);
    
    /*$sql=DB::select("SELECT * FROM becas_nivel_bodies WHERE estado=?",['A']) ;
    return response() -> json ($sql);
    foreach ($sql as $becas_body){
       // return $becas_body;
        return response() -> json ($becas_body); 
        //->nombre;
    }*/
});


Route::get('/becas', function()
{
    $becas=DB::table('becas_nivels')
    ->orderByDesc('id')
    ->get();
    return response() -> json ($becas);
});


Route::get('/interfaz/{pagina}', function ($pagina)
{
    $inter=DB::table('interfazs')
    -> where ('pagina', 'LIKE', "%pagina%" )
    -> get();
    return $pagina;
    return response() -> json ($inter);

});

/*
Route::get('/interfazcon2/{pagina?}', function($interfaz = null ) {
    $interfaz = [DB::table('interfazs')
    ->join('interfaz_contenidos','interfazs.id','=','interfaz_contenidos.id_interfazs')
    ->select('interfazs.nombre as InterfazNombre','interfazs.pagina', 'interfaz_contenidos.id_interfazs','interfaz_contenidos.nombre','interfaz_contenidos.descripcion','interfaz_contenidos.urlimagen','interfaz_contenidos.estado')
    -> where('estado','A') 
    -> get()
];
    return $pagina;
});*/

Route::get('/interfaz', function () {
    return interfaz::query()
        ->when(request('search'), function ($query, $pagina) {
            $query->select( 'nombre', 'pagina')
                ->selectRaw(
                    'match(nombre,pagina) against(? with query expansion) as score',
                    [$pagina]
                )
                ->whereRaw(
                    'match(nombre,pagina) against(? with query expansion) > 0.0000001',
                    [$pagina]
                );
        })
        ->get();
});
