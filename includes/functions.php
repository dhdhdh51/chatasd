<?php
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function request_method(): string
{
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
}

function old(string $key, mixed $default = ''): mixed
{
    return $_POST[$key] ?? $default;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $value;
}

function generate_student_id(PDO $pdo): string
{
    $count = (int) $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
    return 'STD' . date('Y') . str_pad((string)($count + 1), 4, '0', STR_PAD_LEFT);
}

function app_setting(PDO $pdo, string $key, string $fallback = ''): string
{
    $stmt = $pdo->prepare('SELECT setting_value FROM settings WHERE setting_key = :k LIMIT 1');
    $stmt->execute(['k' => $key]);
    return $stmt->fetchColumn() ?: $fallback;
}
