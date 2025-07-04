<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class Mailer {
    public static function send($emailTo, $subject, $content, $attachment = null) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set DEBUG_SERVER for verbose output
            $mail->isSMTP();
            $mail->Host = 'mailpit'; // container name from docker-compose
            $mail->SMTPAuth = false;
            $mail->Port = 1025;

            // Sender and recipient
            $mail->setFrom('no-reply@trialapp.local', 'Trial App');
            $mail->addAddress($emailTo);
            $mail->addReplyTo('support@trialapp.local', 'Support');

            // Optional attachment
            if ($attachment !== null) {
                $mail->addAttachment($attachment);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $content;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }
}