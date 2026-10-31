<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>add internship students</h1>
    <form method="post" action="insert.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="mobile">Mobile:</label>
        <input type="tel" id="mobile" name="mobile" required pattern="[0-9]{10}" title="please enter 10 digit number">
        <br><br>
        <label for="college">College:</label>
        <input type="text" id="college" name="college" required>
        <br><br>
        <label for="branch">Branch:</label>
        <input type="text" id="branch" name="branch" required>
        <br><br>
        <label for="technology">Technology:</label>
        <input type="text" id="technology" name="technology" required>
        <br><br>
        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" required>
        <br><br>
        <label for="skills">Skills:</label>
        <input type="text" id="skills" name="skills" required>
        <br><br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        <br><br>
        <button type="submit">Save student</button>
    </form>
</body>
</html>