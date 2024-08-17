<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="css/payment.css">
</head>

<body>
    <div class="container">
        <h1>Payment Details</h1>

        <div class="payment-options">
            <label>
                <input type="radio" name="paymentMethod" value="bank" checked onclick="togglePaymentMethod('bank')">
                Pay via Bank Account
            </label>
            <label>
                <input type="radio" name="paymentMethod" value="qr" onclick="togglePaymentMethod('qr')">
                Pay via QR Code
            </label>
        </div>

        <div id="bankDetails" class="payment-details bank-details">
            <h4>Bank Account Details:</h4>
            <div class="ddd">
                <p>โอนจอง Povila</p>
                <p>Account Number: 076-3687-929</p>
                <p>Name: นันท์นภัส นวโชติ</p>
                <p>Bank: กสิกรไทย</p>
            </div>
            
            <h4>จำนวนเงิน: 4000 บาท</h4>
        </div>

        <div id="qrDetails" class="payment-details" style="display:none;">
            <h4>Scan QR Code:</h4>
            <img src="poo/payment.jpg" style="width: 50%; margin-top: -1rem;" alt="QR Code">
            
            <h4>จำนวนเงิน: 4000 บาท</h4>
        </div>

        <div class="payment-slip">
            <!-- Payment slip attachment -->
            <form id="paymentForm" action="payment.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <label for="paymentSlip">Attach Payment Slip:</label>
                <input type="file" id="paymentSlip" name="paymentSlip" accept=".jpg, .jpeg, .png" required>


                <button type="submit">Upload</button>
            </form>
        </div>
    </div>

    <script>
        function togglePaymentMethod(method) {
            const bankDetails = document.getElementById('bankDetails');
            const qrDetails = document.getElementById('qrDetails');

            if (method === 'bank') {
                bankDetails.style.display = 'block';
                qrDetails.style.display = 'none';
            } else {
                bankDetails.style.display = 'none';
                qrDetails.style.display = 'block';
            }
        }

        function validateForm() {
            const paymentSlip = document.getElementById('paymentSlip').files.length;
            if (paymentSlip === 0) {
                alert('Please attach a payment slip before submitting.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
<?php

session_start();
require 'db_connect.php'; // Include the database connection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the payment slip was uploaded without errors
    if (isset($_FILES['paymentSlip']) && $_FILES['paymentSlip']['error'] === UPLOAD_ERR_OK) {
        // Check file type
        $allowedMimeTypes = ['image/jpeg', 'image/png'];
        $fileMimeType = mime_content_type($_FILES['paymentSlip']['tmp_name']);

        if (in_array($fileMimeType, $allowedMimeTypes)) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadFile = $uploadDir . basename($_FILES['paymentSlip']['name']);

            if (move_uploaded_file($_FILES['paymentSlip']['tmp_name'], $uploadFile)) {
                // Retrieve booking details from session
                $id =  $_SESSION['user_id'] ?? 0;
                $check_in = $_SESSION['checkin'] ?? 'ไม่ระบุ';
                $check_out = $_SESSION['checkout'] ?? 'ไม่ระบุ';
                $room = $_SESSION['room'] ?? 'ไม่ระบุ';
                $room_price = $_SESSION['price'] ?? 0;
                $people =  $_SESSION['people'] ?? 0;
                $status = 'check'; // Default status

                $name = $_SESSION['name'] ?? 'ไม่ระบุ';
                $first_name = $_SESSION['firstname'] ?? 'ไม่ระบุ';
                $last_name = $_SESSION['lastname'] ?? 'ไม่ระบุ';
                $phone = $_SESSION['phone'] ?? 'ไม่ระบุ';

                // Prepare SQL query to update orders_db with the slip path
                $sql = "INSERT INTO orders_db (name, price, people, checkin, checkout, status, phone, room, firstname, lastname, slip, user_id) 
                        VALUES (:name, :price, :people, :checkin, :checkout, :status, :phone, :room, :firstname, :lastname, :slip, :user_id)";
                
                $stmt = $pdo->prepare($sql);
                
                // Execute the query with the data from the form and session
                $stmt->execute([
                    ':name' => $name,
                    ':price' => $room_price,
                    ':people' => $people,
                    ':checkin' => $check_in,
                    ':checkout' => $check_out,
                    ':status' => $status,
                    ':phone' => $phone,
                    ':room' => $room,
                    ':firstname' => $first_name,
                    ':lastname' => $last_name,
                    ':slip' => $uploadFile,
                    ':user_id' => $id
                ]);
                
                // Redirect to a completion page
                header('Location: Completed.php');
                exit();
            } else {
                echo 'Failed to upload file.';
            }
        } else {
            echo 'Invalid file type. Only JPG, JPEG, and PNG files are allowed.';
        }   
    } else {
        echo 'No file uploaded or there was an upload error.';
    }
}


?>