<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_csrf();
$name = sanitize_string($_POST['name'] ?? '');
$email = sanitize_string($_POST['email'] ?? '');
$class = sanitize_string($_POST['class_name'] ?? '');
$studentId = generate_student_id($pdo);

$pdo->beginTransaction();
$stmt = $pdo->prepare('INSERT INTO users (name,email,password_hash,role) VALUES (:n,:e,:p,\'student\')');
$stmt->execute(['n'=>$name,'e'=>$email,'p'=>password_hash(bin2hex(random_bytes(4)), PASSWORD_DEFAULT)]);
$uid = (int)$pdo->lastInsertId();
$stmt2 = $pdo->prepare('INSERT INTO students (student_id,user_id,class_name,admission_status) VALUES (:sid,:uid,:class,\'pending\')');
$stmt2->execute(['sid'=>$studentId,'uid'=>$uid,'class'=>$class]);
$pdo->commit();

send_system_email($config, $email, 'Admission Received', '<p>Your admission ID is <strong>' . e($studentId) . '</strong>.</p>');
flash('success', 'Admission submitted successfully. Your tracking ID: ' . $studentId);
redirect('/public/admissions.php');
