<?php
include "db.php";
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<html>
    <head>
        <title>Edit User Record</title>

    </head>
    <body>
        <h1>Edit User Record</h1>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo $row['password']; ?>"><br><br>
            <button type="submit">Update user</button>
        </form>
    </body>
</html>