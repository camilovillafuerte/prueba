<?php

namespace App\Http\Controllers;

use App\Models\funcionalidad_usuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller{

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

            if($exist){
                $response = [
                    'estado' => true,
                    'mensaje' => 'Usuario existe',
                    'usuario' => $exist
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
                    'estado' => false,
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
}
