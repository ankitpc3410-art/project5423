# Mahakal Travels — PHP + MySQL Website

A complete starter travel-agency website with public pages, package/destination listings, booking enquiries, contact enquiries, and a protected admin panel.

## Requirements
- PHP 8.1+ (8.2 recommended)
- MySQL 8+ or MariaDB 10.5+
- Apache with `mod_rewrite` optional (works without rewrite rules)
- PHP PDO MySQL extension enabled

## Setup (XAMPP / local)
1. Copy this folder into `htdocs/mahakal-travels`.
2. Create a MySQL database named `mahakal_travels` (or choose another name).
3. Import `database/schema.sql` using phpMyAdmin.
4. Edit `config/config.php` and set database credentials and `BASE_URL`.
   - Example base URL: `http://localhost/mahakal-travels`
   - Do not include a trailing slash.
5. Visit `http://localhost/mahakal-travels/`.
6. Create an admin account by running this command from the project folder:
   `php scripts/create_admin.php admin@example.com "ChangeThisPassword123!"`
   Or create a password hash with `php -r "echo password_hash('YourPassword', PASSWORD_DEFAULT), PHP_EOL;"` and insert it into the `admins` table.
7. Sign in at `/admin/login.php`.

## Important configuration
- Set `APP_ENV` to `production` on a live server.
- Change `APP_KEY` to a long random secret.
- Set real contact information in `config/config.php`.
- Set your WhatsApp business number as digits only, including country code.
- Add your own licensed destination photos to `assets/images/`. Placeholder image paths are included.
- Make sure `storage/` is not publicly accessible on production, or move it outside the web root.
- Use HTTPS in production.

## Features
- Responsive Bootstrap 5 frontend
- Home page, destinations, packages, gallery, about, contact
- Search/filter for destinations and packages
- Booking request form saved to MySQL
- Contact form saved to MySQL
- Admin login/logout with password hashing and CSRF protection
- Admin dashboard
- CRUD management for packages and destinations
- Booking status management
- Contact enquiry management
- Prepared SQL statements and output escaping
- Server-side validation and session security basics

## Notes
This is a functioning enquiry/management application, not a real-time inventory engine. It does not automatically reserve hotels, flights, or vehicles, and it does not charge payments. Add a payment gateway and supplier integrations only after configuring them securely.
