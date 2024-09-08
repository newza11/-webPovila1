<div class="navigation">
    <ul>
        <li class="active">
            <a href="index.php">
                <span class="icon">
                    <ion-icon name="storefront-outline"></ion-icon>
                </span>
                <span class="title">Povila</span>
            </a>
        </li>

        <li>
            <a href="admin.php">
                <span class="icon">
                    <ion-icon name="bar-chart-outline"></ion-icon>
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
            <a href="villa_setting.php">
                <span class="icon">
                    <ion-icon name="home-outline"></ion-icon>
                </span>
                <span class="title">Villa Management</span>
            </a>

        </li>

        <li>
            <a href="room_price_list.php">
                <span class="icon">
                    <ion-icon name="cash-outline"></ion-icon>
                </span>
                <span class="title">Room_price</span>
            </a>
        </li>

        <li>
            <a href="user.php">
                <span class="icon">
                    <ion-icon name="person-circle-outline"></ion-icon>
                </span>
                <span class="title">User</span>
            </a>
        </li>
        <li>
            <a href="contact_user.php">
                <span class="icon">
                    <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                </span>
                <span class="title">Contact</span>
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

<style>
    .navigation ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .navigation li {
        margin: 0;
    }

    .navigation a {
        display: flex;
        align-items: center;
        padding: 10px;
        text-decoration: none;
        color: #333;
    }



    .navigation .icon {
        margin-right: 10px;
    }

    #searchResults {
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        max-height: 200px;
        overflow-y: auto;
        background: #f9f9f9;
        border-radius: 4px;
    }

    #searchResults div {
        padding: 5px;
        border-bottom: 1px solid #ddd;
    }
</style>

<!-- ========================= Main ==================== -->
<div class="main">
    <div class="topbar">
        <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
        </div>

        <!-- <div class="search">
            <label>
                <input type="text" id="searchInput" placeholder="Search here">
                <ion-icon name="search-outline"></ion-icon>
            </label>
            <div id="searchResults"></div>
        </div> -->

        <div class="user-settings">
            <div class="user" onclick="toggleDropdown()">
                <img id="userProfilePic" src="path/to/default/profile.jpg" alt="">
            </div>
            <div class="dropdown" id="userDropdown">
                <a href="setting.php">Settings</a>
                <a href="../index.php">back to Home</a>
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

        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value;

            if (query.length > 2) { // Only start searching when the query length is more than 2 characters
                fetch('search_users.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'query=' + encodeURIComponent(query)
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle the data returned from the server
                        displaySearchResults(data);
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('searchResults').innerHTML = ''; // Clear results if query is too short
            }
        });

        function displaySearchResults(results) {
            const resultsContainer = document.getElementById('searchResults');
            resultsContainer.innerHTML = '';

            if (results.length > 0) {
                results.forEach(result => {
                    let resultElement = document.createElement('div');
                    resultElement.textContent = `User: ${result.name}, Order ID: ${result.id}`;
                    resultsContainer.appendChild(resultElement);
                });
            } else {
                resultsContainer.textContent = 'No results found.';
            }
        }
    </script>

