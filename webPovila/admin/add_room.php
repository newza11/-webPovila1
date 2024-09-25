<?php

session_start();

// Backend PHP Logic for adding a room
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php';

    $room_number = $_POST['room_number'];
    $price = $_POST['price'];

    $sql = "INSERT INTO room_pirce (room, price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('id', $room_number, $price);

    if ($stmt->execute()) {
        $success_message = "Room added successfully!";
    } else {
        $error_message = "Error adding room: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
    <link rel="stylesheet" href="../css/user.css">
    <title>Add Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<style>
    .form-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .form-container h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-container form {
        display: flex;
        flex-direction: column;
    }

    .form-container form label {
        margin-bottom: 5px;
    }

    .form-container form input,
    .form-container form select {
        margin-bottom: 15px;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form-container form button {
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: none;
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    .form-container form button:hover {
        background-color: #0056b3;
    }
</style>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="form-container">
            <h1>Add Room</h1>
            <form method="POST">
                <label for="roomNumber">Room Number:</label>
                <select id="roomNumber" name="room_number" required>
                    <option value="">Select a room</option> <!-- Default option -->
                    <option value="1">1 ห้อง</option>
                    <option value="2">2 ห้อง</option>
                    <option value="3">3 ห้อง</option>
                    <option value="4">4 ห้อง</option>
                    <option value="5">5 ห้อง</option>
                    <option value="6">6 ห้อง</option>
                </select>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required step="0.01">

                <button type="submit">Add Room</button>
            </form>
        </div>
    </div>

    <?php include '../mains.php'; ?>

    <script>
        <?php if (isset($success_message)) : ?>
            Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '<?php echo $success_message; ?>',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'room_price_list.php';
                    });
        <?php elseif (isset($error_message)) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $error_message; ?>'
            });
        <?php endif; ?>
    </script>
</body>

</html>
