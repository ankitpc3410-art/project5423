<?php
include 'db.php';
$id = $_GET['id'] ?? '' ;

if (empty($id)) {
    die ('ID is required'); 
}
$stmt = mysqli_prepare(
    $conn,
    "delete from users where id=?"
);
mysqli_stmt_bind_param($stmt, "i", $id);
if(mysqli_stmt_execute($stmt)) {
    // echo "Student deleted successfully";
    header("Location: index.php");
    exit();

} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>