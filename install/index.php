<?php
session_start();
if (file_exists(__DIR__ . '/.installed')) { header('Location: /auth/login.php?role=admin'); exit; }
$step = (int)($_GET['step'] ?? 1);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($step === 2) {
        $_SESSION['install_db'] = [
            'host' => $_POST['host'] ?? 'localhost',
            'name' => $_POST['name'] ?? '',
            'user' => $_POST['user'] ?? '',
            'pass' => $_POST['pass'] ?? '',
            'charset' => 'utf8mb4',
        ];
        header('Location: ?step=3');
        exit;
    }

    if ($step === 3) {
        $db = $_SESSION['install_db'] ?? null;
        $adminName = trim($_POST['admin_name'] ?? 'Super Admin');
        $adminEmail = trim($_POST['admin_email'] ?? 'admin@example.com');
        $adminPassword = $_POST['admin_password'] ?? 'admin12345';
        if (!$db) $errors[] = 'Database details missing.';

        if (!$errors) {
            try {
                $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $db['host'], $db['name'], $db['charset']);
                $pdo = new PDO($dsn, $db['user'], $db['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                $sql = file_get_contents(__DIR__ . '/../database/school_erp.sql');
                $pdo->exec($sql);

                $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:n,:e,:p,\'admin\')');
                $stmt->execute([
                    'n' => $adminName,
                    'e' => $adminEmail,
                    'p' => password_hash($adminPassword, PASSWORD_DEFAULT)
                ]);

                $config = "<?php\nreturn " . var_export([
                    'app' => [
                        'name' => 'NovaSchool ERP',
                        'base_url' => '',
                        'timezone' => 'Asia/Kolkata',
                        'session_name' => 'nova_school_session',
                    ],
                    'db' => $db,
                    'smtp' => [
                        'host' => 'smtp.example.com',
                        'port' => 587,
                        'username' => 'noreply@example.com',
                        'password' => 'change-me',
                        'encryption' => 'tls',
                        'from_email' => 'noreply@example.com',
                        'from_name' => 'NovaSchool ERP',
                    ],
                    'payu' => [
                        'key' => 'YOUR_PAYU_KEY',
                        'salt' => 'YOUR_PAYU_SALT',
                        'base_url' => 'https://secure.payu.in',
                    ],
                ], true) . ";\n";
                file_put_contents(__DIR__ . '/../config/config.php', $config);
                file_put_contents(__DIR__ . '/.installed', '1');

                header('Location: /auth/login.php?role=admin&installed=1');
                exit;
            } catch (Throwable $e) {
                $errors[] = $e->getMessage();
            }
        }
    }
}

$requirements = [
    'PHP 8.1+' => version_compare(PHP_VERSION, '8.1.0', '>='),
    'PDO extension' => extension_loaded('pdo_mysql'),
    'Writable /config' => is_writable(__DIR__ . '/../config'),
    'Writable /uploads' => is_writable(__DIR__ . '/../uploads'),
];
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Installer</title><link rel="stylesheet" href="/assets/css/app.css"></head><body>
<div class="container section">
    <div class="glass card">
        <h1>NovaSchool Installer</h1>
        <?php foreach ($errors as $error): ?><p style="color:#ff8c8c"><?= htmlspecialchars($error) ?></p><?php endforeach; ?>

        <?php if ($step === 1): ?>
            <h3>Step 1: Server Requirement Check</h3>
            <?php foreach ($requirements as $name => $ok): ?>
                <p><?= htmlspecialchars($name) ?>: <?= $ok ? '✅ OK' : '❌ Failed' ?></p>
            <?php endforeach; ?>
            <a class="btn" href="?step=2">Continue</a>
        <?php elseif ($step === 2): ?>
            <h3>Step 2: Database Configuration</h3>
            <form method="post">
                <input class="form-control" name="host" placeholder="DB Host" value="localhost" required><br>
                <input class="form-control" name="name" placeholder="DB Name" required><br>
                <input class="form-control" name="user" placeholder="DB User" required><br>
                <input class="form-control" type="password" name="pass" placeholder="DB Password"><br>
                <button class="btn">Save & Continue</button>
            </form>
        <?php else: ?>
            <h3>Step 3: Admin Account</h3>
            <form method="post">
                <input class="form-control" name="admin_name" placeholder="Admin Name" required><br>
                <input class="form-control" type="email" name="admin_email" placeholder="Admin Email" required><br>
                <input class="form-control" type="password" name="admin_password" placeholder="Password" required><br>
                <button class="btn">Install Now</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body></html>
