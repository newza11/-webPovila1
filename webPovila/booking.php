<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้ากรอกข้อมูลการจอง</title>
    <link rel="stylesheet" href="css\booking.css">
</head>
<body>
    <nav>
      
        <div class="nav__logo" >
        <img src="https://scontent.fkdt1-1.fna.fbcdn.net/v/t1.15752-9/451463161_439508502254984_1564988875763696941_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeFLxpw7P5hzAbD0zGFx4wcQ_iqw6XCTKgf-KrDpcJMqB2ssTrxaM93qmoZDROCA15lSca9F0AG3_Aum4HlxxYYy&_nc_ohc=BErgEdBJnUwQ7kNvgGYDR0P&_nc_ht=scontent.fkdt1-1.fna&oh=03_Q7cD1QG_QMJ_iS3LVLg9FVnCJhM17wgMqHFgMIkqJvWW2npLGA&oe=66BF59DB" alt="Ocean" width="22" height="80" style="display: flex; width: 100%;">
      </div>
           
        <ui class="nav__links">
          <li class="link"><a href="index.php">Home</a></li>
            </ui>
      </nav>
    <div class="container">
        <div class="details">
            <div class="header">
                <h2>รายละเอียดการจอง</h2>
                <p>Povila: นันท์นภัส พลูวิลล่า</p>
                <p>ที่อยู่: เลขที่ 88/1 ถนน รพช. สส. 3046 อ.เมืองสมุทรสงคราม จ.สมุทรสงคราม</p>
                <p>check in: พุธ 21 ส.ค. 2024 เวลา 14:00.</p>
                <p>check out: พฤหัสบดี 22 ส.ค. 2024  เวลา 12:00</p>
                <p>ห้อง: 6 ห้อง </p>
            </div>
            <div class="summary">
                <p>ราคาต่อคืน: THB 12,000</p>
                <p>ยอดจอง: THB 2,000</p>
                <p class="total">ยอดรวม: THB 12,000</p>
            </div>
        </div>
        <div class="form-container">
            <div class="customer-info">
                <h2>กรอกข้อมูลของท่าน</h2>
                <form action="payment.php" method="POST">
                    <label for="first-name">ชื่อ (ภาษาอังกฤษ)</label>
                    <input type="text" id="first-name" name="first-name" required>
                    
                    <label for="last-name">นามสกุล (ภาษาอังกฤษ)</label>
                    <input type="text" id="last-name" name="last-name" required>

                    
                    
                    
                    
                    
                    <label for="country">ประเทศ/ภูมิภาค</label>
                    <select id="country" name="country" required>
                        <option value="เลือก">เลือก</option>
                        <option value="ไทย">thai</option>
                        <option value="ต่างชาติ">foreign</option>
                        <!-- Add more countries as needed -->
                    </select>
                    
                    <label for="phone">หมายเลขติดต่อ (แนะนำให้ระบุของมือถือ)</label>
                    <input type="text" id="phone" name="phone" required>
                    
                    <button type="submit" class="submit-btn" > ทำการจอง </button>
                    
                </form>
            </div>
        </div>
    </div>
</body>
</html>
