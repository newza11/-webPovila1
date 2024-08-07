<?php
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

// Fetch total orders
$orderSql = "SELECT COUNT(*) as totalOrders FROM orders_db";
$orderResult = $conn->query($orderSql);
$orderRow = $orderResult->fetch_assoc();
$totalOrders = $orderRow['totalOrders'];

// Fetch total revenue
$revenueSql = "SELECT SUM(price) as totalRevenue FROM orders_db";
$revenueResult = $conn->query($revenueSql);
$revenueRow = $revenueResult->fetch_assoc();
$totalRevenue = $revenueRow['totalRevenue'];

// Placeholder for total expenses
$totalExpenses = 0;

// Calculate total income
$totalIncome = $totalRevenue - $totalExpenses;

// Fetch recent orders (limit 7 rows)
$recentOrdersSql = "SELECT * FROM orders_db ORDER BY checkin DESC LIMIT 9";
$recentOrdersResult = $conn->query($recentOrdersSql);

$recentOrders = [];
if ($recentOrdersResult->num_rows > 0) {
    while ($row = $recentOrdersResult->fetch_assoc()) {
        $recentOrders[] = $row;
    }
}

$data = [
    'totalOrders' => $totalOrders,
    'totalRevenue' => $totalRevenue,
    'totalExpenses' => $totalExpenses,
    'totalIncome' => $totalIncome,
    'recentOrders' => $recentOrders
];
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
