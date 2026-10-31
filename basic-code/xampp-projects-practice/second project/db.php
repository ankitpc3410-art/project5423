<?php
$servername = "localhost";
$username = "root";           // Default username for XAMPP
$password = "";               // Default password for XAMPP is blank
$dbname = "studentdb"; // Change this to your actual database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>