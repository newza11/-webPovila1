

<div class="navigation">
            <ul>
                <li>
                    <a href="admin.php">
                        <span class="icon">
                            <ion-icon name=""></ion-icon>
                        </span>
                        <span class="title">Povila</span>
                    </a>
                </li>

                <li>
                    <a href="admin.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="Order.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Order</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">Messages</span>
                    </a>
                </li>

                <li>
                    <a href="user.php">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">user</span>
                    </a>
                </li>

                <li>
                    <a href="setting.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>

                

                <li>
                    <a href="confirm_signout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user-settings">
    <div class="user" onclick="toggleDropdown()">
        <img id="userProfilePic" src="path/to/default/profile.jpg" alt="">
    </div>
    <div class="dropdown" id="userDropdown">
        <a href="setting.php">Settings</a>
        <a href="confirm_signout.php">SignOut</a>
    </div>
</div>
 </div>
 <script>
    document.addEventListener('DOMContentLoaded', () => {
        const storedProfilePic = localStorage.getItem('profilePic');

        if (storedProfilePic) {
            document.getElementById('userProfilePic').src = storedProfilePic;
        }
    });

    function toggleDropdown() {
        document.getElementById('userDropdown').classList.toggle('show');
    }
</script>
        
