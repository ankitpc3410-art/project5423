<?php

session_start();

require_once "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../login.php");

    exit;
}


$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";


if ($email === "" || $password === "") {

    header("Location: ../login.php?error=" . urlencode("Please fill all fields."));

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header("Location: ../login.php?error=" . urlencode("Please enter a valid email."));

    exit;
}


$stmt = $pdo->prepare(
    "SELECT id, name, email, password
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->execute([$email]);

$user = $stmt->fetch();


if (!$user || !password_verify($password, $user["password"])) {

    header("Location: ../login.php?error=" . urlencode("Invalid email or password."));

    exit;
}


session_regenerate_id(true);

$_SESSION["user_id"] = $user["id"];
$_SESSION["user_name"] = $user["name"];
$_SESSION["user_email"] = $user["email"];


header("Location: ../index.php");

exit;