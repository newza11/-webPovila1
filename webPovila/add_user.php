<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/user.css">
</head>
<body>
<div class="container">
        
        <div class="details1">
            <div class="recentOrders">
                <div class="cardHeader ">
    <h1>Add User</h1>
    <form action="add_user.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="email">email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required><br>
        <input type="submit" value="Add User">
    </form>
    </div>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include 'db_connection.php';

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $sql = "INSERT INTO login_user (name, email, password, role) VALUES ('$username', '$email','$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            
            header("Location: user.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
