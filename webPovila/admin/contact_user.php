<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/contact_user.css">
    <link rel="stylesheet" href="../css/order.css">
    <title>Contact Messages</title>
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="details2">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Contact Messages</h2>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Sent At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db_connection.php';

                        // Query to fetch messages and order by created_at (latest first)
                        $sql = "SELECT id, name, email, phone, message, created_at FROM contact ORDER BY created_at DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>{$row['phone']}</td>";
                                // ใช้ class message-cell เพื่อแสดงข้อความในกล่องที่ตัดข้อความ
                                echo "<td class='message-cell'>{$row['message']}</td>";
                                echo "<td>{$row['created_at']}</td>";
                                echo "<td>
                       
                        <a href='#' onclick='confirmDelete({$row['id']})' class='btn'>Delete</a>
                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No contact messages found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script>
        function confirmDelete(contactId) {
            if (confirm('Are you sure you want to delete this message?')) {
                window.location.href = `delete_contact.php?id=${contactId}`;
            }
        }
    </script>

    <?php include '../mains.php'; ?>
</body>

</html>