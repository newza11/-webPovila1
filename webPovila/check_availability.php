<?php
include 'db_connection.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'not_logged_in']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkin = $_POST['check_in'];
    $checkout = $_POST['check_out'];
    $guests = $_POST['guests'];
    $room = $_POST['room'];

    $sql = "SELECT * FROM orders_db WHERE (checkin_date <= ? AND checkout_date >= ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $checkout, $checkin);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'unavailable']);
    } else {
        echo json_encode(['status' => 'available']);
    }
}
?>
