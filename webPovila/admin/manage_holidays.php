<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
    <link rel="stylesheet" href="../css/user.css">
    <title>Manage Holidays</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 80%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            color: #fff;
            font-size: 35px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

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

        /* Additional styles for table and buttons */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

       

        
    </style>
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="details2">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Manage Holidays</h2>
                    <a href="add_holiday.php" class="btn">Add Holiday</a>
                </div>

                <?php
                include 'db_connection.php';

                // Pagination setup
                $limit = 10; // Number of records per page
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $offset = ($page - 1) * $limit;

                // Count total holidays
                $countSql = "SELECT COUNT(*) as total FROM holidays_db";
                $countResult = $conn->query($countSql);
                $totalRows = $countResult->fetch_assoc()['total'];
                $totalPages = ceil($totalRows / $limit);

                // Query for holidays with pagination
                $sql = "SELECT holiday_name, holiday_date, holiday_price FROM holidays_db LIMIT $limit OFFSET $offset";
                $result = $conn->query($sql);
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>Holiday Name</th>
                            <th>Holiday Date</th>
                            <th>Holiday Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['holiday_name']}</td>";
                                echo "<td>{$row['holiday_date']}</td>";
                                echo "<td>{$row['holiday_price']}</td>";
                                echo "<td>
                                        <a href='edit_holiday.php?id={$row['holiday_date']}' class='btn'>Edit Holiday</a>
                                        <button class='btn delete-btn' data-id='{$row['holiday_date']}'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No holidays found</td></tr>";
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
        document.addEventListener('DOMContentLoaded', function () {
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

            document.querySelectorAll('.delete-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const holidayDate = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`delete_holiday.php?id=${holidayDate}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire(
                                            'Deleted!',
                                            data.message,
                                            'success'
                                        ).then(() => {
                                            location.reload(); // Reload the page to reflect changes
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            data.message,
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the holiday.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });
        });
    </script>

    <?php include '../mains.php'; ?>
</body>

</html>
