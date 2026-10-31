<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome to the Student Database</h1>
    <form action="insert.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br><br>

        <label for="hobbies[]">Hobbies:</label>
        <input type="checkbox" id="hobbies-reading" name="hobbies[]" value="reading" >
        <label for="hobbies[]">Reading</label>
        <input type="checkbox" id="hobbies-sports" name="hobbies[]" value="sports" >
        <label for="hobbies[]">Sports</label>
        <input type="checkbox" id="hobbies-music" name="hobbies[]" value="music" >
        <label for="hobbies[]">Music</label> <br><br>

        <label for="course[]">Course:</label>
        <input type="checkbox" id="course-computer-science" name="course[]" value="Computer Science" >
        <label for="course[]">Computer Science</label>
        <input type="checkbox" id="course-mathematics" name="course[]" value="Mathematics" >
        <label for="course[]">Mathematics</label>
        <input type="checkbox" id="course-physics" name="course[]" value="Physics" >
        <label for="course[]">Physics</label><br><br>

        <select name="gender" id="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br><br>

        
        <input type="submit" value="Submit">
</body>
</html>