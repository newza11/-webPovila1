<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/user.css">
</head>
<body>
<div class="container">
        
        <div class="details1">
            <div class="recentOrders">
                <div class="cardHeader ">
    <h1>Update User</h1>

    <?php
    include 'db_connection.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM login_user WHERE id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form action="update_user.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $row['name']; ?>" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $row['password']; ?>" required><br>
                <label for="role">Role:</label>
                <input type="text" id="role" name="role" value="<?php echo $row['role']; ?>" required><br>
                <input type="submit" value="Update User">
            </form>
            </div>
            </div>
        </div>
    </div>

            <?php
        } else {
            echo "User not found";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE login_user SET name='$username', password='$hashed_password', role='$role' WHERE id='$id'";
        

        if ($conn->query($sql) === TRUE) {
            // Redirect to user.php after successful update
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