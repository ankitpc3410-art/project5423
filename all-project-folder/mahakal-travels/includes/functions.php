<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = ''): string
{
    return rtrim(BASE_URL, '/') . ($path !== '' ? '/' . ltrim($path, '/') : '');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e($_SESSION['csrf_token'] ?? '') . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Your session token expired. Please go back and try again.');
    }
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function is_admin(): bool
{
    return !empty($_SESSION['admin_id']);
}

function require_admin(): void
{
    if (!is_admin()) {
        flash('warning', 'Please sign in to access the admin area.');
        redirect('admin/login.php');
    }
}

function setting(string $key, string $fallback = ''): string
{
    static $settings = null;
    if ($settings === null) {
        try {
            $settings = [];
            foreach (db()->query('SELECT setting_key, setting_value FROM settings')->fetchAll() as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Throwable $e) {
            $settings = [];
        }
    }
    return (string)($settings[$key] ?? $fallback);
}

function money(?string $amount): string
{
    if ($amount === null || $amount === '') {
        return 'Request a quote';
    }
    return '₹' . number_format((float)$amount, 0);
}

function image_url(?string $path, string $fallback = 'assets/images/hero.jpg'): string
{
    $path = trim((string)$path);
    if ($path === '') {
        $path = $fallback;
    }
    if (preg_match('~^https?://~i', $path)) {
        return $path;
    }
    return url($path);
}

function post_string(string $key, int $max = 2000): string
{
    $value = trim((string)($_POST[$key] ?? ''));
    return mb_substr($value, 0, $max);
}
