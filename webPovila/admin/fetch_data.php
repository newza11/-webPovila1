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

// Fetch monthly revenue for the current month
$monthlyRevenueSql = "SELECT SUM(price) as monthlyRevenue FROM orders_db WHERE MONTH(checkin) = MONTH(CURRENT_DATE()) AND YEAR(checkin) = YEAR(CURRENT_DATE())";
$monthlyRevenueResult = $conn->query($monthlyRevenueSql);
$monthlyRevenueRow = $monthlyRevenueResult->fetch_assoc();
$monthlyRevenue = $monthlyRevenueRow['monthlyRevenue'];

// Fetch monthly revenue for the current year
$yearlyRevenueSql = "SELECT MONTH(checkin) as month, SUM(price) as revenue FROM orders_db WHERE YEAR(checkin) = YEAR(CURRENT_DATE()) GROUP BY MONTH(checkin)";
$yearlyRevenueResult = $conn->query($yearlyRevenueSql);
$yearlyRevenue = [];
while ($row = $yearlyRevenueResult->fetch_assoc()) {
    $yearlyRevenue[(int)$row['month']] = $row['revenue'];
}

// Fetch total users
$totalUsersResult = $conn->query("SELECT COUNT(*) AS totalUsers FROM login_user");
$totalUsers = $totalUsersResult->fetch_assoc()['totalUsers'];

// Placeholder for total expenses
$totalExpenses = 0;

// Calculate total income
$totalIncome = $totalRevenue - $totalExpenses;

// Fetch recent orders (limit 9 rows)
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
    'monthlyRevenue' => $monthlyRevenue,
    'yearlyRevenue' => $yearlyRevenue,
    'totalUsers' => $totalUsers,
    'totalExpenses' => $totalExpenses,
    'totalIncome' => $totalIncome,
    'recentOrders' => $recentOrders
];
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
