<?php
require "config.php";
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register Project</title><link rel="stylesheet" href="style.css"></head>
<body>
<nav class="nav"><div class="inner"><strong>Innovation Center</strong><div class="links"><a href="index.php">Register</a><a href="display.php">Projects</a></div></div></nav>
<div class="container"><div class="card">
<h1>Project Registration</h1>
<?php if ($msg): ?><div class="msg success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<form action="insert.php" method="post" enctype="multipart/form-data">
<div class="grid">
<div><label>Project Title</label><input name="project_title" minlength="5" maxlength="150" required></div>
<div><label>Student Name</label><input name="student_name" pattern="[A-Za-z ]+" required></div>
<div><label>College Name</label><input name="college_name" maxlength="150" required></div>
<div><label>Branch</label><select name="branch" required><option value="">Select Branch</option><option>CSE</option><option>IT</option><option>ECE</option><option>EEE</option><option>ME</option><option>Civil</option><option>Other</option></select></div>
<div><label>Project Domain</label><select name="domain" required><option value="">Select Domain</option><option>AI</option><option>IoT</option><option>Web</option><option>Robotics</option><option>Embedded</option></select></div>
<div><label>Email</label><input type="email" name="email" required></div>
<div><label>Mobile</label><input name="mobile" pattern="[0-9]{10}" maxlength="10" inputmode="numeric" required></div>
<div><label>Project Poster (JPG/PNG, max 2 MB)</label><input type="file" name="poster" accept=".jpg,.jpeg,.png,image/jpeg,image/png"></div>
<div class="full"><label>Project Description</label><textarea name="description" minlength="30" required></textarea></div>
<div class="full"><label>GitHub Link</label><input type="url" name="github_link" placeholder="https://github.com/username/project" required></div>
</div>
<button class="btn" type="submit">Submit Project</button>
</form></div></div>
</body></html>