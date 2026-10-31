<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Popular Destinations';
$activePage = 'destinations';
$q = trim((string)($_GET['q'] ?? ''));
$sql = "SELECT * FROM destinations WHERE is_active = 1";
$params = [];
if ($q !== '') {
    $sql .= " AND (name LIKE ? OR state LIKE ? OR short_description LIKE ?)";
    $like = '%' . $q . '%';
    $params = [$like, $like, $like];
}
$sql .= " ORDER BY sort_order, name";
$stmt = db()->prepare($sql);
$stmt->execute($params);
$destinations = $stmt->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<main><section class="page-hero"><div class="container"><span class="eyebrow">EXPLORE INDIA</span><h1>Popular <span>Destinations</span></h1><p>Find the places, culture and experiences that inspire your next journey.</p></div></section>
<section class="section-padding"><div class="container">
<form class="search-bar mb-4" method="get"><input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Search by destination, state or experience"><button class="btn btn-primary-custom" type="submit"><i class="bi bi-search me-1"></i> Search</button></form>
<div class="row g-4"><?php foreach ($destinations as $d): ?><div class="col-md-6 col-lg-4"><article class="destination-card"><img src="<?= e(image_url($d['image'])) ?>" alt="<?= e($d['name']) ?>" loading="lazy"><span class="destination-tag"><?= e($d['category'] ?: 'Explore India') ?></span><div class="destination-overlay"><div><small><?= e($d['state']) ?></small><h3><?= e($d['name']) ?></h3><p><?= e($d['short_description']) ?></p></div><a class="round-arrow" href="<?= e(url('booking.php?destination=' . (int)$d['id'])) ?>" aria-label="Enquire about <?= e($d['name']) ?>"><i class="bi bi-arrow-up-right"></i></a></div></article></div><?php endforeach; ?></div>
<?php if (!$destinations): ?><div class="empty-state mt-4">No destinations matched your search.</div><?php endif; ?>
</div></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
