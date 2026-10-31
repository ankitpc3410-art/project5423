<?php
include "db.php";
$id = $_GET['id'];
$sql = "SELECT * FROM internship_students WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<html>
    <head>
        <title>Edit Internship Student Record</title>

    </head>
    <body>
        <h1>Edit Internship Student Record</h1>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>
            <label for="mobile">Mobile:</label>
            <input type="tel" name="mobile" value="<?php echo $row['mobile']; ?>"><br><br>
            <label for="college">College:</label>
            <input type="text" name="college" value="<?php echo $row['college']; ?>"><br><br>
            <label for="branch">Branch:</label>
            <input type="text" name="branch" value="<?php echo $row['branch']; ?>"><br><br>
            <label for="technology">Technology:</label>
            <input type="text" name="technology" value="<?php echo $row['technology']; ?>"><br><br>
            <label for="duration">Duration:</label>
            <input type="number" name="duration" value="<?php echo $row['duration']; ?>"><br><br>
            <label for="skills">Skills:</label>
            <input type="text" name="skills" value="<?php echo $row['skills']; ?>"><br><br>
            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo $row['address']; ?>"><br><br>
            <button type="submit">Update student</button>
        </form>
    </body>
</html>