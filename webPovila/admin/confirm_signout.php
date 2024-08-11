<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Confirm Sign Out</title>
    <link rel="stylesheet" href="../confirm_signout.css">
    <link rel="stylesheet" href="../css/admin.css">
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
    </div>
    <script>
        document.getElementById('confirmButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sign out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../logout.php';
                }
            })
        });

        document.getElementById('cancelButton').addEventListener('click', function() {
            window.location.href = 'admin.php'; // กลับไปหน้าแดชบอร์ด
        });
    </script>
    <?php include '../mains.php'; ?>
</body>
</html> 
