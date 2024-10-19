<?php

session_start();

include 'db_connection.php';

$id = null;

// Fetch user details by ID if it's provided via GET request
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $sql = "SELECT * FROM login_user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found";
        exit();
    }
} else {
    echo "No user ID provided.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Fetch current user information
    $sql = "SELECT password FROM login_user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_password = $result->fetch_assoc()['password'];

    // Check if password is empty; if yes, keep the current password
    if (empty($password)) {
        $hashed_password = $current_password;
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Update user details
    $sql = "UPDATE login_user SET name = ?, password = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $hashed_password, $role, $id);

    if ($stmt->execute()) {
        $update_success = true;
    } else {
        $update_success = false;
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

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

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
            <h1>Edit User</h1>
            <form action="edit_user.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
                
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="User" <?php echo ($user['role'] === 'User') ? 'selected' : ''; ?>>User</option>
                    <option value="Admin" <?php echo ($user['role'] === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
                <button type="submit">Edit User</button>
            </form>
        </div>
    </div>
    <?php include '../mains.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            <?php if (isset($update_success)): ?>
                <?php if ($update_success): ?>
                    Swal.fire({
                        title: 'Success!',
                        text: 'User updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'user.php';
                        }
                    });
                <?php else: ?>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the user.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                <?php endif; ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
