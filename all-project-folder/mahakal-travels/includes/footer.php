<footer class="site-footer">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a href="<?= e(url('index.php')) ?>" class="footer-brand"><i class="bi bi-airplane"></i> Mahakal Travels</a>
                <p class="footer-description">Discover new destinations, embrace new experiences and make every journey memorable with Mahakal Travels.</p>
                <div class="social-links">
                    <a href="<?= e(setting('facebook_url', '#')) ?>" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="<?= e(setting('instagram_url', '#')) ?>" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://wa.me/<?= e(preg_replace('/\D+/', '', setting('whatsapp_number', WHATSAPP_NUMBER))) ?>" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="<?= e(url('index.php')) ?>">Home</a></li><li><a href="<?= e(url('destinations.php')) ?>">Destinations</a></li><li><a href="<?= e(url('packages.php')) ?>">Packages</a></li><li><a href="<?= e(url('contact.php')) ?>">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3>Contact</h3>
                <ul class="footer-contact">
                    <li><i class="bi bi-geo-alt"></i><span><?= e(setting('business_address', BUSINESS_ADDRESS)) ?></span></li>
                    <li><i class="bi bi-telephone"></i><span><?= e(setting('business_phone', BUSINESS_PHONE)) ?></span></li>
                    <li><i class="bi bi-envelope"></i><span><?= e(setting('business_email', BUSINESS_EMAIL)) ?></span></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3>Plan a trip</h3>
                <p class="footer-description">Tell us where you want to go. Our team can help you explore suitable travel options.</p>
                <a href="<?= e(url('booking.php')) ?>" class="btn btn-footer">Request a Quote <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
        <div class="footer-bottom mt-4">
            <p class="mb-0">&copy; <?= date('Y') ?> Mahakal Travels. All rights reserved.</p>
            <a href="<?= e(url('admin/login.php')) ?>">Admin Login</a>
        </div>
    </div>
</footer>
<button id="backToTop" class="back-to-top" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(url('assets/js/main.js')) ?>"></script>
</body>
</html>
