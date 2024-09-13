<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../css/user.css">
    <title>Room Price List</title>
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="details2">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Room Price List</h2>
                    <a href="add_room.php" class="btn">Add Room</a>
                    
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db_connection.php';

                        $sql = "SELECT room, price FROM room_pirce";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['room']}</td>";
                                echo "<td>{$row['price']}</td>";
                                echo "<td>
                                        <a href='edit_price.php?id={$row['room']}' class='btn'>Edit Price</a>
                                        <a href='#' onclick='confirmDelete({$row['room']})' class='btn'>Delete</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No rooms found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <script>
        function confirmDelete(roomId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `delete_room.php?id=${roomId}`;
                }
            });
        }
    </script>

    <?php include '../mains.php'; ?>
</body>

</html>
