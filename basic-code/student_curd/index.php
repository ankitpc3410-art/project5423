<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>add students</h1>
    <form method="post" action="insert.php" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}" title="please enter 10 digit number">
        <br><br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <br><br>
        <button type="submit">Save student</button>
    </form>
</body>
</html>