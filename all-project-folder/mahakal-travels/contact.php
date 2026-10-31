<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Contact Us';
$activePage = 'contact';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = post_string('name', 120);
    $email = post_string('email', 190);
    $phone = post_string('phone', 40);
    $subject = post_string('subject', 190);
    $message = post_string('message', 4000);
    if ($name === '') $errors[] = 'Please enter your name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if ($message === '') $errors[] = 'Please enter a message.';
    if (!$errors) {
        $stmt = db()->prepare("INSERT INTO contact_messages (name,email,phone,subject,message,status,created_at) VALUES (?,?,?,?,?,'new',NOW())");
        $stmt->execute([$name, $email, $phone ?: null, $subject ?: null, $message]);
        flash('success', 'Thanks for contacting Mahakal Travels. Your message has been received.');
        redirect('contact.php');
    }
}
require __DIR__ . '/includes/header.php';
?>
<main><section class="page-hero"><div class="container"><span class="eyebrow">WE'RE HERE TO HELP</span><h1>Contact <span>Mahakal Travels</span></h1><p>Ask a question, discuss your plans or request a personalized quote.</p></div></section>
<section class="section-padding"><div class="container"><div class="row g-5"><div class="col-lg-5"><span class="eyebrow">GET IN TOUCH</span><h2 class="display-heading">Let's plan something <span>memorable.</span></h2><p>Send us your travel enquiry and our team will get back to you.</p><div class="contact-details mt-4"><p><i class="bi bi-telephone"></i><span><?= e(setting('business_phone', BUSINESS_PHONE)) ?></span></p><p><i class="bi bi-envelope"></i><span><?= e(setting('business_email', BUSINESS_EMAIL)) ?></span></p><p><i class="bi bi-geo-alt"></i><span><?= e(setting('business_address', BUSINESS_ADDRESS)) ?></span></p></div></div><div class="col-lg-7"><div class="form-shell">
<?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" class="row g-3"><?= csrf_field() ?>
<div class="col-md-6"><label class="form-label" for="name">Full name *</label><input class="form-control" id="name" name="name" maxlength="120" required value="<?= e((string)($_POST['name'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label" for="email">Email address *</label><input class="form-control" id="email" name="email" type="email" maxlength="190" required value="<?= e((string)($_POST['email'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label" for="phone">Phone number</label><input class="form-control" id="phone" name="phone" maxlength="40" value="<?= e((string)($_POST['phone'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label" for="subject">Subject</label><input class="form-control" id="subject" name="subject" maxlength="190" value="<?= e((string)($_POST['subject'] ?? '')) ?>"></div>
<div class="col-12"><label class="form-label" for="message">Message *</label><textarea class="form-control" id="message" name="message" rows="5" maxlength="4000" required><?= e((string)($_POST['message'] ?? '')) ?></textarea></div>
<div class="col-12"><button class="btn btn-primary-custom w-100" type="submit">Send Message <i class="bi bi-send ms-2"></i></button></div>
</form></div></div></div></div></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
