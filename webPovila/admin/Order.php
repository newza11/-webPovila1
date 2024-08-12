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
                    <a href="Room_Price_List.php"><button>Edit Price</button></a>
                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Price</td>
                                <td>People</td>
                                <td>Check In</td>
                                <td>Check Out</td>
                                <td>Status</td>
                                <td>Slip</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody id="orderTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for displaying slip -->
    <div id="slipModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="slipImage">
    </div>

    <script>
        fetch('fetch_orders.php')
            .then(response => response.json())
            .then(data => {
                console.log('Orders fetched:', data); // ตรวจสอบข้อมูลที่ถูกส่งมา
                const tableBody = document.getElementById('orderTableBody');
                tableBody.innerHTML = '';

                data.forEach(order => {
                    console.log(order); // ตรวจสอบแต่ละออเดอร์
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${order.name}</td>
                <td>${order.price}</td>
                <td>${order.people}</td>
                <td>${order.checkin}</td>
                <td>${order.checkout}</td>
                <td><span class="status ${getStatusClass(order.status)}">${order.status}</span></td>
                <td><button onclick="viewSlip('${order.slip}')">View Slip</button></td>
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
                case 'check':
                    return 'check';
                case 'Completed':
                    return 'delivered';
                case 'Cancel':
                    return 'return';
                case 'Waiting to enter':
                    return 'pending';
                default:
                    return '';
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

        function viewSlip(slip) {
            console.log('Slip URL:', slip); // ตรวจสอบว่า slipUrl มีค่าอะไร
            const baseURL = window.location.origin; // ดึง base URL ของเว็บไซต์
            const fullSlip = `${baseURL}/webPovila/webPovila/${slip}`; // สร้าง full URL โดยใช้ baseURL และ slipUrl

            const modal = document.getElementById("slipModal");
            const modalImg = document.getElementById("slipImage");
            modal.style.display = "block";
            modalImg.src = fullSlip; // ใช้ full URL ในการแสดงรูปภาพ

            const span = document.getElementsByClassName("close")[0];
            span.onclick = function() {
                modal.style.display = "none";
            }
        }
    </script>

    <style>
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <?php include '../mains.php'; ?>
</body>

</html>