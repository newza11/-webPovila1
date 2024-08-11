<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
    <link rel="stylesheet" href="../css/user.css">
    <title>Add Room</title>
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="form-container">
            <h1>Add Room</h1>
            <form method="POST">
                <label for="roomNumber">Room Number:</label>
                <input type="text" id="roomNumber" name="room_number" required>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required step="0.01">

                <button type="submit">Add Room</button>
            </form>
        </div>
    </div>

    <?php include '../mains.php'; ?>
</body>

</html>

<?php
// Backend PHP Logic for adding a room
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php';

    $room_number = $_POST['room_number'];
    $price = $_POST['price'];

    $sql = "INSERT INTO room_pirce (room, price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('id', $room_number, $price);

    if ($stmt->execute()) {
        echo "<script>alert('Room added successfully!'); window.location.href='room_price_list.php';</script>";
    } else {
        echo "<script>alert('Error adding room: " . $conn->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
