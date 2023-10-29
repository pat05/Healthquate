<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function sendMail($email, $name, $subject, $message)
{
    // Load .env file
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $sender_mail = $_ENV['SENDER_MAIL'];
    $host_mail = $_ENV['HOST_MAIL'];
    $port_mail = $_ENV['PORT_MAIL'];
    $password_mail = $_ENV['PASSWORD_MAIL'];
    $sender_name = $_ENV['SENDER_NAME'];

    $mail = new PHPMailer(true);
    // to debug
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = $host_mail;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $port_mail;
    $mail->Username = $sender_mail;
    $mail->Password = $password_mail;

    $mail->setFrom($sender_mail, $sender_name);
    $mail->addAddress($email, $name);

    $mail->Subject = $subject;
    $mail->Body = $message;
    if ($mail->send()) {
        echo "mail have been send successfully";
        return true;
    }
    echo "Failed to send email";
    return false;
}
