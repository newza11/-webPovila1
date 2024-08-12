<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$profile_picture = 'default_profile.png'; // Default profile picture

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve the user's profile picture
    $query = "SELECT profile_picture FROM login_user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $profile_picture = $user['profile_picture'] ?: 'default_profile.png';

    // Retrieve booking history for the logged-in user
    $query = "SELECT id, checkin, checkout, room, price, name, status FROM orders_db WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/book_his.css">
</head>
<body>
<nav>
    <div class="nav__logo">
        <img src="https://scontent.fkdt1-1.fna.fbcdn.net/v/t1.15752-9/451463161_439508502254984_1564988875763696941_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeFLxpw7P5hzAbD0zGFx4wcQ_iqw6XCTKgf-KrDpcJMqB2ssTrxaM93qmoZDROCA15lSca9F0AG3_Aum4HlxxYYy&_nc_ohc=BErgEdBJnUwQ7kNvgGYDR0P&_nc_ht=scontent.fkdt1-1.fna&oh=03_Q7cD1QG_QMJ_iS3LVLg9FVnCJhM17wgMqHFgMIkqJvWW2npLGA&oe=66BF59DB" alt="Logo" width="22" height="80" style="display: flex; width: 100%;">
    </div>
    <ul class="nav__links">
        <li class="link">
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user">
                    <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" width="50" height="50"  onclick="toggleDropdown()">
                    <div id="dropdownContent" class="dropdown-content">
                        <a href="settings.php">Settings</a>
                        <a href="booking_history.php">Booking</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            <?php endif; ?>
        </li>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <li class="link"><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
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
<div class="container">
    <h2 class="mt-4">Booking History</h2>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Room</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name'];  ?></td>
                        <td><?php echo $row['checkin']; ?></td>
                        <td><?php echo $row['checkout']; ?></td>
                        <td><?php echo $row['room']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <?php if ($row['status'] === 'check'): ?>
                                <button type="button" class="btn btn-secondary" disabled>รอตรวจสอบ</button>
                            <?php else: ?>
                                <form action="generate_receipt.php" method="post" target="_blank">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Generate Receipt</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
