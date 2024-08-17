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
$check_out = $_POST['check_out'];
$people = $_POST['people'];

// คำนวณจำนวนคืนที่เข้าพัก
$nights = (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24); 

// Determine the check-in day
$check_in_day = date('N', strtotime($check_in)); 

// Automatically select 6 rooms if it's Friday or Saturday
if ($check_in_day == 5 || $check_in_day == 6) {
    $room = '6ห้อง';
} else {
    $room = $_POST['room'];
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
if ($check_in_day == 5) { 
    $room_price += 3000;
} elseif ($check_in_day == 6) { 
    $room_price += 5000;
}

// คำนวณราคารวมสำหรับจำนวนคืนที่พัก
$total_price = $room_price * $nights;

// Loop เพื่อตรวจสอบวันที่ตั้งแต่ check_in จนถึงวันก่อน check_out
$is_full = false;
$current_date = strtotime($check_in);
$last_date = strtotime('-1 day', strtotime($check_out)); // หาวันสุดท้ายที่ต้องเช็ค (วันก่อน check_out)

$full_dates = []; // สร้าง array เพื่อเก็บวันที่ห้องถูกจองเต็ม

while ($current_date <= $last_date) {
    $current_date_str = date('Y-m-d', $current_date);

    // เช็คแต่ละวันในช่วงเข้าพักว่าถูกจองเต็มหรือไม่
    $query = "SELECT COUNT(*) as total_booked FROM orders_db 
              WHERE checkin = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $current_date_str);  
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_booked = $row['total_booked'];

    if ($total_booked > 0) {
        $is_full = true;
        $full_dates[] = $current_date_str; // เก็บวันที่เต็ม
    }

    // เพิ่มวัน
    $current_date = strtotime('+1 day', $current_date);
}

// แสดงผลลัพธ์ตามการเช็คว่าเต็มหรือไม่
if ($is_full) {
    // ห้องพักถูกจองเต็มในช่วงวันที่เลือก
    $response = array(
        "availability" => "เต็ม",
        "is_full" => true,
        "full_dates" => $full_dates, // ส่งวันที่เต็มไปยัง client
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿" . number_format($total_price, 2),
        "security_deposit" => "ค่าประกัน3000"
    );
} else {
    // ห้องว่างในช่วงวันที่เลือก
    $response = array(
        "availability" => "ว่าง",
        "is_full" => false,
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿" . number_format($total_price, 2),
        "security_deposit" => "ค่าประกัน3000"
    );
}

// เก็บข้อมูลใน session
$_SESSION['checkin'] = $check_in;
$_SESSION['checkout'] = $check_out;
$_SESSION['room'] = $room;
$_SESSION['people'] = $people;
$_SESSION['price'] = $total_price;

echo json_encode($response);

$stmt->close();
$price_stmt->close();
$conn->close();
?>
