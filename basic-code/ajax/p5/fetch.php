<?php
include 'db.php';

$sql = "SELECT * FROM students ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Name</th><th>Email</th><th>Mobile</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center; color:#777;'>No records found.</p>";
}
?>
