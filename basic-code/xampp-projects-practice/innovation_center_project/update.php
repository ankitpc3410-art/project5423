<?php
require "config.php";
function fail($m){die('<link rel="stylesheet" href="style.css"><div class="container"><div class="card"><div class="msg">'.htmlspecialchars($m).'</div><a class="btn" href="display.php">Back</a></div></div>');}
$id=(int)($_POST['id']??0);
$stmt=$conn->prepare("SELECT poster FROM innovation_projects WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); $old=$stmt->get_result()->fetch_assoc(); if(!$old) fail("Project not found.");
$title=trim($_POST['project_title']??''); $student=trim($_POST['student_name']??''); $college=trim($_POST['college_name']??'');
$branch=trim($_POST['branch']??''); $domain=trim($_POST['domain']??''); $email=trim($_POST['email']??''); $mobile=trim($_POST['mobile']??'');
$description=trim($_POST['description']??''); $github=trim($_POST['github_link']??'');
if(strlen($title)<5 || !preg_match('/^[A-Za-z ]+$/',$student) || !$college || !$branch || !$domain || !filter_var($email,FILTER_VALIDATE_EMAIL) || !preg_match('/^[0-9]{10}$/',$mobile) || strlen($description)<30 || !filter_var($github,FILTER_VALIDATE_URL)) fail("Please enter valid data.");
$poster=$old['poster'];
if(isset($_FILES['poster']) && $_FILES['poster']['error']!==UPLOAD_ERR_NO_FILE){
 if($_FILES['poster']['error']!==UPLOAD_ERR_OK || $_FILES['poster']['size']>2*1024*1024) fail("Image upload failed or exceeds 2 MB.");
 $allowed=['image/jpeg'=>'jpg','image/png'=>'png']; $mime=(new finfo(FILEINFO_MIME_TYPE))->file($_FILES['poster']['tmp_name']);
 if(!isset($allowed[$mime])) fail("Only JPG/PNG images are allowed.");
 $poster=uniqid('poster_',true).'.'.$allowed[$mime];
 if(!move_uploaded_file($_FILES['poster']['tmp_name'],__DIR__.'/uploads/'.$poster)) fail("Could not save image.");
 if($old['poster']!=='default.png' && is_file(__DIR__.'/uploads/'.$old['poster'])) unlink(__DIR__.'/uploads/'.$old['poster']);
}
$stmt=$conn->prepare("UPDATE innovation_projects SET project_title=?,student_name=?,college_name=?,branch=?,domain=?,email=?,mobile=?,description=?,poster=?,github_link=? WHERE id=?");
$stmt->bind_param("ssssssssssi",$title,$student,$college,$branch,$domain,$email,$mobile,$description,$poster,$github,$id); $stmt->execute();
header("Location: display.php"); exit;
?>