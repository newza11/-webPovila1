<?php
session_start();

// Check if the user is logged in as Admin
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
                    <div class="cardName">Order</div>
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
                <canvas id="revenueChart"></canvas>

                <div class="cardHeader">
                    <h2>Yearly Revenue</h2>
                </div>
                <canvas id="yearlyRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Script to fetch data and generate charts -->
    <script>
        fetch('fetch_data.php')
            .then(response => response.json())
            .then(data => {
                // Update cards with fetched data
                document.getElementById('totalOrders').textContent = data.totalOrders;
                document.getElementById('monthlyRevenue').textContent = data.monthlyRevenue + '฿';
                document.getElementById('totalUsers').textContent = data.totalUsers;
                document.getElementById('totalIncome').textContent = data.totalIncome + '฿';

                // Sort and display recent orders
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
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Prepare data for yearly revenue chart for multiple years
                const ctxYearly = document.getElementById('yearlyRevenueChart').getContext('2d');
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const yearlyRevenueChart = new Chart(ctxYearly, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                                label: '2022',
                                data: data.yearlyRevenue['2022'],
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: '2023',
                                data: data.yearlyRevenue['2023'],
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: '2024',
                                data: data.yearlyRevenue['2024'],
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: '2025',
                                data: data.yearlyRevenue['2025'],
                                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            },
                            {
                                label: '2026',
                                data: data.yearlyRevenue['2026'],
                                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    autoSkip: false, // Avoid skipping ticks
                                    maxRotation: 45, // Rotate labels to avoid overlap
                                    minRotation: 45,
                                    padding: 10, // Add some space between the labels and the axis
                                    font: {
                                        size: 12 // Adjust font size to make it more readable
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.3)' // Lighten the grid lines
                                },
                                ticks: {
                                    padding: 10, // Add some space between the ticks and the chart area
                                    font: {
                                        size: 12 // Adjust font size for better readability
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
                case 'Completed':
                    return 'delivered';
                case 'check':
                    return 'check';
                case 'Cancel':
                    return 'return';
                case 'Waiting to enter':
                    return 'pending';
                default:
                    return '';
            }
        }
    </script>

    <!-- ====== ionicons ======= -->
    <?php include '../mains.php'; ?>
</body>

</html>