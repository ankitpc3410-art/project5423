<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>

<h2>Add New Product</h2>

<form action="insert.php" method="POST" enctype="multipart/form-data">

    <label>Product Name:</label><br>
    <input type="text" name="product_name" required>
    <br><br>

    <label>Category:</label><br>
    <select name="category" required>
        <option value="">Select Category</option>
        <option value="Mobile">Mobile</option>
        <option value="Laptop">Laptop</option>
        <option value="Clothes">Clothes</option>
        <option value="Shoes">Shoes</option>
        <option value="Electronics">Electronics</option>
    </select>
    <br><br>

    <label>Price:</label><br>
    <input type="number" name="price" step="0.01" required>
    <br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" required>
    <br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea>
    <br><br>

    <label>Product Image:</label><br>
    <input type="file" name="image">
    <br><br>

    <button type="submit">Add Product</button>

</form>

</body>
</html>