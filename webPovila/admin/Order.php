<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                    <!-- เพิ่มการเลือกสถานะคำสั่งซื้อ -->
                    <label for="statusFilter">Filter by Status:</label>
                    <select id="statusFilter" onchange="filterOrders()">
                        <option value="all">All</option>
                        <option value="check">Check</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancel">Cancel</option>
                        <option value="Waiting to enter">Waiting to enter</option>
                    </select>

                    
                    

                    <!-- ตารางแสดงคำสั่งซื้อ -->
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

                    <!-- Pagination Controls -->
                    <div class="pagination">
                        <button class="prev-page" disabled>ก่อนหน้า</button>
                        <span class="page-info">หน้าที่ 1 จาก 1</span>
                        <button class="next-page">ถัดไป</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for displaying slip -->
    <div id="slipModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="slipImage">
    </div>

    <!-- สคริปต์สำหรับโหลดและแสดงรายการ -->
    <script>
        let allOrders = []; // ตัวแปรเก็บคำสั่งซื้อทั้งหมด
        const itemsPerPage = 10; // จำนวนรายการที่จะแสดงต่อหน้า
        let currentPage = 1;
        let totalPages = 1;

        document.addEventListener('DOMContentLoaded', function() {
            loadOrders(currentPage);

            document.querySelector('.prev-page').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    loadOrders(currentPage);
                }
            });

            document.querySelector('.next-page').addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    loadOrders(currentPage);
                }
            });
        });

        function loadOrders(page) {
            fetch('fetch_orders.php')
                .then(response => response.json())
                .then(data => {
                    allOrders = data; // เก็บข้อมูลทั้งหมดในตัวแปร allOrders
                    totalPages = Math.ceil(data.length / itemsPerPage);
                    displayOrders(filterData(data), page);
                    updatePagination();
                })
                .catch(error => console.error('Error fetching orders:', error));
        }

        function displayOrders(orders, page) {
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';

            const paginatedOrders = orders.slice((page - 1) * itemsPerPage, page * itemsPerPage);
            paginatedOrders.forEach(order => {
                const row = document.createElement('tr');
                const slipPath = `../${order.slip}`;
                
                row.innerHTML = `
                    <td>${order.name}</td>
                    <td>${order.price}</td>
                    <td>${order.people}</td>
                    <td>${order.checkin}</td>
                    <td>${order.checkout}</td>
                    <td><span class="status ${getStatusClass(order.status)}">${order.status}</span></td>
                    <td>
                        <img src="${slipPath}" alt="Slip" style="width: 50px; height: 50px; cursor: pointer;" onclick="viewSlip('${slipPath}')">
                    </td>
                    <td>
                        <a href="edit_order.php?id=${order.id}"><button>Edit</button></a>
                        <button onclick="deleteOrder(${order.id})">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function filterData(data) {
            const statusFilter = document.getElementById('statusFilter').value;
            
            if (statusFilter === 'all') {
                return data;
            }

            return data.filter(order => order.status === statusFilter);
        }

        function filterOrders() {
            const filteredOrders = filterData(allOrders);
            displayOrders(filteredOrders, currentPage);
            totalPages = Math.ceil(filteredOrders.length / itemsPerPage);
            updatePagination();
        }

        function updatePagination() {
            document.querySelector('.page-info').textContent = `หน้าที่ ${currentPage} จาก ${totalPages}`;
            document.querySelector('.prev-page').disabled = currentPage === 1;
            document.querySelector('.next-page').disabled = currentPage === totalPages;
        }

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
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`delete_order.php?id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message,
                    }).then(() => {
                        loadOrders(currentPage); // Reload orders for the current page
                    });
                })
                .catch(error => {
                    console.error('Error deleting order:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an issue deleting the order. Please try again.',
                    });
                });
        }
    });
}


        function viewSlip(slip) {
            const modal = document.getElementById("slipModal");
            const modalImg = document.getElementById("slipImage");

            // ตรวจสอบว่าเส้นทางของสลิปถูกต้องหรือไม่
            if (slip) {
                modal.style.display = "block";
                modalImg.src = slip;
                modalImg.style.maxWidth = "90%"; // ทำให้รูปภาพมีขนาดไม่เกิน 90% ของความกว้างหน้าจอ
                modalImg.style.maxHeight = "80%"; // ทำให้รูปภาพมีขนาดไม่เกิน 80% ของความสูงหน้าจอ
            } else {
                alert('No slip available for this order.');
            }

            const span = document.getElementsByClassName("close")[0];
            span.onclick = function() {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>


    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 50px;
            /* ลดการเว้นระยะห่างจากขอบบน */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            /* สีพื้นหลังเข้มขึ้น */
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            /* ลดขนาดลงให้ไม่เกิน 90% ของความกว้างหน้าจอ */
            max-height: 80%;
            /* ลดขนาดลงให้ไม่เกิน 80% ของความสูงหน้าจอ */
            border-radius: 10px;
            /* ทำให้ขอบของรูปภาพมีความโค้งมน */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* เพิ่มเงาให้รูปภาพ */
        }

        .close {
            position: absolute;
            top: 10px;
            /* ปรับให้อยู่ในระยะที่เหมาะสม */
            right: 20px;
            /* ลดระยะขอบ */
            color: #fff;
            font-size: 35px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .pagination button {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination button:hover {
            background: #0056b3;
        }

        .pagination button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .pagination .page-info {
            font-size: 16px;
            margin: 0 10px;
        }
    </style>
    <?php include '../mains.php'; ?>
</body>

</html>