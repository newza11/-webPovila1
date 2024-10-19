<?php
session_start();

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

$profile_picture = 'default_profile.png'; // Default profile picture

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT profile_picture FROM login_user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $profile_picture = $user['profile_picture'] ?: 'default_profile.png';
}

// Check if form is submitted
$alertMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO contact (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);
    if ($stmt->execute()) {
        $alertMessage = "success";
    } else {
        $alertMessage = "error";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>

    <?php include 'nav.php'; ?>

    <section class="contact">
        <div class="contact-container">
            <!-- Contact Information Section -->
            <div class="contact-left">
                <h3>Contact US</h3>
                <h2>CONTACT WITH US</h2>
                <p>Rapidiously mycoordinate cross-platform intellectual capital after the model. Appropriately create interactive infrastructures
                    after maintaince. Holisticly facilitate stand-alone.</p>

                <div class="contact-info1">
                    <div class="info-item">
                        <i class="fas fa-phone-alt"></i>
                        <div>
                            <span>Call Us Now</span>
                            <p> 098 646 1451</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <span>Send Email</span>
                            <p>nannaphas12345678@gmail.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <span>Our Locations</span>
                            <p>โครงการพูลวิลล่า ต.คลองเขิน อ.อัมพวา จ.สมุทรสงคราม 75110</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Contact Form Section -->
            <div class="contact-right">
                <h2>GET IN TOUCH</h2>
                <form action="contact.php" method="POST">
                    <input type="text" name="name" placeholder="Your Name" autocomplete="off"  required oninput="validateText(this)" pattern="[A-Za-zก-๙]+" inputmode="text">
                    <input type="email" name="email" placeholder="Enter Your Email" autocomplete="off" inputmode="text"  >
                    <input type="text" name="phone" placeholder="My Phone" autocomplete="off"  oninput="validateGuests(this)" min="0" step="10" required>

                    <textarea name="message" placeholder="Write Message"  required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>

        </div>
    </section>



    <!-- แสดงผล SweetAlert เมื่อการดำเนินการสำเร็จหรือเกิดข้อผิดพลาด -->
    <script>
        <?php if ($alertMessage == "success") : ?>
            Swal.fire({
                title: 'Success!',
                text: 'Your message has been sent.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        <?php elseif ($alertMessage == "error") : ?>
            Swal.fire({
                title: 'Error!',
                text: 'Failed to send the message. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdownContent");
            dropdown.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.user img')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>

    <script>
        function validateText(input) {

            input.value = input.value.replace(/[0-9]/g, '');
        }

        function validateGuests(input) {
            // ลบตัวเลขทศนิยมออกหากมีการพิมพ์ทศนิยม
            input.value = input.value.replace(/[^0-9]/g, '');
            const min = parseInt(input.min);

            const value = parseInt(input.value);

            if (value < min) {
                input.value = min;
            }

        }
    </script>

</body>

</html>