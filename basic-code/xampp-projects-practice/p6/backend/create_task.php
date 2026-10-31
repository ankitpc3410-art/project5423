<?php

require_once "auth.php";
require_once "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../index.php");

    exit;
}


$userId = $_SESSION["user_id"];


$title = trim($_POST["title"] ?? "");
$description = trim($_POST["description"] ?? "");
$priority = $_POST["priority"] ?? "medium";
$dueDate = $_POST["due_date"] ?? null;


if ($title === "") {

    header(
        "Location: ../index.php?error=" .
        urlencode("Task title is required.")
    );

    exit;
}


$allowedPriorities = [
    "low",
    "medium",
    "high"
];


if (!in_array($priority, $allowedPriorities, true)) {

    $priority = "medium";
}


if ($dueDate === "") {
    $dueDate = null;
}


$stmt = $pdo->prepare(
    "INSERT INTO tasks
    (
        user_id,
        title,
        description,
        priority,
        due_date
    )
    VALUES (?, ?, ?, ?, ?)"
);


$stmt->execute([
    $userId,
    $title,
    $description,
    $priority,
    $dueDate
]);


header(
    "Location: ../index.php?success=" .
    urlencode("Task created successfully.")
);

exit;