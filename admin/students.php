<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_role('admin');
if (request_method()==='POST') {
    require_csrf();
    $sid = generate_student_id($pdo);
    $stmt = $pdo->prepare('INSERT INTO students (student_id,class_name,section_name,guardian_name,phone,address,admission_status) VALUES (:sid,:c,:s,:g,:p,:a,\'approved\')');
    $stmt->execute(['sid'=>$sid,'c'=>sanitize_string($_POST['class_name']),'s'=>sanitize_string($_POST['section_name']),'g'=>sanitize_string($_POST['guardian_name']),'p'=>sanitize_string($_POST['phone']),'a'=>sanitize_string($_POST['address'])]);
}
$rows = $pdo->query('SELECT * FROM students ORDER BY id DESC LIMIT 50')->fetchAll();
include __DIR__ . '/../includes/header.php'; ?>
<section class="section"><div class="container"><div class="glass card"><h1>Student Management</h1><form method="post"><input type="hidden" name="_token" value="<?= csrf_token() ?>"><div class="card-grid"><input class="form-control" name="class_name" placeholder="Class" required><input class="form-control" name="section_name" placeholder="Section"><input class="form-control" name="guardian_name" placeholder="Guardian"><input class="form-control" name="phone" placeholder="Phone"></div><br><textarea class="form-control" name="address" placeholder="Address"></textarea><br><button class="btn">Add Student</button></form></div>
<div class="glass card" style="margin-top:1rem"><table class="table"><thead><tr><th>Student ID</th><th>Class</th><th>Guardian</th><th>Status</th><th>ID Card</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= e($r['student_id']) ?></td><td><?= e($r['class_name'].'-'.$r['section_name']) ?></td><td><?= e($r['guardian_name']) ?></td><td><?= e($r['admission_status']) ?></td><td><a class="btn secondary" href="/admin/id-card.php?id=<?= $r['id'] ?>">Print</a></td></tr><?php endforeach; ?></tbody></table></div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
