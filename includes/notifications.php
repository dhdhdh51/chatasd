<?php
function push_notification(PDO $pdo, int $userId, string $role, string $title, string $message, string $type = 'info'): void
{
    $stmt = $pdo->prepare('INSERT INTO notifications (user_id, role, title, message, type, is_read, created_at) VALUES (:uid, :role, :title, :msg, :type, 0, NOW())');
    $stmt->execute([
        'uid' => $userId,
        'role' => $role,
        'title' => $title,
        'msg' => $message,
        'type' => $type,
    ]);
}

function unread_notifications(PDO $pdo, int $userId, string $role): array
{
    $stmt = $pdo->prepare('SELECT * FROM notifications WHERE (user_id = :uid OR role = :role) AND is_read = 0 ORDER BY created_at DESC LIMIT 10');
    $stmt->execute(['uid' => $userId, 'role' => $role]);
    return $stmt->fetchAll();
}
