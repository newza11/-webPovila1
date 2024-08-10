<div class="user-settings">
    <div class="user" onclick="toggleDropdown()">
        <img id="userProfilePic" src="<?php echo isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'path/to/default/profile.jpg'; ?>" alt="ProfilePicture">
    </div>
    <div id="dropdownContent" class="dropdown-content">
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Load stored data on page load
        const storedProfilePic = localStorage.getItem('profilePic');
        if (storedProfilePic) {
            document.getElementById('profileImage').src = storedProfilePic;
            document.getElementById('userProfilePic').src = storedProfilePic; // Update profile pic in user settings dropdown
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
        // Store the new profile picture in localStorage
        if (newProfilePic) {
            localStorage.setItem('profilePic', newProfilePic);
            document.getElementById('userProfilePic').src = newProfilePic;
        }
    });

    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownContent');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Close dropdown if clicked outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdownContent');
        const user = document.querySelector('.user-settings .user');
        if (!user.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>

<style>
.user-settings {
    position: relative;
    display: flex;
    align-items: center;
}

.user-settings .user {
    margin-left: 10px;
    cursor: pointer;
}

.user-settings .user img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

.user-settings .dropdown-content {
    display: none;
    position: absolute;
    top: 60px; /* Adjusted for the size of the profile image */
    right: 0;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    overflow: hidden;
    z-index: 10;
}

.user-settings .dropdown-content a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s;
}

.user-settings .dropdown-content a:hover {
    background-color: #f0f0f0;
}
</style>
