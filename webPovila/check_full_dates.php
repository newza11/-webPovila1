<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูล checkin และ checkout จากฐานข้อมูล
$query = "SELECT checkin, checkout FROM orders_db";
$result = $conn->query($query);

$full_dates = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $checkin = new DateTime($row['checkin']);
        $checkout = new DateTime($row['checkout']);
        
        // ลดวัน checkout ลง 1 วันเพื่อไม่ให้แสดงเป็นวันเต็ม
        $checkout->modify('-1 day');

        // วนลูปเพื่อเก็บวันทั้งหมดระหว่าง checkin และก่อน checkout
        while ($checkin <= $checkout) {
            $full_dates[] = $checkin->format('Y-m-d');
            // เพิ่มวันถัดไป
            $checkin->modify('+1 day');
        }
    }
}

// ส่งผลลัพธ์ในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($full_dates);

$conn->close();
?>
