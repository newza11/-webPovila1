<?php
include 'db_connection.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    
    

    // Fetch the current user information
    $sql = "SELECT * FROM login_user WHERE id='$id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

  
   
    $sql = "UPDATE login_user SET name='$username' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to user.php after successful update
        header("Location: setting.php");
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
    <title>Settings</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/setting.css">
</head>

<body>
<!-- =============== Navigation ================ -->
<div class="container">
    <?php include 'menu.php'; ?>

    <!-- ======================= Settings Section ================== -->
    <div class="settings-section">
        <h1>Settings</h1>
        <form class="settings-form" id="settingsForm" action="settings.php" method="POST">
            <div class="profile-pic">
                <label for="profilePicInput">
                    <img id="profileImage" src="path/to/default/profile.jpg" alt="Profile Picture">
                </label>
                <input type="file" id="profilePicInput" accept="image/*" onchange="previewProfileImage(event)">
            </div>
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username"  required>

            

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

<!-- =========== Scripts =========  -->
<script src="main.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Load stored data on page load
        const storedProfilePic = localStorage.getItem('profilePic');
        const storedUsername = localStorage.getItem('username');
        

        if (storedProfilePic) {
            document.getElementById('profileImage').src = storedProfilePic;
            document.getElementById('userProfilePic').src = storedProfilePic; // Update profile pic in user settings dropdown
        }
        if (storedUsername) {
            document.getElementById('username').value = storedUsername;
        }
       
    });

    let newProfilePic = null;

    function previewProfileImage(event) {
        const image = document.getElementById('profileImage');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            image.src = reader.result;
            newProfilePic = reader.result; // Store the new image data
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('settingsForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const username = document.getElementById('username').value;
        

        if (newProfilePic) {
            localStorage.setItem('profilePic', newProfilePic);
            document.getElementById('userProfilePic').src = newProfilePic;
        }

        localStorage.setItem('username', username);
        

        alert('Settings saved!');
    });
</script>

<!-- ====== ionicons ======= -->
<?php include '../mains.php'; ?>
</body>

</html>
