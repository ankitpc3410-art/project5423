<?php

include "db.php";

$product_name = $_POST['product_name'];
$category = $_POST['category'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$description = $_POST['description'];

$image = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];

// Absolute path
$upload_folder = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;

// Check folder
if (!is_dir($upload_folder)) {
    die("Uploads folder nahi mila: " . $upload_folder);
}

// Image upload
if ($image != "") {

    $image_path = $upload_folder . basename($image);

    if (move_uploaded_file($tmp_name, $image_path)) {

        $sql = "INSERT INTO products
                (product_name, category, price, quantity, description, image)
                VALUES
                ('$product_name', '$category', '$price', '$quantity', '$description', '$image')";

        if (mysqli_query($conn, $sql)) {
            echo "Product added successfully!";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }

    } else {
        echo "Image upload failed!";
    }

} else {

    echo "Please select an image.";

}

?>