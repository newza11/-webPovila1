<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/order.css">
    <link rel="stylesheet" href="../css/user.css">
    <title>Villa Management</title>
    <style>
        /* ตกแต่งทั่วไป */

        /* การจัดการการแสดงเนื้อหา */
        .content-block {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-block h3 {
            margin-top: 0;
            color: #333;
            font-size: 1.5em;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .content-block img {
            max-width: 300px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .content-block p {
            font-size: 1em;
            line-height: 1.6;
            color: #555;
        }

        /* ปุ่ม dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* เมนู dropdown content ที่ถูกซ่อนเป็นค่าเริ่มต้น */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        /* เมนู dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* แสดง dropdown เมื่อ hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* ปุ่มที่เป็น dropdown */
        .dropdown-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        .dropdown-btn:hover {
            background-color: #0056b3;
        }

        .content-block .edit-btn {
            display: inline-block;
            margin-top: 15px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            
            /* เพิ่มเงา */
            font-weight: bold;
            /* ตัวหนา */
        }
        .dropdown-content .btn{
            background-color: white;
            color: #000;
            padding: 1rem 0.5rem;
        }

        #content-area {
            margin-top: 30px;
        }
        .selected-btn {
            background-color: #0056b3;
            /* สีฟ้าเข้ม เพื่อบอกว่าเป็นปุ่มที่ถูกเลือก */
            box-shadow: 0px 8px 15px rgba(0, 86, 179, 0.3);
            /* เพิ่มเงาให้ชัดเจน */
            color: #fff;
            /* สีตัวอักษรขาว */
        }

        .selected-btn:hover {
            background-color: #004099;
            box-shadow: 0px 12px 20px rgba(0, 64, 153, 0.5);
            /* เงาเมื่อโฮเวอร์ */
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>

        <div class="details2">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Villa Management</h2>

                    <!-- เริ่มต้นส่วนของ Dropdown -->
                    <div class="dropdown">
                        <button class="dropdown-btn">Management</button>
                        <div class="dropdown-content">
                            <a href="#" class="btn" onclick="loadContent('concept')">แนวคิด</a>
                            <a href="#" class="btn" onclick="loadContent('project')">ข้อมูลโครงการ</a>
                            <a href="#" class="btn" onclick="loadContent('facilities')">สิ่งอำนวยความสะดวก</a>
                            <a href="#" class="btn" onclick="loadContent('gallery')">อัลบั้มภาพ</a>
                            <a href="#" class="btn" onclick="loadContent('main')">Main</a>
                            <a href="#" class="btn" onclick="loadContent('about')">about</a>
                            <a href="#" class="btn" onclick="loadContent('descriptions')">Footer</a>
                        </div>
                    </div>
                    <!-- จบส่วนของ Dropdown -->
                    
                </div>

                <div id="content-area">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../mains.php'; ?>

    <script>
        window.onload = function () {
            loadContent('concept'); // โหลดเนื้อหาแนวคิดเมื่อเปิดหน้า
            highlightSelectedButton('concept'); // ไฮไลท์ปุ่ม "แนวคิด"
        };

        function loadContent(section) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `fetch_villa_data.php?section=${section}`, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    document.getElementById('content-area').innerHTML = this.responseText;
                }
            };
            xhr.send();

            highlightSelectedButton(section); // เรียกใช้ฟังก์ชันเพื่อไฮไลท์ปุ่มที่ถูกเลือก
        }

        function highlightSelectedButton(section) {
            // ลบคลาส 'selected-btn' จากปุ่มทั้งหมด
            document.querySelectorAll('.btn').forEach(function (btn) {
                btn.classList.remove('selected-btn');
            });

            // เพิ่มคลาส 'selected-btn' ให้กับปุ่มที่ตรงกับ section ที่เลือก
            document.querySelector(`.btn[onclick="loadContent('${section}')"]`).classList.add('selected-btn');
        }
    </script>
</body>

</html>
