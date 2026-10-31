<?php
require_once __DIR__ . '/_init.php';
$pageTitle = 'Admin Dashboard';
$counts = [];
foreach (['destinations','packages','bookings','contact_messages'] as $table) {
    $counts[$table] = (int)db()->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
}
$recent = db()->query("SELECT b.*, d.name AS destination_name, p.title AS package_title FROM bookings b LEFT JOIN destinations d ON d.id=b.destination_id LEFT JOIN packages p ON p.id=b.package_id ORDER BY b.created_at DESC LIMIT 8")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="admin-area"><div class="container py-5"><div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"><div><span class="eyebrow">MANAGEMENT CONSOLE</span><h1 class="h2 mb-0">Welcome, <?= e((string)($_SESSION['admin_name'] ?? 'Admin')) ?></h1></div><a class="btn btn-outline-custom" href="<?= e(url('admin/logout.php')) ?>">Sign out <i class="bi bi-box-arrow-right ms-1"></i></a></div>
<div class="row g-3 mb-4">
<?php foreach (['destinations'=>'Destinations','packages'=>'Packages','bookings'=>'Booking enquiries','contact_messages'=>'Contact messages'] as $key=>$label): ?><div class="col-6 col-lg-3"><div class="stat-card"><span><?= e($label) ?></span><strong><?= $counts[$key] ?></strong></div></div><?php endforeach; ?>
</div>
<div class="admin-links mb-4"><a href="<?= e(url('admin/destinations.php')) ?>"><i class="bi bi-geo-alt"></i> Manage destinations</a><a href="<?= e(url('admin/packages.php')) ?>"><i class="bi bi-suitcase-lg"></i> Manage packages</a><a href="<?= e(url('admin/bookings.php')) ?>"><i class="bi bi-calendar-check"></i> Manage bookings</a><a href="<?= e(url('admin/messages.php')) ?>"><i class="bi bi-envelope"></i> Contact messages</a></div>
<div class="admin-table-card"><h2 class="h4 mb-3">Latest booking enquiries</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Name</th><th>Destination / package</th><th>Travel date</th><th>Status</th><th>Received</th></tr></thead><tbody><?php foreach ($recent as $b): ?><tr><td><?= e($b['name']) ?><small class="d-block text-muted"><?= e($b['email']) ?></small></td><td><?= e($b['destination_name'] ?? 'Not selected') ?><small class="d-block text-muted"><?= e($b['package_title'] ?? '') ?></small></td><td><?= e($b['travel_date'] ?? 'Flexible') ?></td><td><span class="status-pill"><?= e($b['status']) ?></span></td><td><?= e($b['created_at']) ?></td></tr><?php endforeach; ?><?php if (!$recent): ?><tr><td colspan="5" class="text-center text-muted">No booking enquiries yet.</td></tr><?php endif; ?></tbody></table></div></div>
</div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
