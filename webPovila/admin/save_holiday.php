<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $holiday_name = $_POST['holiday_name'];
    $holiday_date = $_POST['holiday_date'];
    $holiday_price = $_POST['holiday_price'];

    $sql = "INSERT INTO holidays_db (holiday_name, holiday_date, holiday_price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $holiday_name, $holiday_date, $holiday_price);

    if ($stmt->execute()) {
        header("Location: manage_holidays.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
