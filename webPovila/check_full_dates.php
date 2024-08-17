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

// ดึงข้อมูล checkin จากฐานข้อมูล
$query = "SELECT checkin FROM orders_db";
$result = $conn->query($query);

$full_dates = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $checkin = new DateTime($row['checkin']);
        $full_dates[] = $checkin->format('Y-m-d'); // เก็บเฉพาะ checkin
    }
}

// ส่งผลลัพธ์ในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($full_dates);

$conn->close();
?>
