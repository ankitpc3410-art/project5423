<?php
require "config.php";
$id=(int)($_GET['id']??0);
$stmt=$conn->prepare("SELECT * FROM innovation_projects WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc();
if(!$r) die("Project not found.");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Edit Project</title><link rel="stylesheet" href="style.css"></head><body>
<nav class="nav"><div class="inner"><strong>Innovation Center</strong><div class="links"><a href="display.php">Projects</a></div></div></nav>
<div class="container"><div class="card"><h1>Edit Project</h1>
<form action="update.php" method="post" enctype="multipart/form-data"><input type="hidden" name="id" value="<?=$id?>">
<div class="grid">
<div><label>Project Title</label><input name="project_title" value="<?=htmlspecialchars($r['project_title'])?>" minlength="5" required></div>
<div><label>Student Name</label><input name="student_name" value="<?=htmlspecialchars($r['student_name'])?>" pattern="[A-Za-z ]+" required></div>
<div><label>College Name</label><input name="college_name" value="<?=htmlspecialchars($r['college_name'])?>" required></div>
<div><label>Branch</label><input name="branch" value="<?=htmlspecialchars($r['branch'])?>" required></div>
<div><label>Domain</label><select name="domain" required><?php foreach(['AI','IoT','Web','Robotics','Embedded'] as $d): ?><option <?= $r['domain']===$d?'selected':'' ?>><?=$d?></option><?php endforeach;?></select></div>
<div><label>Email</label><input type="email" name="email" value="<?=htmlspecialchars($r['email'])?>" required></div>
<div><label>Mobile</label><input name="mobile" value="<?=htmlspecialchars($r['mobile'])?>" pattern="[0-9]{10}" maxlength="10" required></div>
<div><label>Replace Poster (optional)</label><input type="file" name="poster" accept=".jpg,.jpeg,.png,image/jpeg,image/png"><small> Current: <?=htmlspecialchars($r['poster'])?></small></div>
<div class="full"><label>Description</label><textarea name="description" minlength="30" required><?=htmlspecialchars($r['description'])?></textarea></div>
<div class="full"><label>GitHub Link</label><input type="url" name="github_link" value="<?=htmlspecialchars($r['github_link'])?>" required></div>
</div><button class="btn">Update Project</button> <a class="btn secondary" href="display.php">Cancel</a></form></div></div></body></html>