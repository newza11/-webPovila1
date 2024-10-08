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
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/book_his.css">
</head>
<body>
<?php include 'nav.php'; ?>

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
        <button type="button" class="btn btn-secondary" disabled>กำลังตรวจสอบ</button>
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

?>
