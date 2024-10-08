<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "u642212680_poolvilla";
$password = "0613989655Za";
$dbname = "u642212680_poolvilla";

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

    // Fetch current profile picture from the database
    $sql = "SELECT profile_picture FROM login_user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $profile_picture_path = $user['profile_picture'] ?? 'uploads/profiletest.jpg';

    // Handle image upload
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);

        if ($check !== false) {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $profile_picture_path = $target_file; // Update the profile picture path
                $message = 'Your profile picture has been updated.';
            } else {
                $message = 'There was an error uploading your profile picture.';
            }
        } else {
            $message = 'The file you selected is not a valid image.';
        }
    }

    if (empty($name)) {
        $message = 'Please enter your name.';
    } else {
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE login_user SET name = ?, password = ?, profile_picture = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $hashed_password, $profile_picture_path, $user_id);
        } else {
            $sql = "UPDATE login_user SET name = ?, profile_picture = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $name, $profile_picture_path, $user_id);
        }

        if ($stmt->execute()) {
            $_SESSION['user_name'] = $name;
            $_SESSION['profile_picture'] = $profile_picture_path; // Update session with new profile picture path
            $message = 'Your information has been updated.';
            header("Location: index.php");
            exit();
        } else {
            $message = 'Something went wrong. Please try again.';
        }
    }
}

// Fetch user data
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
    <title>Settings | MyWebsite</title>
    <link rel="stylesheet" href="css/settings.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="poo/image2.png" alt="Ocean" width="137" height="80">
        </div>
        <nav class="navigation">
            <a href="index.php">HOME</a>
        </nav>
    </header>
    <div class="settings-container">
        <h1>Settings</h1>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form id="settingsForm" action="settings.php" method="POST" enctype="multipart/form-data">
            <div class="profile-pic">
                <img id="profileImage" src="<?php echo $user['profile_picture'] ? $user['profile_picture'] : 'uploads/profiletest.jpg'; ?>" alt="Profile Picture">
                <input type="file" id="profilePicInput" accept="image/*" name="profile_picture" onchange="previewProfileImage(event)">
                <label for="profilePicInput">Change Profile Picture</label>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
            </div>
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="input-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="Leave blank to keep current password">
            </div>
            <button type="submit" class="submit-btn">Update</button>
        </form> 
    </div>

    <script>
        function previewProfileImage(event) {
            const image = document.getElementById('profileImage');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                image.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
        
    </script>
    
</body>

</html>
