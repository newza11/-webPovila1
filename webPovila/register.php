<?php
$servername = "localhost";
$username = "u642212680_poolvilla";
$password = "0613989655Za";
$dbname = "u642212680_poolvilla";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$success = false; // ตัวแปรสำหรับจัดการการแสดง SweetAlert

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    
    if ($email && $name && $password && $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "SELECT * FROM login_user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($password !== $confirm_password) {
            $message = 'รหัสผ่านไม่ตรงกัน';
        } else {
            if ($result->num_rows > 0) {
                $message = 'อีเมลนี้มีการลงทะเบียนแล้ว';
            } else {
                $sql = "INSERT INTO login_user (email, name, password, role) VALUES (?, ?, ?, 'user')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $email, $name, $hashed_password);
                if ($stmt->execute()) {
                    $success = true; // ตั้งค่าสำเร็จเมื่อข้อมูลถูกบันทึกใน DB
                } else {
                    $message = "Error: " . $stmt->error;
                }
            }
        }

        $stmt->close();
    } else {
        $message = 'กรุณากรอกข้อมูลให้ครบถ้วน';
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
    <title>Register | Ludiflex</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    
</head>

<body>
<?php if ($success): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'สมัครสมาชิกสำเร็จ',
        showConfirmButton: false,
        timer: 2000
    }).then(function() {
        window.location = 'login.php';
    });
</script>
<?php endif; ?>
<host>
        
        <div class="logo">
            <img src="poo/image2.png" alt="Ocean" width="137" height="80">
          </div>
        <nav class="naigation">
            
            <a href="index.php">HOME</a>
            
        </nav>
    
    </host>

    <div class="register">
        <form action="" method="POST">
            <div class="register-header">
                <header>Register</header>
                <?php if ($message): ?>
                    <p style="color: red;"><?php echo $message; ?></p>
                <?php endif; ?>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" placeholder="Email" name="email" required>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" placeholder="Name" name="name" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" placeholder="Password" name="password" required>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" placeholder="Confirm Password" name="confirm_password" required>
            </div>
            <div class="input-submit">
                <button type="submit" class="submit1-btn" id="submit">Sign up</button>
            </div>
            <div class="login-up-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
