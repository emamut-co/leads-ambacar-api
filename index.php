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
      $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'user@example.com';                     //SMTP username
      $mail->Password   = 'secret';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom('from@example.com', 'Mailer');
      $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
      $mail->addAddress('ellen@example.com');               //Name is optional
      $mail->addReplyTo('info@example.com', 'Information');
      $mail->addCC('cc@example.com');
      $mail->addBCC('bcc@example.com');

      //Content
      $mail->Subject = 'Here is the subject';
      $mail->Body    = $message;

      $mail->send();
      json_response(200, 'Message has been sent');
    } catch (Exception $e) {
      json_response(500, "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
  }
}