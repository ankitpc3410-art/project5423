<?php
session_start();
require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('admin');

if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];

    if ($id != $_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header("Location: users.php");
    exit;
}

$result = $conn->query("SELECT id,name,email,role,created_at FROM users ORDER BY id DESC");

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5 bg-dark text-white shadow rounded" style="margin-bottom: 30px; padding: 40px;">

    <h2 style="color: #d8b90a;">Manage Users</h2>

    <div class="table-responsive mt-4">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php while ($user = $result->fetch_assoc()): ?>

                <tr>

                    <td><?php echo $user['id']; ?></td>

                    <td>
                        <?php echo htmlspecialchars($user['name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($user['email']); ?>
                    </td>

                    <td><?php echo $user['role']; ?></td>

                    <td><?php echo $user['created_at']; ?></td>

                    <td>

                        <?php if ($user['id'] != $_SESSION['user_id']): ?>

                            <a href="?delete=<?php echo $user['id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this user?')">
                                Delete
                            </a>

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>