<?php

$conn =mysqli_connect("localhost", "root","", "studentdb_1");
if(!$conn){
    die("Database connection failed:" .mysqli_connect_error());

}
echo "Database connected successfully";

?>