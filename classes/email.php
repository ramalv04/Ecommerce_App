<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        //Crear el objeto de email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPAuth = true;
        
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . ",</strong> Has creado tu cuenta en app Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona Aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "Si tu no creaste esta cuenta, solo ignora este mensaje";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();

    }

    public function enviarInstrucciones() {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = $_ENV['EMAIL_HOST'];
                $mail->SMTPAuth = true;
                $mail->Port = $_ENV['EMAIL_PORT'];
                $mail->Username = $_ENV['EMAIL_USER'];
                $mail->Password = $_ENV['EMAIL_PASS'];
                $mail->SMTPAuth = true;
                
                $mail->setFrom('cuentas@ecommerceApp.com');
                $mail->addAddress($this->email, $this->nombre);
                $mail->Subject = 'Restablece tu password';
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
        
                $contenido = "<html><head><style>body {font-family: Arial, sans-serif;background-color: #f0f0f0;display: flex;justify-content: center;align-items: center;height: 100vh;}.container {background-color: #fff;padding: 20px;border-radius: 5px;box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);text-align: center;}a {display: inline-block;margin-top: 20px;padding: 10px 20px;color: #fff;background-color: #368BC1;border-radius: 5px;text-decoration: none;transition: background-color 0.3s ease;}a:hover {background-color: #2a6fb5;}</style></head><body><div class='container'><h2>EcommerceApp</h2><p><strong>Hola " . $this->nombre . ",</strong></p><p>Has solicitado restablecer tu password, sigue el siguiente enlace para hacerlo.</p><p><a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Restablecer Password</a></p><p>Si tu no solicistaste restablecer, solo ignora este mensaje</p></div></body></html>";
                
                $mail->Body = $contenido;
        
                //Enviar el email
                $mail->send();
    }

}