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
        <p>Please complete payment by scanning the QR code.</p>
        <p>โอนจอง Povila</p>
        <h4>ยอด 2000บาท</h4>
        
        <div class="payment-details">
            <!-- QR code -->
            <img src="poo\payment.jpg" style="width: 50%; margin-top: -1rem;" alt="QR Code">

            <!-- Payment slip attachment -->
            <form id="paymentForm" action="payment.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <label for="paymentSlip">Attach Payment Slip:</label>
                <input type="file" id="paymentSlip" name="paymentSlip" required>
                
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>

    <script>
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['paymentSlip']) && $_FILES['paymentSlip']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['paymentSlip']['name']);

        if (move_uploaded_file($_FILES['paymentSlip']['tmp_name'], $uploadFile)) {
            header('Location: Completed.php');
            exit();
        } else {
            echo 'Failed to upload file.';
        }
    } 
    
}
?>
