<?php
declare(strict_types=1);

/*
 * Copy/edit these settings for your environment.
 * For production, use environment variables or a config file outside the public web root.
 */
define('APP_NAME', 'Mahakal Travels');
define('APP_ENV', 'development'); // change to production on a live server
define('BASE_URL', 'http://localhost/mahakal-travels'); // no trailing slash
define('APP_KEY', 'CHANGE_THIS_TO_A_LONG_RANDOM_SECRET_BEFORE_DEPLOYING');

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'mahakal_travel');
define('DB_USER', 'root');
define('DB_PASS', '');

define('BUSINESS_PHONE', '+91 00000 00000');
define('BUSINESS_EMAIL', 'hello@example.com');
define('BUSINESS_ADDRESS', 'Add your office address');
define('WHATSAPP_NUMBER', '910000000000'); // digits only, country code + number

date_default_timezone_set('Asia/Kolkata');

if (APP_ENV === 'production') {
    ini_set('display_errors', '0');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}
