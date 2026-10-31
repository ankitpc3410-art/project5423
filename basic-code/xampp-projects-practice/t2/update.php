<?php

session_start();

require_once __DIR__ . "/db.php";

$id = $_POST['id'] ?? '';
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($id) || !is_numeric($id)) {
    die("Invalid user ID");
}

if (empty($name)) {
    die("Name is required");
}

if (empty($email)) {
    die("Email is required");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email is not valid");
}

if (empty($password)) {
    die("Password is required");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare(
    $conn,
    "UPDATE users
     SET name = ?, email = ?, password = ?
     WHERE id = ?"
);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "sssi",
    $name,
    $email,
    $hashedPassword,
    $id
);

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: index.php");
    exit;

} else {

    echo "Update failed: " . mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>