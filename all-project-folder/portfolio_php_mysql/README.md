# PHP + MySQL Portfolio Website

A responsive portfolio website with a protected admin dashboard, content CRUD, image/resume uploads, and a contact inbox.

## Included
- Public portfolio: hero/profile, about, skills, projects, resume download, social links, contact form.
- Admin login with `password_hash()` / `password_verify()`, session ID regeneration, and logout.
- Profile/about/social/contact detail editing.
- Profile photo upload and PDF resume replacement.
- Projects CRUD: title, description, website URL, image, display order.
- Skills CRUD: name, proficiency and display order.
- Contact messages inbox: view and delete.
- Change admin password.
- PDO prepared statements, output escaping, CSRF protection, upload MIME/size checks.
- Bootstrap 5, responsive custom CSS, subtle scroll reveal and hover animations.

## Requirements
- PHP 8.0+ (8.1+ recommended), MySQL 5.7+/MariaDB 10.4+.
- PHP extensions: PDO MySQL, fileinfo.
- Apache/Nginx or a local stack such as XAMPP.

## Setup
1. Copy this folder into your web server document root (for XAMPP: `htdocs/portfolio_php_mysql`).
2. Create the database by importing `database.sql` in phpMyAdmin or run it with the MySQL client.
3. Edit `config.php`: set `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`. If installed in a subfolder, set `BASE_URL` to e.g. `/portfolio_php_mysql`.
4. Ensure `uploads/`, `uploads/projects/`, and `uploads/resume/` are writable by PHP (usually permissions `755`, ownership depending on hosting).
5. Visit `/portfolio_php_mysql/setup.php` and create the first admin. Use a strong password (12+ characters).
6. **Delete `setup.php` from the server immediately after creating the admin.**
7. Visit `/portfolio_php_mysql/admin/login.php` to manage your site.

## First content edits
In admin: Profile & about → add your name, role, tagline, email, location, bio, links, photo and PDF resume. Add skills and projects. Your public site updates automatically.

## Deployment / security checklist
- Use HTTPS.
- Change the default database credentials and use a dedicated database user with only required privileges.
- Delete `setup.php` after first-time setup.
- Keep PHP/MySQL updated and back up the database and `uploads/` directory.
- Configure PHP `upload_max_filesize` and `post_max_size` to permit your desired upload sizes.
- For production, configure web-server rules to deny direct access to configuration and SQL files; the included `.htaccess` is for Apache.
- Add rate limiting / CAPTCHA or an email verification workflow if the contact form is likely to receive spam.
- Consider a scheduled backup and monitoring process.

## Notes
- Bootstrap and Google Fonts are loaded from CDNs; an internet connection is required for those assets.
- Contact messages are saved in the database; this starter does not send notification emails.
- The admin password can be changed from the Password section after login.
