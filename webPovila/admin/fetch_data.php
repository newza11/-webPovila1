<?php
session_start();

// Check if the user is logged in as Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}

// Connection to your database
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

// Define array for month abbreviations
$monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

// Fetch yearly revenue for the past 2 years, current year, and next 2 years
$years = [2022, 2023, 2024, 2025, 2026];
$yearlyRevenue = [];

foreach ($years as $year) {
    $yearlyRevenueSql = "SELECT MONTH(checkin) as month, SUM(price) as revenue 
                         FROM orders_db 
                         WHERE YEAR(checkin) = $year 
                         GROUP BY MONTH(checkin)";
    $yearlyRevenueResult = $conn->query($yearlyRevenueSql);
    $yearlyRevenue[$year] = array_fill_keys($monthNames, 0); // Initialize each month to 0

    while ($row = $yearlyRevenueResult->fetch_assoc()) {
        $monthIndex = (int)$row['month'] - 1; // Get index (0-11) for the month
        $monthName = $monthNames[$monthIndex]; // Get the month name (e.g., Jan, Feb)
        $yearlyRevenue[$year][$monthName] = $row['revenue'];
    }
}

// Fetch total users
$totalUsersResult = $conn->query("SELECT COUNT(*) AS totalUsers FROM login_user");
$totalUsers = $totalUsersResult->fetch_assoc()['totalUsers'];

// Placeholder for total expenses (if you have this data, fetch it from the database)
$totalExpenses = 0;

// Calculate total income
$totalIncome = $totalRevenue - $totalExpenses;

// Fetch recent orders (limit 9 rows) and sort by status
$recentOrdersSql = "SELECT * FROM orders_db ORDER BY 
                    CASE 
                        WHEN status = 'Waiting to enter' THEN 1
                        WHEN status = 'check' THEN 2
                        WHEN status = 'Completed' THEN 3
                        ELSE 4
                    END, checkin DESC LIMIT 9";
$recentOrdersResult = $conn->query($recentOrdersSql);

$recentOrders = [];
if ($recentOrdersResult->num_rows > 0) {
    while ($row = $recentOrdersResult->fetch_assoc()) {
        $recentOrders[] = $row;
    }
}

// Data structure for JSON response
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

// Send JSON response
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
