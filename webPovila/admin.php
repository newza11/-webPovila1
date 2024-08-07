<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <?php include 'menu.php'; ?>

        
            
            

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"  id="totalOrders">0</div>
                        <div class="cardName">Order</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers" id="totalRevenue">0B</div>
                        <div class="cardName">รายรับ</div>
                    </div>

                    <div class="iconBx1">
                        <ion-icon name="arrow-up-circle-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers" id="totalExpenses">0B</div>
                        <div class="cardName">รายจ่าย</div>
                    </div>

                    <div class="iconBx2">
                        <ion-icon name="arrow-down-circle-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers" id="totalIncome">0B</div>
                        <div class="cardName">ยอดรวม</div>
                    </div>

                    <div class="iconBx3">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>


            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                        <a href="Order.php" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Price</td>
                                <td>people</td>
                                <td>check in</td>
                                <td>check out</td>
                               
                                <td>Status</td>
                            </tr>
                        </thead>

                        <tbody id="orderTableBody">
                            
                        </tbody>
                    </table>
                </div>
                <script>
                    fetch('fetch_data.php')
        .then(response => response.json())
        .then(data => {
            console.log('Fetched data:', data); // Log the fetched data

            // Update cards with fetched data
            document.getElementById('totalOrders').textContent = data.totalOrders;
            document.getElementById('totalRevenue').textContent = data.totalRevenue + 'B';
            document.getElementById('totalExpenses').textContent = data.totalExpenses + 'B';
            document.getElementById('totalIncome').textContent = data.totalIncome + 'B';

            // Update recent orders table
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';

            data.recentOrders.forEach(order => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${order.name}</td>
                    <td>${order.price}</td>
                    <td>${order.people}</td>
                    <td>${order.checkin}</td>
                    <td>${order.checkout}</td>
                    
                    <td><span class="status ${getStatusClass(order.status)}">${order.status}</span></td>
                `;

                console.log('Order:', order); // Log each order
                console.log('Status class:', getStatusClass(order.status)); // Log the status class

                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error:', error));

    function getStatusClass(status) {
        switch (status) {
            case 'Completed': return 'delivered';
            case 'cancel': return 'return';
            case 'Waiting to enter': return 'pending';
            
            default: return '';
        }
    }


                    // Add new order to the server
                    document.getElementById('orderForm').addEventListener('submit', function(event) {
                        event.preventDefault();

                        const formData = new FormData(this);
                        const data = {};
                        formData.forEach((value, key) => {
                            data[key] = value;
                        });

                        fetch('add_order.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(order => {
                            const tableBody = document.getElementById('orderTableBody');
                            const rowCount = tableBody.rows.length;

                            if (rowCount < 7) {
                                const row = document.createElement('tr');

                                row.innerHTML = `
                                    <td>${order.name}</td>
                                    <td>${order.price}</td>
                                    <td>${order.people}</td>
                                    <td>${order.checkin}</td>
                                    <td>${order.checkout}</td>
                                    <td>${order.payment}</td>
                                    <td><span class="status ${getStatusClass(order.status)}">${order.status}</span></td>
                                `;

                                tableBody.appendChild(row);
                            }

                            // Update total order count and revenue
                            document.getElementById('totalOrders').textContent = parseInt(document.getElementById('totalOrders').textContent) + 1;
                            document.getElementById('totalRevenue').textContent = (parseFloat(document.getElementById('totalRevenue').textContent) + parseFloat(order.price)) + 'B';
                            document.getElementById('totalIncome').textContent = (parseFloat(document.getElementById('totalRevenue').textContent) - parseFloat(document.getElementById('totalExpenses').textContent)) + 'B';
                        })
                        .catch(error => console.error('Error:', error));
                    });
                </script>


                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent Customers</h2>
                    </div>

                    <table>
                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="poo/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>new<br> <span>thai</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="poo/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>noey<br> <span>thai</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="poo/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>new<br> <span>thai</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="poo/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>noey<br> <span>thai</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="poo/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>new<br> <span>thai</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="poo/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>noey<br> <span>thai</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="poo/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>noey<br> <span>thai</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="jpoo/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>new<br> <span>thai</span></h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
