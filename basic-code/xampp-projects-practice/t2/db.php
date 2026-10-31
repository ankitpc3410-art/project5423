<?php

$conn = mysqli_connect("localhost","root","","task_manager");
if (!$conn) {
    die("database connection failed :". mysqli_connect_error());
}
// echo"database connected successfully";

?>