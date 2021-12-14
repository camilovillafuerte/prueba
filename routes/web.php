<?php

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


Route::get('/interfaz/{pagina}', function ()
{
    $inter=DB::table('interfazs')
    ->get();
    return response() -> json ($inter);

});
