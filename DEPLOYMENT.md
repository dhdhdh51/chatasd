# cPanel Deployment Guide

1. Create a new MySQL database and user in cPanel.
2. Upload this project to `public_html/` (or a subdirectory).
3. Ensure folders `config/` and `uploads/` are writable (755/775).
4. Visit `/install/index.php` and complete 3-step installer.
5. After install, remove or restrict `/install` directory access.
6. Update SMTP credentials in `config/config.php`.
7. Update PayU credentials in `config/config.php`.
8. Set cron for optional sitemap regeneration if needed.

## Default URLs
- Website: `/public/index.php`
- Admin: `/admin/login.php`
- Role Login: `/auth/login.php?role=student|teacher|parent`

## Security Hardening
- Force HTTPS from cPanel.
- Enable ModSecurity.
- Add IP restrictions for `/install` after setup.
