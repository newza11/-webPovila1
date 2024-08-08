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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $people = $_POST['people'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $status = $_POST['status'];

    $sql = "INSERT INTO orders_db (name, price, people, checkin, checkout, status)
    VALUES ('$name', '$price', '$people', '$checkin', '$checkout', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Order added successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }

    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
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
        .form-container form input {
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
            <h1>Add Order</h1>
            <form id="addOrder" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required>
                <label for="people">People:</label>
                <input type="number" id="people" name="people" required>
                <label for="checkin">Check In:</label>
                <input type="date" id="checkin" name="checkin" required>
                <label for="checkout">Check Out:</label>
                <input type="date" id="checkout" name="checkout" required>
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Completed">Completed</option>
                    <option value="Cancel">Cancel</option>
                    <option value="Waiting to enter">Waiting to enter</option>
                </select>
                <button type="submit">Add Order</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('addOrder').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('add_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                window.location.href = 'order.php'; // Redirect to order list page
            })
            .catch(error => console.error('Error adding order:', error));
        });
    </script>
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
