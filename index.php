<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'json-response.php';


$mail = new PHPMailer(true);

if(isset($_POST['token'])) {
  if($_POST['token'] == 'fffad1e120d91edc688ab07699605c04') {
    try {
      $message = "Nombre completo: {$_POST['names']} \n
      Email: {$_POST['email']} \n
      Teléfono: {$_POST['phone']} \n
      Cédula: {$_POST['cedula']} \n
      Versión: {$_POST['version']} \n
      Concesionario: {$_POST['agency']} \n
      Industria: car  \n
      Origen: amplif";

      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'mail.administracionedificiosiad.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'webmaster@administracionedificiosiad.com';                     //SMTP username
      $mail->Password   = '80{EyyseBDnp';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom('webmaster@administracionedificiosiad.com', 'Mailer');
      $mail->addAddress('fabervergara@gmail.com', 'Joe User');     //Add a recipient

      //Content
      $mail->Subject = 'Sirena - Email Estándar';
      $mail->Body    = $message;

      $mail->send();
      json_response(200, 'Message has been sent');
    } catch (Exception $e) {
      json_response(500, "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
  }
}