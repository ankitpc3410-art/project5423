<?php
include"db.php";
$id =$_POST["id"];
$name =$_POST["name"];
$email =$_POST["email"];
$phone =$_POST["phone"];
$sql="update students
SET name ='$name',
email='$email',
phone='$phone'
where id=$id";
$result=mysqli_query($conn,$sql);
if($result){
    echo"Record updated successfully";
} 
else {
    echo"Error". mysqli_error($conn);
}
?>