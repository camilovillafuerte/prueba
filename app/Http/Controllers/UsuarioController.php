<?php

namespace App\Http\Controllers;

use App\Models\cargo;
use App\Models\cargo_usuario;
use App\Models\funcionalidad_usuario;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use IlluminateSupportFacadesStorage;

class UsuarioController extends Controller{

    private $baseCtrl;

    public function __construct(){
        $this->baseCtrl = new BaseController();
    }

    public function login(Request $request){
        $usuarioData = (object)$request->usuario;
        $response = []; $encriptar = false;

        if(isset($usuarioData) && isset($usuarioData->correo) && isset($usuarioData->contrasena) ){
            $sesion = Usuario::where('correo', $usuarioData->correo)->first();
            // $encriptar = Hash::make($usuarioData->contrasena);

            if($sesion){
                if(Hash::check($usuarioData->contrasena, $sesion->contrasena)){
                    $response = [
                        'estado' => true,
                        'mensaje' => 'Acceso al sistema',
                        'usuario' => $sesion
                    ];
                }else{
                    $response = [
                        'estado' => false,
                        'mensaje' => 'Contraseña incorrecta'
                    ];
                }
            }else{
                $response = [
                    'estado' => false,
                    'mensaje' => 'El corre no existe'
                ];
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No ha enviado data'
            ];
        }

        return response()->json($response);
    }

    public function searchUser($cedula){
        $response = [];

        if(isset($cedula)){
            $exist = Usuario::where('cedula',$cedula)->first();
            $cargosId = cargo_usuario::select('cargos_id')->where('usuario_id', $exist->id)->get();
            $cargos = [];

            if($cargosId->count() > 0){
                foreach($cargosId as $c){
                    $auxCargo = cargo::where('cargos_id',$c->cargos_id)->first();
                    $cargos[] = $auxCargo;
                }
            }

            if($exist){
                $response = [
                    'estado' => true,
                    'mensaje' => 'Usuario existe',
                    'usuario' => $exist,
                    'cargos' => $cargos
                ];
            }else{
                $response = [
                    'estado' => false,
                    'mensaje' => 'La cédula no se encuentra',
                    'usuario' => false
                ];
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No hay data',
                'usuario' => false
            ];
        }

        return response()->json($response);
    }

    public function getFuncionalidades($cedula){

        $usuario = Usuario::where('cedula', $cedula)->first();
        $response = []; $funciones = [];

        if($usuario){
            $funcion_usuario = funcionalidad_usuario::where('usuario_id', $usuario->id)->get();

            if($funcion_usuario->count() > 0){

                foreach($funcion_usuario as $fu){
                    $fu->funcionalidad;
                }

                $response = [
                    'estado' => true,
                    'data' => $funcion_usuario
                ];

            }else{
                $response = [
                    'estado' => false,
                    'data' => []
                ];
            }
        }else{
            $response = [
                'estado' => false,
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function uploadImageServer(Request $request){

        if($request->hasFile('img_user')){
            $imagen = $request->file('img_user');

            $filenamewithextension = $imagen->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);                //Sin extension
            $extension = $request->file('img_user')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;

            Storage::disk('ftp')->put($filenametostore, fopen($request->file('img_user'), 'r+'));
           // $url = $this->baseCtrl->getUrlServer('/Contenido/ImagenesPerfil');

            $response = [
                'estado' => true,
               // 'imagen' => $url.$filenametostore,
                'mensaje' => 'La imagen se ha subido al servidor'
            ];
        }else{
            $response = [
                'estado' => false,
                'imagen' => '',
                'mensaje' => 'No hay un archivo para procesar'
            ];
        }

        return response()->json($response);
    }

    public function updateUsuario(Request $request){

        $user = (object)$request->usuario;

        if($user){
            $exisEmail = Usuario::where('correo', trim($user->correo))->first();

            $update = Usuario::find($user->id);

            $update->nombres = ucfirst(trim($user->nombres));
            $update->apellidos = ucfirst(trim($user->apellidos));
            $update->telefono = trim($user->telefono);
            $update->correo = trim($user->correo);
            $update->foto = $user->foto;

            if($exisEmail){ //Existe el correo
                //Verificar si el correo pertenece al usuario y pasa
                if($exisEmail->id === $user->id){
                    $update->save();

                    $response = [
                        'estado' => true,
                        'mensaje' => 'Datos del usuario actualizado',
                        'usuario' => $update
                    ];
                } else{
                    $response = [
                        'estado' => false,
                        'mensaje' => 'El correo ya se encuentra registrado',
                        'usuario' => false
                    ];
                }
            }else{  //No existe el correo

                $update->save();

                $response = [
                    'estado' => true,
                    'mensaje' => 'Datos del usuario actualizado',
                    'usuario' => $update
                ];
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para procesar',
                'usuario' => false
            ];
        }

        return response()->json($response);
    }

    public function updatePassword(Request $request){

        $datos = (object)$request->usuario;
        $usuario = false;   $response = [];

        $newPassword = $datos->nueva_clave;
        $oldPassword = $datos->anterior_clave;
        $id = $datos->id;

        $usuario = Usuario::find($id);

        if($usuario){

           //Verificar que la contraseña anterior es la correcta y actualizar
           if(Hash::check($oldPassword, $usuario->contrasena)){
            $usuario->contrasena = Hash::make($newPassword);
            $usuario->save();

            $response = [
                'estado' => true,
                'mensaje' => 'Contraseña actualizada'
            ];
           }else{
            $response = [
                'estado' => false,
                'mensaje' => 'La contraseña de verificación o anterior está incorrecta !!'
            ];
           }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'El usuario no existe'
            ];
        }

        return response()->json($response);
    }
}
