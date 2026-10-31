<?php
    include "db.php";
    $id = $_GET["id"];
    $sql = "select * from students where id =$id";
    $result = mysqli_query( $conn, $sql);
    $row = mysqli_fetch_array($result);
?>
<html>
    <head>
        <title>Edit Student</title>
    </head>
    <body>
        <form method="post" action="update.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $row['name']; ?>">
            <br><br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>">
            <br><br>
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $row['phone']; ?>">
            <br><br>
            <input type="submit" value="Update">
        </form>
    </body>
</html>