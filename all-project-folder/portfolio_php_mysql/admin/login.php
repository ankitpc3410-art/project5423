<?php
require dirname(__DIR__) . '/config.php';
if (is_admin()) redirect('admin/index.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $u = trim($_POST['username'] ?? ''); $p = $_POST['password'] ?? '';
    $stmt = db()->prepare('SELECT * FROM admins WHERE username=?'); $stmt->execute([$u]); $admin = $stmt->fetch();
    if ($admin && password_verify($p, $admin['password_hash'])) {
        session_regenerate_id(true); $_SESSION['admin_id'] = $admin['id']; $_SESSION['admin_name'] = $admin['username']; redirect('admin/index.php');
    }
    $error = 'Incorrect username or password.';
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin login</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="../assets/style.css" rel="stylesheet"></head><body class="admin-body"><div class="login-card"><a class="back-link" href="../index.php">← View portfolio</a><h1>Welcome back<span class="accent">.</span></h1><p class="muted">Sign in to manage your portfolio.</p><?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><label>Username</label><input class="form-control mb-3" name="username" required autocomplete="username"><label>Password</label><input class="form-control mb-4" type="password" name="password" required autocomplete="current-password"><button class="btn btn-primary w-100">Sign in →</button></form></div></body></html>
