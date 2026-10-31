<?php

include"db.php";
$sql = "select * from students";
$result = mysqli_query( $conn, $sql);
?>

<html>
    <head>
        <title>Student Records</title>
    </head>
    <body>
        <h1>Student Records</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>phone</th>
            </tr>
            <?php while ( $row = mysqli_fetch_assoc( $result ) ):?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><a href="edit.php?id=<?php echo $row['id']; ?>"
                 onclick="return confirm(' you are sure ?')">Edit |</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>"
                 onclick="return confirm('Are you sure want to delete student ?')">delete</a>
                </td>
            </tr>
            <?php endwhile; ?>  
        </table>
    </body>
</html>
