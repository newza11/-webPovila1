<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ฟังก์ชันสร้าง token
function generateToken()
{
    return bin2hex(random_bytes(16));
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ''; // ตัวแปรสำหรับเก็บข้อความ

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $userEmail = trim($_POST['email']); // ตรวจสอบอีเมลจากฟอร์ม

    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $message = "ที่อยู่อีเมลไม่ถูกต้อง";
    } else {
        // สร้าง token และวันหมดอายุ (1 ชั่วโมงจากเวลาปัจจุบัน)
        $token = generateToken();
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // บันทึก token และวันหมดอายุในฐานข้อมูล
        $stmt = $conn->prepare("UPDATE login_user SET reset_token=?, token_expiry=? WHERE email=?");
        $stmt->bind_param("sss", $token, $expiry, $userEmail);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $stmt->close();
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';  // ใช้ SMTP ของ Gmail
                $mail->SMTPAuth   = true;
                $mail->Username   = 'kulwadee45@gmail.com';  // อีเมลของคุณ
                $mail->Password   = 'oqbi xoob sfrj cpzh';  // App password ของ Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // การเข้ารหัส TLS
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('kulwadee45@gmail.com', 'Mailer');
                $mail->addAddress($userEmail);  // ส่งอีเมลไปยังที่อยู่ที่กรอก

                // Content
                $mail->isHTML(true);
                $resetLink = "http://localhost/webPovila/webPovila/reset_password.php?token=" . $token; // สร้างลิงค์รีเซ็ตรหัสผ่าน
                $mail->Subject = 'Reset Password Poolvila';
                $mail->Body    = 'กรุณาคลิกที่ลิงค์นี้เพื่อตั้งค่ารหัสผ่านใหม่: <a href="' . $resetLink . '">รีเซ็ตรหัสผ่าน</a>';
                $mail->AltBody = 'กรุณาคลิกที่ลิงค์นี้เพื่อตั้งค่ารหัสผ่านใหม่: ' . $resetLink;

                $mail->send();
                $message = 'ข้อความได้ถูกส่งไปยังอีเมลของคุณ กรุณาตรวจสอบเพื่อทำการรีเซ็ตรหัสผ่าน';
            } catch (Exception $e) {
                $message = "ไม่สามารถส่งข้อความได้. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $message = "อีเมลนี้ไม่ถูกต้อง กรุณาใส่อีเมลใหม่";
        }
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
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Forgot Password</title>
</head>
<style>
    .login {
        height: 350px;
    }

    .login-header p {
        margin-bottom: 2rem;
    }

    .login-header header {
        margin-bottom: 1rem;
    }

    .input-box .input-field {
        margin-bottom: 1rem;
    }

    .input-submit {
        margin-top: 1rem;
    }

    .error-message {
        color: red;
        /* กำหนดสีข้อความเป็นสีแดง */
    }
  
    .back-to-login {
    
    text-align: center; /* จัดตำแหน่งกลาง */
}

.back-btn {
    display: inline-block; /* ทำให้สามารถใช้ padding */
    
   
    color: black; /* สีข้อความ */
    text-decoration: none; /* ไม่ให้มีเส้นใต้ */
    border-radius: 5px; /* มุมมน */
}





</style>

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
        <form action="forgot_password.php" method="POST">
            <div class="login-header">
                <header>Forgot Password</header>
                <p>กรุณากรอกอีเมลของคุณ</p>
            </div>
            <div class="input-box">
                <input type="email" class="input-field" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-submit">
                <button class="submit-btn" id="submit"></button>
                <label for="submit">Forgot Password</label>
            </div>
            <div class="back-to-login">
                <a href="login.php" class="back-btn">Back to Login</a>
            </div>
        </form>

    </div>

    <script>
        // แสดง SweetAlert2 เมื่อมีข้อความ
        <?php if (!empty($message)) : ?>
            Swal.fire({
                title: 'แจ้งเตือน',
                text: "<?php echo $message; ?>",
                icon: 'info',
                confirmButtonText: 'ตกลง'
            });
        <?php endif; ?>
    </script>
</body>

</html>