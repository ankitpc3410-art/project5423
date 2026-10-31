<?php
include 'db.php';
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$sql ="INSERT INTO students (name,email,phone) VALUES ('$name','$email','$phone')";
$result = mysqli_query($conn, $sql);
if($result){
    echo "Student Added Successfully";

}
else{
    echo "Error:" .mysqli_error( $conn);
}
?>