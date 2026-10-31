<?php

require_once "auth.php";
require_once "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../index.php");

    exit;
}


$userId = $_SESSION["user_id"];


$id = (int)($_POST["id"] ?? 0);

$title = trim($_POST["title"] ?? "");

$description = trim(
    $_POST["description"] ?? ""
);

$priority = $_POST["priority"] ?? "medium";

$dueDate = $_POST["due_date"] ?? null;

$completed = (int)(
    $_POST["completed"] ?? 0
);


if ($id <= 0 || $title === "") {

    header(
        "Location: ../index.php?error=" .
        urlencode("Invalid task data.")
    );

    exit;
}


if (!in_array(
    $priority,
    ["low", "medium", "high"],
    true
)) {

    $priority = "medium";
}


if ($completed !== 1) {
    $completed = 0;
}


if ($dueDate === "") {
    $dueDate = null;
}


/*
|--------------------------------------------------------------------------
| Check task ownership
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare(
    "SELECT id
     FROM tasks
     WHERE id = ?
     AND user_id = ?
     LIMIT 1"
);


$stmt->execute([
    $id,
    $userId
]);


if (!$stmt->fetch()) {

    header(
        "Location: ../index.php?error=" .
        urlencode("Task not found.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| Update task
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare(
    "UPDATE tasks
     SET
        title = ?,
        description = ?,
        priority = ?,
        due_date = ?,
        completed = ?
     WHERE id = ?
     AND user_id = ?"
);


$stmt->execute([
    $title,
    $description,
    $priority,
    $dueDate,
    $completed,
    $id,
    $userId
]);


header(
    "Location: ../index.php?success=" .
    urlencode("Task updated successfully.")
);

exit;