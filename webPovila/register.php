<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

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
                    $message = "New record created successfully";
                    header("Location: login.php");
                    exit();
                } else {
                    $message = "Error: " . $stmt->error;
                }
            }
        }

        $stmt->close();
    } else {
        $message = 'Please fill all fields.';
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
<host>
        
        <div class="logo">
            <img src="https://scontent.fkdt1-1.fna.fbcdn.net/v/t1.15752-9/451463161_439508502254984_1564988875763696941_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeFLxpw7P5hzAbD0zGFx4wcQ_iqw6XCTKgf-KrDpcJMqB2ssTrxaM93qmoZDROCA15lSca9F0AG3_Aum4HlxxYYy&_nc_ohc=BErgEdBJnUwQ7kNvgGYDR0P&_nc_ht=scontent.fkdt1-1.fna&oh=03_Q7cD1QG_QMJ_iS3LVLg9FVnCJhM17wgMqHFgMIkqJvWW2npLGA&oe=66BF59DB" alt="Ocean" width="137" height="80">
          </div>
        <nav class="naigation">
            
            <a href="index.php">Home</a>
            
        </nav>
    
    </host>
    <div class="register">
        
        <form action="register.php" method="POST">
            
            <div class="register-header">
                <header>Register</header>
                <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
            </div>
            
            <div class="input-box">
                <input type="text" class="input-field" placeholder="Email" name="email" required>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" placeholder="Name" name="name" required>
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

