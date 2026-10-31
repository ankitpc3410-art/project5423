<?php
$conn = mysqli_connect("localhost", "root", "", "ajax_class");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
