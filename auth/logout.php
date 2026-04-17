<?php
require_once __DIR__ . '/../includes/bootstrap.php';
logout_user();
redirect('/auth/login.php');
