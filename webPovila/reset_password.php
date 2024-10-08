<?php
$error_message = ""; // เพื่อเก็บข้อความข้อผิดพลาด
$email = ""; // เพื่อเก็บอีเมลของผู้ใช้

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // ตรวจสอบว่ารหัสผ่านทั้งสองช่องตรงกันหรือไม่
    if ($password !== $confirm_password) {
        $error_message = "รหัสผ่านไม่ตรงกัน."; // เก็บข้อความข้อผิดพลาด
    } else {
        $new_password = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        $servername = "localhost";
        $username = "u642212680_poolvilla";
        $password = "0613989655Za";
        $dbname = "u642212680_poolvilla";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Validate the token using prepared statement
        $stmt = $conn->prepare("SELECT * FROM login_user WHERE reset_token=?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $token_expiry = $row['token_expiry'];
            $email = $row['email']; // ดึงอีเมลจากฐานข้อมูล

            // Check if token has expired
            if (new DateTime() > new DateTime($token_expiry)) {
                header("Location: reset_password.php?error=Token has expired. Please request a new password reset link.");
                exit();
            } else {
                // Update the password using prepared statement
                $update_stmt = $conn->prepare("UPDATE login_user SET password=?, reset_token=NULL, token_expiry=NULL WHERE reset_token=?");
                $update_stmt->bind_param("ss", $new_password, $token);
                if ($update_stmt->execute()) {
                    header("Location: reset_password.php?success=1"); // Redirect to reset_password page
                    exit();
                } else {
                    header("Location: reset_password.php?error=Error updating password.");
                    exit();
                }
                $update_stmt->close();
            }
        } else {
            header("Location: reset_password.php?error=Invalid token.");
            exit();
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css\login.css">
    <style>
        .login{
            height: 400px;
            
        }
        
    .login-header p{
        margin-bottom: 2rem;
       
     }
     .login-header header{
        margin-bottom: 2px;
       
     }
     .input-submit{
        margin-top: 2rem;

     }
     .error-message {
            color: red; /* กำหนดสีข้อความเป็นสีแดง */
        }
     
    </style>
</head>

<body>
    <host>

        <div class="logo">
            <img src="poo/image2.png" alt="Ocean" width="137" height="80">
        </div>
        <nav class="naigation">

            <a href="index.php">HOME</a>

        </nav>

    </host>

    <div class="login">
        <form action="reset_password.php" method="POST">
            <div class="login-header">
                <header>Reset Password</header>
                <p>Enter a new password for you</p>
            </div>
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>" required>
            <div class="input-box">
                <input type="password" class="input-field" name="password" placeholder="Enter new password" required>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required>
                <?php if (!empty($error_message)): ?>
                    <small class="error-message"><?php echo $error_message; ?></small> <!-- แสดงข้อความข้อผิดพลาด -->
                <?php endif; ?>
            </div>
            <div class="input-submit">
                <button class="submit-btn" id="submit"></button>
                <label for="submit">Reset Password</label>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        <?php if (isset($_GET['success']) && $_GET['success'] == '1') : ?>
            swal("สำเร็จ!", "Your password has been reset successfully.", "success").then(() => {
                window.location.href = "login.php"; // กลับไปที่หน้า login หลังจากคลิก OK
            });
        <?php elseif (isset($_GET['error'])) : ?>
            swal("ข้อผิดพลาด!", "<?php echo $_GET['error']; ?>", "error").then(() => {
                window.location.href = "login.php";
            });
        <?php endif; ?>
    </script>
</body>

</html>
