<?php

require_once "config.php";


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header(
        "Location: index.php?error=" .
        urlencode("Invalid student ID.")
    );

    exit;
}


$id = (int) $_GET['id'];


$stmt = $pdo->prepare(
    "DELETE FROM students WHERE id = ?"
);

$stmt->execute([$id]);


if ($stmt->rowCount() > 0) {

    header(
        "Location: index.php?success=" .
        urlencode("Student deleted successfully.")
    );

} else {

    header(
        "Location: index.php?error=" .
        urlencode("Student not found.")
    );

}

exit;

?>