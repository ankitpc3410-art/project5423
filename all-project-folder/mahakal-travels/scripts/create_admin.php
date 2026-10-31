<?php
/*
 * Run from project root:
 * php scripts/create_admin.php admin@example.com "Use-A-Strong-Password!"
 */
require_once __DIR__ . '/../includes/bootstrap.php';
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Run this script from the command line only.\n");
}
$email = $argv[1] ?? '';
$password = $argv[2] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 12) {
    fwrite(STDERR, "Usage: php scripts/create_admin.php admin@example.com \"AtLeast12Characters!\"\n");
    exit(1);
}
$stmt = db()->prepare("SELECT id FROM admins WHERE email=?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    fwrite(STDERR, "An admin with that email already exists.\n");
    exit(1);
}
$name = 'Administrator';
$insert = db()->prepare("INSERT INTO admins (name,email,password_hash,created_at) VALUES (?,?,?,NOW())");
$insert->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
echo "Admin account created for {$email}\n";
