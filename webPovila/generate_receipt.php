<?php
session_start();

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

if (!isset($_POST['booking_id'])) {
    die("Booking ID not provided.");
}

$booking_id = $_POST['booking_id'];

// Retrieve booking details
$query = "SELECT id, checkin, checkout, room, price, name, people, phone, status FROM orders_db WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if ($booking) {
    // ดึงค่าของ price จาก $booking
    $price = $booking['price'];

    // คำนวณค่า total หลังจากหัก 4000
    $total = $price - 4000;
} else {
    die("Booking not found.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .receipt-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .receipt-header h2 {
            font-size: 24px;
            font-weight: bold;
            border-bottom-style: solid;
            border-color: #e4b58a;
        }

        .receipt-header p {
            font-size: 16px;
            color: #6c757d;
        }

        .receipt-details p {
            font-size: 14px;
            margin-bottom: 10px;
            color: #495057;
        }

        .receipt-details strong {
            color: #343a40;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 30px;
        }

        .receipt-footer p {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 40px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Hide the print button when printing */
        @media print {
            .receipt-footer {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h2>Booking 🌊บ้านนันท์นภัส พลูวิลล่า</h2>
        </div>

        <div class="receipt-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
            <p><strong>Room:</strong> <?php echo htmlspecialchars($booking['room']); ?></p>
            <p><strong>Check In:</strong> <?php echo $booking['checkin']; ?>(14.00 น.)</p>
            <p><strong>Check Out:</strong> <?php echo $booking['checkout']; ?>(12.00 น.)</p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone']); ?></p>
            <p><strong>Guests:</strong> <?php echo $booking['people']; ?> คน</p>
            <p><strong>Price:</strong> <?php echo number_format($price, 2); ?> บาท</p>
            

            <p>🔆แถมฟรี🔆<br>
                ❕ฟรีถ่าน 1 ถุง<br>
                ❕แถมน้ำดื่ม 2 แพ๊ค<br>
                ❕แถมน้ำแข็ง 2 ถุงใหญ่<br>
                ❕เป๊ปซี่ขวดใหญ่ 2 ขวด
            </p>
            <p><strong>💸 ลูกค้าจ่ายส่วนต่างวันเข้าพักจำนวน:</strong> <?php echo number_format($total, 2); ?> บาท</p>
            และค่าประกันบ้านจำนวน 3,000 บาทกับแม่บ้าน<br>
            *ค่าประกันลูกค้าจะได้คืนในวันเช็คเอาท์เต็มจำนวนกรณีไม่มีของเสียหายค่ะ ขอบคุณค่ะ*<br>
            ‼️ติดต่อสอบถามแอดมินเนย‼️<br>
            ☎️ 098-646-1451
            </p>
        </div>

        <div class="receipt-footer">
            <p>Thank you for your booking!</p>
            <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
        </div>
    </div>
</body>

</html>