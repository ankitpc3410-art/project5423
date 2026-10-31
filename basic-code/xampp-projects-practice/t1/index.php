<?php

require_once "config.php";

// Get all students
$stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
$students = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Student Registration System</h1>

    <div class="top-bar">

        <a href="add.php" class="btn add-btn">
            + Add Student
        </a>

    </div>

    <?php if (isset($_GET['success'])): ?>

        <div class="success">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>

    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>

        <div class="error">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>

    <?php endif; ?>


    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Course</th>
                    <th>Address</th>
                    <th>Registration Date</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

            <?php if (count($students) > 0): ?>

                <?php foreach ($students as $student): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($student['id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student['name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student['email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student['phone']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student['gender']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student['course']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student['address']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($student['created_at']) ?>
                        </td>

                        <td class="actions">

                            <a
                                href="edit.php?id=<?= $student['id'] ?>"
                                class="btn edit-btn"
                            >
                                Edit
                            </a>

                            <a
                                href="delete.php?id=<?= $student['id'] ?>"
                                class="btn delete-btn"
                                onclick="return confirm('Are you sure you want to delete this student?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="9" class="no-data">
                        No students registered yet.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>