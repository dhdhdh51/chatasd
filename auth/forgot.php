<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$message = '';
if (request_method() === 'POST') {
    require_csrf();
    $email = sanitize_string($_POST['email']);
    $otp = random_int(100000, 999999);
    $_SESSION['otp'][$email] = $otp;
    send_system_email($config, $email, 'Password Reset OTP', '<p>Your OTP is <strong>' . $otp . '</strong></p>');
    $message = 'OTP sent to email.';
}
include __DIR__ . '/../includes/header.php'; ?>
<section class="section"><div class="container"><div class="glass card" style="max-width:480px;margin:auto"><h1>Forgot Password</h1><p><?= e($message) ?></p><form method="post"><input type="hidden" name="_token" value="<?= csrf_token() ?>"><input class="form-control" type="email" name="email" placeholder="Email"><br><button class="btn">Send OTP</button></form></div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
