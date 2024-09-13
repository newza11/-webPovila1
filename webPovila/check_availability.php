<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$people = $_POST['people'];

// Define the days to be calculated (check-in day and the day before check-out)
$dates_to_check = [strtotime($check_in), strtotime('-1 day', strtotime($check_out))];

// Fetch holidays from the database (between check-in and check-out)
$holiday_query = "SELECT holiday_date, holiday_price FROM holidays_db WHERE holiday_date BETWEEN ? AND ?";
$holiday_stmt = $conn->prepare($holiday_query);
$holiday_stmt->bind_param("ss", $check_in, $check_out);
$holiday_stmt->execute();
$holiday_result = $holiday_stmt->get_result();

$holidays = [];
while ($holiday_row = $holiday_result->fetch_assoc()) {
    $holidays[$holiday_row['holiday_date']] = $holiday_row['holiday_price']; // เก็บวันที่ของวันหยุดในฟอร์แมต Y-m-d
}

// Check if any of the dates fall on a Friday, Saturday, or a holiday
$force_six_rooms = false;
foreach ($dates_to_check as $date) {
    $current_day = date('N', $date);
    $current_date_str = date('Y-m-d', $date); // ฟอร์แมตวันที่เป็น Y-m-d

    // ตรวจสอบว่าเป็นวันศุกร์หรือเสาร์ หรือวันหยุด
    if ($current_day == 5 || $current_day == 6 || $current_day == 7 || isset($holidays[$current_date_str])) {
        $force_six_rooms = true;
        break;
    }
}

// Automatically select 6 rooms if any of the dates fall on Friday, Saturday, or a holiday
if ($force_six_rooms) {
    $room = '6ห้อง';
} else {
    $room = $_POST['room'];
}

// Fetch the base price from the database
$price_query = "SELECT price FROM room_pirce WHERE room = ?";
$price_stmt = $conn->prepare($price_query);
$price_stmt->bind_param("s", $room);
$price_stmt->execute();
$price_result = $price_stmt->get_result();
$price_row = $price_result->fetch_assoc();
$base_price = $price_row['price'];

// Initialize total price
$total_price = 0;

// Loop through each day from check-in to the day before check-out
$current_date = strtotime($check_in);
$last_date = strtotime('-1 day', strtotime($check_out));

while ($current_date <= $last_date) {
    $current_day = date('N', $current_date); // Get day of the week
    $current_date_str = date('Y-m-d', $current_date); // Format date

    // Set the daily price based on the day of the week
    $daily_price = $base_price;
    if ($current_day == 5) { 
        $daily_price += 3000; // Friday
    } elseif ($current_day == 6) { 
        $daily_price += 5000; // Saturday
    }

    // Check if the date is a holiday and apply holiday price if available
    if (isset($holidays[$current_date_str])) {
        $daily_price = $holidays[$current_date_str]; // Use holiday price if available
    }

    // Add daily price to the total price
    $total_price += $daily_price;

    // Move to the next day
    $current_date = strtotime('+1 day', $current_date);
}

// Check if the selected dates are fully booked
$is_full = false;
$current_date = strtotime($check_in);
$full_dates = [];

while ($current_date <= $last_date) {
    $current_date_str = date('Y-m-d', $current_date);

    // Check each day in the range if the room is fully booked
    $query = "SELECT COUNT(*) as total_booked FROM orders_db 
              WHERE checkin = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $current_date_str);  
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_booked = $row['total_booked'];

    if ($total_booked > 0) {
        $is_full = true;
        $full_dates[] = $current_date_str; // Save fully booked date
    }

    // Move to the next day
    $current_date = strtotime('+1 day', $current_date);
}

// Show the result based on availability
if ($is_full) {
    $response = array(
        "availability" => "เต็ม",
        "is_full" => true,
        "full_dates" => $full_dates,
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿" . number_format($total_price, 2),
        "security_deposit" => "ค่าประกัน3000"
    );
} else {
    $response = array(
        "availability" => "ว่าง",
        "is_full" => false,
        "checkin" => $check_in,
        "checkout" => $check_out,
        "room" => $room,
        "price" => "฿" . number_format($total_price, 2),
        "security_deposit" => "ค่าประกัน3000"
    );
}

// Store session data
$_SESSION['checkin'] = $check_in;
$_SESSION['checkout'] = $check_out;
$_SESSION['room'] = $room;
$_SESSION['people'] = $people;
$_SESSION['price'] = $total_price;

echo json_encode($response);

$stmt->close();
$price_stmt->close();
$holiday_stmt->close();
$conn->close();
?>
