<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller{

    protected $correoMatriz = '';
    protected $llaveMatriz = '';
    protected $email;
    protected $nombre;
    protected $titulo;

    public function __construct($email)
    {
        $this->email = $email;
        $this->correoMatriz = env('CORREMATRIZ');
        $this->llaveMatriz = env('LLAVEMATRIZ');
    }

    public function sendEmailForgetPassword($titulo, $mensaje, $enlace)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        $enviar = false;

        try {
            //Server settings
            /*  $mail->SMTPDebug = SMTP::DEBUG_SERVER;  */                //Enable verbose debug output
            $mail->isSMTP();                                             //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                        //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                    //Enable SMTP authentication
            $mail->Username   = $this->correoMatriz;                     //SMTP username
            $mail->Password   = $this->llaveMatriz;                      //SMTP password
            $mail->SMTPSecure = 'tls';                                   //Enable implicit TLS encryption
            $mail->Port       = 587;                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('soporte@gmail.com', utf8_decode('Recuperacion de contraseña'));
            $mail->addAddress($this->email, 'Usuario');              //Add a recipient

            $mail->addReplyTo('soporte@gmail.com', 'Recuperacion de contraseña');

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = utf8_decode($titulo);
            $content = '
            <div style="padding: 20px; with: 100%; margin: 0 auto;
            background-color: #f4f4f4;">
                <div style="width: 50%; background-color: #fff; margin:auto; padding:20px;
                border-radius:10px">
                   <div>
                        <h2>'.$titulo.'</h2>
                        <p style="font-size:1rem;">
                            '.$mensaje.'
                        </p>

                        <br>

                        <a href="'.$enlace.'" target="_blank" style="border: 1px solid green; border-radius:7px; padding:10px; color: green;">
                        Resetear password</a>
                   </div>

                   <br>
                   <div style="font-size:1rem;">
                    <small>Correo generado automáticamente</small>
                   </div>
                </div>
            </div>';

            $mail->Body = $content;

            $mail->send();
            $enviar = true;
        } catch (Exception $e) {
            $enviar = false;
            dd($e);
        }

        return $enviar;
    }

    public function enviarCorreo($titulo, $texto = '', $codigo = '')
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        $enviar = false;

        try {
            //Server settings
            /*  $mail->SMTPDebug = SMTP::DEBUG_SERVER;  */                //Enable verbose debug output
            $mail->isSMTP();                                             //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                        //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                    //Enable SMTP authentication
            $mail->Username   = $this->correoMatriz;                     //SMTP username
            $mail->Password   = $this->llaveMatriz;                      //SMTP password
            $mail->SMTPSecure = 'tls';                                   //Enable implicit TLS encryption
            $mail->Port       = 587;                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('soporte@gmail.com', utf8_decode('Recuperacion de contraseña'));
            $mail->addAddress($this->email, 'Usuario');              //Add a recipient

            $mail->addReplyTo('soporte@gmail.com', 'Recuperacion de contraseña');

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = utf8_decode($titulo);
            $mail->Body    = "Estimado propietario de la cuenta " . $this->email;

            $mail->send();
            $enviar = true;
        } catch (Exception $e) {
            $enviar = false;
            dd($e);
        }

        return $enviar;
    }
}
