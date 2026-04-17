<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$invoice = sanitize_string($_GET['invoice'] ?? '');
$status = sanitize_string($_GET['status'] ?? ($_POST['status'] ?? 'failed'));
if (request_method()==='POST' && !verify_payu_response($config['payu'], $_POST)) {
    exit('Invalid hash response');
}
if ($status === 'success') {
    $stmt = $pdo->prepare("UPDATE fees SET status='paid', paid_at=NOW(), payu_txn_id=:tx WHERE invoice_no=:i");
    $stmt->execute(['tx'=>($_POST['txnid'] ?? 'NA'), 'i'=>$invoice]);
}
include __DIR__ . '/../includes/header.php'; ?>
<section class="section"><div class="container"><div class="glass card"><h1>Payment <?= e(strtoupper($status)) ?></h1><p>Invoice <?= e($invoice) ?> has been processed.</p><a href="/student/index.php" class="btn">Back to Dashboard</a></div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
