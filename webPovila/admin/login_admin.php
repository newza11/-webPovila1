<?php
session_start();

// Database connection
$servername = "localhost";
$username = "u642212680_poolvilla";
$password = "0613989655Za";
$dbname = "u642212680_poolvilla";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is already logged in via cookies
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];

    // Verify the user
    $sql = "SELECT * FROM login_user WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Check if the user is Admin
            if ($user['role'] !== 'Admin') {
                $message = 'สิทธิ์ไม่เพียงพอ';
            } else {
                
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                
                header("Location: admin.php");
                exit();
            }
        }
    }
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']);

    $sql = "SELECT * FROM login_user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $message = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
    } else {
        $user = $result->fetch_assoc();
        if (!password_verify($password, $user['password'])) {
            $message = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
        } else {
            // Check if the user is Admin
            if ($user['role'] !== 'Admin') {
                $message = 'สิทธิ์ไม่เพียงพอ';
            } else {
                
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                
                if ($remember) {
                    setcookie('email', $email, time() + (86400 * 30), "/"); // 30 days
                    setcookie('password', $password, time() + (86400 * 30), "/"); // 30 days
                }

                // Redirect to Admin page
                header("Location: admin.php");
                exit();
            }
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
    <link rel="stylesheet" href="..\css\login.css">
    <title>Admin Login | Ludiflex</title>
</head>

<body>

    <div class="login">
        <form action="login_admin.php" method="POST">

            <div class="login-header">
                <header>Admin Login</header>
                <?php if ($message): ?>
                    <p style="color: red;"><?php echo $message; ?></p>
                <?php endif; ?>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" placeholder="Email" id="email" name="email" required>
            </div>

            <div class="input-box">
                <input type="password" class="input-field" placeholder="Password" id="password" name="password" required>
            </div>

            <div class="forgot">
                <section>
                    <input type="checkbox" id="check" name="remember">
                    <label for="check">Remember me</label>
                </section>
            </div>

            <div class="input-submit">
                <button class="submit-btn" id="submit"></button>
                <label for="submit">Sign In</label>
            </div>

        </form>
    </div>

</body>

</html>
