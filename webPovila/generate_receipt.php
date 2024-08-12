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

if (!isset($_POST['booking_id'])) {
    die("Booking ID not provided.");
}

$booking_id = $_POST['booking_id'];

// Retrieve booking details
$query = "SELECT id, checkin, checkout, room, price, name,people, status FROM orders_db WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Booking not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .receipt-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-details {
            margin-bottom: 20px;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h2>Booking 🌊บ้านนันท์นภัส พลูวิลล่า</h2>
            <p><strong>Booking ID:</strong> <?php echo $booking['id']; ?></p>
        </div>

        <div class="receipt-details">
            <p><strong>Name:</strong> <?php echo $booking['name']; ?></p>
            <p><strong>Check In:</strong> <?php echo $booking['checkin']; ?>(14.00 น.)</p>
            <p><strong>Check Out:</strong> <?php echo $booking['checkout']; ?>(12.00 น.) </p>
            <p><strong>Room:</strong> <?php echo $booking['room']; ?></p>
            <p><strong>Guests:</strong> <?php echo $booking['people']; ?>คน</p>
            <p><strong>Price:</strong> <?php echo number_format($booking['price'], 2); ?> บาท</p>
            <p>🔆แถมฟรี🔆
                ❕ฟรีถ่าน 1 ถุง<br>
                ❕แถมน้ำดื่ม 2 แพ๊ค<br>
                ❕แถมน้ำแข็ง 2 ถุงใหญ่<br>
                ❕เป๊ปซี่ขวดใหญ่ 2 ขวด</p>
                <p><strong>💸 ลูกค้าจ่ายส่วนต่างวันเข้าพักจำนวน</strong> <?php echo number_format($booking['price'], 2); ?> บาท<br>

และค่าประกันบ้านจำนวน 3,000 บาทกับแม่บ้าน<br>
*ค่าประกันลูกค้าจะได้คืนในวันเช็คเอาท์เต็มจำนวนกรณีไม่มีของเสียหายค่ะ ขอบคุณค่ะ*
‼️ติดต่อสอบถามแอดมินเนย‼️<br>
☎️ 098-646-1451</p>

        </div>

        <div class="receipt-footer">
            <p>Thank you for your booking!</p>
            <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
        </div>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>