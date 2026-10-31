<?php
require __DIR__ . '/config.php';
$projects = db()->query('SELECT * FROM projects ORDER BY sort_order ASC, id DESC')->fetchAll();
$skills = db()->query('SELECT * FROM skills ORDER BY sort_order ASC, id ASC')->fetchAll();
$name = setting('name', 'Your Name');
$photo = setting('profile_photo');
$resume = setting('resume_path');
?>
<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($name) ?> | Portfolio</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= e(url('assets/style.css')) ?>" rel="stylesheet">
</head><body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top nav-glass"><div class="container">
<a class="navbar-brand fw-bold" href="#home"><?= e($name) ?><span class="accent">.</span></a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nav"><ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
<li><a class="nav-link" href="#about">About</a></li><li><a class="nav-link" href="#skills">Skills</a></li><li><a class="nav-link" href="#projects">Projects</a></li><li><a class="nav-link" href="#contact">Contact</a></li>
<li><a class="btn btn-outline-light btn-sm px-3" href="<?= e(url('admin/login.php')) ?>">Admin</a></li></ul></div></div></nav>

<header id="home" class="hero"><div class="container"><div class="row align-items-center min-vh-100 g-5">
<div class="col-lg-7 reveal"><p class="eyebrow">HELLO, I'M</p><h1><?= e($name) ?><span class="accent">.</span></h1>
<h2><?= e(setting('role','Creative Developer')) ?></h2><p class="lead mt-4"><?= e(setting('tagline')) ?></p>
<div class="d-flex flex-wrap gap-3 mt-4"><a class="btn btn-primary btn-lg" href="#projects">Explore my work <span>↗</span></a>
<a class="btn btn-outline-light btn-lg" href="#contact">Let's talk</a>
<?php if ($resume): ?><a class="btn btn-outline-light btn-lg" href="<?= e(url($resume)) ?>" target="_blank">Download CV ↓</a><?php endif; ?></div>
<div class="social-row mt-5"><?php if(setting('linkedin_url')):?><a href="<?=e(setting('linkedin_url'))?>" target="_blank">LinkedIn ↗</a><?php endif;?><?php if(setting('github_url')):?><a href="<?=e(setting('github_url'))?>" target="_blank">GitHub ↗</a><?php endif;?></div></div>
<div class="col-lg-5 text-center reveal delay-1"><div class="portrait-wrap"><div class="portrait-orbit"></div>
<?php if($photo):?><img class="portrait" src="<?=e(url($photo))?>" alt="<?=e($name)?>"><?php else:?><div class="portrait placeholder-photo"><?=e(strtoupper(substr($name,0,1)))?></div><?php endif;?>
<div class="floating-note"><span class="status-dot"></span> Available for opportunities</div></div></div>
</div></div><div class="scroll-cue">SCROLL TO EXPLORE <span>↓</span></div></header>

<main>
<section id="about" class="section"><div class="container"><div class="section-head reveal"><span class="eyebrow">01 / ABOUT</span><h2>A little about <span class="accent">me.</span></h2></div>
<div class="row g-5"><div class="col-lg-8 reveal"><p class="about-copy"><?= nl2br(e(setting('about'))) ?></p></div>
<div class="col-lg-4 reveal delay-1"><div class="info-card"><span>BASED IN</span><strong><?=e(setting('location'))?></strong><span>EMAIL</span><a href="mailto:<?=e(setting('email'))?>"><?=e(setting('email'))?></a><?php if(setting('phone')):?><span>PHONE</span><strong><?=e(setting('phone'))?></strong><?php endif;?></div></div></div></div></section>

<section id="skills" class="section section-alt"><div class="container"><div class="section-head reveal"><span class="eyebrow">02 / TOOLKIT</span><h2>Skills & <span class="accent">expertise.</span></h2></div>
<div class="row g-4"><?php foreach($skills as $s):?><div class="col-md-6 col-lg-4 reveal"><div class="skill-card"><div class="d-flex justify-content-between"><h3><?=e($s['name'])?></h3><span><?= (int)$s['level']?>%</span></div><div class="progress"><div class="progress-bar" style="width:<?=min(100,(int)$s['level'])?>%"></div></div></div></div><?php endforeach;?></div>
<?php if(!$skills):?><p class="muted">Skills will be added soon.</p><?php endif;?></div></section>

<section id="projects" class="section"><div class="container"><div class="section-head reveal"><span class="eyebrow">03 / SELECTED WORK</span><h2>Featured <span class="accent">projects.</span></h2></div>
<div class="row g-4"><?php foreach($projects as $p):?><div class="col-md-6 reveal"><article class="project-card">
<?php if($p['image_path']):?><div class="project-image"><img src="<?=e(url($p['image_path']))?>" alt="<?=e($p['title'])?>"></div><?php else:?><div class="project-image project-placeholder">PROJECT / <?=sprintf('%02d',(int)$p['id'])?></div><?php endif;?>
<div class="project-body"><div><span class="eyebrow">FEATURED PROJECT</span><h3><?=e($p['title'])?></h3><p><?=e($p['description'])?></p></div><?php if($p['website_url']):?><a class="project-link" href="<?=e($p['website_url'])?>" target="_blank" rel="noopener">View live project ↗</a><?php endif;?></div></article></div><?php endforeach;?>
<?php if(!$projects):?><p class="muted">Projects will appear here soon.</p><?php endif;?></div></div></section>

<section id="contact" class="section contact-section"><div class="container"><div class="row g-5"><div class="col-lg-5 reveal"><span class="eyebrow">04 / GET IN TOUCH</span><h2>Have a project<br>in <span class="accent">mind?</span></h2><p class="muted mt-4">Have an idea, opportunity, or just want to say hello? Send me a message.</p><a class="contact-email" href="mailto:<?=e(setting('email'))?>"><?=e(setting('email'))?> ↗</a></div>
<div class="col-lg-7 reveal delay-1"><?php if(isset($_GET['sent'])):?><div class="alert alert-success">Thanks! Your message has been sent.</div><?php endif;?>
<form class="contact-form" action="<?=e(url('contact.php'))?>" method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<div class="row g-3"><div class="col-md-6"><label>Your name</label><input required name="name" maxlength="120" class="form-control"></div><div class="col-md-6"><label>Email address</label><input required type="email" name="email" maxlength="190" class="form-control"></div><div class="col-12"><label>Subject</label><input name="subject" maxlength="190" class="form-control"></div><div class="col-12"><label>Your message</label><textarea required name="message" rows="5" maxlength="5000" class="form-control"></textarea></div><div class="col-12"><button class="btn btn-primary btn-lg">Send message ↗</button></div></div></form></div></div></div></section>
</main>
<footer><div class="container d-flex flex-wrap justify-content-between gap-2"><span>© <?=date('Y')?> <?=e($name)?>. Crafted with purpose.</span><a href="#home">Back to top ↑</a></div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script src="<?=e(url('assets/app.js'))?>"></script></body></html>
