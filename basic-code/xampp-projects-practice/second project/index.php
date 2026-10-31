<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Practice</title>
</head>
<body>

    <h2>Student Registration Form</h2>

    <form method="POST" action="save.php">

        <label>Full Name:</label>
        <input type="text" name="name" required>
        <br><br>

        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>

        <label>Age:</label>
        <input type="number" name="age" required>
        <br><br>

        <label>Gender:</label>
        <input type="radio" name="gender" value="Male"> Male
        <input type="radio" name="gender" value="Female"> Female
        <br><br>

        <label>City:</label>
        <select name="city">
            <option value="Gorakhpur">Gorakhpur</option>
            <option value="Lucknow">Lucknow</option>
            <option value="Delhi">Delhi</option>
            <option value="Mumbai">Mumbai</option>
        </select>
        <br><br>

        <label>Hobbies:</label>
        <input type="checkbox" name="hobbies[]" value="Cricket"> Cricket
        <input type="checkbox" name="hobbies[]" value="Music"> Music
        <input type="checkbox" name="hobbies[]" value="Reading"> Reading
        <br><br>

        <label>Address:</label>
        <br>
        <textarea name="address" rows="4" cols="30"></textarea>
        <br><br>

        <!-- <input type="submit" name="submit" value="Register"> -->
         <button type="submit">save </button>

    </form>

</body>
</html>