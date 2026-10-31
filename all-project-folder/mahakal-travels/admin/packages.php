<?php
require_once __DIR__ . '/_init.php';
$pageTitle = 'Manage Packages';
$errors = [];
$editing = null;
$destinations = db()->query("SELECT id,name FROM destinations ORDER BY name")->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = post_string('action', 20);
    $id = (int)($_POST['id'] ?? 0);
    if ($action === 'delete') {
        db()->prepare("DELETE FROM packages WHERE id=?")->execute([$id]);
        flash('success','Package deleted.');
        redirect('admin/packages.php');
    }
    $title = post_string('title', 180);
    $destinationId = (int)($_POST['destination_id'] ?? 0);
    $category = post_string('category', 80);
    $duration = post_string('duration', 80);
    $priceRaw = trim((string)($_POST['price'] ?? ''));
    $price = $priceRaw === '' ? null : filter_var($priceRaw, FILTER_VALIDATE_FLOAT);
    $image = post_string('image', 500);
    $short = post_string('short_description', 500);
    $description = post_string('description', 5000);
    $featured = isset($_POST['is_featured']) ? 1 : 0;
    $active = isset($_POST['is_active']) ? 1 : 0;
    if ($title === '') $errors[] = 'Package title is required.';
    if ($priceRaw !== '' && ($price === false || $price < 0)) $errors[] = 'Price must be a non-negative number.';
    if ($destinationId && !in_array($destinationId, array_column($destinations, 'id'))) $errors[] = 'Please select a valid destination.';
    if (!$errors) {
        if ($id > 0) {
            $stmt = db()->prepare("UPDATE packages SET destination_id=?,title=?,category=?,duration=?,price=?,image=?,short_description=?,description=?,is_featured=?,is_active=? WHERE id=?");
            $stmt->execute([$destinationId ?: null,$title,$category,$duration,$price,$image,$short,$description,$featured,$active,$id]);
            flash('success','Package updated.');
        } else {
            $stmt = db()->prepare("INSERT INTO packages (destination_id,title,category,duration,price,image,short_description,description,is_featured,is_active,created_at) VALUES (?,?,?,?,?,?,?,?,?,?,NOW())");
            $stmt->execute([$destinationId ?: null,$title,$category,$duration,$price,$image,$short,$description,$featured,$active]);
            flash('success','Package added.');
        }
        redirect('admin/packages.php');
    }
}
if (isset($_GET['edit'])) {
    $stmt = db()->prepare("SELECT * FROM packages WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $editing = $stmt->fetch() ?: null;
}
$list = db()->query("SELECT p.*, d.name AS destination_name FROM packages p LEFT JOIN destinations d ON d.id=p.destination_id ORDER BY p.id DESC")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="admin-area"><div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h2">Tour Packages</h1><a class="btn btn-outline-custom" href="<?= e(url('admin/index.php')) ?>">Dashboard</a></div>
<div class="admin-table-card mb-4"><h2 class="h4"><?= $editing ? 'Edit package' : 'Add package' ?></h2><?php if ($errors): ?><div class="alert alert-danger"><?= e(implode(' ', $errors)) ?></div><?php endif; ?><form method="post" class="row g-3"><?= csrf_field() ?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)($editing['id'] ?? 0) ?>">
<div class="col-md-6"><label class="form-label">Package title *</label><input class="form-control" name="title" required maxlength="180" value="<?= e($editing['title'] ?? '') ?>"></div>
<div class="col-md-3"><label class="form-label">Destination</label><select class="form-select" name="destination_id"><option value="0">None</option><?php foreach ($destinations as $d): ?><option value="<?= (int)$d['id'] ?>" <?= (int)($editing['destination_id'] ?? 0)===(int)$d['id']?'selected':'' ?>><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Category</label><input class="form-control" name="category" maxlength="80" value="<?= e($editing['category'] ?? 'Tour') ?>"></div>
<div class="col-md-3"><label class="form-label">Duration</label><input class="form-control" name="duration" maxlength="80" placeholder="e.g. 3 days / 2 nights" value="<?= e($editing['duration'] ?? '') ?>"></div>
<div class="col-md-3"><label class="form-label">Price (INR; blank for quote)</label><input class="form-control" type="number" min="0" step="0.01" name="price" value="<?= e((string)($editing['price'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label">Image path or URL</label><input class="form-control" name="image" maxlength="500" placeholder="assets/images/varanasi.jpg" value="<?= e($editing['image'] ?? '') ?>"></div>
<div class="col-12"><label class="form-label">Short description</label><textarea class="form-control" name="short_description" rows="2" maxlength="500"><?= e($editing['short_description'] ?? '') ?></textarea></div>
<div class="col-12"><label class="form-label">Full description / inclusions</label><textarea class="form-control" name="description" rows="4" maxlength="5000"><?= e($editing['description'] ?? '') ?></textarea></div>
<div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" id="featured" <?= (int)($editing['is_featured'] ?? 0)===1?'checked':'' ?>><label class="form-check-label" for="featured">Featured on home</label></div></div>
<div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="active" <?= !isset($editing['is_active']) || (int)$editing['is_active']===1?'checked':'' ?>><label class="form-check-label" for="active">Active / visible</label></div></div>
<div class="col-12"><button class="btn btn-primary-custom">Save package</button> <?php if ($editing): ?><a class="btn btn-outline-secondary" href="<?= e(url('admin/packages.php')) ?>">Cancel</a><?php endif; ?></div></form></div>
<div class="admin-table-card"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Package</th><th>Destination</th><th>Price</th><th>Visibility</th><th>Actions</th></tr></thead><tbody><?php foreach ($list as $p): ?><tr><td><?= e($p['title']) ?><small class="d-block text-muted"><?= e($p['category']) ?></small></td><td><?= e($p['destination_name'] ?? '—') ?></td><td><?= e(money($p['price'])) ?></td><td><?= (int)$p['is_active']?'Active':'Hidden' ?><?= (int)$p['is_featured']?' · Featured':'' ?></td><td><a class="btn btn-sm btn-outline-primary" href="<?= e(url('admin/packages.php?edit='.(int)$p['id'])) ?>">Edit</a> <form method="post" class="d-inline" onsubmit="return confirm('Delete this package?');"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr><?php endforeach; ?></tbody></table></div></div>
</div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
