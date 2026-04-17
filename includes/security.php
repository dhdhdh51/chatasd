<?php
function init_csrf_token(): void
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

function csrf_token(): string
{
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(string $token): bool
{
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function require_csrf(): void
{
    if (request_method() === 'POST') {
        $token = $_POST['_token'] ?? '';
        if (!verify_csrf_token($token)) {
            http_response_code(419);
            exit('Invalid CSRF token.');
        }
    }
}

function sanitize_string(string $value): string
{
    return trim(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}
