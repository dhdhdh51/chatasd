<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_role('admin');
$user = auth_user();
$students = (int)$pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
$teachers = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='teacher'")->fetchColumn();
$feesPending = (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM fees WHERE status='pending'")->fetchColumn();
if (request_method()==='POST' && isset($_POST['broadcast'])) { require_csrf(); push_notification($pdo, 0, 'student', 'Admin Broadcast', sanitize_string($_POST['broadcast']), 'announcement'); }
include __DIR__ . '/../includes/header.php';
?>
<div class="sidebar-layout">
<aside class="sidebar glass" id="adminSidebar"><h3>Admin Panel</h3><nav class="menu"><a class="active" href="/admin/index.php"><i class="fa fa-chart-pie"></i> Dashboard</a><a href="/admin/students.php"><i class="fa fa-user-graduate"></i> Students</a><a href="/admin/exams.php"><i class="fa fa-file-lines"></i> Exams & Marks</a><a href="/admin/fees.php"><i class="fa fa-money-bill-wave"></i> Fees</a><a href="/admin/content.php"><i class="fa fa-globe"></i> Website CMS</a><a href="/auth/logout.php"><i class="fa fa-right-from-bracket"></i> Logout</a></nav></aside>
<main class="content"><button class="btn mobile-toggle" data-mobile-toggle="#adminSidebar">☰ Menu</button><h1>Welcome, <?= e($user['name']) ?></h1><div class="card-grid"><div class="glass kpi"><h3><?= $students ?></h3><p>Students</p></div><div class="glass kpi"><h3><?= $teachers ?></h3><p>Teachers</p></div><div class="glass kpi"><h3>₹<?= number_format($feesPending,2) ?></h3><p>Pending Fees</p></div></div>
<div class="card-grid" style="margin-top:1rem"><div class="glass card"><h3>Broadcast Notification</h3><form method="post"><input type="hidden" name="_token" value="<?= csrf_token() ?>"><textarea class="form-control" name="broadcast" placeholder="Message"></textarea><br><button class="btn">Send</button></form></div><div class="glass card"><h3>Live Notifications <i class="fa fa-bell"></i></h3><div data-notification-feed>Loading...</div></div></div>
</main></div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
