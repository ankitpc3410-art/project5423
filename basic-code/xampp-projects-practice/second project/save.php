<?php
include 'db.php';

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$age = $_POST['age'] ?? '';
$gender = $_POST['gender'] ?? '';
$city = $_POST['city'] ?? '';

// Get hobbies as an array
$hobbies = $_POST['hobbies'] ?? [];

// Convert array to string
$hobbies = implode(', ', $hobbies);

$address = $_POST['address'] ?? '';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection is not available.');
}

// Hash password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insert data safely
$stmt = mysqli_prepare(
    $conn,
    'INSERT INTO form 
    (name, email, password, age, gender, city, hobbies, address)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
);

if (!$stmt) {
    die('Database query could not be prepared.');
}

mysqli_stmt_bind_param(
    $stmt,
    'ssssssss',
    $name,
    $email,
    $passwordHash,
    $age,
    $gender,
    $city,
    $hobbies,
    $address
);

if (mysqli_stmt_execute($stmt)) {
    echo "New record created successfully";
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>