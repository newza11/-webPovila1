<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/contact_user.css">
    <link rel="stylesheet" href="../css/order.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.22/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.22/dist/sweetalert2.min.js"></script>

    <title>Contact Messages</title>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .pagination button {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination button:hover {
            background: #0056b3;
        }

        .pagination button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .pagination .page-info {
            font-size: 16px;
            margin: 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

        .btn {
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .message-cell {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="details2">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Contact Messages</h2>
                </div>

                <?php
                include 'db_connection.php';

                // Pagination setup
                $limit = 10; // Number of records per page
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $offset = ($page - 1) * $limit;

                // Count total contact messages
                $countSql = "SELECT COUNT(*) as total FROM contact";
                $countResult = $conn->query($countSql);
                $totalRows = $countResult->fetch_assoc()['total'];
                $totalPages = ceil($totalRows / $limit);

                // Query for contact messages with pagination
                $sql = "SELECT id, name, email, phone, message, created_at FROM contact ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
                $result = $conn->query($sql);
                ?>

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
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>{$row['phone']}</td>";
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

                <div class="pagination">
                    <button class="prev-page" <?php if ($page <= 1) echo 'disabled'; ?>>ก่อนหน้า</button>
                    <span class="page-info">หน้าที่ <?php echo $page; ?> จาก <?php echo $totalPages; ?></span>
                    <button class="next-page" <?php if ($page >= $totalPages) echo 'disabled'; ?>>ถัดไป</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(contactId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this message?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete_contact.php page with the contact ID
                    window.location.href = `delete_contact.php?id=${contactId}`;
                }
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.prev-page').addEventListener('click', () => {
                if (<?php echo $page; ?> > 1) {
                    window.location.href = `?page=<?php echo $page - 1; ?>`;
                }
            });

            document.querySelector('.next-page').addEventListener('click', () => {
                if (<?php echo $page; ?> < <?php echo $totalPages; ?>) {
                    window.location.href = `?page=<?php echo $page + 1; ?>`;
                }
            });
        });
    </script>

    <?php include '../mains.php'; ?>
</body>

</html>