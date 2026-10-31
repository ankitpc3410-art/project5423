<?php
require_once __DIR__ . '/_init.php';
$pageTitle = 'Manage Destinations';
$errors = [];
$editing = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = post_string('action', 20);
    $id = (int)($_POST['id'] ?? 0);
    if ($action === 'delete') {
        db()->prepare("DELETE FROM destinations WHERE id=?")->execute([$id]);
        flash('success', 'Destination deleted.');
        redirect('admin/destinations.php');
    }
    $name = post_string('name', 120);
    $state = post_string('state', 120);
    $category = post_string('category', 80);
    $image = post_string('image', 500);
    $description = post_string('short_description', 500);
    $sort = (int)($_POST['sort_order'] ?? 0);
    $active = isset($_POST['is_active']) ? 1 : 0;
    if ($name === '') $errors[] = 'Destination name is required.';
    if (!$errors) {
        if ($id > 0) {
            $stmt = db()->prepare("UPDATE destinations SET name=?,state=?,category=?,image=?,short_description=?,sort_order=?,is_active=? WHERE id=?");
            $stmt->execute([$name,$state,$category,$image,$description,$sort,$active,$id]);
            flash('success','Destination updated.');
        } else {
            $stmt = db()->prepare("INSERT INTO destinations (name,state,category,image,short_description,sort_order,is_active,created_at) VALUES (?,?,?,?,?,?,?,NOW())");
            $stmt->execute([$name,$state,$category,$image,$description,$sort,$active]);
            flash('success','Destination added.');
        }
        redirect('admin/destinations.php');
    }
}
if (isset($_GET['edit'])) {
    $stmt = db()->prepare("SELECT * FROM destinations WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $editing = $stmt->fetch() ?: null;
}
$list = db()->query("SELECT * FROM destinations ORDER BY sort_order, name")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="admin-area"><div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h2">Destinations</h1><a class="btn btn-outline-custom" href="<?= e(url('admin/index.php')) ?>">Dashboard</a></div>
<div class="admin-table-card mb-4"><h2 class="h4"><?= $editing ? 'Edit destination' : 'Add destination' ?></h2><?php if ($errors): ?><div class="alert alert-danger"><?= e(implode(' ', $errors)) ?></div><?php endif; ?><form method="post" class="row g-3"><?= csrf_field() ?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)($editing['id'] ?? 0) ?>">
<div class="col-md-4"><label class="form-label">Name *</label><input class="form-control" name="name" required maxlength="120" value="<?= e($editing['name'] ?? post_string('name')) ?>"></div>
<div class="col-md-4"><label class="form-label">State / region</label><input class="form-control" name="state" maxlength="120" value="<?= e($editing['state'] ?? '') ?>"></div>
<div class="col-md-4"><label class="form-label">Category</label><input class="form-control" name="category" maxlength="80" value="<?= e($editing['category'] ?? '') ?>"></div>
<div class="col-md-8"><label class="form-label">Image path or full URL</label><input class="form-control" name="image" maxlength="500" placeholder="assets/images/varanasi.jpg" value="<?= e($editing['image'] ?? '') ?>"></div>
<div class="col-md-2"><label class="form-label">Sort order</label><input class="form-control" type="number" name="sort_order" value="<?= e((string)($editing['sort_order'] ?? 0)) ?>"></div>
<div class="col-md-2 d-flex align-items-end"><div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="is_active" id="active" <?= !isset($editing['is_active']) || (int)$editing['is_active'] === 1 ? 'checked' : '' ?>><label class="form-check-label" for="active">Active</label></div></div>
<div class="col-12"><label class="form-label">Short description</label><textarea class="form-control" name="short_description" rows="2" maxlength="500"><?= e($editing['short_description'] ?? '') ?></textarea></div>
<div class="col-12"><button class="btn btn-primary-custom">Save destination</button> <?php if ($editing): ?><a class="btn btn-outline-secondary" href="<?= e(url('admin/destinations.php')) ?>">Cancel</a><?php endif; ?></div></form></div>
<div class="admin-table-card"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Name</th><th>State</th><th>Category</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php foreach ($list as $d): ?><tr><td><?= e($d['name']) ?></td><td><?= e($d['state']) ?></td><td><?= e($d['category']) ?></td><td><?= (int)$d['is_active'] ? 'Active' : 'Hidden' ?></td><td><a class="btn btn-sm btn-outline-primary" href="<?= e(url('admin/destinations.php?edit='.(int)$d['id'])) ?>">Edit</a> <form method="post" class="d-inline" onsubmit="return confirm('Delete this destination? Related package destinations will be unlinked.');"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$d['id'] ?>"><button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr><?php endforeach; ?></tbody></table></div></div>
</div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
