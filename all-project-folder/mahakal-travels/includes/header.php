<?php
$pageTitle = $pageTitle ?? APP_NAME;
$activePage = $activePage ?? '';
$flashMessage = get_flash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($metaDescription ?? 'Discover India with Mahakal Travels. Explore spiritual journeys, family holidays and customized travel packages.') ?>">
    <title><?= e($pageTitle) ?> | <?= e(APP_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
     <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top main-navbar">
    <div class="container">
        
<a class="navbar-brand d-flex align-items-center"
   href="<?= BASE_URL ?>/">

     <video autoplay loop muted playsinline class="site-logo" style=" width: 80px;
    height: 80px;
    border-radius: 50%;" >
            <source src="<?= e(url('assets/images/logo.mp4')) ?>" type="video/mp4" id="logo">
        </video>

</a>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link <?= $activePage === 'home' ? 'active' : '' ?>" href="<?= e(url('index.php')) ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $activePage === 'destinations' ? 'active' : '' ?>" href="<?= e(url('destinations.php')) ?>">Popular Destinations</a></li>
                <li class="nav-item"><a class="nav-link <?= $activePage === 'packages' ? 'active' : '' ?>" href="<?= e(url('packages.php')) ?>">Packages</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('index.php#about')) ?>">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('index.php#gallery')) ?>">Gallery</a></li>
                <li class="nav-item"><a class="nav-link <?= $activePage === 'contact' ? 'active' : '' ?>" href="<?= e(url('contact.php')) ?>">Contact Us</a></li>
            </ul>
            <a class="btn btn-book-nav" href="<?= e(url('booking.php')) ?>">Book Now <i class="bi bi-arrow-up-right ms-1"></i></a>
        </div>
    </div>
</nav>
<?php if ($flashMessage): ?>
<div class="container mt-3"><div class="alert alert-<?= e($flashMessage['type']) ?> alert-dismissible fade show" role="alert"><?= e($flashMessage['message']) ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>
<?php endif; ?>
