<?php

use LDAP\Result;        

include"db.php";
$name =$_POST['name'];
$email =$_POST['email'];
$phone =$_POST['phone'];
$hobbies = isset($_POST['hobbies']) ? implode(', ', $_POST['hobbies']) : ''; 
$course = isset($_POST['course']) ? implode(', ', $_POST['course']) : '';
$gender = $_POST['gender'];


$sql = "INSERT INTO studinfo (name, email, phone, hobbies, course, gender) VALUES ('$name', '$email', '$phone', '$hobbies', '$course', '$gender')";
$result = mysqli_query($conn, $sql);
if($result){
    echo"students added successfully";
}
else{
    
    echo"Error:".mysqli_error($conn);
}

?>