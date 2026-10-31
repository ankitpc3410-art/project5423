<?php
require dirname(__DIR__) . '/config.php'; require_admin();
$fields = ['name','role','tagline','email','phone','location','about','linkedin_url','github_url','website_url'];
if ($_SERVER['REQUEST_METHOD']==='POST') {
 csrf_check();
 try {
  foreach($fields as $f) { $v=trim($_POST[$f]??''); if($f==='email' && $v!=='' && !filter_var($v,FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Enter a valid email address.'); $st=db()->prepare('INSERT INTO settings(setting_key,setting_value) VALUES(?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)'); $st->execute([$f,$v]); }
  $photo=upload_file('profile_photo','projects',['image/jpeg'=>['jpg'],'image/png'=>['png'],'image/webp'=>['webp']]);
  if($photo){delete_upload(setting('profile_photo'));$st=db()->prepare("UPDATE settings SET setting_value=? WHERE setting_key='profile_photo'");$st->execute([$photo]);}
  $resume=upload_file('resume','resume',['application/pdf'=>['pdf']],8000000);
  if($resume){delete_upload(setting('resume_path'));$st=db()->prepare("UPDATE settings SET setting_value=? WHERE setting_key='resume_path'");$st->execute([$resume]);}
  flash('Profile updated successfully.');
 } catch(Throwable $e){flash($e->getMessage(),'danger');}
 redirect('admin/profile.php');
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Profile settings</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="../assets/style.css" rel="stylesheet"></head><body class="dashboard"><div class="admin-shell"><?php include 'nav.php';?><main class="admin-main"><div class="admin-top"><div><span class="eyebrow">WEBSITE CONTENT</span><h1>Profile & about</h1></div></div><?php show_flash();?><div class="admin-panel"><form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><div class="row g-3">
<?php foreach($fields as $f):?><div class="col-md-<?=in_array($f,['about','tagline'])?'12':'6'?>"><label><?=ucfirst(str_replace('_',' ',$f))?></label><?php if($f==='about'):?><textarea class="form-control" rows="6" name="<?=$f?>"><?=e(setting($f))?></textarea><?php else:?><input class="form-control" name="<?=$f?>" value="<?=e(setting($f))?>" <?=in_array($f,['email'])?'type="email"':''?>><?php endif;?></div><?php endforeach;?>
<div class="col-md-6"><label>Profile photo (JPG, PNG, WEBP)</label><input class="form-control" type="file" name="profile_photo" accept=".jpg,.jpeg,.png,.webp"><?php if(setting('profile_photo')):?><small class="muted">Current: <?=e(setting('profile_photo'))?></small><?php endif;?></div>
<div class="col-md-6"><label>Resume (PDF, max 8 MB)</label><input class="form-control" type="file" name="resume" accept=".pdf"><?php if(setting('resume_path')):?><small><a href="../<?=e(setting('resume_path'))?>" target="_blank">View current resume</a> — uploading a new PDF replaces it.</small><?php endif;?></div>
<div class="col-12"><button class="btn btn-primary">Save profile changes</button></div></div></form></div></main></div></body></html>
