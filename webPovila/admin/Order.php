<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <div class="order-section">
            <div class="recentOrders">
            <div class="cardHeader">
                <h1>Order List</h1>
                <a href="add_order.php"><button>Add Order</button></a>
                <table>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Price</td>
                            <td>People</td>
                            <td>Check In</td>
                            <td>Check Out</td>
                            <td>Status</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody"></tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <script>
        fetch('fetch_orders.php')
            .then(response => response.json())
            .then(data => {
                console.log('Orders fetched:', data); // Debugging log
                const tableBody = document.getElementById('orderTableBody');
                tableBody.innerHTML = '';

                data.forEach(order => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${order.name}</td>
                        <td>${order.price}</td>
                        <td>${order.people}</td>
                        <td>${order.checkin}</td>
                        <td>${order.checkout}</td>
                        <td><span class="status ${getStatusClass(order.status)}">${order.status}</span></td>
                        <td>
                            <a href="edit_order.php?id=${order.id}"><button>Edit</button></a>
                            <button onclick="deleteOrder(${order.id})">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching orders:', error));

        function getStatusClass(status) {
            switch (status) {
                case 'Completed': return 'delivered';
                case 'Cancel': return 'return';
                case 'Waiting to enter': return 'pending';
                default: return '';
            }
        }

        function deleteOrder(orderId) {
            if (confirm('Are you sure you want to delete this order?')) {
                fetch(`delete_order.php?id=${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => console.error('Error deleting order:', error));
            }
        }
    </script>
     <?php include '../mains.php'; ?>
</body>
</html>
