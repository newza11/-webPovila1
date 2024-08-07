



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/order.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
    <?php include 'menu.php'; ?>

        <!-- ========================= Main ==================== -->
        

            <div class="order-section">
                <div class="recentOrders">
                <h1>Order Page</h1>
               
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
        </div>
    </div>
    </div>        
    <!-- =========== Scripts =========  -->
    <script src="main.js"></script>
    <script>

        fetch('fetch_orders.php')
            .then(response => response.json())
            .then(data => {
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
                    `;

                    tableBody.appendChild(row);
                });
            });

        function getStatusClass(status) {
            switch (status) {
                case 'Completed': return 'delivered';
                case 'cancel': return 'return';
                case 'Waiting to enter': return 'pending';
                default: return '';
            }
        }
    
    </script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>