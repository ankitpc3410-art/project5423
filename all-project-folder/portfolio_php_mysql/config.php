<?php
declare(strict_types=1);
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'myportfolio_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', '/portfolio_php_mysql'); // Example: '/portfolio' when installed in a subfolder

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}
function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function url(string $path = ''): string { return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/'); }
function redirect(string $path): never { header('Location: ' . url($path)); exit; }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_check(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Invalid request token. Please go back and retry.');
    }
}
function is_admin(): bool { return !empty($_SESSION['admin_id']); }
function require_admin(): void { if (!is_admin()) redirect('admin/login.php'); }
function flash(string $message, string $type = 'success'): void { $_SESSION['flash'] = [$message, $type]; }
function show_flash(): void {
    if (!empty($_SESSION['flash'])) {
        [$m, $t] = $_SESSION['flash']; unset($_SESSION['flash']);
        echo '<div class="alert alert-' . e($t) . ' alert-dismissible fade show" role="alert">' .
             e($m) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}
function upload_file(string $field, string $folder, array $allowed, int $maxBytes = 5000000): ?string {
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK || $f['size'] > $maxBytes) throw new RuntimeException('Upload failed or file is too large.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $exts = $allowed[$mime] ?? null;
    if (!$exts) throw new RuntimeException('Unsupported file type.');
    $ext = $exts[0];
    $name = bin2hex(random_bytes(16)) . '.' . $ext;
    $dir = __DIR__ . '/uploads/' . trim($folder, '/');
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    if (!move_uploaded_file($f['tmp_name'], $dir . '/' . $name)) throw new RuntimeException('Could not save uploaded file.');
    return 'uploads/' . trim($folder, '/') . '/' . $name;
}
function delete_upload(?string $path): void {
    if (!$path || !str_starts_with($path, 'uploads/')) return;
    $full = __DIR__ . '/' . $path;
    if (is_file($full)) @unlink($full);
}
function setting(string $key, string $default = ''): string {
    $stmt = db()->prepare('SELECT setting_value FROM settings WHERE setting_key = ?');
    $stmt->execute([$key]); $v = $stmt->fetchColumn();
    return $v === false ? $default : (string)$v;
}
