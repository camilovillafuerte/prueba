<?php

namespace App\Http\Controllers;

use App\Models\cargo;
use App\Models\cargo_usuario;
use App\Models\funcionalidad_usuario;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use IlluminateSupportFacadesStorage;

class UsuarioController extends Controller{

    private $baseCtrl;

    public function __construct(){
        $this->baseCtrl = new BaseController();
    }

    public function loginUTM (Request $request) {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $password = $request->get('password');
        $email = $request->get('email');

        $info = DB::select("SELECT esq_roles.fnc_login_2_desarrollo(
            '" . $email . "',
            '" . $password . "',
            '',
            '',
            '',
            '',
            '',
            0,
            '') as data");

        $data = str_replace('"','',$info[0]->data);
        $data = str_replace('(','',$data);
        $data = str_replace(')','',$data);

        $info_split = explode(',', $data);

        if ($info_split[0] != "Ok.") {
            return response()->json([
                'error' => true,
                'error_text' => $info[0]->data
            ]);
        }
        $r_error = false;
        $r_idpersonal = $info_split[1];
        $r_cedula = $info_split[2];
        $r_nombres = $info_split[3];
        $r_password_changed = $info_split[4];
        $r_mail_alternativo = $info_split[5];
        $r_fecha = $info_split[6];
        $r_idfichero_hoja_vida_foto = $info_split[7];
        $r_conexion = $info_split[8];

        $r_roles = explode('*', $r_conexion);

        $r_roles_proc = [];

        foreach ($r_roles as $rol) {
            $r_rol = explode('|', $rol);
            $id_rol_raw = explode(':', $r_rol[count($r_rol) -2 ]);
            $id_rol = end($id_rol_raw);

            $escuelas_raw = explode(':', $rol);

            $rolJson = [
                'id' => $id_rol,
                'nombre' => $r_rol[count($r_rol) -1 ],
                'escuelas' => explode('|', $escuelas_raw[ 1 ]),
                'modalidad' => $id_rol_raw[ 0 ],
                'conexion' => $r_rol[ 0 ]
            ];
            array_push($r_roles_proc, $rolJson);
        }

        $jsonRespuesta = [
            'error' => $r_error,
            'id_personal' => $r_idpersonal,
            'cedula' => $r_cedula,
            'nombres' => $r_nombres,
            'password_changed' => $r_password_changed,
            'mail_alternativo' => $r_mail_alternativo,
            'fecha' => $r_error,
            'fichero_hoja_de_vida_foto' => $r_idfichero_hoja_vida_foto,
            'conexion' => $r_conexion,
            'roles' => $r_roles_proc
        ];
        return response()->json($jsonRespuesta);
    }

    public function loginsistema($id)
    {
        $sesion = Usuario::where('personal_id', $id)->first();
        if($sesion)
        {
            $response = [
                'estado' => true,
                'mensaje' => 'Acceso al sistema',
                'usuario'=>$sesion
            ];

        }
        else{
            $response = [
                'estado' => false,
                'mensaje' => 'Usted no tiene acceso al sistema DRICB',
            ];

        }
        return response()->json($response);

    }
    
    /*public function login(Request $request){
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
*/
    public function searchUser($id){
        $response = [];

        if(isset($cedula)){
            $exist = Usuario::where('id',$id)->first();
            if($exist){
                $cargosId = cargo::select('cargo')->where('cargos_id', $exist->cargos_id)->get();
                $response = [
                    'estado' => true,
                    'mensaje' => 'Usuario existe',
                    'usuario' => $exist,
                    'cargos' => $cargosId
                ];
            }else{
                $response = [
                    'estado' => false,
                    'mensaje' => 'El usuario no se encuentra ',
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

    public function getFuncionalidades($id){

        $usuario = Usuario::where('id', $id)->first();
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

    /*
    public function uploadImageServer(Request $request){

        if($request->hasFile('img_user')){
            $imagen = $request->file('img_user');

            $filenamewithextension = $imagen->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);            //Sin extension
            $extension = $request->file('img_user')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;

            Storage::disk('ftp')->put($filenametostore, fopen($request->file('img_user'), 'r+'));

           $url = $this->baseCtrl->getUrlServer('Contenido/ImagenesPerfil/');

            $response = [
                'estado' => true,
                'imagen' => $url.$filenametostore,
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
    */

   /* public function updateUsuario(Request $request){

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
                        'mensaje' => 'El correo se ha actualizado',
                        'usuario' => $update,
                        'email' => true
                    ];
                } else{
                    $response = [
                        'estado' => false,
                        'mensaje' => 'El correo ya se encuentra registrado',
                        'usuario' => false,
                        'email' => false
                    ];
                }
            }else{  //No existe el correo

                $update->save();

                $response = [
                    'estado' => true,
                    'mensaje' => 'Datos del usuario actualizado',
                    'usuario' => $update,
                    'email' => false
                ];
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para procesar',
                'usuario' => false,
                'email' => false
            ];
        }

        return response()->json($response);
    }
    */

    /*public function updatePassword(Request $request){

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

    public function actualizarContrasena(Request $request){

        $response = [];
        $data = (object)$request->credenciales;
        $data->token = trim($data->token);

        //Buscar usuario
        $usuario = Usuario::where('token', $data->token)->first();

        if($usuario){
            $encriptar = Hash::make($data->contrasena);

            if($usuario->token){
                $usuario->contrasena = $encriptar;
                $usuario->token = null;
                $usuario->save();

                $response = [
                    'estado' => true,
                    'mensaje' => 'La contraseña ha sido actualizada !!'
                ];
            }else{
                $usuario->token = null;
                $usuario->save();

                $response = [
                    'estado' => false,
                    'mensaje' => 'No es posible actualizar la contraseña, vuelva a intentarlo !'
                ];
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'El usuario no tiene permiso para actualizar la contraseña !!'
            ];
        }

        return response()->json($response);
    }
    */
}
