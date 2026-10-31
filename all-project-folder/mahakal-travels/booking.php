<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Request a Booking';
$activePage = '';
$errors = [];
$destinations = db()->query("SELECT id, name FROM destinations WHERE is_active = 1 ORDER BY name")->fetchAll();
$packages = db()->query("SELECT id, title FROM packages WHERE is_active = 1 ORDER BY title")->fetchAll();

$selectedDestination = (int)($_POST['destination_id'] ?? $_GET['destination'] ?? 0);
$selectedPackage = (int)($_POST['package_id'] ?? $_GET['package'] ?? 0);
$travelDate = (string)($_POST['travel_date'] ?? $_GET['travel_date'] ?? '');
$travelers = (int)($_POST['travelers'] ?? $_GET['travelers'] ?? 2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = post_string('name', 120);
    $email = post_string('email', 190);
    $phone = post_string('phone', 40);
    $message = post_string('message', 3000);
    $travelDate = post_string('travel_date', 10);
    $travelers = (int)($_POST['travelers'] ?? 1);
    $selectedDestination = (int)($_POST['destination_id'] ?? 0);
    $selectedPackage = (int)($_POST['package_id'] ?? 0);

    if ($name === '') $errors[] = 'Please enter your name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (!preg_match('/^[0-9+\-\s()]{7,25}$/', $phone)) $errors[] = 'Please enter a valid phone number.';
    if ($travelers < 1 || $travelers > 100) $errors[] = 'Please enter a valid number of travelers.';
    if ($travelDate !== '' && (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $travelDate) || $travelDate < date('Y-m-d'))) $errors[] = 'Please choose a valid future travel date.';
    if ($selectedDestination && !in_array($selectedDestination, array_column($destinations, 'id'))) $errors[] = 'Please select a valid destination.';
    if ($selectedPackage && !in_array($selectedPackage, array_column($packages, 'id'))) $errors[] = 'Please select a valid package.';

    if (!$errors) {
        $stmt = db()->prepare("INSERT INTO bookings (name,email,phone,destination_id,package_id,travel_date,travelers,message,status,created_at) VALUES (?,?,?,?,?,?,?,?, 'new', NOW())");
        $stmt->execute([$name, $email, $phone, $selectedDestination ?: null, $selectedPackage ?: null, $travelDate ?: null, $travelers, $message ?: null]);
        flash('success', 'Thank you! Your booking enquiry has been received. Our team will contact you.');
        redirect('booking.php');
    }
}
require __DIR__ . '/includes/header.php';
?>
<main><section class="page-hero"><div class="container"><span class="eyebrow">LET'S PLAN YOUR JOURNEY</span><h1>Request a <span>Booking</span></h1><p>Share your plans and our team will follow up with you.</p></div></section>
<section class="section-padding"><div class="container"><div class="form-shell mx-auto">
<?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" action="<?= e(url('booking.php')) ?>" class="row g-3">
<?= csrf_field() ?>
<div class="col-md-6"><label class="form-label" for="name">Full name *</label><input class="form-control" id="name" name="name" required maxlength="120" autocomplete="name" value="<?= e((string)($_POST['name'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label" for="email">Email address *</label><input class="form-control" id="email" name="email" type="email" required maxlength="190" autocomplete="email" value="<?= e((string)($_POST['email'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label" for="phone">Phone number *</label><input class="form-control" id="phone" name="phone" required maxlength="40" autocomplete="tel" value="<?= e((string)($_POST['phone'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label" for="travelers">Number of travelers *</label><input class="form-control" id="travelers" name="travelers" type="number" min="1" max="100" required value="<?= e((string)$travelers) ?>"></div>
<div class="col-md-6"><label class="form-label" for="destination_id">Destination</label><select class="form-select" id="destination_id" name="destination_id"><option value="0">I'm flexible / not decided</option><?php foreach ($destinations as $d): ?><option value="<?= (int)$d['id'] ?>" <?= $selectedDestination === (int)$d['id'] ? 'selected' : '' ?>><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label" for="package_id">Tour package</label><select class="form-select" id="package_id" name="package_id"><option value="0">Choose a package (optional)</option><?php foreach ($packages as $p): ?><option value="<?= (int)$p['id'] ?>" <?= $selectedPackage === (int)$p['id'] ? 'selected' : '' ?>><?= e($p['title']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label" for="travel_date">Preferred travel date</label><input class="form-control" id="travel_date" name="travel_date" type="date" min="<?= date('Y-m-d') ?>" value="<?= e($travelDate) ?>"></div>
<div class="col-12"><label class="form-label" for="message">Trip details / requirements</label><textarea class="form-control" id="message" name="message" rows="5" maxlength="3000" placeholder="Tell us about your plans, budget, transport or accommodation needs."><?= e((string)($_POST['message'] ?? '')) ?></textarea></div>
<div class="col-12"><button class="btn btn-primary-custom w-100" type="submit">Submit Booking Enquiry <i class="bi bi-arrow-right ms-2"></i></button><small class="d-block text-muted mt-3">This submits an enquiry, not a confirmed reservation or payment.</small></div>
</form></div></div></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
