<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$invoice = sanitize_string($_GET['invoice'] ?? '');
$stmt = $pdo->prepare('SELECT f.*, s.student_id, u.name, u.email FROM fees f JOIN students s ON s.id=f.student_id LEFT JOIN users u ON u.id=s.user_id WHERE invoice_no=:i LIMIT 1');
$stmt->execute(['i'=>$invoice]);
$fee = $stmt->fetch();
if(!$fee){ exit('Invalid invoice'); }
$txnid = 'TXN' . time() . rand(100,999);
$fields = [
    'txnid'=>$txnid,
    'amount'=>$fee['amount'],
    'productinfo'=>'School Fee - '.$invoice,
    'firstname'=>$fee['name'] ?: 'Student',
    'email'=>$fee['email'] ?: 'parent@example.com',
];
$hash = payu_hash($config['payu'], $fields);
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<section class="section"><div class="container"><div class="glass card"><h1>PayU Checkout</h1><p>Invoice: <?= e($invoice) ?> | Amount: ₹<?= e($fee['amount']) ?></p>
<form method="post" action="<?= e($config['payu']['base_url']) ?>/_payment">
<input type="hidden" name="key" value="<?= e($config['payu']['key']) ?>">
<?php foreach($fields as $k=>$v): ?><input type="hidden" name="<?= e($k) ?>" value="<?= e($v) ?>"><?php endforeach; ?>
<input type="hidden" name="surl" value="<?= e(($config['app']['base_url'] ?: '') . '/public/payu-callback.php?status=success&invoice=' . urlencode($invoice)) ?>">
<input type="hidden" name="furl" value="<?= e(($config['app']['base_url'] ?: '') . '/public/payu-callback.php?status=failed&invoice=' . urlencode($invoice)) ?>">
<input type="hidden" name="hash" value="<?= e($hash) ?>">
<button class="btn">Proceed to PayU</button>
</form></div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
