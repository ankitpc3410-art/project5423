<?php

session_start();

require_once "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../register.php");

    exit;
}


$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";


if ($name === "" || $email === "" || $password === "" || $confirmPassword === "") {

    header(
        "Location: ../register.php?error=" .
        urlencode("Please fill all fields.")
    );

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header(
        "Location: ../register.php?error=" .
        urlencode("Please enter a valid email.")
    );

    exit;
}


if (strlen($password) < 6) {

    header(
        "Location: ../register.php?error=" .
        urlencode("Password must be at least 6 characters.")
    );

    exit;
}


if ($password !== $confirmPassword) {

    header(
        "Location: ../register.php?error=" .
        urlencode("Passwords do not match.")
    );

    exit;
}


$stmt = $pdo->prepare(
    "SELECT id FROM users WHERE email = ? LIMIT 1"
);

$stmt->execute([$email]);

if ($stmt->fetch()) {

    header(
        "Location: ../register.php?error=" .
        urlencode("Email already registered.")
    );

    exit;
}


$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);


$stmt = $pdo->prepare(
    "INSERT INTO users
    (name, email, password)
    VALUES (?, ?, ?)"
);


$stmt->execute([
    $name,
    $email,
    $hashedPassword
]);


$userId = $pdo->lastInsertId();


session_regenerate_id(true);

$_SESSION["user_id"] = $userId;
$_SESSION["user_name"] = $name;
$_SESSION["user_email"] = $email;


header("Location: ../index.php");

exit;