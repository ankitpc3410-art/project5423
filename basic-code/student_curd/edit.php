<?php
include "db.php";
$id = $_GET['id']?? '';
// if(!filter_has_var($id, FILTER_VALIDATE_INT)) {
//     die('Invalid ID');
// }
$sql = "SELECT * FROM students WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<html>
    <head>
        <title>Edit Student Record</title>

    </head>
    <body>
        <h1>Edit Student Record</h1>
        <form action="update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo ($row['id']); ?>">
            <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($row['image']); ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>"><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"><br><br>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>"><br><br>
            <label for="image">Image:</label>
            <br>
            <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Student Image" width="100">
            <br><br>
            <input type="file" name="image" accept="image/*"><br><br>
            <button type="submit">Update student</button>
        </form>
    </body>
</html>