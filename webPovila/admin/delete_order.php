<?php
$servername = "localhost";
$username = "u642212680_poolvilla";
$password = "0613989655Za";
$dbname = "u642212680_poolvilla";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['id'];

$sql = "DELETE FROM orders_db WHERE id=$order_id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Order deleted successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>
