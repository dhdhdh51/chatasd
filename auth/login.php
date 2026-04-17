<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$role = $_GET['role'] ?? 'student';
$roles = ['admin','student','teacher','parent'];
if (!in_array($role, $roles, true)) $role = 'student';
$error = '';

if (request_method() === 'POST') {
    require_csrf();
    $role = $_POST['role'];
    if (login_user($pdo, sanitize_string($_POST['email']), $_POST['password'], $role)) {
        redirect('/' . $role . '/index.php');
    }
    $error = 'Invalid login credentials.';
}
include __DIR__ . '/../includes/header.php';
?>
<section class="section"><div class="container"><div class="glass card" style="max-width:500px;margin:auto"><h1><?= ucfirst($role) ?> Login Portal</h1>
<p>Secure access with premium UX and role-based dashboards.</p>
<?php if($error): ?><p style="color:#ff8c8c"><?= e($error) ?></p><?php endif; ?>
<form method="post"><input type="hidden" name="_token" value="<?= csrf_token() ?>"><input type="hidden" name="role" value="<?= e($role) ?>">
<input class="form-control" type="email" name="email" placeholder="Email" required><br>
<input class="form-control" type="password" name="password" placeholder="Password" required><br>
<button class="btn">Login Now</button></form>
<p style="margin-top:1rem">Switch: <?php foreach($roles as $r): ?><a href="?role=<?= $r ?>" class="btn secondary" style="margin:2px"><?= ucfirst($r) ?></a><?php endforeach; ?></p>
<a href="/auth/forgot.php">Forgot password (OTP)</a>
</div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
