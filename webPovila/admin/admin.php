<?php
session_start(); 


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {

    header('Location: login.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <?php include 'menu.php'; ?>

        <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <div class="card" onclick="window.location.href='order.php';">
                
                <div>
                    <div class="numbers" id="totalOrders">0</div>
                    <div class="cardName" >Order</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="cart-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers" id="monthlyRevenue">0฿</div>
                    <div class="cardName">รายรับ (เดือนนี้)</div>
                </div>

                <div class="iconBx1">
                    <ion-icon name="arrow-up-circle-outline"></ion-icon>
                </div>
            </div>

            <div class="card" onclick="window.location.href='user.php';">
                <div>
                    <div class="numbers" id="totalUsers">0</div>
                    <div class="cardName">จำนวน User</div>
                </div>

                <div class="iconBx2">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers" id="totalIncome">0฿</div>
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
                            <td>People</td>
                            <td>Check In</td>
                            <td>Check Out</td>
                            <td>Status</td>
                        </tr>
                    </thead>

                    <tbody id="orderTableBody"></tbody>
                </table>
            </div>

            <!-- Chart Section -->
            <div class="recentCustomers">
    <div class="cardHeader">
        <h2>Monthly Revenue</h2>
    </div>
    <canvas id="revenueChart"></canvas> <!-- ไม่ต้องตั้ง width/height ใน canvas -->
    <div class="cardHeader">
        <h2>Yearly Revenue</h2>
    </div>
    <canvas id="yearlyRevenueChart"></canvas>
</div>
        </div>
    </div>

    <script>
        fetch('fetch_data.php')
            .then(response => response.json())
            .then(data => {
                console.log('Fetched data:', data); // Log the fetched data

                // Update cards with fetched data
                document.getElementById('totalOrders').textContent = data.totalOrders;
                document.getElementById('monthlyRevenue').textContent = data.monthlyRevenue + '฿';
                document.getElementById('totalUsers').textContent = data.totalUsers;
                document.getElementById('totalIncome').textContent = data.totalIncome + '฿';

                // Sort recent orders by status
                data.recentOrders.sort((a, b) => {
                    const statusOrder = ['Waiting to enter','check', 'Completed', 'Cancel'];
                    return statusOrder.indexOf(a.status) - statusOrder.indexOf(b.status);
                });

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

                // Chart.js to create the monthly revenue chart
                const ctx = document.getElementById('revenueChart').getContext('2d');
                const revenueChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Monthly Revenue'],
                        datasets: [{
                            label: 'Revenue',
                            data: [data.monthlyRevenue],
                            backgroundColor: ['rgba(75, 192, 192, 0.6)'],
                            borderColor: ['rgba(75, 192, 192, 1)'],
                            borderWidth: 1,
                        barPercentage: 0.5, 
                        categoryPercentage: 0.7
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: { size: 16 },
                                bodyFont: { size: 14 },
                                footerFont: { size: 12 }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.3)'
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });

                // Prepare data for yearly revenue chart
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const yearlyRevenueData = Array(12).fill(0);
                Object.keys(data.yearlyRevenue).forEach(month => {
                    yearlyRevenueData[month - 1] = data.yearlyRevenue[month];
                });

                // Chart.js to create the yearly revenue chart
                const ctxYearly = document.getElementById('yearlyRevenueChart').getContext('2d');
                const yearlyRevenueChart = new Chart(ctxYearly, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Revenue',
                            data: yearlyRevenueData,
                            backgroundColor: 'rgba(153, 102, 255, 0.6)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: { size: 16 },
                                bodyFont: { size: 14 },
                                footerFont: { size: 12 }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.3)'
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error:', error));

        function getStatusClass(status) {
            switch (status) {
                case 'Completed': return 'delivered';
                case 'check': return 'check';
                case 'Cancel': return 'return';
                case 'Waiting to enter': return 'pending';
                default: return '';
            }
        }
        
    </script>

    <!-- ====== ionicons ======= -->
    <?php include '../mains.php'; ?>
</body>

</html>
