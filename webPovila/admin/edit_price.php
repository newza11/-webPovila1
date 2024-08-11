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
        echo "Room not found.";
        exit;
    }
} else {
    echo "No room ID provided.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPrice = htmlspecialchars($_POST['price']);

    // Update the room price in the database
    $updateSql = "UPDATE room_pirce SET price = ? WHERE room = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ds", $newPrice, $roomId);

    if ($updateStmt->execute()) {
        echo "Room price updated successfully.";
        header("Location: room_price_list.php");
        exit;
    } else {
        echo "Error updating price: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Edit Room Price</title>
</head>
<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="form-container">
            <h1>Edit Room Price</h1>
            <form method="POST">
                <label for="roomNumber">Room Number:</label>
                <input type="text" id="roomNumber" name="room_number" value="<?php echo $room['room']; ?>" readonly>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo $room['room']; ?>" required step="0.01">

                <button type="submit">Update Price</button>
            </form>
        </div>
    </div>

    <?php include '../mains.php'; ?>
</body>
</html>
