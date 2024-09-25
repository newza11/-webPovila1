<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
    <?php include 'menu.php'; ?>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                    <img src="poo/customer01.jpg" alt="">
                </div>
            </div>
            <div class="container1">
                <h1>You have successfully signed out</h1>
                <p>Thank you for visiting. Click the button below to return to the login page.</p>
                <button id="homeButton" onclick="window.location.href='login.php'">Go to Login Page</button>
            </div>

    <!-- =========== Scripts =========  -->
    <?php include '../mains.php'; ?>
</body>

</html>
