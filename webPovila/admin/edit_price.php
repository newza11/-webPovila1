<?php
include 'db_connection.php';

// Check if the room ID is provided in the URL
if (isset($_GET['id'])) {
    $roomId = htmlspecialchars($_GET['id']);

    // Fetch the current room details
    $sql = "SELECT * FROM room_pirce WHERE room = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $room = $result->fetch_assoc();
    } else {
        $error_message = "Room not found.";
    }
} else {
    $error_message = "No room ID provided.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPrice = htmlspecialchars($_POST['price']);

    // Update the room price in the database
    $updateSql = "UPDATE room_pirce SET price = ? WHERE room = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ds", $newPrice, $roomId);

    if ($updateStmt->execute()) {
        $success_message = "Room price updated successfully.";
    } else {
        $error_message = "Error updating price: " . $conn->error;
    }

    $updateStmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Edit Room Price</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
</head>
<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="form-container">
            <h1>Edit Room Price</h1>
            <?php if (isset($success_message)) : ?>
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '<?php echo $success_message; ?>',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'room_price_list.php';
                    });
                </script>
            <?php elseif (isset($error_message)) : ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?php echo $error_message; ?>'
                    });
                </script>
            <?php endif; ?>
            <form method="POST">
                <label for="roomNumber">Room Number:</label>
                <input type="text" id="roomNumber" name="room_number" value="<?php echo htmlspecialchars($room['room']); ?>" readonly>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($room['price']); ?>" required step="0.01">

                <button type="submit">Update Price</button>
            </form>
        </div>
    </div>

    <?php include '../mains.php'; ?>
</body>
</html>
