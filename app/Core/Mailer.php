<?php

namespace App\Core;

class Mailer {
    public static function send(string $to, string $subject, string $htmlBody): bool {
        $smtpHost = env('SMTP_HOST', 'smtp.gmail.com');
        $smtpPort = (int)env('SMTP_PORT', 587);
        $smtpUser = env('SMTP_USERNAME', 'sales.vietnamuniquetravel@gmail.com');
        $smtpPass = env('SMTP_PASSWORD', '');
        $fromEmail = env('MAIL_FROM_ADDRESS', 'sales.vietnamuniquetravel@gmail.com');
        $fromName = env('MAIL_FROM_NAME', 'Vietnam Unique Travel');

        // Fallback using standard mail() if SMTP password is empty or default placeholder
        if (empty($smtpPass) || $smtpPass === 'demo_app_password' || $smtpPass === 'your_app_password_here') {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: {$fromName} <{$fromEmail}>" . "\r\n";
            $headers .= "Reply-To: {$fromEmail}" . "\r\n";

            return @mail($to, $subject, $htmlBody, $headers);
        }

        // Socket-based lightweight SMTP client
        try {
            $context = stream_context_create([
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
            ]);
            $socket = fsockopen(($smtpPort === 465 ? 'ssl://' : '') . $smtpHost, $smtpPort, $errno, $errstr, 15);
            if (!$socket) return false;

            self::readResponse($socket);
            fputs($socket, "EHLO " . gethostname() . "\r\n");
            self::readResponse($socket);

            if ($smtpPort === 587) {
                fputs($socket, "STARTTLS\r\n");
                self::readResponse($socket);
                stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                fputs($socket, "EHLO " . gethostname() . "\r\n");
                self::readResponse($socket);
            }

            fputs($socket, "AUTH LOGIN\r\n");
            self::readResponse($socket);
            fputs($socket, base64_encode($smtpUser) . "\r\n");
            self::readResponse($socket);
            fputs($socket, base64_encode($smtpPass) . "\r\n");
            self::readResponse($socket);

            fputs($socket, "MAIL FROM: <{$fromEmail}>\r\n");
            self::readResponse($socket);
            fputs($socket, "RCPT TO: <{$to}>\r\n");
            self::readResponse($socket);

            fputs($socket, "DATA\r\n");
            self::readResponse($socket);

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: {$fromName} <{$fromEmail}>\r\n";
            $headers .= "To: <{$to}>\r\n";
            $headers .= "Subject: {$subject}\r\n\r\n";

            fputs($socket, $headers . $htmlBody . "\r\n.\r\n");
            self::readResponse($socket);

            fputs($socket, "QUIT\r\n");
            fclose($socket);
            return true;
        } catch (\Throwable $t) {
            error_log("SMTP Error: " . $t->getMessage());
            return false;
        }
    }

    private static function readResponse($socket) {
        $response = "";
        while ($str = fgets($socket, 515)) {
            $response .= $str;
            if (substr($str, 3, 1) == " ") break;
        }
        return $response;
    }
}
