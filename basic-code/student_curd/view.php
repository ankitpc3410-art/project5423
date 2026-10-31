<?php

include 'db.php';
$search = trim($_GET['search'] ?? '') ;
if($search != '') {
    $stmt = mysqli_prepare(
        $conn,
        "select * from students where name like ? or email like ?"
    );
    $searchValue = "%$search%";
    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $searchValue,
        $searchValue
    );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
else {
    $sql = "select * from students";
    $result = mysqli_query($conn, $sql);
}

// $sql = 'select * from students';
// $result = mysqli_query($conn,$sql);



?>
<html>
    <head>
        <title>Student Records</title>
    </head>
    <body>
        <h1>Student Records</h1>
        <?php

        if(isset($_GET['msg'])) {
            if($_GET['msg']==' inserted') {
                echo "<p style='color:green'>User inserted successfully</p>";
            }
            else if($_GET["msg"]== ' updated') {
                echo "<p style='color:green'>User updated successfully</p>";
            }
            else if($_GET["msg"]== ' deleted') {
                echo "<p style='color:green'>User deleted successfully</p>";
            }
        }

        ?>
        
        <form action="view.php" method="GET">
            <input type="text" name="search" placeholder="Search students..." value="<?php echo $_GET['search'] ?? '' ; ?>">
            <button type="submit">Search</button>
            <a href="view.php">show all</a>
        </form>
        <br/>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>phone</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td>
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Student Image" width="100">
                </td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" onclick="return confirm('are you sure you want edit this data ?.........')">Edit</a>  |
                    <a href="delete.php?id=<?php echo $row['id']; ?>"  onclick="return confirm('Are you sure to delete this data ?..')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </body>
</html>