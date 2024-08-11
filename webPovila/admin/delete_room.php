<?php
// Backend PHP Logic for deleting a room
if (isset($_GET['id'])) {
    include 'db_connection.php';

    $room_id = $_GET['id'];

    $sql = "DELETE FROM room_pirce WHERE room = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $room_id);

    if ($stmt->execute()) {
        echo "<script>alert('Room deleted successfully!'); window.location.href='room_price_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting room: " . $conn->error . "'); window.location.href='room_price_list.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('No room ID provided.'); window.location.href='room_price_list.php';</script>";
}
?>
