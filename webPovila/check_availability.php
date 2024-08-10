<?php
// Start the session
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the form data
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$room = $_POST['room'];

// Prepare the SQL query to check for availability
$query = "SELECT COUNT(*) as total_booked FROM orders_db 
          WHERE
          checkin > ? AND checkout < ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $check_in, $check_out);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_booked = $row['total_booked'];


if ($row['total_booked'] > 0) {
    // Room is fully booked during the requested period
    $response = array(
        "availability" => "เต็ม",
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿6,900",
        "security_deposit" => "ค่าประกัน3000"
    );
} else {
    // Room is available during the requested period
    $response = array(
        "availability" => "ว่าง",
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿6,900",
        "security_deposit" => "ค่าประกัน3000"
    );
}

// Return the response as a JSON object
echo json_encode($response);

$stmt->close();
$conn->close();
?>
