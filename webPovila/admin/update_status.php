<?php
    if (isset($_GET['id']) && isset($_GET['status'])) {
        $orderId = $_GET['id'];
        $newStatus = $_GET['status'];

        // เชื่อมต่อกับฐานข้อมูล
        include 'db_connection.php';

        // อัปเดตสถานะในฐานข้อมูล
        $query = "UPDATE orders SET status = '$newStatus' WHERE id = $orderId";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['message' => 'Status updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update status']);
        }
    } else {
        echo json_encode(['message' => 'Invalid request']);
    }
?>
