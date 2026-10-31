<?php
include 'db.php';

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

$sql = "INSERT INTO students (name, email, mobile) VALUES ('$name', '$email', '$mobile')";

if (mysqli_query($conn, $sql)) {
    echo "Student registered successfully";
} else {
    echo "Something went wrong: " . mysqli_error($conn);
}
?>
