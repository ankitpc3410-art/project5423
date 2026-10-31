<?php

require_once "auth.php";
require_once "db.php";


header("Content-Type: application/json");


$userId = $_SESSION["user_id"];


$stmt = $pdo->prepare(
    "SELECT
        id,
        title,
        description,
        priority,
        due_date,
        completed,
        created_at
     FROM tasks
     WHERE user_id = ?
     ORDER BY completed ASC, due_date ASC, id DESC"
);


$stmt->execute([$userId]);


$tasks = $stmt->fetchAll();


echo json_encode([
    "success" => true,
    "tasks" => $tasks
]);