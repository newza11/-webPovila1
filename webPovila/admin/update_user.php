<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM login_user WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "User not found";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Fetch the current user information
    $sql = "SELECT * FROM login_user WHERE id='$id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // If password is empty, use the existing password
    if (empty($password)) {
        $hashed_password = $user['password']; // Use the existing hashed password
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container form label {
            margin-bottom: 5px;
        }
        .form-container form input, .form-container form select {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container form button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .form-container form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="container">
        <div class="form-container">
            <h1>Update User</h1>
            <form action="update_user.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $row['name']; ?>" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="User" <?php if ($row['role'] == 'User') echo 'selected'; ?>>User</option>
                    <option value="Admin" <?php if ($row['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                </select>
                <button type="submit">Update User</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('password').addEventListener('input', function() {
            if (this.value.length > 0) {
                this.setAttribute('type', 'text');
            } else {
                this.setAttribute('type', 'password');
            }
        });
    </script>
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
