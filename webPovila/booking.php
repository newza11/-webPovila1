    <?php
    session_start();
    require 'db_connect.php'; // Include the database connection

    $check_in = $_SESSION['checkin'] ?? 'ไม่ระบุ';
    $check_out = $_SESSION['checkout'] ?? 'ไม่ระบุ';
    $room = $_SESSION['room'] ?? 'ไม่ระบุ';
    $room_price = $_SESSION['price'] ?? 0;
    $people =  $_SESSION['people'] ?? 0;
    $status = 'check'; // Default status

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve the form data
        $name = $_POST['name'];
        $first_name = $_POST['firstname'];
        $last_name = $_POST['lastname'];
        $phone = $_POST['phone'];

        $_SESSION['name'] = $name;
            $_SESSION['phone'] = $phone;
            $_SESSION['firstname'] = $first_name;
            $_SESSION['lastname'] = $last_name;
            
        
        
        
        
        // Prepare SQL query to insert data into orders_db table
        $sql = "INSERT INTO orders_db (name, price, people, checkin, checkout, status, phone, room, firstname, lastname) 
                VALUES (:name, :price, :people, :checkin, :checkout, :status, :phone, :room, :firstname, :lastname)";
        
        $stmt = $pdo->prepare($sql);
        
        // Execute the query with the data from the form and session
        
        header('Location: payment.php');
    exit;

    }
    // Assuming a fixed price per night for simplicity
    $price_per_night = $room_price+3000+4000; // Example price
    $total_price = $price_per_night ; // You might calculate this differently based on the number of nights
    $booking_fee = 2000; // Example booking fee

    ?>

    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>หน้ากรอกข้อมูลการจอง</title>
        <link rel="stylesheet" href="css/booking.css">
    </head>
    <body>
        <nav>
            <div class="nav__logo">
                <img src="https://scontent.fkdt1-1.fna.fbcdn.net/v/t1.15752-9/451463161_439508502254984_1564988875763696941_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeFLxpw7P5hzAbD0zGFx4wcQ_iqw6XCTKgf-KrDpcJMqB2ssTrxaM93qmoZDROCA15lSca9F0AG3_Aum4HlxxYYy&_nc_ohc=BErgEdBJnUwQ7kNvgGYDR0P&_nc_ht=scontent.fkdt1-1.fna&oh=03_Q7cD1QG_QMJ_iS3LVLg9FVnCJhM17wgMqHFgMIkqJvWW2npLGA&oe=66BF59DB" alt="Ocean" width="22" height="80" style="display: flex; width: 100%;">
            </div>
            <ul class="nav__links">
                <li class="link"><a href="index.php">Home</a></li>
            </ul>
        </nav>
        <div class="container">
            <div class="details">
                <div class="header">
                    <h2>รายละเอียดการจอง</h2>
                    <p>Povila: นันท์นภัส พลูวิลล่า</p>
                    <p>ที่อยู่: เลขที่ 88/1 ถนน รพช. สส. 3046 อ.เมืองสมุทรสงคราม จ.สมุทรสงคราม</p>
                    <p>Check-in: <?php echo htmlspecialchars($check_in, ENT_QUOTES, 'UTF-8'); ?>เข้า 14.00</p>
                    <p>Check-out: <?php echo htmlspecialchars($check_out, ENT_QUOTES, 'UTF-8'); ?>ออก 12.00</p>
                    <p>ห้อง: <?php echo htmlspecialchars($room, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="summary">
                    <p>ราคาต่อคืน: THB <?php echo number_format($room_price); ?></p>
                    <p>ยอดจอง: THB <?php echo number_format($booking_fee); ?></p>
                    <p>ประกัน: 3000 THB </p>
                    <p class="total">ยอดรวม: THB <?php echo number_format($total_price); ?></p>
                </div>
            </div>
            <div class="form-container">
                <div class="customer-info">
                    <h2>กรอกข้อมูลของท่าน</h2>
                    <form action="booking.php" method="POST">
                    <label for="name">ชื่อ</label>
                    <input type="text" id="name" name="name" required>
                        <label for="first-name">ชื่อจริง</label>
                        <input type="text" id="firstname" name="firstname" required>
                        
                        <label for="last-name">นามสกุล</label>
                        <input type="text" id="lastname" name="lastname" required>
                        
                        
                        
                        <label for="phone">หมายเลขติดต่อ (แนะนำให้ระบุของมือถือ)</label>
                        <input type="text" id="phone" name="phone" required>
                        
                        <button type="submit" class="submit-btn">ทำการจอง</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
    </html>
