<?php
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php';

    $holiday_name = $_POST['holiday_name'];
    $holiday_date = $_POST['holiday_date'];
    $holiday_price = $_POST['holiday_price'];
    
    // Check if the holiday date already exists
    $sql = "SELECT * FROM holidays_db WHERE holiday_date=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $holiday_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Holiday date already exists. Please use a different date.";
    } else {
        $sql = "INSERT INTO holidays_db (holiday_name, holiday_date, holiday_price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $holiday_name, $holiday_date, $holiday_price);

        if ($stmt->execute()) {
            $success_message = "Holiday added successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Holiday</title>
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
            <h1>Add Holiday</h1>
            <?php if (!empty($error_message)) : ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form id="holidayForm" action="add_holiday.php" method="POST">
                <label for="holiday_name">Holiday Name:</label>
                <input type="text" id="holiday_name" name="holiday_name" required>
                <label for="holiday_date">Holiday Date:</label>
                <input type="date" id="holiday_date" name="holiday_date" required>
                <label for="holiday_price">Holiday Price:</label>
                <input type="text" id="holiday_price" name="holiday_price" required>
                <button type="submit">Add Holiday</button>
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
