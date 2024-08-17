<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$check_in = $_POST['check_in'];

// Calculate the check-out date as one day after the check-in date (แต่ไม่ต้องใช้ในการเช็ค)
$check_out = date('Y-m-d', strtotime($check_in . ' +1 day'));

$people = $_POST['people'];

// Determine the check-in day
$check_in_day = date('N', strtotime($check_in)); // 1 = Monday, 7 = Sunday

// Automatically select 6 rooms if it's Friday or Saturday
if ($check_in_day == 5 || $check_in_day == 6) {
    $room = '6ห้อง';
} else {
    $room = $_POST['room']; // Use the selected room if it's not Friday or Saturday
}

// Fetch the base price from the database
$price_query = "SELECT price FROM room_pirce WHERE room = ?";
$price_stmt = $conn->prepare($price_query);
$price_stmt->bind_param("s", $room);
$price_stmt->execute();
$price_result = $price_stmt->get_result();
$price_row = $price_result->fetch_assoc();
$room_price = $price_row['price'];

// Adjust the price based on the check-in day
if ($check_in_day == 5) { // Friday
    $room_price += 3000;
} elseif ($check_in_day == 6) { // Saturday
    $room_price += 5000;
}

// เช็คเฉพาะวันที่ checkin ว่าถูกจองเต็มหรือไม่
$query = "SELECT COUNT(*) as total_booked FROM orders_db 
          WHERE checkin = ?";   

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $check_in);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_booked = $row['total_booked'];

$is_full = $total_booked > 0;

if ($is_full) {
    // Room is fully booked on the check-in date
    $response = array(
        "availability" => "เต็ม",
        "is_full" => true,
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿" . number_format($room_price, 2),
        "security_deposit" => "ค่าประกัน3000"
    );
} else {
    // Room is available on the check-in date
    $response = array(
        "availability" => "ว่าง",
        "is_full" => false,
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿" . number_format($room_price, 2),
        "security_deposit" => "ค่าประกัน3000"
    );
}

$_SESSION['checkin'] = $check_in;
$_SESSION['checkout'] = $check_out; // สามารถใช้ checkout เป็นค่าแสดงผลได้ แต่ไม่ใช้ในการเช็คห้อง
$_SESSION['room'] = $room;
$_SESSION['people'] = $people;
$_SESSION['price'] = $room_price;

echo json_encode($response);

$stmt->close();
$price_stmt->close();
$conn->close();

?>
