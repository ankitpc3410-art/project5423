<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Discover India, Create Memories';
$metaDescription = 'Explore spiritual journeys, family holidays and customized India tour packages with Mahakal Travels.';
$activePage = 'home';

$destinations = db()->query("SELECT * FROM destinations WHERE is_active = 1 ORDER BY sort_order, id DESC LIMIT 3")->fetchAll();
$packages = db()->query("SELECT p.*, d.name AS destination_name FROM packages p LEFT JOIN destinations d ON d.id = p.destination_id WHERE p.is_active = 1 ORDER BY p.is_featured DESC, p.id DESC LIMIT 3")->fetchAll();

require __DIR__ . '/includes/header.php';
?>
<main>
<section class="hero-section">
    <div class="container">
        <div class="hero-panel">
            <div class="hero-content">
                <span class="hero-badge"><i class="bi bi-compass me-2"></i>YOUR JOURNEY, OUR PASSION</span>
                <h1>Mahakal Travels <span>Discover India. Create Memories.</span></h1>
                <p>From sacred temples to breathtaking landscapes, let us help you plan a memorable journey. Your next destination is closer than you think.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= e(url('packages.php')) ?>" class="btn btn-primary-custom">Explore Packages <i class="bi bi-arrow-right ms-2"></i></a>
                    <a href="<?= e(url('destinations.php')) ?>" class="btn btn-outline-light-custom">Discover Destinations</a>
                </div>
                <div class="hero-features"><span><i class="bi bi-shield-check"></i> Thoughtful trip planning</span><span><i class="bi bi-geo-alt"></i> Destinations across India</span></div>
            </div>
            <div class="hero-bottom-label">EXPLORE MORE <span></span> INDIA & BEYOND</div>
        </div>
    </div>
</section>


<section class="booking-strip">
    <div class="container">
        <div class="booking-card">
            <div><span class="eyebrow">PLAN YOUR NEXT TRIP</span><h2>Where would you like to go?</h2><p>Start with a destination and tell us about your plans.</p></div>
            <form class="booking-quick-form" action="<?= e(url('booking.php')) ?>" method="get">
                <div><label for="quickDestination">Destination</label><select class="form-select" name="destination" id="quickDestination"><option value="">Choose destination</option><?php foreach ($destinations as $destination): ?><option value="<?= (int)$destination['id'] ?>"><?= e($destination['name']) ?></option><?php endforeach; ?></select></div>
                <div><label for="quickDate">Travel date</label><input class="form-control" type="date" name="travel_date" id="quickDate" min="<?= date('Y-m-d') ?>"></div>
                <div><label for="quickGuests">Travelers</label><select class="form-select" name="travelers" id="quickGuests"><option>1</option><option selected>2</option><option>3</option><option>4</option><option>5</option><option value="6">6+</option></select></div>
                <button class="btn booking-submit" type="submit">Plan My Trip <i class="bi bi-arrow-right ms-1"></i></button>
            </form>
        </div>
    </div>
</section>

<section class="section-padding" id="destinations">
    <div class="container">
        <div class="section-heading text-center"><span class="eyebrow">EXPLORE THE INCREDIBLE</span><h2>Popular <span>Destinations</span></h2><p>Discover sacred cities, rich heritage and remarkable landscapes across India.</p></div>
        <div class="row g-4">
            <?php if ($destinations): foreach ($destinations as $destination): ?>
            <div class="col-md-6 col-lg-4"><article class="destination-card">
                <img src="<?= e(image_url($destination['image'], 'assets/images/hero.jpg')) ?>" alt="<?= e($destination['name']) ?>" loading="lazy">
                <span class="destination-tag"><?= e($destination['category'] ?: 'Explore India') ?></span>
                <div class="destination-overlay"><div><small><?= e($destination['state']) ?></small><h3><?= e($destination['name']) ?></h3><p><?= e($destination['short_description']) ?></p></div><a class="round-arrow" href="<?= e(url('booking.php?destination=' . (int)$destination['id'])) ?>" aria-label="Enquire about <?= e($destination['name']) ?>"><i class="bi bi-arrow-up-right"></i></a></div>
            </article></div>
            <?php endforeach; else: ?><div class="col-12"><div class="empty-state">Destinations will appear here once added in the admin panel.</div></div><?php endif; ?>
        </div>
        <div class="text-center mt-5"><a href="<?= e(url('destinations.php')) ?>" class="btn btn-outline-custom">Explore All Destinations <i class="bi bi-arrow-right ms-2"></i></a></div>
    </div>
</section>

<section class="section-padding about-section" id="about">
    <div class="container"><div class="row align-items-center g-5">
        <div class="col-lg-6"><div class="about-image-wrap"><img src="<?= e(url('assets/images/rishikesh.jpg')) ?>" alt="Scenic Indian travel destination" loading="lazy"><div class="image-note"><div><strong>Travel made personal</strong><span>Every journey matters</span></div></div></div></div>
        <div class="col-lg-6"><span class="eyebrow">WELCOME TO MAHAKAL TRAVELS</span><h2 class="display-heading">Every journey has a story. <span>Let's write yours.</span></h2><p>We believe travel is more than reaching a destination. It is about discovering places, experiencing culture and creating memories that stay with you.</p><p>Whether you are planning a pilgrimage, family holiday, romantic getaway or sightseeing trip, we can help you explore options that suit your interests and schedule.</p><ul class="check-list"><li><i class="bi bi-check-circle-fill"></i> Personalized travel plans</li><li><i class="bi bi-check-circle-fill"></i> Flexible travel options</li><li><i class="bi bi-check-circle-fill"></i> Helpful enquiry and booking assistance</li><li><i class="bi bi-check-circle-fill"></i> Experiences for different travel styles</li></ul><a href="<?= e(url('contact.php')) ?>" class="btn btn-primary-custom mt-3">Talk to Our Team <i class="bi bi-arrow-right ms-2"></i></a></div>
    </div></div>
</section>

<section class="section-padding" id="packages">
    <div class="container"><div class="section-heading text-center"><span class="eyebrow">FIND YOUR PERFECT ESCAPE</span><h2>Featured Tour <span>Packages</span></h2><p>Find inspiration for your next journey. Ask us for a customized quote.</p></div>
        <div class="row g-4">
        <?php if ($packages): foreach ($packages as $package): ?>
            <div class="col-md-6 col-lg-4"><article class="package-card"><div class="package-image"><img src="<?= e(image_url($package['image'], 'assets/images/hero.jpg')) ?>" alt="<?= e($package['title']) ?>" loading="lazy"><span class="destination-tag"><?= e($package['category']) ?></span></div><div class="package-body"><small class="location-line"><i class="bi bi-geo-alt"></i> <?= e($package['destination_name'] ?? 'India') ?></small><h3><?= e($package['title']) ?></h3><p><?= e($package['short_description']) ?></p><div class="package-meta"><span><i class="bi bi-clock"></i> <?= e($package['duration'] ?: 'Flexible duration') ?></span><strong><?= e(money($package['price'])) ?></strong></div><a href="<?= e(url('booking.php?package=' . (int)$package['id'])) ?>" class="package-link">Enquire about this trip <i class="bi bi-arrow-right"></i></a></div></article></div>
        <?php endforeach; else: ?><div class="col-12"><div class="empty-state">Tour packages will appear here once added in the admin panel.</div></div><?php endif; ?>
        </div><div class="text-center mt-5"><a href="<?= e(url('packages.php')) ?>" class="btn btn-outline-custom">View All Packages <i class="bi bi-arrow-right ms-2"></i></a></div>
    </div>
</section>

<section class="section-padding why-section">
    <div class="container"><div class="section-heading text-center"><span class="eyebrow">THE MAHAKAL EXPERIENCE</span><h2>Why Travel With <span>Us?</span></h2><p>Travel planning should feel exciting, clear and personal.</p></div>
        <div class="row g-4">
            <div class="col-sm-6 col-lg-3"><div class="why-card"><div class="why-icon"><i class="bi bi-person-heart"></i></div><h3>Personalized Trips</h3><p>Plans shaped around your interests, schedule and preferences.</p></div></div>
            <div class="col-sm-6 col-lg-3"><div class="why-card"><div class="why-icon"><i class="bi bi-signpost-split"></i></div><h3>Local Experiences</h3><p>Explore cultural landmarks, sacred places and local highlights.</p></div></div>
            <div class="col-sm-6 col-lg-3"><div class="why-card"><div class="why-icon"><i class="bi bi-wallet2"></i></div><h3>Flexible Options</h3><p>Discuss options that fit your travel style and budget.</p></div></div>
            <div class="col-sm-6 col-lg-3"><div class="why-card"><div class="why-icon"><i class="bi bi-headset"></i></div><h3>Helpful Assistance</h3><p>Get help with itinerary planning and travel enquiries.</p></div></div>
        </div>
    </div>
</section>

<section class="section-padding" id="gallery"><div class="container"><div class="section-heading text-center"><span class="eyebrow">MOMENTS WORTH EXPLORING</span><h2>Travel <span>Gallery</span></h2><p>A little inspiration for the places you might explore next.</p></div>
    <div class="gallery-grid">
        <a href="<?= e(url('destinations.php')) ?>" class="gallery-item gallery-large"><img src="<?= e(url('assets/images/varanasi.jpg')) ?>" alt="Varanasi riverfront" loading="lazy"><span>Varanasi</span></a>
        <a href="<?= e(url('destinations.php')) ?>" class="gallery-item"><img src="<?= e(url('assets/images/mahakaleshwar.jpg')) ?>" alt="Ujjain temple" loading="lazy"><span>Ujjain</span></a>
        <a href="<?= e(url('destinations.php')) ?>" class="gallery-item"><img src="<?= e(url('assets/images/ayodhya.jpg')) ?>" alt="Ayodhya temple" loading="lazy"><span>Ayodhya</span></a>
        <a href="<?= e(url('destinations.php')) ?>" class="gallery-item"><img src="<?= e(url('assets/images/rishikesh.jpg')) ?>" alt="Rishikesh landscape" loading="lazy"><span>Rishikesh</span></a>
        <a href="<?= e(url('destinations.php')) ?>" class="gallery-item"><img src="<?= e(url('assets/images/tajmahal.jpg')) ?>" alt="Taj Mahal, Agra" loading="lazy"><span>Agra</span></a>
    </div>
</div></section>

<section class="cta-section"><div class="container text-center"><span class="eyebrow">YOUR NEXT ADVENTURE STARTS HERE</span><h2>The world is waiting. <span>Let's explore it together.</span></h2><p>Tell us your dream destination and request a travel plan made for you.</p><a href="<?= e(url('booking.php')) ?>" class="btn btn-cta">Start Planning Today <i class="bi bi-arrow-right ms-2"></i></a></div></section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
