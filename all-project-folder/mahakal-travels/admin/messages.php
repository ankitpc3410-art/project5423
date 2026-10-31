<?php
require_once __DIR__ . '/_init.php';
$pageTitle = 'Contact Messages';
$allowed = ['new','read','replied','closed'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $status = post_string('status', 20);
    if (in_array($status, $allowed, true)) {
        db()->prepare("UPDATE contact_messages SET status=? WHERE id=?")->execute([$status,$id]);
        flash('success','Message status updated.');
    }
    redirect('admin/messages.php');
}
$rows = db()->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="admin-area"><div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h2">Contact Messages</h1><a class="btn btn-outline-custom" href="<?= e(url('admin/index.php')) ?>">Dashboard</a></div><div class="admin-table-card"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Sender</th><th>Subject</th><th>Message</th><th>Status</th><th>Received</th></tr></thead><tbody><?php foreach ($rows as $m): ?><tr><td><strong><?= e($m['name']) ?></strong><small class="d-block"><?= e($m['email']) ?></small><small class="d-block"><?= e($m['phone'] ?? '') ?></small></td><td><?= e($m['subject'] ?? '') ?></td><td class="message-cell"><?= e($m['message']) ?></td><td><form method="post" class="status-form"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><select class="form-select form-select-sm" name="status" onchange="this.form.submit()"><?php foreach ($allowed as $s): ?><option value="<?= e($s) ?>" <?= $m['status']===$s?'selected':'' ?>><?= e(ucfirst($s)) ?></option><?php endforeach; ?></select></form></td><td><?= e($m['created_at']) ?></td></tr><?php endforeach; ?><?php if (!$rows): ?><tr><td colspan="5" class="text-center text-muted">No contact messages yet.</td></tr><?php endif; ?></tbody></table></div></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
