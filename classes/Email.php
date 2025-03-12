<?php

namespace Classes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token = null)
    {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function sendConfirmation()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom($_ENV['EMAIL_USER'], 'BeautyBook');
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirma tu cuenta';

        // SET HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->Body = "
    <html>
        <body style='font-family: Arial, Helvetica, sans-serif; background-color: #ffffff; max-width: 400px; margin: 0 auto; padding: 20px; text-align:center;'>
            <h1 style='color:#000;'>BeautyBook</h1>
            <h2 style='font-size:25px; font-weight:500; line-height:25px;'>¡Gracias por registrarte!</h2>
            <p style='line-height:18px;'>Hola, <strong>$this->nombre</strong>, por favor confirma tu correo electrónico para que puedas comenzar a disfrutar de todos los servicios de BeautyBook</p>
    
            <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'
            style='display:inline-block; background:#000; color:#fff; padding:10px 20px; text-decoration:none; font-weight:bold; border-radius:8px;'>
            Confirmar Cuenta
            </a>

            <p style='font-size:12px; text-align:left;'>Si tú no te registraste en BeautyBook, por favor ignora este correo electrónico.</p>
    
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td align='center' style='padding:20px; border-top:1px solid #000;'>
                    <p style='font-size:12px;'>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</p>
                    </td>
                </tr>
            </table>
        </body>
    </html>";

        //  ENVIAR EMAIL
        $mail->send();
    }


    public function enviarInstrucciones()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;


        $mail->setFrom($_ENV['EMAIL_USER'], 'BeautyBook');
        $mail->addAddress($this->email);
        $mail->Subject = 'Reestablece tu password';

        // SET HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif; background-color: #ffffff; max-width: 400px; margin: 0 auto; padding: 20px; text-align:center;'>
                <h1 style='color:#000;'>BeautyBook</h1>
                <h2 style='font-size:25px; font-weight:500; line-height:25px;'>¡Reestablecer password!</h2>
                <p style='line-height:18px; text-align:left;'>Hola, <strong>$this->nombre</strong>, Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo:</p>
                
                <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'
                style='display:inline-block; background:#000; color:#fff; padding:10px 20px; text-decoration:none; font-weight:bold; border-radius:8px;'>
                Reestablecer password
                </a>

                <p style='font-size:12px; text-align:left;'>Si tú no solicitaste este cambio, por favor ignora este correo electrónico.</p>
                
                <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-top:40px;'>
                    <tr>
                        <td align='center' style='padding:20px; border-top:1px solid #000;'>
                            <p style='font-size:12px;'>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>";

        //  ENVIAR EMAIL
        $mail->send();
    }






    public function enviarConfirmacionCita($fecha, $hora, $servicios)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASSWORD'];
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            // Configuración del correo
            $mail->setFrom($_ENV['EMAIL_USER'], 'BeautyBook');
            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Confirmación de tu cita en BeautyBook';

            // Convertir servicios a lista de texto
            $serviciosLista = implode(", ", $servicios);

            // Configuración HTML del correo
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $mail->Body = "
            <html>
                <body style='font-family: Arial, Helvetica, sans-serif; background-color: #ffffff; max-width: 400px; margin: 0 auto; padding: 20px; text-align: center;'>
                    <h1 style='color: #000;'>BeautyBook</h1>
                    <h2 style='font-size: 25px; font-weight: 500; line-height: 25px;'>¡Tu cita ha sido confirmada!</h2>
                    <p style='line-height: 18px; text-align: left;'>Hola <strong>{$this->nombre}</strong>, tu cita está agendada con los siguientes detalles:</p>
                    
                    <p style='line-height: 18px; text-align: left;'><strong>Fecha:</strong> {$fecha}</p>
                    <p style='line-height: 18px; text-align: left;'><strong>Hora:</strong> {$hora} Horas</p>
                    <p style='line-height: 18px; text-align: left;'><strong>Servicio/s:</strong> {$serviciosLista}</p>
                    
                    <p style='line-height: 18px; text-align: left;'>Si deseas modificar o cancelar tu cita, por favor contáctanos.</p>
                    
                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-top: 40px;'>
                        <tr>
                            <td align='center' style='padding: 20px; border-top: 1px solid #000;'>
                                <p style='font-size: 12px;'>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correos electrónicos entrantes. Por favor no respondas a este mensaje.</p>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>";            

            // Enviar correo
            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}
