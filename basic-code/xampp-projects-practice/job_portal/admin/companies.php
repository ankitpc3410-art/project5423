<?php
session_start();
require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('admin');

if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM companies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: companies.php");
    exit;
}

$result = $conn->query("
    SELECT companies.*, users.name AS recruiter_name
    FROM companies
    LEFT JOIN users ON companies.recruiter_id = users.id
    ORDER BY companies.id DESC
");

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>Manage Companies</h2>

    <div class="table-responsive mt-4">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Company</th>
                    <th>Recruiter</th>
                    <th>Location</th>
                    <th>Website</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($company = $result->fetch_assoc()): ?>

                <tr>

                    <td><?php echo $company['id']; ?></td>

                    <td>
                        <?php echo htmlspecialchars($company['company_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($company['recruiter_name'] ?? ''); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($company['location'] ?? ''); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($company['website'] ?? ''); ?>
                    </td>

                    <td>

                        <a href="?delete=<?php echo $company['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete company?')">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>