<?php

use App\Http\Controllers\Becas_nivel_bodyController;
use App\Http\Controllers\Becas_nivelController;
use App\Http\Controllers\BecasMaestriaDoctoradoController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ClausulasController;
use App\Http\Controllers\Convenios_especificosController;
use App\Http\Controllers\ConveniosController;
use App\Http\Controllers\Firma_emisorController;
use App\Http\Controllers\Firma_receptorController;
use App\Http\Controllers\FirmasController;
use App\Http\Controllers\Funcionalidad_usuarioController;
use App\Http\Controllers\FuncionalidadController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\Imagen_solicitudesController;
use App\Http\Controllers\Imagenes_conveniosController;
use App\Http\Controllers\Imagenes_interfacesController;
use App\Http\Controllers\Interfaz_contenidoController;
use App\Http\Controllers\InterfazController;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\MovilidadController;
use App\Http\Controllers\Nombre_tipoconvenioController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\SolicitudesController;
use App\Http\Controllers\UsuarioController;
use App\Models\firmas;
use App\Models\imagenes_solicitudes;
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
// Route::put('/updateTipo_con/{id}','App\Http\Controllers\Tipo_conController@updateTipo_con');//actualizar un registro
// Route::delete('/tipo_con/{id}','App\Http\Controllers\Tipo_conController@destroy');//eliminar un registro
// Route::delete('/deleteTipo_con/{id}','App\Http\Controllers\Tipo_conController@deleteTipo_con');//eliminar un registro

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

//Ruta para tabla funcionalidad
Route::get('/funcion','App\Http\Controllers\FuncionalidadController@getFuncionalidad');
Route::get('/funcion/{id}','App\Http\Controllers\FuncionalidadController@getFuncionalidadxid');
Route::post('/addFuncion','App\Http\Controllers\FuncionalidadController@insertFuncionalidad');
Route::put('/updateFuncion/{id}','App\Http\Controllers\FuncionalidadController@updateFuncionalidad');
Route::delete('/deleteFuncion/{id}','App\Http\Controllers\FuncionalidadController@deleteFuncionalidad');

//Ruta para tabla funcionalidad_usuario
Route::get('/fusuario','App\Http\Controllers\Funcionalidad_usuarioController@getFusuario');
Route::get('/fusuario/{id}','App\Http\Controllers\Funcionalidad_usuarioController@getFusuarioxid');
Route::post('/addFusuario','App\Http\Controllers\Funcionalidad_usuarioController@insertFusuario');
Route::put('/updateFusuario/{id}','App\Http\Controllers\Funcionalidad_usuarioController@updateFusuario');
Route::delete('/deleteFusuario/{id}','App\Http\Controllers\Funcionalidad_usuarioController@deleteFusuario');

//Ruta para tabla cargo
Route::get('/cargo','App\Http\Controllers\CargoController@getCargo');
Route::get('/cargo/{id}','App\Http\Controllers\CargoController@getCargoxid');
Route::post('/addCargo','App\Http\Controllers\CargoController@insertCargo');
Route::put('/updateCargo/{id}','App\Http\Controllers\CargoController@updateCargo');
Route::delete('/deleteCargo/{id}','App\Http\Controllers\CargoController@deleteCargo');

//Ruta para tabla cargo_usuario
Route::get('/cargou','App\Http\Controllers\Cargo_usuarioController@getCusuario');
Route::get('/cargou/{id}','App\Http\Controllers\Cargo_usuarioController@getCusuarioxid');
Route::post('/addCargou','App\Http\Controllers\Cargo_usuarioController@insertCusuario');
Route::put('/updateCargou/{id}','App\Http\Controllers\Cargo_usuarioController@updateCusuario');
Route::delete('/deleteCargou/{id}','App\Http\Controllers\Cargo_usuarioController@deleteCusuario');

//Ruta para tabla firma_emisor
Route::get('/femisor','App\Http\Controllers\Firma_emisorController@getFirmaemi');
Route::get('/femisor/{id}','App\Http\Controllers\Firma_emisorController@getFirmaemixid');
Route::post('/addFemisor','App\Http\Controllers\Firma_emisorController@insertFirmaemi');
Route::put('/updateFemisor/{id}','App\Http\Controllers\Firma_emisorController@updateFirmaemi');
Route::delete('/deleteFemisor/{id}','App\Http\Controllers\Firma_emisorController@deleteFirmaemi');

//Ruta para tabla firma_receptor
Route::get('/freceptor','App\Http\Controllers\Firma_receptorController@getFirmarec');
Route::get('/freceptor/{id}','App\Http\Controllers\Firma_receptorController@getFirmarecxid');
Route::post('/addFreceptor','App\Http\Controllers\Firma_receptorController@insertFirmarec');
Route::put('/updateFreceptor/{id}','App\Http\Controllers\Firma_receptorController@updateFirmarec');
Route::delete('/deleteFreceptor/{id}','App\Http\Controllers\Firma_receptorController@deleteFirmarec');

//Ruta para tabla historial_usuario
Route::get('/husuario','App\Http\Controllers\HistorialController@getHistorial');
Route::get('/husuario/{id}','App\Http\Controllers\HistorialController@getHistorialxid');
Route::post('/addHusuario','App\Http\Controllers\HistorialController@insertHistorial');
Route::put('/updateHusuario/{id}','App\Http\Controllers\HistorialController@updateHistorial');
Route::delete('/deleteHusuario/{id}','App\Http\Controllers\HistorialController@deleteHistorial');

//Ruta para tabla nombre_tipoconvenios
Route::get('/nombretc',[Nombre_tipoconvenioController::class, 'getNombre_tc']);
Route::get('/nombretc/{id}',[Nombre_tipoconvenioController::class, 'getNombre_tcxid']);
Route::post('/addNombretc',[Nombre_tipoconvenioController::class, 'insertNombre_tc']);
Route::put('/updateNombretc/{id}',[Nombre_tipoconvenioController::class, 'updateNombre_tc']);
Route::delete('/deleteNombretc/{id}',[Nombre_tipoconvenioController::class, 'deleteNombre_tc']);

//Ruta tabla personal de la UTM
Route::get('/personal', [PersonalController::class, 'getPersonal']);
Route::get('/personal/{id}', [PersonalController::class, 'getPersonalxid']);
Route::post('/addPersonal', [PersonalController::class, 'insertPersonal']);
Route::put('/updatePersonal', [PersonalController::class, 'updatePersonal']);
Route::delete('/deletePersonal', [PersonalController::class, 'deletePersonal']);


//Ruta de firmas
Route::get('firma-new', [FirmasController::class, 'getFirmas_new']);
Route::post('firma-new', [FirmasController::class, 'insertarFirmas']);

//Ruta para Imagenes_convenios

Route::get('imagen-convenio',[Imagenes_conveniosController::class, 'getImgcon']);
Route::get('imagen-convenio/{id}',[Imagenes_conveniosController::class, 'getImgconxid']);
Route::post('imagen-convenio/subir',[Imagenes_conveniosController::class, 'insertImgcon']);
Route::put('imagen-convenio/actualizar',[Imagenes_conveniosController::class, 'updateImgcon']);
Route::delete('imagen-convenio/eliminar/{id}',[Imagenes_conveniosController::class, 'deleteImgcon']);

//Ruta para Imagenes_interfaces

Route::get('imagen-interfaces',[Imagenes_interfacesController::class, 'getImginter']);
Route::get('imagen-interfaces/{id}',[Imagenes_interfacesController::class, 'getImginterxid']);
Route::post('imagen-interfaces/subir',[Imagenes_interfacesController::class, 'insertImginter']);
Route::put('imagen-interfaces/actualizar',[Imagenes_interfacesController::class, 'updateImginter']);
Route::delete('imagen-interfaces/eliminar/{id}',[Imagenes_interfacesController::class, 'deleteImginter']);

//Nuevas rutas
Route::get('interfaz/contenido/{params}', [InterfazController::class, 'getInterfazContenidos']);

//Rutas para usuario
Route::get('usuario/login/{personal_id}',[UsuarioController::class, 'loginsistema']);

Route::get('usuario/search/{id}', [UsuarioController::class, 'searchUser']);
Route::get('usuario/funcionalidad/{id}', [UsuarioController::class, 'getFuncionalidades']);

// Route::put('usuario/update', [UsuarioController::class, 'updateUsuario']);
// Route::post('usuario/upload-image', [UsuarioController::class, 'uploadImageServer']);
// Route::post('usuario/update-password', [UsuarioController::class, 'updatePassword']);
//Route::put('usuario/reset-password', [UsuarioController::class, 'actualizarContrasena']);

//Ruta para insertar convenios especificos y recuperar
Route::get('convenio-especifico/get', [Convenios_especificosController::class, 'getConvenios']);
Route::post('convenio-especifico/crear', [Convenios_especificosController::class, 'create']);

//Rutas para convenios
Route::post('convenio-new', [ConveniosController::class, 'create']);
Route::get('convenio-new/{tipo_documento}', [ConveniosController::class, 'getConveniosByTipoDocumento']);
Route::get('convenio-new/get/{id}', [ConveniosController::class, 'show']);
Route::post('convenio-new-guardado', [ConveniosController::class, 'guardar']);
Route::get('convenio/get/{id}',[ConveniosController::class,'findconvenio']);

Route::put('convenio/eliminar', [ConveniosController::class, 'eliminarConvenio']);
Route::put('convenio/update/aprobado', [ConveniosController::class, 'updateConveniosAprobados']);
Route::put('convenio/update/pdf', [ConveniosController::class, 'updatePDFURl']);
Route::put('convenio/all/update', [ConveniosController::class, 'updateAllConvenio']);

//Rutas para clausalas
Route::get('clausulas-new', [ClausulasController::class, 'getClausulas_v2']);
Route::post('clausulas-new', [ClausulasController::class, 'newClausala']);

//Enviar el correo
//Route::post('email/forget-password', [MailerController::class, 'forget_password']);

//Ruta para obtener nombre de tipo de convenios
Route::get('nombre-tipo-convenio', [Nombre_tipoconvenioController::class, 'get_nombre']);

//Ruta para pdf
Route::post('pdf/convenio', [PdfController::class, 'makePdfConvenios_v2']);
Route::get('archivo/{folder}/{file}', [PdfController::class, 'getFile']);

//Ruta para subir documento al servidor ftp
Route::post('documento/upload-document', [ConveniosController::class, 'uploadDocumentServer']);

// Eliminar los archivos del repositorio
Route::get('eliminar-archivo',[PdfController::class,'eliminarArchivos']);

//Subir imagen de carrusel
Route::post('imagen-carrusel',[InterfazController::class, 'subirImagenServidor'] );

//carrosel
Route::post('update/carrosel',[InterfazController::class, 'updateCarrosel']);
Route::put('delete/carrosel',[InterfazController::class, 'deleteCarrosel']);

//Ruta para subir documento al servidor ftp
Route::post('documento/mas-informacion', [Interfaz_contenidoController::class, 'subirDocumento']);
Route::post('documento/reglamento', [Interfaz_contenidoController::class, 'subirDocumento']);


//modificar la pagina Nosotros
Route::put('pagina-nosotros/update',[Interfaz_contenidoController::class,'updateNosotros']);

//modificar la pagina Convenios
Route::put('pagina-convenios/update',[Interfaz_contenidoController::class,'updateConvenio']);

//modificar la pagina Movilidad
Route::put('pagina-movilidad/update',[Interfaz_contenidoController::class,'updateMovilidad']);

//becas nivel
Route::post('pagina-becas/add',[Becas_nivelController::class,'create']);
Route::put('pagina-becas/update/estado',[Becas_nivelController::class,'updateEstado']);
Route::put('pagina-becas/update',[Becas_nivelController::class,'updatenombre']);

//becas nivel body
Route::get('pagina-becas-body/get/{id}',[Becas_nivel_bodyController::class,'getBecasnivelBody']);

// documentos de becas nivel body
Route::post('documento/Capacitaciones', [Becas_nivel_bodyController::class, 'subirDocumentoBecasCapacitaciones']);
Route::post('documento/Pregrado', [Becas_nivel_bodyController::class, 'subirDocumentoBecasPregrado']);
Route::post('documento/Investigacion', [Becas_nivel_bodyController::class, 'subirDocumentoBecasInvestigacion']);
Route::post('documento/Maestria', [Becas_nivel_bodyController::class, 'subirDocumentoBecasMaestria']);
Route::post('documento/Doctorado', [Becas_nivel_bodyController::class, 'subirDocumentoBecasDoctorado']);
//creacion 
Route::post('pagina-becas-body/add', [Becas_nivel_bodyController::class, 'create']);
Route::put('pagina-becas-body/update', [Becas_nivel_bodyController::class, 'edit']);
Route::put('pagina-becas-body/update/estado', [Becas_nivel_bodyController::class, 'updateEstado']);

//Nueva ruta para beca
Route::get('beca-v2/{tipo}', [Becas_nivelController::class, 'becas_v2']);


//Traer todo los datos que tengan rol estudiante
Route::get('rol-estudiante/{cedula}',[MovilidadController::class,'rol_estudiantes']);


//Traer todo los datos que no sean estudiantes
Route::get('roles',[MovilidadController::class,'roles']);
Route::get('rolesbecas',[BecasMaestriaDoctoradoController::class,'roles_becas_maestrias']);

//Ruta para inicio de Sesi??n
Route::post('login-UTM',[UsuarioController::class,'loginUTM']);

//Consultar Datos movilidad
Route::get('consulta-movilidad/{id}',[MovilidadController::class,'consultar']);

//Consultar Datos Becas
Route::get('consulta-becas/{id}',[BecasMaestriaDoctoradoController::class,'consultarbecas']);

//Usuario con acceso al sistema DRICN
Route::get('acceso-usuario',[UsuarioController::class,'usuarioDRICB']);

//Consultar Personal para obtener ID
Route::get('consulta-usuario/{cedula}',[UsuarioController::class,'consultarID']);

//Consultar tipo de modalidad y naturaleza, beca y monto
Route::get('modalidad/{tipo}',[MovilidadController::class,'modalidad']);
Route::get('naturaleza/{tipo}',[MovilidadController::class,'naturaleza']);
Route::get('apoyo/{tipo}',[MovilidadController::class,'becas']);
Route::get('monto/{tipo}',[MovilidadController::class,'monto']);
Route::get('alergias',[MovilidadController::class,'tipoalergias']);


//Obtener Universidades
Route::get('universidades',[MovilidadController::class,'universidad']);


//Obtener Beneficios
Route::get('beneficios/{id}',[BecasMaestriaDoctoradoController::class,'beneficios_naturaleza']);

//Subir Documentos de movilidad
Route::post('documento/movilidad', [MovilidadController::class, 'subirDocumentoMovilidad']);

//Subir Documentos de movilidad
Route::post('documentos/movilidad', [MovilidadController::class, 'subirDocumentosMovilidad']);
Route::post('documento/movilidad', [MovilidadController::class, 'subirDocumentoMovilidad']);

//Subir Documentos de becas
Route::post('documento/becas', [BecasMaestriaDoctoradoController::class, 'subirDocumentoBecas']);

//Solicitud Movilidad
Route::post('movilidad-new', [MovilidadController::class, 'addsolicitud']);
//solicitud Becas
Route::post('becas-new', [BecasMaestriaDoctoradoController::class, 'create_solicitud_becas']);

//Consultar Solicitud Movilidad
Route::get('solicitud-movilidad/{id}',[MovilidadController::class,'consultarMovilidad']);
//Consultar Solicitud Beca
Route::get('solicitud-beca/{id}',[BecasMaestriaDoctoradoController::class,'consultarBeca']);


//Obtener todos los datos de la solicitud de Becas
Route::get('solicitud/becas/{id}',[BecasMaestriaDoctoradoController::class,'beneficios']);
//Obtener todos los datos de la solicitud de movilidad
Route::get('solicitud/movilidad/{id}',[MovilidadController::class,'solicitudMovilidad']);

//Obtener todos los datos de la solicitud de movilidad y becas por tipo y estado
Route::get('consultar/solicitudes/{tipo}/{estado}',[MovilidadController::class,'consultarSolicitudes']);
Route::get('becas/solicitudes/{tipo}/{estado}',[BecasMaestriaDoctoradoController::class,'consultarSolicitudesBecas']);


Route::get('consultar/usuario/{cedula}',[UsuarioController::class,'consultarID']);


Route::post('ingresar/usuario',[UsuarioController::class,'insertarUsuario']);


Route::get('obtener/cargos',[CargoController::class,'obtenercargos']);

//Ruta para actualizar el estado de las solicitudes de movilidad y becas
Route::put('updatemovilidad/solicitud',[MovilidadController::class,'updateSolicitudMovilidad']);
Route::put('updatebecas/solicitud',[BecasMaestriaDoctoradoController::class,'updateSolicitudBecas']);


//Modificar el estado del usuario dentro del sistema DRICB
Route::put('update/usuario/dricb',[UsuarioController::class,'updateUsuario']);
Route::put('update/cargo/usuario',[UsuarioController::class,'updateCargo']);


//Consultar solicitudes aprobadas
Route::get('movilidad/s-aprobada/{estado}',[MovilidadController::class,'solicitudesAprobadas']);
Route::get('becas/s-aprobada/{estado}',[BecasMaestriaDoctoradoController::class,'solicitudesBecasAprobadas']);


//Subir documentos de solicitudes aprobadas
Route::post('subir/pdfsolicitudes',[SolicitudesController::class,'subirDocumentoMovilidadyBecas']);


//Actualizar estado del informe Final en S_Aprobadas
Route::put('actualizar/informe/s_aprobadas',[SolicitudesController::class,'actualizarAprobados']);


//consultar solicitud para poder editar(becas, movilidad)
Route::get('consultar/solicitud-editar/{tipo}/{id}/{tipo_solicitud}',[SolicitudesController::class,'consultarSolicitud']);


//actualizar solicitudes Movilidad
Route::put('actualizar-solicitud-movilidad',[MovilidadController::class,'updateSolicitudMovilidad_v2']);

//actualizar solicitudes Becas
Route::put('actualizar-solicitud-becas',[BecasMaestriaDoctoradoController::class,'updateSolicitudBecas_v2']);


//Obtener pdf de Solicitud de Movilidad
Route::get('pdf-solicitud/movilidad/{id}',[MovilidadController::class,'pdf_solicitudMovilidad']);


//Ruta para obtener todas los datos de la tabla imagenes_solicitudes
Route::get('imagen-solicitudes',[Imagen_solicitudesController::class, 'getImgSolicitudes']);

Route::put('update/imagen-solicitudes',[Imagen_solicitudesController::class, 'updateImagenSolicitudes']);

Route::put('delete/imagen-solicitudes',[Imagen_solicitudesController::class, 'deleteImagenSolicitudes']);

Route::post('imagen-solicitudes/subir',[Imagenes_interfacesController::class, 'insertImgsolicitudes']);

Route::put('update/imagen/solicitudes',[Imagen_solicitudesController::class, 'update']);


Route::get('historial',[HistorialController::class,'traerdatoshistorial']);

Route::get('historial/{id}',[HistorialController::class,'traerdatoshistorialxid']);

Route::get('prueba-historial/{id}',[HistorialController::class,'historialxid']);

//Usuarios registrados en el sistema DRICB
Route::get('usuarios/dricb',[UsuarioController::class,'UsuariosDRICB']);

//permisos usuario
Route::get('funcionalidad-usuario/{id}',[Funcionalidad_usuarioController::class,'getFuncionalidad']);

//actualizar estado de funcionalidad usuario
Route::post('update/funcionalidad-usuario',[Funcionalidad_usuarioController::class,'UpdateEstado']);

//obtener funcionalidades por nombre
Route::get('funcionalidad/nombre',[FuncionalidadController::class,'getFuncionalidad_v2']);

//agregar funcionalidad
Route::post('add/funcionalidad-usuario',[Funcionalidad_usuarioController::class,'agregarFuncionalidad']);
//generar reporte
Route::post('convenio/reporte/pdf', [PdfController::class, 'convenioReportePdf']);

//generar reporte becas
Route::post('becas/reporte/pdf', [PdfController::class, 'becasReportePdf']);

//generar reporte movilidad
Route::post('movilidad/reporte/pdf', [PdfController::class, 'movilidadReportePdf']);

//Obtener pdf de Solicitud de Movilidad
Route::post('pdf-solicitud/movilidad',[PdfController::class,'pdfSolicitudMovilidad']);

//Obtener pdf de Solicitud de Becas
Route::post('pdf-solicitud/becas',[PdfController::class,'pdfSolicitudBecas']);

Route::get('solicitudes/get/{id}',[SolicitudesController::class,'findsolicitudes']);