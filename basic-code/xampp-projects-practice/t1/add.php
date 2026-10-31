<?php

require_once "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $gender = trim($_POST["gender"]);
    $course = trim($_POST["course"]);
    $address = trim($_POST["address"]);


    // Validation

    if ($name === "") {

        $error = "Name is required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email.";

    } elseif ($phone === "") {

        $error = "Phone number is required.";

    } elseif ($gender === "") {

        $error = "Gender is required.";

    } elseif ($course === "") {

        $error = "Course is required.";

    } elseif ($address === "") {

        $error = "Address is required.";

    } else {

        // Insert using prepared statement

        $stmt = $pdo->prepare(
            "INSERT INTO students
            (name, email, phone, gender, course, address, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );

        $stmt->execute([
            $name,
            $email,
            $phone,
            $gender,
            $course,
            $address
        ]);

        header(
            "Location: index.php?success=" .
            urlencode("Student registered successfully.")
        );

        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-container">

    <h1>Student Registration</h1>

    <?php if ($error): ?>

        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <form method="POST" action="">

        <label>Student Name</label>

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
            placeholder="Enter student name"
            required
        >


        <label>Email</label>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            placeholder="Enter email"
            required
        >


        <label>Phone Number</label>

        <input
            type="text"
            name="phone"
            value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
            placeholder="Enter phone number"
            required
        >


        <label>Gender</label>

        <div class="gender">

            <label>
                <input
                    type="radio"
                    name="gender"
                    value="Male"
                    required
                >
                Male
            </label>

            <label>
                <input
                    type="radio"
                    name="gender"
                    value="Female"
                >
                Female
            </label>

            <label>
                <input
                    type="radio"
                    name="gender"
                    value="Other"
                >
                Other
            </label>

        </div>


        <label>Course</label>

        <select name="course" required>

            <option value="">-- Select Course --</option>

            <option value="BCA">BCA</option>

            <option value="BBA">BBA</option>

            <option value="B.Tech">B.Tech</option>

            <option value="MCA">MCA</option>

            <option value="MBA">MBA</option>

        </select>


        <label>Address</label>

        <textarea
            name="address"
            rows="5"
            placeholder="Enter student address"
            required
        ><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>


        <div class="form-buttons">

            <button type="submit" class="btn submit-btn">
                Register Student
            </button>

            <a href="index.php" class="btn back-btn">
                Back
            </a>

        </div>

    </form>

</div>

</body>

</html>