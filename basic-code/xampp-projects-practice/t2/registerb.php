<?php

session_start();

require_once __DIR__ . "/db.php";


// =====================================================
// ONLY ALLOW POST REQUEST
// =====================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit;
}


// =====================================================
// GET FORM DATA
// =====================================================

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$gender = trim($_POST["gender"] ?? "");

$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";


// =====================================================
// CHECK EMPTY FIELDS
// =====================================================

if (
    $name === "" ||
    $email === "" ||
    $phone === "" ||
    $gender === "" ||
    $password === "" ||
    $confirmPassword === ""
) {
    header(
        "Location: register.php?error=" .
        urlencode("Please fill all fields.")
    );
    exit;
}


// =====================================================
// VALIDATE NAME
// =====================================================

if (strlen($name) < 2) {
    header(
        "Location: register.php?error=" .
        urlencode("Name must be at least 2 characters.")
    );
    exit;
}


// =====================================================
// VALIDATE EMAIL
// =====================================================

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header(
        "Location: register.php?error=" .
        urlencode("Please enter a valid email address.")
    );
    exit;
}


// =====================================================
// VALIDATE PHONE
// =====================================================

// Accept 10 digit phone number
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    header(
        "Location: register.php?error=" .
        urlencode("Please enter a valid 10-digit phone number.")
    );
    exit;
}


// =====================================================
// VALIDATE GENDER
// =====================================================

$allowedGenders = ["Male", "Female", "Other"];

if (!in_array($gender, $allowedGenders, true)) {
    header(
        "Location: register.php?error=" .
        urlencode("Please select a valid gender.")
    );
    exit;
}


// =====================================================
// VALIDATE PASSWORD
// =====================================================

if (strlen($password) < 6) {
    header(
        "Location: register.php?error=" .
        urlencode("Password must be at least 6 characters.")
    );
    exit;
}


// =====================================================
// CONFIRM PASSWORD
// =====================================================

if ($password !== $confirmPassword) {
    header(
        "Location: register.php?error=" .
        urlencode("Passwords do not match.")
    );
    exit;
}


// =====================================================
// CHECK IF EMAIL ALREADY EXISTS
// =====================================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT id FROM users WHERE email = ? LIMIT 1"
);

if (!$stmt) {
    die("Database error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $email
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {

    mysqli_stmt_close($stmt);

    header(
        "Location: register.php?error=" .
        urlencode("Email already registered.")
    );

    exit;
}

mysqli_stmt_close($stmt);


// =====================================================
// HASH PASSWORD
// =====================================================

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

if ($hashedPassword === false) {
    header(
        "Location: register.php?error=" .
        urlencode("Unable to secure password.")
    );
    exit;
}


// =====================================================
// INSERT USER
// =====================================================

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO users
    (name, email, phone, gender, password)
    VALUES (?, ?, ?, ?, ?)"
);

if (!$stmt) {
    die("Database error: " . mysqli_error($conn));
}


// =====================================================
// BIND PARAMETERS
// =====================================================

// name       = string
// email      = string
// phone      = string
// gender     = string
// password   = string

mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $name,
    $email,
    $phone,
    $gender,
    $hashedPassword
);


// =====================================================
// EXECUTE INSERT
// =====================================================

if (!mysqli_stmt_execute($stmt)) {

    // Handle duplicate email from database UNIQUE constraint
    if (mysqli_errno($conn) == 1062) {

        mysqli_stmt_close($stmt);

        header(
            "Location: register.php?error=" .
            urlencode("Email already registered.")
        );

        exit;
    }

    $error = mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);

    die("Registration failed: " . $error);
}


// =====================================================
// GET NEW USER ID
// =====================================================

$userId = mysqli_insert_id($conn);

mysqli_stmt_close($stmt);


// =====================================================
// CREATE SESSION
// =====================================================

session_regenerate_id(true);

$_SESSION["user_id"] = $userId;
$_SESSION["user_name"] = $name;
$_SESSION["user_email"] = $email;
$_SESSION["phone"] = $phone;
$_SESSION["gender"] = $gender;


// =====================================================
// REDIRECT TO DASHBOARD
// =====================================================

header("Location: index.php");
exit;

?>