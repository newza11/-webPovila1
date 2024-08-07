<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/setting.css">
</head>

<body>
<!-- =============== Navigation ================ -->
<div class="container">
<?php include 'menu.php'; ?>


        <!-- ======================= Settings Section ================== -->
        <div class="settings-section">
            <h1>Settings</h1>
            <form class="settings-form" action="admin.php">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>


                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
</div>

            
    <!-- =========== Scripts =========  -->
    <script src="main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>