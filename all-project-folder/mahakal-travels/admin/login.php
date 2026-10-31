<?php
require_once __DIR__ . '/../includes/bootstrap.php';
if (is_admin()) redirect('admin/index.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $stmt = db()->prepare("SELECT id, name, email, password_hash FROM admins WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        redirect('admin/index.php');
    }
    $error = 'The email or password was not correct.';
}
$pageTitle = 'Admin Login';
require __DIR__ . '/../includes/header.php';
?>
<section class="section-padding"><div class="container"><div class="form-shell login-shell"><span class="eyebrow">SECURE ADMIN AREA</span><h1 class="h2 mb-4">Admin Sign In</h1><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" type="email" name="email" id="email" required autocomplete="username"></div><div class="mb-4"><label class="form-label" for="password">Password</label><input class="form-control" type="password" name="password" id="password" required autocomplete="current-password"></div><button class="btn btn-primary-custom w-100" type="submit">Sign In</button></form></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
