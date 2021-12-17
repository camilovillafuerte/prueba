<?php

use App\Http\Controllers\InterfazController;
use App\Models\interfaz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Ruta para tabla articulos
Route::get('/articulos','App\Http\Controllers\ArticulosController@index');//mostrar todos los registros
Route::get('/articulos/{id}','App\Http\Controllers\ArticulosController@getArticulosxid');//mostrar  los registros por id
Route::post('/articulos','App\Http\Controllers\ArticulosController@store');//crear un registro
Route::post('/addArticulos','App\Http\Controllers\ArticulosController@insertArticulos');//crear un registro
Route::put('/articulos/{id}','App\Http\Controllers\ArticulosController@update');//actualizar un registro
Route::put('/updateArticulos/{id}','App\Http\Controllers\ArticulosController@updateArticulos');//actualizar un registro
Route::delete('/articulos/{id}','App\Http\Controllers\ArticulosController@destroy');//eliminar un registro
Route::delete('/deleteArticulos/{id}','App\Http\Controllers\ArticulosController@deleteArticulos');//eliminar un registro

//Ruta para tabla clausulas
Route::get('/clausulas','App\Http\Controllers\ClausulasController@index');//mostrar todos los registros
Route::get('/clausulas/{id}','App\Http\Controllers\ClausulasController@getClausulasxid');//mostrar  los registros por id
Route::post('/clausulas','App\Http\Controllers\ClausulasController@store');//crear un registro
Route::post('/addClausulas','App\Http\Controllers\ClausulasController@insertClausulas');//crear un registro
Route::put('/clausulas/{id}','App\Http\Controllers\ClausulasController@update');//actualizar un registro
Route::put('/updateClausulas/{id}','App\Http\Controllers\ClausulasController@updateClausulas');//actualizar un registro
Route::delete('/clausulas/{id}','App\Http\Controllers\ClausulasController@destroy');//eliminar un registro
Route::delete('/deleteClausulas/{id}','App\Http\Controllers\ClausulasController@deleteClausulas');//eliminar un registro

//Ruta para tabla contenido_articulo
Route::get('/con_art','App\Http\Controllers\Contenido_articulosController@index');//mostrar todos los registros
Route::get('/con_art/{id}','App\Http\Controllers\Contenido_articulosController@getCon_artxid');//mostrar  los registros por id
Route::post('/con_art','App\Http\Controllers\Contenido_articulosController@store');//crear un registro
Route::post('/addCon_art','App\Http\Controllers\Contenido_articulosController@insertCon_art');//crear un registro
Route::put('/con_art/{id}','App\Http\Controllers\Contenido_articulosController@update');//actualizar un registro
Route::put('/updateCon_art/{id}','App\Http\Controllers\Contenido_articulosController@updateCon_art');//actualizar un registro
Route::delete('/con_art/{id}','App\Http\Controllers\Contenido_articulosController@destroy');//eliminar un registro
Route::delete('/deleteCon_art/{id}','App\Http\Controllers\Contenido_articulosController@deleteCon_art');//eliminar un registro

//Ruta para tabla contenido
Route::get('/contenido','App\Http\Controllers\ContenidoController@index');//mostrar todos los registros
Route::get('/contenido/{id}','App\Http\Controllers\ContenidoController@getContenidoxid');//mostrar  los registros por id
Route::post('/contenido','App\Http\Controllers\ContenidoController@store');//crear un registro
Route::post('/addContenido','App\Http\Controllers\ContenidoController@insertContenido');//crear un registro
Route::put('/contenido/{id}','App\Http\Controllers\ContenidoController@update');//actualizar un registro
Route::put('/updateContenido/{id}','App\Http\Controllers\ContenidoController@updateContenido');//actualizar un registro
Route::delete('/contenido/{id}','App\Http\Controllers\ContenidoController@destroy');//eliminar un registro
Route::delete('/deleteContenido/{id}','App\Http\Controllers\ContenidoController@deleteContenido');//eliminar un registro

//Ruta para tabla convenios
Route::get('/convenios','App\Http\Controllers\ConveniosController@index');//mostrar todos los registros
Route::get('/convenios/{id}','App\Http\Controllers\ConveniosController@getConveniosxid');//mostrar  los registros por id
Route::post('/convenios','App\Http\Controllers\ConveniosController@store');//crear un registro
Route::post('/addConvenios','App\Http\Controllers\ConveniosController@insertConvenios');//crear un registro
Route::put('/convenios/{id}','App\Http\Controllers\ConveniosController@update');//actualizar un registro
Route::put('/updateConvenios/{id}','App\Http\Controllers\ConveniosController@updateConvenios');//actualizar un registro
Route::delete('/convenios/{id}','App\Http\Controllers\ConveniosController@destroy');//eliminar un registro
Route::delete('/deleteConvenios/{id}','App\Http\Controllers\ConveniosController@deleteConvenios');//eliminar un registro


//Ruta para tabla convenios_especificos
Route::get('/convenios_es','App\Http\Controllers\Convenios_especificosController@index');//mostrar todos los registros
Route::get('/convenios_es/{id}','App\Http\Controllers\Convenios_especificosController@getConvenios_esxid');//mostrar  los registros por id
Route::post('/convenios_es','App\Http\Controllers\Convenios_especificosController@store');//crear un registro
Route::post('/addConvenios_es','App\Http\Controllers\Convenios_especificosController@insertConvenios_es');//crear un registro
Route::put('/convenios_es/{id}','App\Http\Controllers\Convenios_especificosController@update');//actualizar un registro
Route::put('/updateConvenios_es/{id}','App\Http\Controllers\Convenios_especificosController@updateConvenios_es');//actualizar un registro
Route::delete('/convenios_es/{id}','App\Http\Controllers\Convenios_especificosController@destroy');//eliminar un registro
Route::delete('/deleteConvenios_es/{id}','App\Http\Controllers\Convenios_especificosController@deleteConvenios_es');//eliminar un registro

//Ruta para tabla tipo_convenios
Route::get('/tipo_con','App\Http\Controllers\Tipo_conveniosController@index');//mostrar todos los registros
Route::get('/tipo_con/{id}','App\Http\Controllers\Tipo_conveniosController@getTipo_conxid');//mostrar  los registros por id
Route::get('/tipocon2','App\Http\Controllers\Tipo_conveniosController@getTipoconvenio');
Route::post('/tipo_con','App\Http\Controllers\Tipo_conveniosController@store');//crear un registro
Route::post('/addTipo_con','App\Http\Controllers\Tipo_conveniosController@insertTipo_con');//crear un registro
Route::put('/tipo_con/{id}','App\Http\Controllers\Tipo_conveniosController@update');//actualizar un registro
Route::put('/updateTipo_con/{id}','App\Http\Controllers\Tipo_conController@updateTipo_con');//actualizar un registro
Route::delete('/tipo_con/{id}','App\Http\Controllers\Tipo_conController@destroy');//eliminar un registro
Route::delete('/deleteTipo_con/{id}','App\Http\Controllers\Tipo_conController@deleteTipo_con');//eliminar un registro

//Ruta para tabla convenios_clausulas
Route::get('/con_clau','App\Http\Controllers\Convenios_clausulasController@index');//mostrar todos los registros
Route::get('/con_clau/{id}','App\Http\Controllers\Convenios_clausulasController@getCon_clauxid');//mostrar  los registros por id
Route::post('/con_clau','App\Http\Controllers\Convenios_clausulasController@store');//crear un registro
Route::post('/addCon_clau','App\Http\Controllers\Convenios_clausulasController@insertCon_clau');//crear un registro
Route::put('/con_clau/{id}','App\Http\Controllers\Convenios_clausulasController@update');//actualizar un registro
Route::put('/updateCon_clau/{id}','App\Http\Controllers\Convenios_clausulasController@updateCon_clau');//actualizar un registro
Route::delete('/con_clau/{id}','App\Http\Controllers\Convenios_clausulasController@destroy');//eliminar un registro
Route::delete('/deleteCon_clau/{id}','App\Http\Controllers\Convenios_clausulasController@deleteCon_clau');//eliminar un registro

//Ruta para tabla becas_nivel
//Route::get('/becas','App\Http\Controllers\Becas_nivelController@consulta');//mostrar todos los registros
Route::get('/becas','App\Http\Controllers\Becas_nivelController@getBecas_nivel');
Route::get('/becas2','App\Http\Controllers\Becas_nivelController@getBecas_niveldes'); //orden descendente
//Route::get('/becas','App\Http\Controllers\Becas_nivelController@getBecasnivel_json');
Route::get('/becas/{id}','App\Http\Controllers\Becas_nivelController@getBecas_nivelxid');//mostrar  los registros por id
Route::post('/becas','App\Http\Controllers\Becas_nivelController@store');//crear un registro
Route::post('/addBecas','App\Http\Controllers\Becas_nivelController@insertBecas_nivel');//crear un registro
Route::put('/becas/{id}','App\Http\Controllers\Becas_nivelController@update');//actualizar un registro
Route::put('/updateBecas/{id}','App\Http\Controllers\Becas_nivelController@updateBecas_nivel');//actualizar un registro
Route::delete('/becas/{id}','App\Http\Controllers\Becas_nivelController@destroy');//eliminar un registro
Route::delete('/deleteBecas/{id}','App\Http\Controllers\Becas_nivelController@deleteBecas_nivel');//eliminar un registro

//Ruta para tabla becas_nivel_body

//Route::get('/becas_body','App\Http\Controllers\Becas_nivel_bodyController@consulta');//mostrar todos los registros
Route::get('/becas_body','App\Http\Controllers\Becas_nivel_bodyController@getBecas_nivelb');
Route::get('/becas_body2','App\Http\Controllers\Becas_nivel_bodyController@getBecas_nivelbdes');//orden descendente
//Route::get('/becas_body','App\Http\Controllers\Becas_nivel_bodyController@getBecasnivelb_json');
Route::get('/becas_body/{id}','App\Http\Controllers\Becas_nivel_bodyController@getBecas_nivelbxid');//mostrar  los registros por id
Route::post('/becas_body','App\Http\Controllers\Becas_nivel_bodyController@store');//crear un registro
Route::post('/addBecas_body','App\Http\Controllers\Becas_nivel_bodyController@insertBecas_nivelb');//crear un registro
Route::put('/becas_body/{id}','App\Http\Controllers\Becas_nivel_bodyController@update');//actualizar un registro
Route::put('/updateBecas_body/{id}','App\Http\Controllers\Becas_nivel_bodyController@updateBecas_nivelb');//actualizar un registro
Route::delete('/becas_body/{id}','App\Http\Controllers\Becas_nivel_bodyController@destroy');//eliminar un registro
Route::delete('/deleteBecas_body/{id}','App\Http\Controllers\Becas_nivel_bodyController@deleteBecas_nivelb');//eliminar un registro

//Ruta para tabla bibliotecavirtual
Route::get('/bvirtual','App\Http\Controllers\BibliotecavirtualController@index');//mostrar todos los registros
Route::get('/bvirtual/{id}','App\Http\Controllers\BibliotecavirtualController@getBvirtualxid');//mostrar  los registros por id
Route::post('/bvirtual','App\Http\Controllers\BibliotecavirtualController@store');//crear un registro
Route::post('/addBvirtual','App\Http\Controllers\BibliotecavirtualController@insertBvirtual');//crear un registro
Route::put('/bvirtual/{id}','App\Http\Controllers\BibliotecavirtualController@update');//actualizar un registro
Route::put('/updateBvirtual/{id}','App\Http\Controllers\BibliotecavirtualController@updateBvirtual');//actualizar un registro
Route::delete('/bvirtual/{id}','App\Http\Controllers\BibliotecavirtualController@destroy');//eliminar un registro
Route::delete('/deleteBvirtual/{id}','App\Http\Controllers\BibliotecavirtualController@deleteBvirtual');//eliminar un registro

//Ruta para tabla interfaz
Route::get('/interfaz','App\Http\Controllers\InterfazController@getInterfaz');
//Route::get('/interfaz/{pagina}','App\Http\Controllers\InterfazController@showpagina');
Route::get('/interfaz/{id}','App\Http\Controllers\InterfazController@getInterfazxid');
Route::post('/addInterfaz','App\Http\Controllers\InterfazController@insertInterfaz');
Route::put('/updateInterfaz/{id}','App\Http\Controllers\InterfazController@updateInterfaz');
Route::delete('/deleteInterfaz/{id}','App\Http\Controllers\InterfazController@deleteInterfaz');


//Ruta para tabla interfaz_contenido
Route::get('/interfazcon','App\Http\Controllers\Interfaz_contenidoController@getInterfazcon');
Route::get('/interfazcon2','App\Http\Controllers\Interfaz_contenidoController@getInterfazconprueba');
Route::get('/interfazcon/{id}','App\Http\Controllers\Interfaz_contenidoController@getInterfazconxid');
Route::post('/addInterfazcon','App\Http\Controllers\Interfaz_contenidoController@insertInterfazcon');
Route::put('/updateInterfazcon/{id}','App\Http\Controllers\Interfaz_contenidoController@updateInterfazcon');
Route::delete('/deleteInterfazcon/{id}','App\Http\Controllers\Interfaz_contenidoController@deleteInterfazcon');

//Nuevas rutas
Route::get('interfaz/contenido/{params}', [InterfazController::class, 'getInterfazContenidos']);
