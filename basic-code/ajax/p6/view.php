<?php

include 'db.php';
$search = trim($_GET['search'] ?? '') ;
if($search != '') {
    $stmt = mysqli_prepare(
        $conn,
        "select * from internship_students where name like ? or email like ? or mobile like ? or college like ? or branch like ? or technology like ? or duration like ? or skills like ? or address like ?"
    );
    $searchValue = "%$search%";
    mysqli_stmt_bind_param(
    $stmt,
    "sssssssss",
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue
);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
else {
    $sql = "select * from internship_students";
    $result = mysqli_query($conn, $sql);
}

// $sql = 'select * from internship_students';
// $result = mysqli_query($conn,$sql);



?>
<html>
    <head>
        <title>Internship Student Records</title>
        <link rel="stylesheet" href="t3.css">
    </head>
    <body>
        <h1>Internship Student Records</h1>
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
        
        <form action="export.php" method="GET">
            <!-- <input type="text" name="search" placeholder="Search students..." value="<?php echo $_GET['search'] ?? '' ; ?>">
            <button type="submit">Search</button>
            <a href="view.php">show all</a> -->
            <button type="submit" name="export">Export to Excel</button>
            <button type="submit" name="export">Export to csv</button>
        </form>
        <br/>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>mobile</th>
                <th>college</th>
                <th>branch</th>
                <th>technology</th>
                <th>duration (in months)</th>
                <th>skills</th>
                <th>address</th>
                <!-- <th>Action</th> -->
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $row['college']; ?></td>
                <td><?php echo $row['branch']; ?></td>
                <td><?php echo $row['technology']; ?></td>
                <td><?php echo $row['duration']; ?></td>
                <td><?php echo $row['skills']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <!-- <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" onclick="return confirm('are you sure you want edit this data ?.........')">Edit</a>  |
                    <a href="delete.php?id=<?php echo $row['id']; ?>"  onclick="return confirm('Are you sure to delete this data ?..')">Delete</a>
            </td> -->

            </tr>
            <?php endwhile; ?>
        </table>
    </body>
</html>