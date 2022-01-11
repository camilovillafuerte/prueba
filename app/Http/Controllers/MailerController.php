<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class MailerController extends Controller{

    private $mailController;
    private $urlFront = "http://localhost:4200/auth/recuperarclave/";

    public function __construct(){ }

    public function forget_password(Request $request){

        $email = trim($request->email);
        $response = [];

        $existeEmail = Usuario::where('correo', $email)->first();

        if($existeEmail){
            $this->mailController = new MailController($email);
            $token = Hash::make($existeEmail->id.date('Y-m-d H:i:s'));
            $token = str_replace("/", "", $token);

            $existeEmail->token = $token;
            $existeEmail->save();

            $mensaje = "Usted ha olvidado su contraseña, este correo ha sido generado para reestablecer y actualizar sus credenciales";
            $enlace = $this->urlFront.$token;
            $exito = $this->mailController->sendEmailForgetPassword('Generación de enlace', $mensaje, $enlace);

            if(true){
                $response = [
                    'estado' => $exito,
                    'mensaje' => 'Correo enviado !!',
                    'email' => $email
                ];
            }else{
                $response = [
                    'estado' => $exito,
                    'mensaje' => 'No se pudo enviar el correo !!',
                    'email' => $email
                ];
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'El correo no existe !!',
                'email' => $email
            ];
        }

        return response()->json($response);
    }
}
