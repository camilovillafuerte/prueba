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
use PhpParser\Node\Stmt\ElseIf_;

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

<<<<<<< HEAD
    public function loginsistema($personal_id)
    {
        $sesion = Usuario::where('personal_id', $personal_id)->first();
        if($sesion)
        {
=======
    public function loginsistema($id)
    {
        $sesion = Usuario::where('personal_id', $id)->first();
<<<<<<< HEAD
        if($sesion){
>>>>>>> 8cc91f21ba4ac9bb391673171011503e4e0a331f
=======
        if ($sesion) {
>>>>>>> 9ff39e67713aa2dcd74a829cea7c7816be5956bc
            $response = [
                'estado' => true,
                'tipo' => 'I',
                'mensaje' => 'Acceso al sistema',
                'usuario' => $sesion
            ];
        } else {
            $consulta2 =$this->verificarDocente($id);
            if ($consulta2) {
                $response = [
                    'estado' => true,
                    'tipo' => 'B',
                    'mensaje' => 'Acceso al sistema Becas',
                ];
            } else {
                    $response = [
                        'estado' => true,
                        'tipo' => 'M',
                        'mensaje' => 'Acceso al sistema Movilidad',
                    ];
            }
        }
        return response()->json($response);
    }



    
    // public function login(Request $request){
    //     $usuarioData = (object)$request->usuario;
    //     $response = []; $encriptar = false;

    //     if(isset($usuarioData) && isset($usuarioData->correo) && isset($usuarioData->contrasena) ){
    //         $sesion = Usuario::where('correo', $usuarioData->correo)->first();
    //         // $encriptar = Hash::make($usuarioData->contrasena);

    //         if($sesion){
    //             if(Hash::check($usuarioData->contrasena, $sesion->contrasena)){
    //                 $response = [
    //                     'estado' => true,
    //                     'mensaje' => 'Acceso al sistema',
    //                     'usuario' => $sesion
    //                 ];
    //             }else{
    //                 $response = [
    //                     'estado' => false,
    //                     'mensaje' => 'Contraseña incorrecta'
    //                 ];
    //             }
    //         }else{
    //             $response = [
    //                 'estado' => false,
    //                 'mensaje' => 'El corre no existe'
    //             ];
    //         }
    //     }else{
    //         $response = [
    //             'estado' => false,
    //             'mensaje' => 'No ha enviado data'
    //         ];
    //     }

    //     return response()->json($response);
    // }

    public function searchUser($id){
        $response = [];

        if(isset($id)){
            $exist = Usuario::where('id',$id)->first();
            if($exist){
                $cargosId = cargo::select('cargo')->where('cargos_id', $exist->cargos_id)->get();
                $response = [
                    'estado' => true,
                    'mensaje' => 'Usuario existe',
                    'usuario' => $exist,
                    'cargos' => $cargosId,
                ];
            }else{
                $response = [
                    'estado' => false,
                    'mensaje' => 'el usuario no se encuentra',
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

    public function usuarioDRICB(){
    $consulta=DB::select("select p.cedula, (p.apellido1 || ' ' || p.apellido2)as Apellidos, p.nombres, c.cargo, u.id, u.estado, c.cargos_id 
    from esq_datos_personales.personal p
    join esq_dricb.usuarios u  on u.personal_id = p.idpersonal
    join esq_dricb.cargos c on c.cargos_id = u.cargos_id 
    order by p.apellido1 ASC"); 
    if($consulta){
        $response=[
            'estado'=> true,
            'datos'=> $consulta,
        ];
    }else{
        $response=[
            'estado'=> false,
            'mensaje'=> 'Este usuario no esta registrado en el sistema'
        ];

    }
    return response()->json($response);

}
    
    //esto debe relacionarse a nuestro sistema
    public function consultarID($cedula){
        if(isset($cedula)){
        $consulta=DB::table('esq_datos_personales.personal')
        ->select ('personal.idpersonal', 'personal.cedula','personal.apellido1','personal.apellido2','personal.nombres')
        ->where ('personal.cedula',$cedula)
        -> first();

        if($consulta){
            $usuario=Usuario::where('personal_id',$consulta->idpersonal)->first();
            if($usuario)
            {
                $response=[
                    'estado'=> false,
                    'mensaje'=> 'Usuario se encuentra dentro del sistema DRICB'
                ];
            }
            else
            {
                $response=[
                    'estado'=> true,
                    'datos'=> $consulta
                ];

            } 
    }else{
                $response=[
                    'estado'=> false,
                    'mensaje'=> 'Usuario no existe en el sistema'
                ];
        }
    }
    else{
            $response=[
                'estado'=> false,
                'mensaje'=> 'No hay datos',
            ];
        }
        return response()->json($response);

    }



    public function insertarUsuario(Request $request){
        $data = (object)$request->data;
        //usuario
        $newusuario =new Usuario();
        $newusuario->personal_id=intval($data ->idpersonal);
        $newusuario->cargos_id=intval($data ->idcargos);
        $newusuario->estado="A";
        $newusuario->save();
        
        $response=[
            'estado'=>true,
            'mensaje' =>'Se ingreso el usuario al sistema' 
        ];

        return response()->json($response);

    }

    public function updateUsuario(Request $request){
        $data= (object) $request->data;
        $usuario=Usuario::where('id',intval($data->id))->first();
        if($usuario){
            $usuario->estado=trim($data->estado);
            $usuario->save();
            $response=[
                'estado'=>true,
                'mensaje'=>'Se actualizo correctamente el usuario'
            ];
        }else{
            $response=[
                'estado'=>false,
                'mensaje'=>'No se encontro el usuario'
            ];
        }
        return response()->json($response);

    }

    public function updateCargo(Request $request){
        $data=(object) $request->data;
        $usuario=Usuario::where('id',intval($data->id))->first();
        if($usuario){
            $usuario->cargos_id=intval($data->cargos_id);
            $usuario->save();
            $response=[
                'estado'=>true,
                'mensaje'=>'Se actualizo correctamente el cargo del usuario'
            ];
        }else{
            $response=[
                'estado'=>false,
                'mensaje'=>'No se encontro el cargo'
            ];
        }
        return response()->json($response);
    }

    public function consultarEstudiante($id){

        $consultaes = DB::table('esq_datos_personales.personal')
        ->join('esq_catalogos.tipo','esq_datos_personales.personal.idtipo_nacionalidad','=','esq_catalogos.tipo.idtipo')
        ->join('esq_catalogos.tipo as t1','esq_datos_personales.personal.idtipo_estado_civil','=','t1.idtipo')
        ->join('esq_catalogos.tipo as t2','esq_datos_personales.personal.idtipo_sangre','=','t2.idtipo')
        ->join('esq_catalogos.tipo as t3','esq_datos_personales.personal.idtipo_discapacidad','=','t3.idtipo')
        ->join('esq_catalogos.ubicacion_geografica','esq_datos_personales.personal.idtipo_pais_residencia','=','esq_catalogos.ubicacion_geografica.idubicacion_geografica')
        ->join('esq_catalogos.ubicacion_geografica as u1','esq_datos_personales.personal.idtipo_provincia_residencia','=','u1.idubicacion_geografica')
        ->join('esq_catalogos.ubicacion_geografica as u2','esq_datos_personales.personal.idtipo_canton_residencia','=','u2.idubicacion_geografica')
        
        ->select('personal.idpersonal','personal.cedula', 'personal.apellido1', 'personal.apellido2','personal.nombres','personal.fecha_nacimiento',
        'tipo.nombre as Nacionalidad','personal.genero','personal.residencia_calle_1', 'personal.residencia_calle_2', 'personal.residencia_calle_3',
        'personal.correo_personal_institucional','personal.correo_personal_alternativo', 't1.nombre as Estado_civil',
        'ubicacion_geografica.nombre as Pais', 'u1.nombre as Provincia','u2.nombre as Canton',
        'personal.telefono_personal_domicilio', 'personal.telefono_personal_celular', 't2.nombre as Tipo_Sangre', 't3.nombre as Nombre_Discapacidad',
        'personal.contacto_emergencia_apellidos','personal.contacto_emergencia_nombres',
        'personal.contacto_emergencia_telefono_1','personal.contacto_emergencia_telefono_2'
        )
        -> where ('esq_datos_personales.personal.idpersonal', $id)
        
        -> first();
        if($consultaes){
        $consulta2 = DB::table('esq_roles.tbl_personal_rol')
        ->join('esq_roles.tbl_rol','esq_roles.tbl_personal_rol.id_rol','=','esq_roles.tbl_rol.id_rol')
        ->join('esq_datos_personales.personal','esq_datos_personales.personal.idpersonal','=','esq_roles.tbl_personal_rol.id_personal')
        ->select('tbl_rol.id_rol','tbl_rol.descripcion as Rol', 'tbl_personal_rol.fecha')
        ->where('personal.idpersonal','=',$consultaes->idpersonal)
        ->where('tbl_rol.estado','=','S')
        ->orderBy('tbl_personal_rol.fecha','DESC')
        
        ->get();
        
        $consultaes->roles=$consulta2;
        $verificar=0;
        $egresado=0;
        $graduado=0;
        
        foreach($consulta2 as $rol){
            $rolObj=(Object) $rol;
            if($rolObj->Rol=='ESTUDIANTE'){
                $consultaDocente=$this->verificarDocente($consultaes->idpersonal);
                if($consultaDocente)
                {
                 $response=[
                     'estado'=> false,
                     'mensaje' =>'Usted no es un Estudiante' 
                 ];
                }
                 else{
                    // consultar utlimo promedio, carrera que estudia y ultimo periodo
                    $semestre=$this->consultarPeriodo($consultaes->idpersonal);
                    if($semestre){
                        $consultaes->carrera=$semestre;
                        // $consulta->carrera=$semestre->escuela_nombre;
                        // $consulta->promedio=$semestre->promedio;
                       return  $consultaes;
                        // $response=[
                        //      'estado'=> true,
                        //      'usuario' => $consultaes
                        //  ];
            
                    }
                    else{
                        $response=[
                            'estado'=> false,
                            'mensaje' => 'Usted no puede solicitar este tipo de becas'
            
                        ];
                    }
                }
         
                
                $verificar=1;
            }
            else if($rolObj->Rol=='EGRESADO'){
                $egresado=1;
        
            }
            else if($rolObj->Rol=='GRADUADO'){
               $graduado=1;
            }
        }
        if($verificar==0 || $egresado==1 || $graduado==1)
        $response=[
            'estado'=> false,
            'mensaje' => 'Usted no forma parte de los Estudiantes de UTM'
        
        ];
        } else{
            $response= [
                'estado'=> false,
                'mensaje' => 'Usted no pertenece a la UTM'
            ];
        
        }
        
        return response()->json($response);
        
        }
        
        
        public function verificarDocente($id){
            $consultaver= DB::select("select f.idfacultad, f.nombre facultad, d.iddepartamento, d.nombre departamento, dd.idpersonal, p.apellido1 || ' ' || p.apellido2 || ' ' || p.nombres nombres
             from esq_distributivos.departamento d
             join esq_inscripciones.facultad f 
                 on d.idfacultad = f.idfacultad
                 and not f.nombre = 'POSGRADO'
                 and not f.nombre = 'CENTRO DE PROMOCIÓN Y APOYO AL INGRESO'
                 and not f.nombre = 'INSTITUTO DE INVESTIGACIÓN'
                 and d.habilitado = 'S'
             join esq_distributivos.departamento_docente dd
                 on dd.iddepartamento = d.iddepartamento
             join esq_datos_personales.personal p 
                 on dd.idpersonal = p.idpersonal
             where p.idpersonal = ".$id."
             order by d.idfacultad, d.iddepartamento, p.idpersonal");
             return $consultaver;
         
         }
        
       

         public function consultarDocente($id){

            $consultadoc = DB::table('esq_datos_personales.personal')
            ->join('esq_catalogos.tipo','esq_datos_personales.personal.idtipo_nacionalidad','=','esq_catalogos.tipo.idtipo')
            ->join('esq_catalogos.tipo as t1','esq_datos_personales.personal.idtipo_estado_civil','=','t1.idtipo')
            ->join('esq_catalogos.tipo as t2','esq_datos_personales.personal.idtipo_sangre','=','t2.idtipo')
            ->join('esq_catalogos.ubicacion_geografica','esq_datos_personales.personal.idtipo_pais_residencia','=','esq_catalogos.ubicacion_geografica.idubicacion_geografica')
            ->join('esq_catalogos.ubicacion_geografica as u1','esq_datos_personales.personal.idtipo_provincia_residencia','=','u1.idubicacion_geografica')
            ->join('esq_catalogos.ubicacion_geografica as u2','esq_datos_personales.personal.idtipo_canton_residencia','=','u2.idubicacion_geografica')
            
            ->select('personal.idpersonal','personal.cedula', 'personal.apellido1', 'personal.apellido2','personal.nombres','personal.fecha_nacimiento',
            'tipo.nombre as Nacionalidad','personal.genero','personal.residencia_calle_1', 'personal.residencia_calle_2', 'personal.residencia_calle_3',
            'personal.correo_personal_institucional','personal.correo_personal_alternativo', 't1.nombre as Estado_civil',
            'ubicacion_geografica.nombre as Pais', 'u1.nombre as Provincia','u2.nombre as Canton',
            'personal.telefono_personal_domicilio', 'personal.telefono_personal_celular', 't2.nombre as Tipo_Sangre',
            'personal.contacto_emergencia_apellidos','personal.contacto_emergencia_nombres',
            'personal.contacto_emergencia_telefono_1','personal.contacto_emergencia_telefono_2'
            )
            -> where ('esq_datos_personales.personal.idpersonal', $id)
            
            -> first();
            if($consultadoc){
            $consulta2 = DB::table('esq_roles.tbl_personal_rol')
            ->join('esq_roles.tbl_rol','esq_roles.tbl_personal_rol.id_rol','=','esq_roles.tbl_rol.id_rol')
            ->join('esq_datos_personales.personal','esq_datos_personales.personal.idpersonal','=','esq_roles.tbl_personal_rol.id_personal')
            ->select('tbl_rol.id_rol','tbl_rol.descripcion as Rol', 'tbl_personal_rol.fecha')
            ->where('personal.idpersonal','=',$consultadoc->idpersonal)
            ->where('tbl_rol.estado','=','S')
            ->orderBy('tbl_personal_rol.fecha','DESC')
            
            ->get();
        
            
            $consultadoc->roles=$consulta2;
            $verificar=0;
            foreach($consulta2 as $rol){
                $rolObj=(Object) $rol;
                if($rolObj->Rol=='ESTUDIANTE'){
                    $consultaDocente=$this->verificarDocente($consultadoc->idpersonal);
                    if($consultaDocente)
                    {
                        $verificar=0;
                    }
                    else
                    {
                        $response=[
                            'estado'=> false,
                            'mensaje' => 'Usted no puede solicitar una Beca'
    
                        ];
                        $verificar=1;
    
                    }
                }
               
            }
            if($verificar==0){
                $consultaDocente2=$this->verificarDocente($consultadoc->idpersonal);
                if($consultaDocente2)
                {
                    return  $consultadoc;
                //       $response=[
                //      'estado'=> true,
                //      'usuario' => $consultadoc
                //     ];
                 }
                else{
                    $response=[
                        'estado'=> false,
                        'mensaje' => 'Usted no puede solicitar una Beca'
    
                    ];
                }
    
    
            }
            
          
            } else{
                $response= [
                    'estado'=> false,
                    'mensaje' => 'Usted no pertenece a la UTM'
                ];
            
            }
            
            return response()->json($response);
            
            } 

            public function consultarPeriodo($idpersonal){
                $consulta3 = DB::select("select es.idescuela,es.nombre as Escuela_Nombre,pa.nombre as PERIODO ,i.prom_s as Promedio, m.nombre as Semestre
                from esq_inscripciones.inscripcion i
                join  esq_inscripciones.escuela es on  i.idescuela = es.idescuela 
                join esq_periodos_academicos.periodo_academico pa on pa.idperiodo=i.idperiodo 
                join esq_mallas.nivel m on i.idnivel=m.idnivel 
                where i.idpersonal = ".$idpersonal." and pa.actual  = 'S'
                order by pa.idperiodo DESC");
                $i=0;
                $consulta4=json_decode(json_encode($consulta3));
                // foreach($consulta4 as $per){
                // $periObj=(Object) $per;
                // if($i==0)
                // {
                //     $response=$periObj;
                //     return $response;
                // }
                // $i++;
                // }
            
                return ($consulta4);
                }
            

}

