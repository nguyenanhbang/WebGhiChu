<?php
namespace App;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    /**
     * $to email người nhận
     * $name tên người nhận
     * $html html cần gửi
     */
    public static function send($to, $name, $subject, $text, $html)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;// Enable verbose debug output
            $mail->isSMTP();// gửi mail SMTP
            $mail->Host = Config::MAIL_DOMAIN;// Set the SMTP server to send through
            $mail->SMTPAuth = true;// Enable SMTP authentication
            $mail->Username = Config::MAIL_USER;// SMTP username
            $mail->Password = Config::MAIL_PASSWORD; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 587; // TCP port to connect to
        
            //Recipients
            $mail->setFrom(Config::MAIL_USER , Config::MAIL_DOMAIN);
            $mail->addAddress($to,$name); // Add a recipient
            // $mail->addAddress('ellen@example.com'); // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
        
            // Content
            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $html;
            $mail->AltBody = $text;
        
            $mail->send();
            //echo 'Message has been sent';

        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
