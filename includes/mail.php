<?php
/**
 * Lightweight PHPMailer-compatible adapter placeholder for shared hosting.
 * Replace with official PHPMailer classes in production if needed.
 */
class SimpleMailer
{
    public function __construct(private array $smtpConfig)
    {
    }

    public function send(string $to, string $subject, string $html): bool
    {
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: ' . ($this->smtpConfig['from_name'] ?? 'School ERP') . ' <' . ($this->smtpConfig['from_email'] ?? 'noreply@example.com') . '>',
        ];
        return mail($to, $subject, $html, implode("\r\n", $headers));
    }
}

function send_system_email(array $config, string $to, string $subject, string $message): bool
{
    $mailer = new SimpleMailer($config['smtp']);
    return $mailer->send($to, $subject, $message);
}
