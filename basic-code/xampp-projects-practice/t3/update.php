<?php
include 'db.php';
$id = $_POST['id'] ?? ''; 
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ??'');
$mobile = trim($_POST['mobile'] ??'');
$college = trim($_POST['college'] ??'');
$branch = trim($_POST['branch'] ??'');
$technology = trim($_POST['technology'] ??'');
$duration = trim($_POST['duration'] ??'');
$skills = trim($_POST['skills'] ??'');
$address = trim($_POST['address'] ??'');

if (empty($name)) {
    die ('Name is required'); 
}
if (empty($email)) {
    die ('Email is required'); 
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die ('Email is not valid'); 
}
if (empty($mobile)) {
    die ('Mobile is required'); 
}
if(!preg_match('/^[0-9]{10}$/', $mobile)) {
    die ('Mobile must be a 10 digit number'); 
}
if (!preg_match('/^[A-Za-z0-9\s.\-&]+$/', $college)) {
    die('College name is not valid');
}
if(!preg_match('/^[A-Za-z0-9\s.\-&]+$/', $branch)) {
    die ('Branch name is not valid'); 
}
if(!preg_match('/^[A-Za-z0-9\s.\-&]+$/', $technology)) {
    die ('Technology name is not valid'); 
}
if(!preg_match('/^[0-9]+$/', $duration)) {
    die ('Duration must be a number'); 
}
if(!preg_match('/^[A-Za-z0-9\s,.\-\/#()]+$/', $skills)) {
    die ('Skills name is not valid'); 
}
if (empty($address)) {
    die('Address is required');
}

if (!preg_match('/^[A-Za-z0-9\s,.\-\/#()]+$/', $address)) {
    die('Address is not valid');
}
$stmt = mysqli_prepare(
    $conn,
    "update internship_students set name=?, email=?, mobile=?, college=?, branch=?, technology=?, duration=?, skills=?, address=? where id=?"
);
mysqli_stmt_bind_param(
    $stmt,
    "sssssssssi",
    $name,
    $email,
    $mobile,
    $college,
    $branch,
    $technology,
    $duration,
    $skills,
    $address,
    $id
);
if(mysqli_stmt_execute($stmt)){
    // echo"Student updated successfully";
    header("Location: view.php?msg= updated ");
    exit(); 
}
else {
    echo "Error: " . mysqli_stmt_error($stmt);
}mysqli_stmt_close($stmt);
mysqli_close($conn);
// $conn->close();
?>