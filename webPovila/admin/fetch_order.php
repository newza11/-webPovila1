<?php
// Database connection (replace with your actual connection details)
$conn = new mysqli('localhost', 'username', 'password', 'my_website');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders from the database
$sql = "SELECT id, name, price, people, checkin, checkout, status, slip FROM orders_db";
$result = $conn->query($sql);

$orders = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $orders[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'people' => $row['people'],
            'checkin' => $row['checkin'],
            'checkout' => $row['checkout'],
            'status' => $row['status'],
            'slip' => $row['slip'], // This assumes the slip field contains the URL or path to the slip
        );
    }
} else {
    echo json_encode(array('message' => 'No orders found'));
    exit();
}

echo json_encode($orders);
echo json_encode($slip);
$conn->close();
?>
