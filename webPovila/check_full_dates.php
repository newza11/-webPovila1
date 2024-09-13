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

// เก็บวันที่ปัจจุบันไว้ในตัวแปร $today
$today = date('Y-m-d');

// เพิ่มวันที่ปัจจุบันเข้าไปใน full_dates เพื่อไม่ให้สามารถจองได้
$full_dates[] = $today;

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

$holiday_dates = [];
$holiday_query = "SELECT holiday_date FROM holidays_db";
$holiday_result = $conn->query($holiday_query);

if ($holiday_result->num_rows > 0) {
    while ($row = $holiday_result->fetch_assoc()) {
        $holiday_dates[] = $row['holiday_date'];  // เก็บวันที่ใน holiday_dates
    }
}

// ส่งผลลัพธ์ในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode([
    'fullDates' => $full_dates,
    'holidayDates' => $holiday_dates
]);

$conn->close();
?>
