<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'json-response.php';

$mail = new PHPMailer(true);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if(isset($_POST['token'])) {
  if($_POST['token'] == $_ENV['POST_TOKEN']) {
    try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = $_ENV['HOST_NAME'];                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = $_ENV['USER_NAME'];                     //SMTP username
      $mail->Password   = $_ENV['SMT_PASSWORD'];                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = $_ENV['PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom($_ENV['USER_NAME'], 'Mail API');
      $mail->addAddress($_POST['emailTo']);     //Add a recipient
	  $mail->addReplyTo($_POST['email'], $_POST['names']);

      //Content
      $mail->Subject = $_POST['subject'];
      $mail->Body    = $_POST['message'];

      $mail->send();
      echo json_response(200, 'Message has been sent');
    } catch (Exception $e) {
      echo json_response(500, "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
  }
  else
    echo json_response(401, 'Invalid token');
}
else
	echo json_response(401, 'No token');