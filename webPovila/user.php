<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/user.css">
    <title>User Management</title>
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="details1">
            <div class="recentOrders">
                <div class="cardHeader ">
                    <h2>User Management</h2>
                    <a href="add_user.php" class="btn">Add User</a>
                    <table class="tablebody">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                </div>
            </div>
        </div>
    </div>
    <tbody>
        <?php
        include 'db_connection.php';

        $sql = "SELECT * FROM login_user";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['role']}</td>";
                echo "<td>
                            <a href='update_user.php?id={$row['id']}'>Edit</a> |
                            <a href='delete_user.php?id={$row['id']}'>Delete</a>
                          </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
    </table>
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>