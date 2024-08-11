<?php
include 'db_connection.php'; // Assume this connects to your database

$sql = "SELECT id, name, price, people, checkin, checkout, status, slip FROM orders_db";
$result = $conn->query($sql);

$orders = array();
while($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
