<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
    <link rel="stylesheet" href="../css/user.css">
    <title>User Management</title>
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>

        <div class="details2">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>User Management</h2>
                    <a href="add_user.php" class="btn">Add User</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db_connection.php';

                        // Pagination variables
                        $itemsPerPage = 10;
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $itemsPerPage;

                        // Query with LIMIT and OFFSET for pagination
                        $sql = "SELECT * FROM login_user LIMIT $itemsPerPage OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>{$row['role']}</td>";
                                echo "<td>
                                        <a href='update_user.php?id={$row['id']}' class='btn'>Edit</a>
                                        <a href='#' onclick='confirmDelete({$row['id']})' class='btn'>Delete</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No users found</td></tr>";
                        }

                        // Calculate total pages
                        $sql_total = "SELECT COUNT(*) as total FROM login_user";
                        $result_total = $conn->query($sql_total);
                        $total_users = $result_total->fetch_assoc()['total'];
                        $total_pages = ceil($total_users / $itemsPerPage);

                        $conn->close();
                        ?>
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="btn">ก่อนหน้า</a>
                    <?php endif; ?>

                    <span class="page-info">หน้าที่ <?= $page ?> จาก <?= $total_pages ?></span>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="btn">ถัดไป</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../mains.php'; ?>
    <script>
        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `delete_user.php?id=${userId}`;
            }
        }
    </script>
</body>

</html>
