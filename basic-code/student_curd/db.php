<?php

$conn = mysqli_connect("localhost","root","","studentdb_1");
if (!$conn) {
    die("database connection failed :". mysqli_connect_error());
}
echo"database connected successfully";

?>