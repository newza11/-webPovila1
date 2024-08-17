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

        

        .content-block .edit-btn:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
            /* ยกปุ่มขึ้นเมื่อโฮเวอร์ */
            
            /* เงาที่ชัดเจนขึ้นเมื่อโฮเวอร์ */
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

        /* จัดการการแสดงผลภายในส่วนต่าง ๆ */
        #content-area {
            margin-top: 30px;
        }

        /* ข้อความที่ไม่พบข้อมูล */
        .no-data {
            text-align: center;
            font-size: 1.2em;
            color: #999;
        }

        /* ส่วนที่เป็นการแบ่งพื้นที่ */
        hr {
            margin: 30px 0;
            border-color: #ddd;
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
                    <a href="#" class="btn" onclick="loadContent('concept')">แนวคิด</a>
                    <a href="#" class="btn" onclick="loadContent('project')">ข้อมูลโครงการ</a>
                    <a href="#" class="btn" onclick="loadContent('facilities')">สิ่งอำนวยความสะดวก</a>
                    <a href="#" class="btn" onclick="loadContent('gallery')">อัลบั้มภาพ</a>
                </div>

                <div id="content-area">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../mains.php'; ?>

    <script>
        window.onload = function() {
            loadContent('concept'); // โหลดเนื้อหาแนวคิดเมื่อเปิดหน้า
            highlightSelectedButton('concept'); // ไฮไลท์ปุ่ม "แนวคิด"
        };

        function loadContent(section) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `fetch_villa_data.php?section=${section}`, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('content-area').innerHTML = this.responseText;
                }
            };
            xhr.send();

            highlightSelectedButton(section); // เรียกใช้ฟังก์ชันเพื่อไฮไลท์ปุ่มที่ถูกเลือก
        }

        function highlightSelectedButton(section) {
            // ลบคลาส 'selected-btn' จากปุ่มทั้งหมด
            document.querySelectorAll('.btn').forEach(function(btn) {
                btn.classList.remove('selected-btn');
            });

            // เพิ่มคลาส 'selected-btn' ให้กับปุ่มที่ตรงกับ section ที่เลือก
            document.querySelector(`.btn[onclick="loadContent('${section}')"]`).classList.add('selected-btn');
        }
    </script>
</body>

</html>