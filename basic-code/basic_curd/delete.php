<?php
include"db.php";
$id =$_GET["id"];
$sql = "DELETE FROM students WHERE id = $id";

$result = mysqli_query($conn, $sql);

if($result){

    echo "Student deleted successfully.";

} else {
    echo "Error:" . mysqli_error($conn);
}
?>