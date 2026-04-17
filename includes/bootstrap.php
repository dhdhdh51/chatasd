<?php
$configPath = __DIR__ . '/../config/config.php';
if (!file_exists($configPath)) {
    header('Location: /install/index.php');
    exit;
}

$config = require $configPath;

date_default_timezone_set($config['app']['timezone'] ?? 'UTC');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name($config['app']['session_name'] ?? 'school_session');
    session_start();
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/seo.php';
require_once __DIR__ . '/notifications.php';
require_once __DIR__ . '/mail.php';
require_once __DIR__ . '/payu.php';

$pdo = db_connect($config['db']);
init_csrf_token();
