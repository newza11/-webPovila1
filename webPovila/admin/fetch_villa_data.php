<?php
include 'db_connection.php';

$section = isset($_GET['section']) ? $_GET['section'] : '';

switch ($section) {
    case 'concept':
        $sql = "SELECT * FROM villa_home_content"; // ดึงข้อมูลแนวคิดจากฐานข้อมูล
        break;
    case 'project':
        $sql = "SELECT * FROM villa_details"; // ดึงข้อมูลโครงการจากฐานข้อมูล
        break;
    case 'facilities':
        $sql = "SELECT * FROM accordion_items"; // ดึงข้อมูลสิ่งอำนวยความสะดวกจากฐานข้อมูล
        break;
    case 'gallery':
        $sql = "SELECT * FROM villa_images"; // ดึงข้อมูลอัลบั้มภาพจากฐานข้อมูล
        break;
    case 'main':
        $sql = "SELECT * FROM villa_main"; // ดึงข้อมูลสิ่งอำนวยความสะดวกจากฐานข้อมูล
        break;
    case 'descriptions':
        $sql = "SELECT * FROM villa_descriptions"; // ดึงข้อมูลสิ่งอำนวยความสะดวกจากฐานข้อมูล
        break;
    default:
        echo "Invalid section";
        exit;
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='content-block'>";

        foreach ($row as $key => $value) {
            if ($key === 'image_path') {
                // แสดงรูปภาพจากโฟลเดอร์ ../uploads/
                $imagePath = '../' . htmlspecialchars($value);
                echo "<div><strong>Image:</strong> <br>";
                echo "<img src='" . $imagePath . "' alt='Villa Image'></div>";
            } else {
                // แสดงข้อมูลทั่วไป
                echo "<p><strong>" . ucfirst($key) . ":</strong> " . htmlspecialchars($value) . "</p>";
            }
        }

        // ปุ่มแก้ไข
        echo "<a href='edit_data.php?id={$row['id']}&section={$section}' class='edit-btn'>Edit</a>";
        echo "</div><hr>";
    }
} else {
    echo "<p class='no-data'>No data available</p>";
}

$conn->close();
