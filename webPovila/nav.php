<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar with Hamburger Menu</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap");
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap');

        nav {
            margin: 0;
            display: flex;
            align-items: center;
            background-color: #fcf0e4;
            border-bottom-style: solid;
            border-color: #e4b58a;
            width: 100%;
            justify-content: space-between;
            position: relative;
        }

        .nav__logo img {
            width: 130px;
            height: 80px;
        }
        .nav__logo  {
            width: 130px;
            height: 80px;
        }

        .nav__links {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0;
            padding-left: 0;
            flex-grow: 1;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .hamburger span {
            height: 3px;
            width: 25px;
            background: #000;
            margin-bottom: 4px;
            border-radius: 5px;
        }

        .center-links {
            display: flex;
            justify-content: center;
            text-align: center;
            align-items: center;
            gap: 2rem;
        }

        .center-links a {
            font-size: 1.1em;
            color: #000;
            text-decoration: none;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
        }

        .login-btn, .user-link {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-left: auto;
        }

        .user img {
            border-radius: 50%;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .show {
            display: block;
        }

        @media (max-width: 468px) {
            nav {
                padding: 1rem;
                justify-content: space-between;
                position: relative;
            }
            .link1 a{
                border: none;
            }
            .nav__logo  {
            width: 130px;
            height: 55px;
        }

            .nav__logo img {
                width: 100px;
                height: 55px;
            }

            .hamburger {
                display: flex;
                margin-left: 10rem;

            }

            .nav__links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: #fcf0e4;
                padding: 1rem;
                border-top: 1px solid #e4b58a;
                z-index: 100;
            }

            .center-links {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }
            .aboutddd{
                display: none;

            }

            .nav__links.active {
                display: flex;
            }

            .user-link img {
                cursor: pointer;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                right: 0;
                top: 100%;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }

            .show {
                display: block;
            }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav__logo">
        <img src="poo/image2.png" alt="Logo" width="22" height="80">
    </div>
    <ul class="nav__links" id="navLinks">
        <li class="center-links">
            <a href="index.php">HOME</a>
            <a href="index.php#book">BOOKING</a>
            <a  href="index.php#detail">DETAIL</a>
            <a  class="aboutddd" href="index.php#about">ABOUT</a>
            <a href="contact.php">CONTACT</a>
        </li>
    </ul>
    <div class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="link1">
            <a href="login.php">Login</a>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-link">
            <div class="user">
                <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" width="50" height="50" onclick="toggleDropdown()">
                <div id="dropdownContent" class="dropdown-content">
                    <a href="settings.php">Settings</a>
                    <a href="booking_history.php">Booking</a>
                    <a href="#" onclick="confirmLogout()">Logout</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</nav>

<script>
    function toggleMenu() {
        const navLinks = document.getElementById("navLinks");
        navLinks.classList.toggle("active");
    }

    function toggleDropdown() {
        const dropdownContent = document.getElementById("dropdownContent");
        dropdownContent.classList.toggle("show");
    }

    // ปิดเมนูแฮมเบอร์เกอร์เมื่อผู้ใช้คลิกที่ลิงก์
    const navLinks = document.querySelectorAll('.center-links a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            const navLinksContainer = document.getElementById("navLinks");
            navLinksContainer.classList.remove("active"); // ปิดเมนูเมื่อคลิกลิงก์
        });
    });
</script>
<script>
function confirmLogout() {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "ยืนยันออกจากระบบ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ออกจากระบบ!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php'; // Redirect to the logout page if confirmed
        }
    });
}
</script>



</body>
</html>
