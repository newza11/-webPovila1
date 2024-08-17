<?php
if (isset($_POST['checkin']) && isset($_POST['checkout']) && isset($_POST['room_type'])) {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $room_type = $_POST['room_type'];

    // เชื่อมต่อกับฐานข้อมูล
    $conn = new mysqli("localhost", "username", "password", "database_name");

    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

    // คำนวณจำนวนคืน
    $checkinDate = new DateTime($checkin);
    $checkoutDate = new DateTime($checkout);
    $interval = $checkinDate->diff($checkoutDate);
    $nights = $interval->days;

    // ดึงราคาต่อคืนจากฐานข้อมูลตามประเภทห้อง
    $sql = "SELECT price_per_night FROM rooms WHERE room_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $room_type);
    $stmt->execute();
    $stmt->bind_result($price_per_night);
    $stmt->fetch();
    $stmt->close();

    if ($price_per_night) {
        // คำนวณราคารวม
        $totalPrice = $price_per_night * $nights;

        // ส่งข้อมูลกลับไปในรูปแบบ JSON
        echo json_encode([
            'success' => true,
            'totalPrice' => $totalPrice
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false]);
}
