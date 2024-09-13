<?php
include 'db_connection.php';

$error_message = '';
$success_message = '';
$holiday = [];

// ตรวจสอบว่าเป็นคำร้องขอ POST หรือ GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $holiday_name = $_POST['holiday_name'];
    $holiday_date = $_POST['holiday_date'];
    $holiday_price = $_POST['holiday_price'];
    
    // อัปเดตข้อมูลวันหยุด
    $sql = "UPDATE holidays_db SET holiday_name=?, holiday_date=?, holiday_price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $holiday_name, $holiday_date, $holiday_price, $id);

    if ($stmt->execute()) {
        $success_message = "Holiday updated successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }
} else {
    // ดึงข้อมูลวันหยุดที่มีอยู่
    $holiday_date = $_GET['id'];
    $sql = "SELECT id, holiday_name, holiday_date, holiday_price FROM holidays_db WHERE holiday_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $holiday_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $holiday = $result->fetch_assoc();

    if (!$holiday) {
        $error_message = "Holiday not found.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Holiday</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container form label {
            margin-bottom: 5px;
        }
        .form-container form input, .form-container form select {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container form button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .form-container form button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="container">
        <div class="form-container">
            <h1>Edit Holiday</h1>
            <?php if (!empty($error_message)) : ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form id="holidayForm" action="edit_holiday.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($holiday['id'] ?? ''); ?>">
                <label for="holiday_name">Holiday Name:</label>
                <input type="text" id="holiday_name" name="holiday_name" value="<?php echo htmlspecialchars($holiday['holiday_name'] ?? ''); ?>" required>
                <label for="holiday_date">Holiday Date:</label>
                <input type="date" id="holiday_date" name="holiday_date" value="<?php echo htmlspecialchars($holiday['holiday_date'] ?? ''); ?>" required>
                <label for="holiday_price">Holiday Price:</label>
                <input type="text" id="holiday_price" name="holiday_price" value="<?php echo htmlspecialchars($holiday['holiday_price'] ?? ''); ?>" required>
                <button type="submit">Update Holiday</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if (!empty($success_message)) : ?>
                Swal.fire({
                    title: 'Success!',
                    text: '<?php echo $success_message; ?>',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function () {
                    window.location.href = 'manage_holidays.php';
                });
            <?php elseif (!empty($error_message)) : ?>
                Swal.fire({
                    title: 'Error!',
                    text: '<?php echo $error_message; ?>',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>
    <?php include '../mains.php'; ?>
</body>
</html>
