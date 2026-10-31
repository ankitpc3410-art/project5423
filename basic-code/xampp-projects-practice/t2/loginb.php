
<?php

session_start();

require_once __DIR__ . "/db.php";

// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

// Check empty fields
if ($email === "" || $password === "") {
    header("Location: login.php?error=" . urlencode("Please fill all fields."));
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: login.php?error=" . urlencode("Please enter a valid email."));
    exit;
}

// Find user using MySQLi
$stmt = mysqli_prepare(
    $conn,
    "SELECT id, name, email, password
     FROM users
     WHERE email = ?
     LIMIT 1"
);

if (!$stmt) {
    die("Database query failed: " . mysqli_error($conn));
}

// Bind email
mysqli_stmt_bind_param($stmt, "s", $email);

// Execute query
mysqli_stmt_execute($stmt);

// Get result
$result = mysqli_stmt_get_result($stmt);

// Get user
$user = mysqli_fetch_assoc($result);

// Check email and password
if (!$user || !password_verify($password, $user["password"])) {
    header("Location: login.php?error=" . urlencode("Invalid email or password."));
    exit;
}

// Regenerate session ID for security
session_regenerate_id(true);

// Store user information
$_SESSION["user_id"] = $user["id"];
$_SESSION["user_name"] = $user["name"];
$_SESSION["user_email"] = $user["email"];

// Login successful
header("Location: index.php");
exit;
?>

