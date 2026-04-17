<?php
return [
    'app' => [
        'name' => 'NovaSchool ERP',
        'base_url' => 'http://localhost/chatasd',
        'timezone' => 'Asia/Kolkata',
        'session_name' => 'nova_school_session',
    ],
    'db' => [
        'host' => 'localhost',
        'name' => 'school_erp',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
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
];
