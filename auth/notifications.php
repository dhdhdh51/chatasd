<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$user = auth_user();
if (!$user) {
    exit('');
}
$rows = unread_notifications($pdo, (int)$user['id'], $user['role']);
foreach ($rows as $row) {
    echo '<div class="notice-item"><strong>' . e($row['title']) . '</strong><small>' . e($row['type']) . '</small></div>';
}
