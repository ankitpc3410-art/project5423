<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>

<h2>All Products</h2>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Description</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <tr>
        <td><?= $row['id']; ?></td>

        <td>
            <?php if ($row['image'] != "") { ?>
                <img src="uploads/<?= $row['image']; ?>" width="80">
            <?php } ?>
        </td>

        <td><?= $row['product_name']; ?></td>
        <td><?= $row['category']; ?></td>
        <td>₹<?= $row['price']; ?></td>
        <td><?= $row['quantity']; ?></td>
        <td><?= $row['description']; ?></td>
    </tr>

    <?php } ?>

</table>

</body>
</html>