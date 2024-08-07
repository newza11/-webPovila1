<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Sign Out</title>
    <link rel="stylesheet" href="confirm_signout.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <?php include 'menu.php'; ?>

        <div class="container1">
        <h1>Are you sure you want to sign out?</h1>
        <button id="confirmButton">Yes, Sign Out</button>
        <button id="cancelButton">Cancel</button>
    </div>
    <script>
        document.getElementById('confirmButton').addEventListener('click', function() {
            window.location.href = 'logout.php';
        });

        document.getElementById('cancelButton').addEventListener('click', function() {
            window.location.href = 'admin.php'; // กลับไปหน้าแดชบอร์ด
        });
    </script>
    <script src="main.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
