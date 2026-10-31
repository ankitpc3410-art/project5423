<?php
require __DIR__ . '/config.php';
$count = (int)db()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
$done = false; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $count === 0) {
    csrf_check();
    $username = trim($_POST['username'] ?? ''); $password = $_POST['password'] ?? '';
    if (strlen($username) < 3 || strlen($password) < 12) $error = 'Username must be 3+ characters and password at least 12 characters.';
    else {
        $stmt = db()->prepare('INSERT INTO admins (username,password_hash) VALUES (?,?)');
        $stmt->execute([$username,password_hash($password, PASSWORD_DEFAULT)]);
        $done = true;
    }
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin setup</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="assets/style.css" rel="stylesheet"></head><body class="admin-body"><div class="login-card"><h1>Initial admin setup</h1>
<?php if($count>0 || $done):?><div class="alert alert-success">Admin setup is complete. Delete <code>setup.php</code> from your server, then sign in.</div><a class="btn btn-primary" href="admin/login.php">Go to login</a>
<?php else:?><?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?>
<p class="muted">Create your first administrator account. Use a unique password.</p><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><label>Username</label><input class="form-control mb-3" name="username" required minlength="3"><label>Password (12+ characters)</label><input class="form-control mb-3" type="password" name="password" required minlength="12"><button class="btn btn-primary w-100">Create admin</button></form><?php endif;?></div></body></html>
