<?php

// use LDAP\Result;        

include"db.php";
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ??'');
$phone = trim($_POST['phone'] ??'');


if (empty($name)) {
    die ('Name is required'); 
}
if (empty($email)) {
    die ('Email is required'); 
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die ('Email is not valid'); 
}
// =================================
// email uniqueness check
// ================================

$check = mysqli_prepare(
    $conn,
    "SELECT id FROM students WHERE email = ?"
);
mysqli_stmt_bind_param($check, "s", $email);
mysqli_stmt_execute($check);
$result = mysqli_stmt_get_result($check);
if (mysqli_num_rows($result) > 0) {
    die ('Email is already in use'); 
}

// ================================
// end of email uniqueness check
// ================================== 

if (empty($phone)) {
    die ('Phone is required'); 
}
if(!preg_match('/^[0-9]{10}$/', $phone)) {
    die ('Phone must be a 10 digit number'); 
}
// ===============================
// image upload handling
// ===============================

$image = $_FILES['image'] ?? null;
$imageName = $image['name'] ?? null;
$imageTmpName = $image['tmp_name'] ?? null;
$uploadfolder = 'uploads/';
$imagePath = $uploadfolder . $imageName;
move_uploaded_file($imageTmpName, $imagePath);

// ===============================
// end of image upload handling
// ===============================
$stmt = mysqli_prepare(
    $conn,
    "insert into students (name, email, phone, image) values (?, ?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $imageName);
if(mysqli_stmt_execute($stmt)) {
    header("Location: view.php?msg= inserted ");
    exit();
    echo "User inserted successfully";
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>