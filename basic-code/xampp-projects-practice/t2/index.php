<?php

session_start();

require_once __DIR__ . "/db.php";


// ============================================
// CHECK LOGIN
// ============================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;
}
// ============================================
// Search query
// ===========================================

$query = trim($_GET["query"] ?? "");

if ($query !== "") {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, name, email, phone, gender, created_at
         FROM users
         WHERE name LIKE ?
            OR email LIKE ?
            OR phone LIKE ?
            OR gender LIKE ?
         ORDER BY id DESC"
    );

    $search = "%" . $query . "%";

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $search,
        $search,
        $search,
        $search
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

} else {

    $sql = "
        SELECT id, name, email, phone, gender, created_at
        FROM users
        ORDER BY id DESC
    ";

    $result = mysqli_query($conn, $sql);
}


// ============================================
// USER SESSION DATA
// ============================================

$userName = $_SESSION["user_name"] ?? "User";
$userEmail = $_SESSION["user_email"] ?? "";



// ============================================
// GET USER RECORDS
// ============================================

if ($query !== "") {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, name, email, phone, gender, password, created_at
         FROM users
         WHERE name LIKE ?
            OR email LIKE ?
            OR phone LIKE ?
            OR gender LIKE ?
         ORDER BY id DESC"
    );

    $search = "%" . $query . "%";

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $search,
        $search,
        $search,
        $search
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

} else {

    $sql = "
        SELECT id, name, email, phone, gender, password, created_at
        FROM users
        ORDER BY id DESC
    ";

    $result = mysqli_query($conn, $sql);
}


// ============================================
// GET TOTAL USERS
// ============================================

$totalQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM users"
);

$totalData = mysqli_fetch_assoc($totalQuery);

$total = $totalData["total"] ?? 0;


// ============================================
// GET MALE USERS
// ============================================

$maleQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE gender = 'male'"
);

$maleData = mysqli_fetch_assoc($maleQuery);

$male = $maleData["total"] ?? 0;


// ============================================
// GET FEMALE USERS
// ============================================

$femaleQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE gender = 'female'"
);

$femaleData = mysqli_fetch_assoc($femaleQuery);

$female = $femaleData["total"] ?? 0;


// ============================================
// GET OTHER USERS
// ============================================

$otherQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE gender = 'other'"
);

$otherData = mysqli_fetch_assoc($otherQuery);

$other = $otherData["total"] ?? 0;

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard - TaskFlow</title>


    <!-- Your Dashboard CSS -->

    <link
        rel="stylesheet"
        href="t2.css"
    >


    <!-- Bootstrap CSS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

</head>


<body>


<!-- ============================================
     WELCOME SECTION
============================================= -->

<section
    class="welcome-section"
    id="welcome-section"
>

    <div>

        <h2>

            Welcome back,
            <?= htmlspecialchars($userName) ?>
            👋

        </h2>

        <p>

            Here is what's happening with your users today.

        </p>

    </div>

</section>


<!-- ============================================
     LOGOUT BUTTON
============================================= -->

<div id="logout-container">

    <a
        href="logoutb.php"
        onclick="return confirm('Are you sure you want to logout?');"
    >

        <button
            type="button"
            id="logout-btn"
        >

            Logout

        </button>

    </a>

</div>


<!-- ============================================
     STAT CARDS
============================================= -->

<div class="container-fluid">

    <div class="row g-4">


        <!-- TOTAL USERS -->

        <div class="col-lg-3 col-md-4">

            <div class="stat-card">

                <div class="icon">

                    <i class="bi bi-people-fill"></i>

                </div>

                <p class="text-muted mt-3 mb-1">

                    Total Users

                </p>

                <div class="number">

                    <?= $total ?>

                </div>

            </div>

        </div>


        <!-- MALE -->

        <div class="col-lg-3 col-md-44">

            <div class="stat-card">

                <div class="icon">

                    <i class="bi bi-person-fill"></i>

                </div>

                <p class="text-muted mt-3 mb-1">

                    Male

                </p>

                <div class="number">

                    <?= $male ?>

                </div>

            </div>

        </div>


        <!-- FEMALE -->

        <div class="col-lg-3 col-md-4">

            <div class="stat-card">

                <div class="icon">

                    <i class="bi bi-person-heart"></i>

                </div>

                <p class="text-muted mt-3 mb-1">

                    Female

                </p>

                <div class="number">

                    <?= $female ?>

                </div>

            </div>

        </div>


        <!-- OTHER -->

        <div class="col-lg-3 col-md-4">

            <div class="stat-card">

                <div class="icon">

                    <i class="bi bi-person-badge"></i>

                </div>

                <p class="text-muted mt-3 mb-1">

                    Other

                </p>

                <div class="number">

                    <?= $other ?>

                </div>

            </div>

        </div>


    </div>

</div>


<!-- ============================================
     PAGE TITLE
============================================= -->

<h1 id="page-title">

    User Records

</h1>


<!-- ============================================
     SEARCH FORM
============================================= -->

<form action="index.php" method="GET" id="search-form">

    <input
        type="text"
        name="query"
        id="search-input"
        placeholder="Search users..."
        value="<?= htmlspecialchars($query) ?>"
    >

    <button type="submit" id="search-btn">
        <i class="bi bi-search"></i>
        Search
    </button>

    <?php if ($query !== ""): ?>

        <a href="index.php" class="clear-search">
            Clear
        </a>

    <?php endif; ?>

</form>
 <!-- <div class="dashboard-actions">
    <a href="./register.php" class="add-user-btn">
        <i class="bi bi-person-plus-fill"></i>
        Add User
    </a>
</div> -->


<!-- ============================================
     USER TABLE
============================================= -->

<div class="table-container">

<table
    id="user-table"
>

    <thead>

        <tr>

            <th>ID</th>

            <th>Name</th>

            <th>Email</th>

            <th>Phone</th>

            <th>Gender</th>
            <th>Password</th>

            <th>Created At</th>

            <th>Actions</th>

        </tr>

    </thead>


    <tbody>


        <?php if (mysqli_num_rows($result) > 0): ?>


            <?php while ($row = mysqli_fetch_assoc($result)): ?>


                <tr>


                    <!-- ID -->

                    <td>

                        <?= htmlspecialchars($row["id"]) ?>

                    </td>


                    <!-- NAME -->

                    <td>

                        <?= htmlspecialchars($row["name"]) ?>

                    </td>


                    <!-- EMAIL -->

                    <td>

                        <?= htmlspecialchars($row["email"]) ?>

                    </td>


                    <!-- PHONE -->

                    <td>

                        <?= htmlspecialchars($row["phone"]) ?>

                    </td>


                    <!-- GENDER -->

                    <td>

                        <?= htmlspecialchars($row["gender"]) ?>

                    </td>
                    <!-- PASSWORD -->

                    <td>

                        <?= htmlspecialchars($row["password"]) ?>

                    </td>

                    <!-- CREATED AT -->

                    <td>

                        <?= htmlspecialchars($row["created_at"]) ?>

                    </td>


                    <!-- ACTIONS -->

                    <td>


                        <a
                            href="edit.php?id=<?= urlencode($row["id"]) ?>"
                            class="edit-btn"
                            onclick="return confirm('Are you sure you want to edit this data?');"
                        >

                            <i class="bi bi-pencil-square"></i>

                            Edit

                        </a>


                        |


                        <a
                            href="delete.php?id=<?= urlencode($row["id"]) ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this data?');"
                        >

                            <i class="bi bi-trash"></i>

                            Delete

                        </a>


                    </td>


                </tr>


            <?php endwhile; ?>


        <?php else: ?>


            <tr>

                <td
                    colspan="7"
                    class="no-records"
                >

                    No users found.

                </td>

            </tr>


        <?php endif; ?>


    </tbody>

</table>

</div>


</body>

</html>