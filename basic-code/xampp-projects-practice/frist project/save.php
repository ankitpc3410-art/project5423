
<?php
include 'db.php';
//Get form data
$name = $_POST['name'];
$email = $_POST['email'];
// Insert data into the database
$sql ="INSERT INTO registration (name,email) values('$name','$email')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
}else{
    echo "Error: ".$sql . "<br>" . mysqli_error($conn);
}
?>