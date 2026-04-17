<?php
function login_user(PDO $pdo, string $email, string $password, string $role): bool
{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND role = :role LIMIT 1');
    $stmt->execute(['email' => $email, 'role' => $role]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];
    return true;
}

function auth_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_role(string $role): void
{
    $user = auth_user();
    if (!$user || $user['role'] !== $role) {
        redirect('/auth/login.php?role=' . urlencode($role));
    }
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
