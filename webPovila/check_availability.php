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
$room = $_POST['room'];
$people = $_POST['people'];


$query = "SELECT COUNT(*) as total_booked FROM orders_db 
          WHERE (
              (checkin <= ? AND checkout > ?) OR
              (checkin < ? AND checkout >= ?)
          )";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssss",  $check_out, $check_in, $check_in, $check_out);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_booked = $row['total_booked'];


$price_query = "SELECT price FROM room_pirce WHERE room = ?";
$price_stmt = $conn->prepare($price_query);
$price_stmt->bind_param("s", $room);
$price_stmt->execute();
$price_result = $price_stmt->get_result();
$price_row = $price_result->fetch_assoc();
$room_price = $price_row['price'];

if ($total_booked > 0) {
    // Room is fully booked during the requested period
    $response = array(
        "availability" => "เต็ม",
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿". number_format($room_price, 2),
        "security_deposit" => "ค่าประกัน3000"
    );
} else {
    // Room is available during the requested period
    $response = array(
        "availability" => "ว่าง",
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿" . number_format($room_price, 2),
        "security_deposit" => "ค่าประกัน3000"
    );
    
    
}
            $_SESSION['checkin'] = $check_in;
            $_SESSION['checkout'] = $check_out;
            $_SESSION['room'] = $room;
            $_SESSION['people'] = $people;
            $_SESSION['price'] = $room_price;
// number_format($room_price, 2)
// Return the response as a JSON object
echo json_encode($response);

$stmt->close();
$price_stmt->close();
$conn->close();
?>