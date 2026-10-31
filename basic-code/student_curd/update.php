<?php
include 'db.php';
$id = $_POST['id'] ?? ''; 
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ??'');
$phone = trim($_POST['phone'] ??'');
$old_image = $_POST['old_image'] ?? '';
if(!empty($_FILES['image']['name'])){
    $image = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $uploadfolder = 'uploads/';
    $imagePath = $uploadfolder . $image;
    move_uploaded_file($imageTmpName, $imagePath);
}
else{
    $image = $old_image;
}
// new type of validation
if(!filter_var($id, FILTER_VALIDATE_INT)) {
    die('Invalid student ID');
}
if (empty($name)) {
    die ('Name is required'); 
}
if (empty($email)) {
    die ('Email is required'); 
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die ('Email is not valid'); 
}
// email uniqueness check
$check = mysqli_prepare(
    $conn,
    "SELECT id FROM students WHERE email = ? and id != ?"
);
mysqli_stmt_bind_param($check, "si", $email, $_POST['id']);
mysqli_stmt_execute($check);
$result = mysqli_stmt_get_result($check);
if (mysqli_num_rows($result) > 0) {
    die ('Email is already in use'); 
}
// end of email uniqueness check
if (empty($phone)) {
    die ('Phone is required'); 
}
if(!preg_match('/^[0-9]{10}$/', $phone)) {
    die ('Phone must be a 10 digit number'); 
}
$stmt = mysqli_prepare(
    $conn,
    "update students set name=?, email=?, phone=?, image=? where id=?"
);
mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $phone, $image, $id);
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