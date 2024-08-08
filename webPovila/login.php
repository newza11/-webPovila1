<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/admin.php");
    } else {
        header("Location: index.php");
    }
}


$servername = "localhost"; // Change if your MySQL server is on a different host
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "my_website"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM login_user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $message = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
    } else {
        $user = $result->fetch_assoc();
        if (!password_verify($password, $user['password'])) {
            $message = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
        } else {
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            if ($user['role'] === 'admin') {
                header("Location: admin/admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
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
    <link rel="stylesheet" href="css\login.css">
    <title>Login | Ludiflex</title>
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
    <div class="login" >
        
    <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">

        <div class="login-header">
            <header>Login</header>
        </div>
        <div class="input-box">
            <input type="text" class="input-field" placeholder="Email" id="email" name="email" required>
        </div>
        <div class="input-box">
            <input type="password" class="input-field" placeholder="Password" id="password" name="password"  required>
        </div>
        <div class="forgot">
            <section>
                <input type="checkbox" id="check">
                <label for="check">Remember me</label>
            </section>
            <!-- <section>
                <a href="forget.html">Forgot password</a>
            </section> -->
        </div>
        <div class="input-submit">
            <button class="submit-btn" id="submit"></button>
            <label for="submit">Sign In</label>
        </div>
        <div class="sign-up-link">
            <p>Don't have account? <a href="register.php">Sign Up</a></p>
        </div>
      </form>
    </div>
</body>
</html>