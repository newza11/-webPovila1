<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $new_password = trim($_POST['new_password']);
    $user_id = $_SESSION['user_id'];

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE login_user SET name = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $hashed_password, $user_id);
    } else {
        $sql = "UPDATE login_user SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name;
        $message = 'ข้อมูลของคุณถูกอัพเดทแล้ว';
    } else {
        $message = 'มีบางอย่างผิดพลาด โปรดลองอีกครั้ง';
    }
}

$sql = "SELECT * FROM login_user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/settings.css">
    <title>Settings | Ludiflex</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="https://scontent.fkdt1-1.fna.fbcdn.net/v/t1.15752-9/451463161_439508502254984_1564988875763696941_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeFLxpw7P5hzAbD0zGFx4wcQ_iqw6XCTKgf-KrDpcJMqB2ssTrxaM93qmoZDROCA15lSca9F0AG3_Aum4HlxxYYy&_nc_ohc=BErgEdBJnUwQ7kNvgGYDR0P&_nc_ht=scontent.fkdt1-1.fna&oh=03_Q7cD1QG_QMJ_iS3LVLg9FVnCJhM17wgMqHFgMIkqJvWW2npLGA&oe=66BF59DB" alt="Ocean" width="137" height="80">
        </div>
        <nav class="navigation">
            <a href="index.php">Home</a>
            <div class="dropdown">
                <button class="dropbtn"><?php echo $_SESSION['user_name']; ?></button>
                <div class="dropdown-content">
                    <a href="settings.php">Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <h1>Settings</h1>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="settings.php" method="POST">
            <div class="input-box">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
            </div>
            <div class="input-box">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="input-box">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="Leave blank to keep current password">
            </div>
            <div class="input-submit">
                <button type="submit">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
