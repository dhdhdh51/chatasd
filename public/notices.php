<?php require_once __DIR__ . '/../includes/bootstrap.php'; include __DIR__ . '/../includes/header.php'; ?>
<nav class="topnav"><div class="container topnav-inner"><div class="brand">NovaSchool</div><div class="nav-links"><a href="/public/index.php">Home</a><a class="btn" href="/auth/login.php">Login Portal</a></div></div></nav>
<section class="section"><div class="container"><div class="glass card"><h1><?php echo ucwords(str_replace('-', ' ', basename(__FILE__, '.php'))); ?></h1><p>This premium page is fully responsive with glassmorphism cards, elegant spacing, and modern typography.</p>
<?php if (basename(__FILE__) === 'admissions.php'): ?>
<form method="post" action="/auth/admission_submit.php"><input type="hidden" name="_token" value="<?= csrf_token() ?>"><input class="form-control" name="name" placeholder="Student Name" required><br><input class="form-control" name="email" type="email" placeholder="Parent Email" required><br><input class="form-control" name="class_name" placeholder="Applying Class" required><br><button class="btn">Submit Admission</button></form>
<?php endif; ?>
<?php if (basename(__FILE__) === 'contact.php'): ?>
<div class="card-grid"><form class="glass card"><input class="form-control" placeholder="Name"><br><input class="form-control" placeholder="Email"><br><textarea class="form-control" placeholder="Message"></textarea><br><button class="btn" type="button">Send</button></form><div class="glass card"><iframe title="map" style="width:100%;height:300px;border:0;border-radius:12px" src="https://maps.google.com/maps?q=delhi&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe></div></div>
<?php endif; ?>
</div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
