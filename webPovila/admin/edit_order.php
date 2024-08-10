<?php
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

$order_id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $people = $_POST['people'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders_db SET name=?, price=?, people=?, checkin=?, checkout=?, status=? WHERE id=?");
    $stmt->bind_param("sissssi", $name, $price, $people, $checkin, $checkout, $status, $order_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Order updated successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}

if ($order_id) {
    $stmt = $conn->prepare("SELECT * FROM orders_db WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "Order not found";
        exit();
    }

    $stmt->close();
} else {
    echo "No order ID provided";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
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
        .form-container form input,
        .form-container form select {
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
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="form-container">
            <h1>Edit Order</h1>
            <form id="editOrder" method="POST">
                <input type="hidden" id="editOrderId" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                <label for="editName">Name:</label>
                <input type="text" id="editName" name="name" value="<?php echo htmlspecialchars($order['name']); ?>" required>
                <label for="editPrice">Price:</label>
                <input type="number" id="editPrice" name="price" value="<?php echo htmlspecialchars($order['price']); ?>" required>
                <label for="editPeople">People:</label>
                <input type="number" id="editPeople" name="people" value="<?php echo htmlspecialchars($order['people']); ?>" required>
                <label for="editCheckin">Check In:</label>
                <input type="date" id="editCheckin" name="checkin" value="<?php echo htmlspecialchars($order['checkin']); ?>" required>
                <label for="editCheckout">Check Out:</label>
                <input type="date" id="editCheckout" name="checkout" value="<?php echo htmlspecialchars($order['checkout']); ?>" required>
                <label for="editStatus">Status:</label>
                <select id="editStatus" name="status" required>
                    <option value="Completed" <?php if ($order['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                    <option value="Cancel" <?php if ($order['status'] == 'Cancel') echo 'selected'; ?>>Cancel</option>
                    <option value="Waiting to enter" <?php if ($order['status'] == 'Waiting to enter') echo 'selected'; ?>>Waiting to enter</option>
                </select>
                <button type="submit">Update Order</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('editOrder').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('edit_order.php?id=<?php echo htmlspecialchars($order_id); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                window.location.href = 'order.php'; // Redirect to order list page
            })
            .catch(error => console.error('Error updating order:', error));
        });
    </script>
    <?php include '../mains.php'; ?>
</body>
</html>
