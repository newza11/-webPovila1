<?php
// Database connection settings
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

// Fetch data from orders table
$sql = "SELECT * FROM orders_db";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data in JSON format
    $orders = array();
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    echo json_encode($orders);
} else {
    echo json_encode(array());
}

$conn->close();
?>
