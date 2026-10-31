<?php
require_once __DIR__ . '/_init.php';
$pageTitle = 'Booking Enquiries';
$allowed = ['new','contacted','confirmed','cancelled','completed'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $status = post_string('status', 20);
    if (in_array($status, $allowed, true)) {
        db()->prepare("UPDATE bookings SET status=? WHERE id=?")->execute([$status,$id]);
        flash('success','Booking enquiry status updated.');
    }
    redirect('admin/bookings.php');
}
$rows = db()->query("SELECT b.*, d.name AS destination_name, p.title AS package_title FROM bookings b LEFT JOIN destinations d ON d.id=b.destination_id LEFT JOIN packages p ON p.id=b.package_id ORDER BY b.created_at DESC")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="admin-area"><div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h2">Booking Enquiries</h1><a class="btn btn-outline-custom" href="<?= e(url('admin/index.php')) ?>">Dashboard</a></div><div class="admin-table-card"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Customer</th><th>Trip</th><th>Travel date</th><th>Guests</th><th>Message</th><th>Status</th><th>Received</th></tr></thead><tbody>
<?php foreach ($rows as $b): ?><tr><td><strong><?= e($b['name']) ?></strong><small class="d-block"><?= e($b['email']) ?></small><small class="d-block"><?= e($b['phone']) ?></small></td><td><?= e($b['destination_name'] ?? 'Flexible') ?><small class="d-block text-muted"><?= e($b['package_title'] ?? '') ?></small></td><td><?= e($b['travel_date'] ?? 'Flexible') ?></td><td><?= (int)$b['travelers'] ?></td><td class="message-cell"><?= e($b['message'] ?? '') ?></td><td><form method="post" class="status-form"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$b['id'] ?>"><select class="form-select form-select-sm" name="status" onchange="this.form.submit()"><?php foreach ($allowed as $s): ?><option value="<?= e($s) ?>" <?= $b['status']===$s?'selected':'' ?>><?= e(ucfirst($s)) ?></option><?php endforeach; ?></select></form></td><td><?= e($b['created_at']) ?></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="7" class="text-center text-muted">No booking enquiries received yet.</td></tr><?php endif; ?>
</tbody></table></div></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
