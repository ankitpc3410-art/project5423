<?php

require_once "config.php";

$error = "";


// Check ID

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php?error=" . urlencode("Invalid student ID."));
    exit;

}

$id = (int) $_GET['id'];


// Get student

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);

$student = $stmt->fetch();


if (!$student) {

    header("Location: index.php?error=" . urlencode("Student not found."));
    exit;

}


// Update

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

        $stmt = $pdo->prepare(
            "UPDATE students
             SET name = ?,
                 email = ?,
                 phone = ?,
                 gender = ?,
                 course = ?,
                 address = ?
             WHERE id = ?"
        );

        $stmt->execute([
            $name,
            $email,
            $phone,
            $gender,
            $course,
            $address,
            $id
        ]);


        header(
            "Location: index.php?success=" .
            urlencode("Student updated successfully.")
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

    <title>Edit Student</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-container">

    <h1>Edit Student</h1>

    <?php if ($error): ?>

        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <form method="POST">


        <label>Student Name</label>

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($student['name']) ?>"
            required
        >


        <label>Email</label>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($student['email']) ?>"
            required
        >


        <label>Phone Number</label>

        <input
            type="text"
            name="phone"
            value="<?= htmlspecialchars($student['phone']) ?>"
            required
        >


        <label>Gender</label>

        <div class="gender">

            <label>
                <input
                    type="radio"
                    name="gender"
                    value="Male"
                    <?= $student['gender'] === 'Male' ? 'checked' : '' ?>
                    required
                >
                Male
            </label>

            <label>
                <input
                    type="radio"
                    name="gender"
                    value="Female"
                    <?= $student['gender'] === 'Female' ? 'checked' : '' ?>
                >
                Female
            </label>

            <label>
                <input
                    type="radio"
                    name="gender"
                    value="Other"
                    <?= $student['gender'] === 'Other' ? 'checked' : '' ?>
                >
                Other
            </label>

        </div>


        <label>Course</label>

        <select name="course" required>

            <option value="">-- Select Course --</option>

            <option
                value="BCA"
                <?= $student['course'] === 'BCA' ? 'selected' : '' ?>
            >
                BCA
            </option>

            <option
                value="BBA"
                <?= $student['course'] === 'BBA' ? 'selected' : '' ?>
            >
                BBA
            </option>

            <option
                value="B.Tech"
                <?= $student['course'] === 'B.Tech' ? 'selected' : '' ?>
            >
                B.Tech
            </option>

            <option
                value="MCA"
                <?= $student['course'] === 'MCA' ? 'selected' : '' ?>
            >
                MCA
            </option>

            <option
                value="MBA"
                <?= $student['course'] === 'MBA' ? 'selected' : '' ?>
            >
                MBA
            </option>

        </select>


        <label>Address</label>

        <textarea
            name="address"
            rows="5"
            required
        ><?= htmlspecialchars($student['address']) ?></textarea>


        <div class="form-buttons">

            <button type="submit" class="btn submit-btn">
                Update Student
            </button>

            <a href="index.php" class="btn back-btn">
                Cancel
            </a>

        </div>

    </form>

</div>

</body>

</html>