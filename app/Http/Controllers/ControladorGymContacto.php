<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'C:/xampp/htdocs/sistema/vendor/autoload.php';



require app_path().'/start/constants.php';

class ControladorGymContacto extends Controller
{
    public function index(){
        return view("web.contact");
    }


    public function submit(Request $request){
        $subject = $request->input('txtNombre');
        $correo = $request->input('txtCorreo');
        $body = $request->input('txtComentario');

        

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION');
        $mail->Port = env('MAIL_PORT');

        //Destinatarios
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($correo, $subject);
        $mail->addReplyTo(env('MAIL_NOREPLY'));
        //$mail->addBCC("");

        //Contenido del mail

        $mail->isHTML(true);
        $mail->Subject = utf8_decode("Contacto Move on Fit");
        $mail->Body = "Recibimos tu consulta, te responderemos a la brevedad";
        $mail->smtpConnect([
            'ssl' => [
                 'verify_peer' => false,
                 'verify_peer_name' => false,
                 'allow_self_signed' => true
             ]
         ]);
        $mail->send();
        if(!$mail->Send()){
            $msg =  "Error al enviar el correo.";
        } else{
        echo 'Mensaje enviado!';}
        $mail->ClearAllRecipients(); //Borra los destinatarios


        return view("web.contact");
    }

}