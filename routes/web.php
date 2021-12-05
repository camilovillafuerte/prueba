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
    $resultados=DB::select("SELECT * FROM becas_nivels WHERE estado=?",["A"] );
    foreach ($resultados as $becas_nivel){
        return $becas_nivel->nombre;
        
    }
});
