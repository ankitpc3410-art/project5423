<?php
require "config.php";

function fail($msg){ die('<link rel="stylesheet" href="style.css"><div class="container"><div class="card"><div class="msg">'.htmlspecialchars($msg).'</div><a class="btn secondary" href="index.php">Go Back</a></div></div>'); }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location:index.php"); exit; }

$title=trim($_POST['project_title']??''); $student=trim($_POST['student_name']??'');
$college=trim($_POST['college_name']??''); $branch=trim($_POST['branch']??'');
$domain=trim($_POST['domain']??''); $email=trim($_POST['email']??'');
$mobile=trim($_POST['mobile']??''); $description=trim($_POST['description']??'');
$github=trim($_POST['github_link']??'');

if(strlen($title)<5 || !preg_match('/^[A-Za-z ]+$/',$student) || !$college || !$branch || !$domain ||
   !filter_var($email,FILTER_VALIDATE_EMAIL) || !preg_match('/^[0-9]{10}$/',$mobile) ||
   strlen($description)<30 || !filter_var($github,FILTER_VALIDATE_URL)) fail("Please enter valid data in all fields.");

$poster='default.png';
if(isset($_FILES['poster']) && $_FILES['poster']['error'] !== UPLOAD_ERR_NO_FILE){
    if($_FILES['poster']['error'] !== UPLOAD_ERR_OK) fail("Image upload failed.");
    if($_FILES['poster']['size'] > 2*1024*1024) fail("Image must be 2 MB or smaller.");
    $allowed=['image/jpeg'=>'jpg','image/png'=>'png'];
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($_FILES['poster']['tmp_name']);
    if(!isset($allowed[$mime])) fail("Only JPG/PNG images are allowed.");
    $poster=uniqid('poster_',true).'.'.$allowed[$mime];
    if(!move_uploaded_file($_FILES['poster']['tmp_name'], __DIR__.'/uploads/'.$poster)) fail("Could not save image.");
}

$stmt=$conn->prepare("INSERT INTO innovation_projects(project_title,student_name,college_name,branch,domain,email,mobile,description,poster,github_link) VALUES(?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssss",$title,$student,$college,$branch,$domain,$email,$mobile,$description,$poster,$github);
$stmt->execute();
header("Location: index.php?msg=".urlencode("Project submitted successfully."));
exit;
?>