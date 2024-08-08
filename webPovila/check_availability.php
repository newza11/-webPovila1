<?php
session_start();

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

header('Content-Type: application/json');

try {
    // Debugging: Output the request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method: ' . $_SERVER['REQUEST_METHOD']);
    }

    $checkin = $_POST['check_in'];
    $checkout = $_POST['check_out'];
    $people = $_POST['people'];
    $room = $_POST['room'];

    // Using prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM orders_db WHERE (checkin <= ? AND checkout >= ?) AND room = ?");
    $stmt->bind_param("sss", $checkout, $checkin, $room);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $result = $stmt->get_result();
    $availability = ($result->num_rows > 0) ? 'เต็ม' : 'ว่าง';

    echo json_encode([
        'availability' => $availability,
        'checkin' => $checkin,
        'checkout' => $checkout,
        'room' => $room,
        'price' => '฿6,900',
        'security_deposit' => 'ค่าประกัน3000'
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    $conn->close();
}
?>