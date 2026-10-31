<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Tour Packages';
$activePage = 'packages';
$q = trim((string)($_GET['q'] ?? ''));
$sql = "SELECT p.*, d.name AS destination_name FROM packages p LEFT JOIN destinations d ON d.id = p.destination_id WHERE p.is_active = 1";
$params = [];
if ($q !== '') {
    $sql .= " AND (p.title LIKE ? OR p.category LIKE ? OR d.name LIKE ? OR p.short_description LIKE ?)";
    $like = '%' . $q . '%';
    $params = [$like, $like, $like, $like];
}
$sql .= " ORDER BY p.is_featured DESC, p.id DESC";
$stmt = db()->prepare($sql);
$stmt->execute($params);
$packages = $stmt->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<main><section class="page-hero"><div class="container"><span class="eyebrow">TRAVEL YOUR WAY</span><h1>Our Tour <span>Packages</span></h1><p>Explore trip ideas and request a quote tailored to your plans.</p></div></section>
<section class="section-padding"><div class="container">
<form class="search-bar mb-4" method="get"><input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Search packages, destinations or categories"><button class="btn btn-primary-custom" type="submit"><i class="bi bi-search me-1"></i> Search</button></form>
<div class="row g-4"><?php foreach ($packages as $p): ?><div class="col-md-6 col-lg-4"><article class="package-card"><div class="package-image"><img src="<?= e(image_url($p['image'])) ?>" alt="<?= e($p['title']) ?>" loading="lazy"><span class="destination-tag"><?= e($p['category']) ?></span></div><div class="package-body"><small class="location-line"><i class="bi bi-geo-alt"></i> <?= e($p['destination_name'] ?? 'India') ?></small><h3><?= e($p['title']) ?></h3><p><?= e($p['short_description']) ?></p><div class="package-meta"><span><i class="bi bi-clock"></i> <?= e($p['duration'] ?: 'Flexible duration') ?></span><strong><?= e(money($p['price'])) ?></strong></div><a href="<?= e(url('booking.php?package=' . (int)$p['id'])) ?>" class="package-link">Enquire about this trip <i class="bi bi-arrow-right"></i></a></div></article></div><?php endforeach; ?></div>
<?php if (!$packages): ?><div class="empty-state mt-4">No packages matched your search. Please try another term.</div><?php endif; ?>
</div></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
