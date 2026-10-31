<?php

$conn = mysqli_connect("localhost","root","","studentdb");
if (!$conn) {
    die("database connection failed :". mysqli_connect_error());
}
echo"database connected successfully";

?>