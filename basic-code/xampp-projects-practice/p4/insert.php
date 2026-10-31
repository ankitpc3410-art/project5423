<?php

use LDAP\Result;        

include"db.php";
$name =$_POST['name'];
$phone =$_POST['phone'];
$email =$_POST['email'];
$position =$_POST['position'];
$salary =$_POST['salary'];



$sql = "INSERT INTO employee_details(emp_name, emp_phone, emp_email, emp_position, emp_salary) VALUES ('$name', '$phone', '$email', '$position', '$salary')";
$result = mysqli_query($conn, $sql);
if($result){
    echo"employees added successfully";
}
else{
    
    echo"Error:".mysqli_error($conn);
}

?>